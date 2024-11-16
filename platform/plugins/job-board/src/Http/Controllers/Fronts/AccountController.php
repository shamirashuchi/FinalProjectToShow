<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Http\Requests\AvatarRequest;
use Botble\JobBoard\Http\Requests\SettingRequest;
use Botble\JobBoard\Http\Requests\UpdatePasswordRequest;
use Botble\JobBoard\Http\Requests\UploadResumeRequest;
use Botble\JobBoard\Http\Resources\ActivityLogResource;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Event;
use Botble\JobBoard\Models\AccountEducation;
use Botble\JobBoard\Models\AccountExperience;
use Botble\JobBoard\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Media\Services\ThumbnailService;
use Illuminate\Support\Str;
use Exception;
use File;
use Hash;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JobBoardHelper;
use OptimizerHelper;
use RvMedia;
use SeoHelper;
use Theme;
use Botble\JobBoard\Repositories\Interfaces\JobSkillInterface;
use Botble\JobBoard\Repositories\Interfaces\TagInterface;
use Illuminate\Support\Arr;

//added later
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    protected AccountInterface $accountRepository;

    protected AccountActivityLogInterface $activityLogRepository;

    protected MediaFileInterface $fileRepository;

    protected JobInterface $jobRepository;

    protected JobSkillInterface $jobSkillRepository;

    protected TagInterface $tagRepository;

    public function __construct(
        Repository $config,
        AccountInterface $accountRepository,
        AccountActivityLogInterface $accountActivityLogRepository,
        MediaFileInterface $fileRepository,
        JobInterface $jobRepository,
        JobSkillInterface $jobSkillRepository,
        TagInterface $tagRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->activityLogRepository = $accountActivityLogRepository;
        $this->fileRepository = $fileRepository;
        $this->jobRepository = $jobRepository;
        $this->jobSkillRepository = $jobSkillRepository;
        $this->tagRepository = $tagRepository;

        Assets::setConfig($config->get('plugins.job-board.assets'));

        OptimizerHelper::disable();
    }

    // public function getHome(){
    //     $account = auth('account')->user();
    //     return JobBoardHelper::scope('account.home', compact('account'));
    // }

    public function getHome()
    {
        $account = auth('account')->user();

        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];

        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $queryResult = DB::table('jb_jobs')
            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->distinct() // Add the distinct method here
            ->get();

        $resultArray = $queryResult->toArray();

        $activities = $this->activityLogRepository->getAllLogs($account->getAuthIdentifier());

        // Passing both $account and $resultArray to the view
        return JobBoardHelper::scope('account.home', compact('account', 'resultArray', 'activities'));
    }
    public function getAdminhome()
    {
        $account = auth('account')->user();
        // dd($account->id);
        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];

        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $queryResult = DB::table('jb_jobs')
            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->distinct() // Add the distinct method here
            ->get();
            $events = Event::where('superadmin_id', $account->id)
            ->get();
           
        $resultArray = $queryResult->toArray();

        $activities = $this->activityLogRepository->getAllLogs($account->getAuthIdentifier());

        // Passing both $account and $resultArray to the view
        return JobBoardHelper::scope('account.adminhome', compact('account', 'resultArray', 'activities','events'));
        // return redirect()->route('public.account.adminhome', [
        //     'account' => $account,
        //     'resultArray' => $resultArray,
        //     'activities' => $activities,
        //     'events' => $events,
        // ]);
        
    }


    public function submitTimes(Request $request, $id)
    {
        $account = auth('account')->user();
    
        // Validate the incoming request data
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    
        // Find the event by ID and ensure it belongs to the authenticated superadmin
        $event = Event::where('id', $id)
            ->where('superadmin_id', $account->id)
            ->first();
    
        // Check if the event exists
        if (!$event) {
            return back()->with('error', 'Event not found or you do not have permission to update it.');
        }
   
        $event->shedulestarttime = $request->input('start_time');  // Set the shedulestarttime column
    $event->sheduleendtime = $request->input('end_time');
    $randomChannelName = Str::random(10);  // Random 10-character string

// Check if the generated channel name already exists
if (Event::where('channelname', $randomChannelName)->exists()) {
    // If it exists, generate a new random channel name
    do {
        $randomChannelName = Str::random(10);  // Regenerate the channel name
    } while (Event::where('channelname', $randomChannelName)->exists());  // Continue until unique
}

// Set the unique channel name
$event->channelname = $randomChannelName;
$event->save();





$events = Event::where('superadmin_id', $account->id)
->get();
        // Redirect back with a success message
        return JobBoardHelper::scope('account.adminhome', compact('events'));
    }
    

    public function getShedule()
    {
        $account = auth('account')->user();

        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];

        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $queryResult = DB::table('jb_jobs')
            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->distinct() // Add the distinct method here
            ->get();

        $resultArray = $queryResult->toArray();

        $activities = $this->activityLogRepository->getAllLogs($account->getAuthIdentifier());

        // Passing both $account and $resultArray to the view
        return JobBoardHelper::scope('account.meets.create', compact('account', 'resultArray', 'activities'));
    }
    public function getIndex()
    {
        $account = auth('account')->user();

        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];

        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $queryResult = DB::table('jb_jobs')
            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->distinct() // Add the distinct method here
            ->get();
            $account = auth('account')->user();

            $events = Event::where('consultant_id', $account->id)
               ->whereNotNull('channelname')
               ->get();


        $resultArray = $queryResult->toArray();

        $activities = $this->activityLogRepository->getAllLogs($account->getAuthIdentifier());

        // Passing both $account and $resultArray to the view
        return JobBoardHelper::scope('account.meets.index', compact('account', 'resultArray', 'activities','events'));
    }


    public function getConsultanthome()
    {
        $account = auth('account')->user();

        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];

        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $queryResult = DB::table('jb_jobs')
            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->distinct() // Add the distinct method here
            ->get();

        $resultArray = $queryResult->toArray();
        $activities = $this->activityLogRepository->getAllLogs($account->getAuthIdentifier());

        // Passing both $account and $resultArray to the view
        return JobBoardHelper::scope('account.consultanthome', compact('account', 'resultArray', 'activities'));
    }




    public function getOverview()
    {
        /**
         * @var Account $account
         */

        $account = auth('account')->user();
        $id = auth('account')->user();

        SeoHelper::setTitle($account->name);
        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('My Profile'), route('public.account.overview'))
            ->add($account->name);

        $educations = AccountEducation::query()
            ->where('account_id', $account->id)
            ->get();

        $experiences = AccountExperience::query()
            ->where('account_id', $account->id)
            ->get();

        $jobseekeraccounts = DB::table('jb_accounts')
            ->where('id', $id->id)
            ->get();

        $data = compact('account', 'educations', 'experiences', 'jobseekeraccounts');

        return JobBoardHelper::scope('account.overview', $data);
    }


    public function getSettings()
    {
        SeoHelper::setTitle(__('Account settings'));

        Assets::addScriptsDirectly('vendor/core/core/js-validation/js/js-validation.js')
            ->addScriptsDirectly('//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js')
            ->addStylesDirectly('//cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css');

        $account = auth('account')->user();


        $jobSkills = [];
        $jobTags = [];
        $selectedJobSkills = [];
        $selectedJobTags = [];

        if ($account->isJobSeeker()) {
            $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

            $jobSkills = $this->jobSkillRepository->advancedGet([
                'condition' => [
                    'status' => BaseStatusEnum::PUBLISHED,
                ],
                'select' => ['id', 'name'],
            ]);

            $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();

            $jobTags = $this->tagRepository->advancedGet([
                'condition' => [
                    'status' => BaseStatusEnum::PUBLISHED,
                ],
                'select' => ['id', 'name'],
            ]);
        }

        // new code start

        $accountId = $account['id'];

        $rows = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        $selectedSkillsArray = $rows;

        $rows2 = DB::table('jb_account_favorite_tags')
            ->where('account_id', $accountId)
            ->pluck('tag_id')
            ->toArray();

        $selectedTagsArray = $rows2;


        $id = auth('account')->user();
        $accountsinformations = DB::table('jb_accounts')
            ->where('id', $id->id)
            ->get();


        return JobBoardHelper::scope('account.settings.index', compact('account', 'jobSkills', 'jobTags', 'selectedJobSkills', 'selectedJobTags', 'selectedSkillsArray', 'selectedTagsArray', 'accountsinformations'));
    }




    public function updateSettings(Request $request)
    {
        $id = auth('account')->user()->id;

        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required',
            'gender' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string',
            'permanent_resident' => 'required|integer',
            'legally_entitled' => 'required|integer',
            'job_skill' => 'required|string|max:255',
            'job_tag' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
            'description' => 'required|string|max:1000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
            'cover_letter' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx',
        ]);

        // Update the `jb_accounts` table
        DB::table('jb_accounts')->where('id', $id)->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'dob' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'address_line_2' => $validatedData['address_line_2'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
            'permanent_resident' => $validatedData['permanent_resident'],
            'legally_entitled' => $validatedData['legally_entitled'],
            'bio' => $validatedData['bio'],
            'description' => $validatedData['description'],
            'job_skill' => $validatedData['job_skill'],
            'job_tag' => $validatedData['job_tag'],
        ]);

        // Handle file uploads
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes');
            DB::table('jb_accounts')->where('id', $id)->update(['resume' => $resumePath]);
        }

        if ($request->hasFile('cover_letter')) {
            $coverLetterPath = $request->file('cover_letter')->store('cover_letters');
            DB::table('jb_accounts')->where('id', $id)->update(['cover_letter' => $coverLetterPath]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }


    public function updatesettingsemployer(Request $request)
    {
        $id = auth('account')->user()->id;

        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required',
            'gender' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string',
            'company_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
        ]);

        // Update the `jb_accounts` table
        DB::table('jb_accounts')->where('id', $id)->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'dob' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'address_line_2' => $validatedData['address_line_2'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
            'company_name' => $validatedData['company_name'],
            'designation' => $validatedData['designation'],
            'bio' => $validatedData['bio'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatesettingsConsultant(Request $request)
    {
        $id = auth('account')->user()->id;

        // Validate the request
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required',
            'gender' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'address_line_2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string',
            'company_name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'bio' => 'required|string|max:500',
        ]);

        // Update the `jb_accounts` table
        DB::table('jb_accounts')->where('id', $id)->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'dob' => $validatedData['dob'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'address_line_2' => $validatedData['address_line_2'],
            'city' => $validatedData['city'],
            'province' => $validatedData['province'],
            'company_name' => $validatedData['company_name'],
            'designation' => $validatedData['designation'],
            'bio' => $validatedData['bio'],
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }





    public function headerSetting()
    {
        $id = auth('account')->user();
        $accountsinformations = DB::table('jb_accounts')
            ->where('id', $id->id)
            ->get();

        return view('theme::jobbox.views.job-board.dashboard.layouts.header', compact('accountsinformations'));

    }

    // C:\xampp\htdocs\ReadyForce-Web-Laravel\platform\themes\jobbox\views\job-board\dashboard\layouts\header.blade.php








    public function postSettings(SettingRequest $request, BaseHttpResponse $response)
    {
        $account = auth('account')->user();
        $data = $request->validated();
        Arr::forget($data, ['resume', 'cover_letter']);

        $data['middle_name'] = $request->input('middle_name');

        $data['permanent_resident'] = $request->input('permanent_resident');
        $data['legally_entitled'] = $request->input('legally_entitled');
        $data['address_line_2'] = $request->input('address_line_2');
        $data['city'] = $request->input('city');
        $data['province'] = $request->input('province');
        //$data['calendly'] = $request->input('calendly');


        //$html_code = $request->input('calendly');
        //$data['calendly'] = htmlspecialchars($html_code);

        //$html_code = $request->input('calendly');
        //$data['calendly'] = htmlentities($html_code, ENT_QUOTES, 'UTF-8');

        $html_code = $request->input('calendly');
        $data['calendly'] = html_entity_decode($html_code, ENT_QUOTES, 'UTF-8');












        if ($request->hasFile('resume')) {
            $result = RvMedia::handleUpload($request->file('resume'), 0, $account->upload_folder);

            if (! $result['error']) {
                $data['resume'] = $result['data']->url;
            }
        }

        if ($request->hasFile('cover_letter')) {
            $result = RvMedia::handleUpload($request->file('cover_letter'), 0, $account->upload_folder);

            if (! $result['error']) {
                $data['cover_letter'] = $result['data']->url;
            }
        }

        event(new UpdatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        $this->accountRepository->createOrUpdate($data, ['id' => $account->getAuthIdentifier()]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_setting']);


        $accountType = $account['type'];


        if ($accountType == "job-seeker") {

            // added later start

            // Retrieve the selected skill IDs from the form submission
            $selectedSkills = $request->input('favorite_skills2');
            $selectedTags = $request->input('favorite_tags2');


            /*$accountId = $account['id'];




        $data2 = [];
        foreach ($selectedSkills as $skillId) {
            $data2[] = [
                'account_id' => $accountId,
                'skill_id' => intval($skillId),
            ];
        }


        DB::table('jb_account_favorite_skills')->insert($data2);*/





            $accountId = $account['id'];

            if ($selectedSkills != null) {
                // Delete existing rows for the account
                DB::table('jb_account_favorite_skills')
                    ->where('account_id', $accountId)
                    ->delete();

                // Prepare the data for insertion
                $data2 = [];
                foreach ($selectedSkills as $skillId) {
                    $data2[] = [
                        'account_id' => $accountId,
                        'skill_id' => intval($skillId),
                    ];
                }

                // Insert the updated data
                DB::table('jb_account_favorite_skills')->insert($data2);
            }



            // Tags new code
            if ($selectedTags != null) {
                // Delete existing rows for the account
                DB::table('jb_account_favorite_tags')
                    ->where('account_id', $accountId)
                    ->delete();

                // Prepare the data for insertion
                $data3 = [];
                foreach ($selectedTags as $tagId) {
                    $data3[] = [
                        'account_id' => $accountId,
                        'tag_id' => intval($tagId),
                    ];
                }

                // Insert the updated data
                DB::table('jb_account_favorite_tags')->insert($data3);
            }
        }














        // added later end

        return $response
            ->setNextUrl(route('public.account.settings'))
            ->setMessage(__('Update profile successfully!'));
    }

    public function getSecurity()
    {
        SeoHelper::setTitle(__('Security'));

        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        return JobBoardHelper::scope('account.settings.security', compact('account'));
    }

    public function postSecurity(UpdatePasswordRequest $request, BaseHttpResponse $response)
    {
        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        if (! Hash::check($request->input('old_password'), $account->getAuthPassword())) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/job-board::dashboard.current_password_incorrect'));
        }

        $this->accountRepository->update(['id' => $account->getAuthIdentifier()], [
            'password' => Hash::make($request->input('password')),
        ]);

        $this->activityLogRepository->createOrUpdate(['action' => 'update_security']);

        return $response->setMessage(trans('plugins/job-board::dashboard.password_update_success'));
    }

    // public function postAvatar(AvatarRequest $request, ThumbnailService $thumbnailService, BaseHttpResponse $response)
    // {
    //     try {
    //         $account = auth('account')->user();

    //         $result = RvMedia::handleUpload($request->file('avatar_file'), 0, $account->upload_folder);

    //         if ($result['error']) {
    //             return $response->setError()->setMessage($result['message']);
    //         }

    //         $avatarData = json_decode($request->input('avatar_data'));

    //         $file = $result['data'];

    //         $thumbnailService
    //             ->setImage(RvMedia::getRealPath($file->url))
    //             ->setSize((int)$avatarData->width, (int)$avatarData->height)
    //             ->setCoordinates((int)$avatarData->x, (int)$avatarData->y)
    //             ->setDestinationPath(File::dirname($file->url))
    //             ->setFileName(File::name($file->url) . '.' . File::extension($file->url))
    //             ->save('crop');

    //         $this->fileRepository->forceDelete(['id' => $account->avatar_id]);

    //         $account->avatar_id = $file->id;

    //         $this->accountRepository->createOrUpdate($account);

    //         $this->activityLogRepository->createOrUpdate([
    //             'action' => 'changed_avatar',
    //         ]);

    //         return $response
    //             ->setMessage(trans('plugins/job-board::dashboard.update_avatar_success'))
    //             ->setData(['url' => RvMedia::url($file->url)]);
    //     } catch (Exception $ex) {
    //         return $response
    //             ->setError()
    //             ->setMessage($ex->getMessage());
    //     }
    // }

    public function postAvatar(AvatarRequest $request, ThumbnailService $thumbnailService, BaseHttpResponse $response)
    {
        try {
            $account = auth('account')->user();

            // Handle the file upload
            $result = RvMedia::handleUpload($request->file('avatar_file'), 0, $account->upload_folder);

            if ($result['error']) {
                return $response->setError()->setMessage($result['message']);
            }

            $file = $result['data'];

            // Ensure you are not modifying the original image
            // Skip thumbnail processing or any other resizing if not required
            $account->avatar_id = $file->id;
            $this->accountRepository->createOrUpdate($account);

            return $response
                ->setMessage(trans('plugins/job-board::dashboard.update_avatar_success'))
                ->setData(['url' => RvMedia::url($file->url)]);
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }


    public function getActivityLogs(BaseHttpResponse $response)
    {
        $activities = $this->activityLogRepository->getAllLogs(auth('account')->user()->getAuthIdentifier());

        return $response->setData(ActivityLogResource::collection($activities))->toApiResponse();
    }

    public function postUpload(UploadResumeRequest $request, BaseHttpResponse $response)
    {
        $account = auth('account')->user();

        $result = RvMedia::handleUpload($request->file('file'), 0, $account->upload_folder);

        if ($result['error']) {
            return $response->setError();
        }

        return $response->setData($result['data']);
    }

    public function postUploadFromEditor(Request $request)
    {
        $account = auth('account')->user();

        return RvMedia::uploadFromEditor($request, 0, $account->upload_folder);
    }

    public function postUploadResume(
        UploadResumeRequest $request,
        AccountInterface $accountRepository,
        BaseHttpResponse $response
    ) {
        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        $result = RvMedia::handleUpload($request->file('file'), 0, $account->upload_folder);

        if ($result['error']) {
            return $response->setError();
        }

        $accountRepository->createOrUpdate(['resume' => $result['data']->url], ['id' => $account->id]);

        $url = null;
        if (! $account->phone) {
            $url = route('public.account.settings');
        }

        return $response->setData(compact('url'));
    }
}
