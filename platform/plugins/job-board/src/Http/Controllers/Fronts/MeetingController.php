<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\AccountMeetingForm;
use Botble\JobBoard\Http\Requests\AccountMeetingRequest;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Event;
use Botble\Base\Forms\FormBuilder;
use JobBoardHelper;
use Carbon\Carbon;
class MeetingController extends BaseController
{
    public function index()
    {
        $account = auth('account')->user();
        // $educations = AccountMeeting::where('account_id', $account->id)->get();

        return JobBoardHelper::scope('account.meets.index', compact('account'));
    }
    public function create()
{
    // Get the authenticated account
    $account = auth('account')->user();

    // Retrieve the event date (and other data) from the events table
    $events = Event::where('consultant_id', $account->id)
                      ->get();// This will fetch the most recent event for the authenticated consultant

    // Pass the event data to the view
    return JobBoardHelper::scope('account.meets.index', compact('account', 'events'));
}

    // public function store(AccountMeetingRequest $request, BaseHttpResponse $response)
    // {
      
        
    //     // return view('job-board::account.meets.create');

    //     // $account = Account::findOrFail($request->input('account_id'));

    //     // if ($account->isConsultant()) {
    //     //     Event::create(array_merge(
    //     //         $request->validated(),
    //     //         ['account_id' => $account->id]
    //     //     ));
    //     // }
    //     $event = Event::create([
    //         'start_time' => 10:00 AM,               // Using the start_time from the request
    //         'end_time' => 10:00 AM,                   // Using the end_time from the request
    //         // Add any other necessary fields here, based on your needs
    //     ]);
    //     return JobBoardHelper::scope('account.meets.index');
    //     // return $response
    //     //     ->setNextUrl(route('public.account.meets.index'))
    //     //     ->setMessage(trans('plugins/job-board::account.meets.store'));
    // }
    public function store(AccountMeetingRequest $request, BaseHttpResponse $response)
{
    // Example static date for testing
    $currentDate = Carbon::now()->toDateString(); // Get today's date (e.g., 2024-11-10)
    $account = auth('account')->user()->id;
    // dd($account);
    // Static time values for testing
    // $startTime = Carbon::parse($currentDate . ' 10:00:00')->format('Y-m-d H:i:s'); // 10:00 AM
    // $endTime = Carbon::parse($currentDate . ' 10:30:00')->format('Y-m-d H:i:s'); // 10:30 AM
    $time12 = $this->convertTo12Hour($request->start_time);
    $time13 = $this->convertTo12Hour($request->end_time);
    // dd($time13);
    
    // Create a new event with static data
    $event = Event::create([
        'start_time' => $time12, // Correct datetime format
        'end_time' =>  $time13,
        'day' => $request->day,
        'date' =>$request->date,// Correct datetime format
        'consultant_id' => $account,
        // Add other necessary fields here (e.g., account_id, etc.)
    ]);
    $events = Event::where('consultant_id', $account)->get()->toArray();;
    // dd($events);
    // Redirect or return response
    // return JobBoardHelper::scope('account.meets.index');
    // return redirect()->route('public.account.meets.index')->with('events', $events);
    // use this route http://127.0.0.1:8000/account/index here
    // Or alternatively
    // return $response
    //     ->setNextUrl(route('public.account.meets.index'))
    //     ->setMessage(trans('plugins/job-board::account.meets.store'));
    return redirect()->to(url('/account/index'))->with('events', $events);
}

public function convertTo12Hour($time24)
    {
        $time = date("g:i A", strtotime($time24)); // Convert to 12-hour format with AM/PM
        return $time;
    }




    public function update(AccountEducationRequest $request, $id, BaseHttpResponse $response)
    {
        $education = AccountEducation::query()
            ->where('id', $id)
            ->where('account_id', $request->input('account_id'))
            ->firstOrFail();

        $education->update($request->validated());

        return $response
            ->setNextUrl(route('public.account.educations.index'))
            ->setMessage(trans('plugins/job-board::account.educations.update'));
    }

    public function destroy($id, BaseHttpResponse $response)
    {
        $education = AccountEducation::findOrFail($id);

        $education->delete();

        return $response
            ->setNextUrl(route('public.account.educations.index'))
            ->setMessage(trans('plugins/job-board::account.educations.delete'));
    }

    public function editModal($id, $accountId, FormBuilder $formBuilder)
    {
        $education = AccountEducation::query()
            ->where('account_id', $accountId)
            ->where('id', $id)
            ->firstOrFail();

        return $formBuilder->create(AccountEducationForm::class, ['model' => $education])->setFormOptions([
            'url' => route('accounts.educations.edit.update', $id),
        ])->renderForm();
    }
}
