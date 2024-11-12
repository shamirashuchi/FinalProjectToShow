<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;



use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Http\Resources\AccountResource;
use Botble\JobBoard\Http\Resources\PackageResource;
use Botble\JobBoard\Http\Resources\TransactionResource;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Package;
use Botble\JobBoard\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\PackageInterface;
use Botble\JobBoard\Repositories\Interfaces\TransactionInterface;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Paypal\Services\Gateways\PayPalPaymentService;
use EmailHandler;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use JobBoardHelper;
use Language;
use SeoHelper;
use Theme;
//added later
use Illuminate\Support\Facades\DB;



class JobSeekerMatchController extends Controller
{
    protected JobApplicationInterface $applicationRepository;

    public function __construct(
        JobApplicationInterface $applicationRepository,
    ) {
        $this->applicationRepository = $applicationRepository;
    }


    public function index()
    {

        $account = auth('account')->user();

        $account_id = $account->id;


        // Get all companies ID under the given account ID
        $companyIds = DB::table('jb_companies_accounts')
            ->where('account_id', $account_id)
            ->pluck('company_id');

        // Get details of each company from jb_companies table with prefix 'comp'
        $companies = DB::table('jb_companies as comp')
            ->whereIn('comp.id', $companyIds)
            ->get();

        // Get all approved jobs from all companies with prefix 'job'
        $jobs = DB::table('jb_jobs as job')
            ->whereIn('job.company_id', $companyIds)
            ->get();

        $jobIds = $jobs->pluck('id');

        // Get job skills for each job
        $jobSkills = DB::table('jb_jobs_skills')
            ->whereIn('job_id', $jobIds)
            ->get();

        $jobSkillIds = $jobSkills->pluck('job_skill_id');

        // Get job skills details from jb_job_skills table with prefix 'skill'
        $skills = DB::table('jb_job_skills as skill')
            ->whereIn('skill.id', $jobSkillIds)
            ->get();

        // Get account favorite skills
        $favoriteSkills = DB::table('jb_account_favorite_skills')
            ->whereIn('skill_id', $jobSkillIds)
            ->get();

        $accountIds = $favoriteSkills->pluck('account_id');


        $resultArray = [];

        //dd($companyIds);



       // $data = ['account' => $account];
       $data = ['account' => $account, 'resultArray' => $resultArray];
       return JobBoardHelper::view('dashboard.jobseekermatch', $data);
    }








    public function applicantslist()
{
    $account = auth('account')->user();
    $account_id = $account->id;

    $companyId = DB::table('jb_companies_accounts')
        ->where('account_id', $account_id)
        ->first('company_id');

    $companyId = $companyId ? $companyId->company_id : null;

    $resultArray = DB::table('jb_jobs')
        ->where('jb_jobs.company_id', $companyId)
        ->leftJoin('jb_applications', 'jb_applications.job_id', '=', 'jb_jobs.id')
        ->leftJoin('jb_accounts', 'jb_accounts.id', '=', 'jb_applications.account_id')
        ->select(
            'jb_jobs.*',
            'jb_applications.id AS jb_application_id', // Alias jb_applications.id as jb_application_id
            'jb_applications.*', // Retrieve all other columns from jb_applications
            'jb_accounts.*' // Retrieve all columns from jb_accounts
        )
        ->get();

    $newApplicants = $this->applicationRepository
        ->select([
            'jb_applications.id',
            'jb_applications.first_name',
            'jb_applications.last_name',
            'jb_applications.email',
            'jb_applications.phone',
        ])
        ->whereHas('job', function (Builder $query) use ($account) {
            $query->byAccount($account->getKey());
        })
        ->orderBy('jb_applications.created_at', 'desc')
        ->limit(10)
        ->get();

    // Merge and remove duplicates based on 'jb_application_id'
    $combinedResultArray = $resultArray->merge($newApplicants)->unique('jb_application_id');

    $data = ['combinedResultArray' => $combinedResultArray, 'company_id' => $companyId];
    return JobBoardHelper::view('dashboard.applicantslist', $data);
}




//     public function applicantslist()
// {
//     $account = auth('account')->user();
//     $account_id = $account->id;

//     // Get the company ID
//     $companyId = DB::table('jb_companies_accounts')
//         ->where('account_id', $account_id)
//         ->first('company_id');

//     if ($companyId) {
//         $companyId = $companyId->company_id;
//     } else {
//         $companyId = null; // Handle if no company ID is found
//     }

//     // Query the jobs and applicants data
//     $resultArray = DB::table('jb_jobs')
//         ->where('jb_jobs.company_id', $companyId)
//         ->leftJoin('jb_applications', 'jb_applications.job_id', '=', 'jb_jobs.id')
//         ->leftJoin('jb_accounts', 'jb_accounts.id', '=', 'jb_applications.account_id')
//         ->select(
//             'jb_jobs.*',
//             'jb_applications.id AS jb_application_id',
//             'jb_applications.*',
//             'jb_accounts.*'
//         )
//         ->get();


//         $newApplicants = $this->applicationRepository
//         ->select([
//             'jb_applications.id',
//             'jb_applications.first_name',
//             'jb_applications.last_name',
//             'jb_applications.email',
//             'jb_applications.phone',
//         ])
//         ->whereHas('job', function (Builder $query) use ($account) {
//             $query->byAccount($account->getKey());
//         })
//         ->orderBy('jb_applications.created_at', 'desc')
//         ->limit(10)
//         ->get();

//     $data = [
//         'resultArray' => $resultArray,
//         'company_id' => $companyId,
//         'newApplicants' => $newApplicants,
//     ];

//     return JobBoardHelper::view('dashboard.applicantslist', $data);
// }





    public function paytoseedetails2()
    {



        //dd($resultArray);




       //$data = ['resultArray' => $resultArray, 'company_id' => $companyId];
       //return JobBoardHelper::view('dashboard.applicantslist', $data);
    }


    public function paytoseedetails3(Request $request)
    {
        $company_id = $request->input('company_id');
        $job_id = $request->input('job_id');
        $applicant_id = $request->input('applicant_id');

        // Now you have access to $company_id, $job_id, and $applicant_id



        // Check credit

        // if not go to the credit add page

        // if yes, insert the data in new tabe and then minux the credit



        //dd($company_id, $job_id, $applicant_id);
    }



    public function paytoseedetails(Request $request)
    {
        $company_id = $request->input('company_id');
        $job_id = $request->input('job_id');
        $applicant_id = $request->input('applicant_id');



        $account_loggedin = auth('account')->user();
        $loggedin_id = $account_loggedin->id;



        // Get single row and credits column from jb_accounts table
        $credits = DB::table('jb_accounts')
            ->where('id', $loggedin_id)
            ->value('credits');

        // Put the credits value in a variable
        $creditsValue = intval($credits);

        // Check if the value is less than 1, then redirect
        if ($creditsValue < 1) {
            return redirect()->route('public.account.packages');
        }

        else {
             // Insert data into paytoseedetails table using DB facade
            DB::table('paytoseedetails')->insert([
                'company_id' => $company_id,
                'job_id' => $job_id,
                'applicant_id' => $applicant_id,
            ]);

            // Decrement credits value by 1 in jb_accounts table using DB facade
            DB::table('jb_accounts')
                ->where('id', $loggedin_id)
                ->decrement('credits');

            return redirect()->route('public.account.applicantslist');

            // Return a response or redirect as needed
        }


    }






























}

