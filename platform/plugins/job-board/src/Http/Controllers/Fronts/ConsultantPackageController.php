<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Log;
use Theme;
use Exception;
use SeoHelper;
use Carbon\Carbon;
use JobBoardHelper;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Gentor\Calendly\CalendlyAPI;
use Botble\Base\Forms\FormBuilder;
use Illuminate\Support\Facades\DB;
use Botble\JobBoard\Models\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Botble\JobBoard\Forms\PackageForm;
use Botble\JobBoard\Tables\PackageTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\JobBoard\Models\ConsultantPackage;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\ConsultantPackageForm;
use Botble\JobBoard\Http\Requests\PackageRequest;
use Botble\Payment\Services\Gateways\CodPaymentService;
use Botble\JobBoard\Tables\Fronts\ConsultantPackageTable;
use Botble\JobBoard\Http\Requests\ConsulatntPackageRequest;
use Botble\Payment\Services\Gateways\BankTransferPaymentService;
use Botble\JobBoard\Repositories\Interfaces\TransactionInterface;
use Botble\JobBoard\Repositories\Interfaces\ConsultantPackageInterface;

class ConsultantPackageController extends BaseController
{
    protected ConsultantPackageInterface $consultantPackageRepository;

    public function __construct(ConsultantPackageInterface $consultantPackageRepository)
    {
        $this->consultantPackageRepository = $consultantPackageRepository;
    }

    public function index(ConsultantPackageInterface $repo)
    {
        $data = $repo->getModel()->where(['consultant_id' => auth('account')->id()])->select([
            'id',
            'name',
            'start_time',
            'end_time',
            'credits',
            'created_at',
            'status',
        ])->get();
        page_title()->setTitle(__('Consultant packages'));
        SeoHelper::setTitle(__('Consultant packages'));
        // Theme::breadcrumb()
        //     ->add(__('Home'), route('public.account.consultant-packages.index'))
        //     ->add(__('Consultant packages'));
        return JobBoardHelper::view('dashboard.tbl', ['data' => $data]);
    }

    public function handleOAuthAndCreate(TransactionInterface $transactionRepository, Request $request, BaseHttpResponse $baseHttpResponse)
    {
        $event = $request->query();
        if (!$request->has('code')) {
            if (session('event')) {
                session()->forget('event');
            }
            session(['event' => $event]);
        }
        // Check if the request has an authorization code
        if ($request->has('code')) {
            $code = $request->query('code');
            $client = new Client();
            $tokenUrl = 'https://auth.calendly.com/oauth/token';

            try {
                // Exchange the authorization code for an access token
                $response = $client->request('POST', $tokenUrl, [
                    'form_params' => [
                        'grant_type'    => 'authorization_code',
                        'code'          => $code,
                        'redirect_uri'  => env('CALENDLY_REDIRECT_URI'),
                        'client_id'     => env('CALENDLY_CLIENT_ID'),
                        'client_secret' => env('CALENDLY_CLIENT_SECRET'),
                    ],
                ]);

                $data = json_decode($response->getBody(), true);
                $accessToken = $data['access_token'];

                // Store the access token in the session
                session(['calendly_access_token' => $accessToken]);

                // Create the event
                return $this->createEvent($accessToken, $event, $baseHttpResponse);
            } catch (\Exception $e) {
                // Handle token request error
                return response()->json([
                    'error' => 'Token request failed',
                    'message' => $e->getMessage(),
                ], 400);
                // return $baseHttpResponse->setMessage('Token request failed');
            }
        } else {
            // Redirect user to Calendly's authorization URL
            $clientId = env('CALENDLY_CLIENT_ID');
            $redirectUri = urlencode(env('CALENDLY_REDIRECT_URI'));

            $authUrl = "https://auth.calendly.com/oauth/authorize?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}";

            return redirect($authUrl);
        }
    }

    protected function createEvent($accessToken, $event, BaseHttpResponse $baseHttpResponse)
    {
        $event = session('event');
        // Get the user ID
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.calendly.com/users/me');

        if ($response->successful()) {
            $userId = $response->json()['resource']['uri'];

            // Create the event
            $createEventResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://api.calendly.com/one_off_event_types', [
                'name' => $event['name'],
                'host' => $userId,
                'duration' => (int)$event['total_hours'],
                'timezone' => $event['region'],
                'date_setting' => [
                    'type' => 'spots',
                    'spots' => [
                        [
                            'start_time' => $event['start_time'],
                            'end_time' => $event['end_time']
                        ]
                    ]
                ],
                'location' => [
                    'kind' => 'custom',
                    'location' => 'Your Location'
                ]
            ]);

            if ($createEventResponse->successful()) {
                $response = $createEventResponse->json();

                // Extract the 'uri' from the response array
                $eventUri = $response['resource']['scheduling_url'] ?? null;

                $package = session('recently_created_package');
                // If you need to update the ConsultantPackage with the URI
                if ($eventUri) {
                    ConsultantPackage::find($package->id)->update([
                        'calendly_event_uri' => $eventUri
                    ]);
                }

                return $baseHttpResponse
                    ->setPreviousUrl(route('public.account.consultant-packages.index'))
                    ->setNextUrl(route('public.account.consultant-packages.edit', $package->id))
                    ->setMessage(trans('core/base::notices.create_success_message'));                // Event created successfully
            } else {
                Log::info($createEventResponse->body()); // Handle error
                abort(500, 'Something went wrong as probably Calendly error');
            }
        } else {
            return $baseHttpResponse
                ->setMessage('Event creation failed.');
            // return response()->json([
            //     'error' => 'Event creation failed',
            //     'body' => $response->body(),
            // ], 400);
        }
    }

    public function listEvents()
    {
        $accessToken = session('calendly_access_token'); // Retrieve the access token from session
        if (!$accessToken) {
            return response()->json([
                'error' => 'Access token not found. Please authenticate first.',
            ], 401);
        }

        $client = new \GuzzleHttp\Client();
        $apiUrl = 'https://api.calendly.com/events'; // Adjust endpoint if needed

        try {
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type'  => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'message' => 'Events retrieved successfully',
                'data'    => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve events',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
    public function purchaseDone(TransactionInterface $transactionRepository, Request $request, BaseHttpResponse $baseHttpResponse)
    {
        // Log::info('Request from webhook', $request->all());

        // Check if the event is 'invitee.created'
        if ($request->input('event') !== 'invitee.created') {
            // Log::info('Event is not invitee.created');
            return $baseHttpResponse->setMessage('Event is not invitee.created');
        }

        // Retrieve consultantPackage from the database
        // $account = Account::find($consultantPackage);
        // $accountId = auth('account')->id();
        $consultantPackageSession = DB::table('webhook_sessions')->first();

        if (!$consultantPackageSession) {
            Log::info('No consultant package session found');
            return $baseHttpResponse->setMessage('No consultant package session found');
        }

        $account = Account::find($consultantPackageSession->account_id);
        $currUser = Auth::loginUsingId($consultantPackageSession->account_id);

        // Retrieve the consultantPackage model
        $consultantPackage = ConsultantPackage::find($consultantPackageSession->package_id);

        if (!$consultantPackage) {
            Log::info('No consultant package found for the session');
            return $baseHttpResponse->setMessage('No consultant package found for the session');
        }

        // Continue with your transaction processing logic...
        try {
            DB::transaction(function () use ($consultantPackage, $account, $transactionRepository) {
                // Update and save the consultant package
                $consultantPackage->update(['is_booked' => true]);

                // Deduct credits from account and save
                $account->credits -= $consultantPackage->credits;
                $account->save();

                // Add credits to consultant and save
                $consultant = $consultantPackage->consultant;
                $consultant->credits += $consultantPackage->credits;
                $consultant->save();

                // Attach the purchased package to the account
                $account->purchasedConsultantPackages()->attach($consultantPackage);

                // Log the transaction
                $transactionRepository->createOrUpdate([
                    'user_id' => 0,
                    'account_id' => $account->id,
                    'credits' => $consultantPackage->credits,
                    'payment_id' => $consultantPackage->id,
                ]);

                // Delete the session data after successful transaction
                DB::table('webhook_sessions')->orderBy('id')->limit(1)->delete();
            });



            return $baseHttpResponse->setMessage('Consultation booked successfully.');
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
            return $baseHttpResponse->setMessage('An error occurred while processing the transaction.');
        }
    }

    public function purchase(ConsultantPackage $consultantPackage,  BaseHttpResponse $baseHttpResponse)
    {
        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        if ($account->credits < $consultantPackage->credits) {
            return $baseHttpResponse->setMessage('Insufficient credit balance');
            // return back()->with(['message' => 'Insufficient credit balance']);
        }
        if (session('consultantPackage')) {
            session()->forget('consultantPackage');
        }
        // Define the account ID and consultant package ID
        $accountId = auth('account')->id();
        $consultantPackageId = $consultantPackage->id;

        // Check if a record exists
        $exists = DB::table('webhook_sessions')
            ->where('account_id', $accountId)
            ->where('package_id', $consultantPackageId)
            ->exists();

        // Insert data if it doesn't exist
        if (!$exists) {
            DB::table('webhook_sessions')->insert([
                'account_id' => $accountId,
                'package_id' => $consultantPackageId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        session(['consultantPackage' => $consultantPackage]);

        if ($consultantPackage->calendly_event_uri && filter_var($consultantPackage->calendly_event_uri, FILTER_VALIDATE_URL)) {
            return redirect()->to($consultantPackage->calendly_event_uri);
        } else {
            return $baseHttpResponse
                ->setMessage('No valid URI found for Calendly.');
            // return back()->with('message', 'No valid URI found for Calendly');
        }
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::consultant-package.create'));

        return $formBuilder->create(ConsultantPackageForm::class)->renderForm();
    }

    public function store(ConsulatntPackageRequest $request, BaseHttpResponse $response)
    {
        if (!$request->input('credits')) {
            $request->merge(['credits' => 0]);
        }

        // Parse the input times
        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));

        // Calculate the difference
        $timeDifferenceInMinutes = $startTime->diffInMinutes($endTime);
        $data = [
            'id' => $request->input('id'),
            'name' => $request->input('name'),
            'consultant_id' => auth('account')->id(),
            'credits' => $request->input('credits'),
            'description' => $request->input('description'),
            'currency_id' => $request->input('currency_id'),
            'order' => $request->input('order'),
            'total_hours' => $timeDifferenceInMinutes,
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'region' => $request->input('region'),
            'status' => $request->input('status'),
        ];

        // Save or update the package
        $package = $this->consultantPackageRepository->createOrUpdate($data);
        // Trigger the event
        event(new CreatedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

        // Store data in session
        if (session()->has('recently_created_package')) {
            session()->forget('recently_created_package');
        }
        session()->put('recently_created_package', $package);

        // Build the query string
        $queryString = http_build_query($data);
        $url = route('public.account.consultant-packages.calendly.callback') . '?' . $queryString;

        return redirect($url); // Use redirect($url) directly
    }

    public function edit(int|string $id, FormBuilder $formBuilder, Request $request)
    {
        $package = $this->consultantPackageRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $package));

        page_title()->setTitle(trans('plugins/job-board::consultant-package.edit') . ' "' . $package->name . '"');

        return $formBuilder->create(ConsultantPackageForm::class, ['model' => $package])->renderForm();
    }

    public function update(int|string $id, Request $request, BaseHttpResponse $response)
    {
        $package = $this->consultantPackageRepository->findOrFail($id);

        if (!$request->input('credits')) {
            $request->merge(['credits' => 0]);
        }

        $package->fill($request->input());

        $this->consultantPackageRepository->createOrUpdate($package);

        event(new UpdatedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

        return $response
            ->setPreviousUrl(route('public.account.consultant-packages.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $package = $this->consultantPackageRepository->findOrFail($id);

            $this->consultantPackageRepository->delete($package);

            event(new DeletedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $package = $this->consultantPackageRepository->findOrFail($id);
            $this->consultantPackageRepository->delete($package);
            event(new DeletedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
