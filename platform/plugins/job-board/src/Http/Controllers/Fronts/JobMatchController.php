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


class JobMatchController extends Controller
{
    public function index()
    {
        //dd('This is a test');

        $account = auth('account')->user();


        /*SeoHelper::setTitle(__('Account settings'));

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

        return JobBoardHelper::scope('account.settings.index', compact('account', 'jobSkills', 'jobTags', 'selectedJobSkills', 'selectedJobTags'));*/

        //$data = [];


        $selectedJobSkills = $account->favoriteSkills()->pluck('jb_job_skills.id')->all();

        $selectedJobTags = $account->favoriteTags()->pluck('jb_tags.id')->all();


        $accountId = $account['id'];



        // Retrieve the user's favorite skills

        /*$favoriteSkills = DB::table('jb_account_favorite_skills')
            ->where('account_id', $accountId)
            ->pluck('skill_id')
            ->toArray();

        // Query the jobs and companies tables, joining the necessary tables
        $queryResult = DB::table('jb_jobs')

            ->select('jb_jobs.*', 'jb_companies.id AS company_id', 'jb_companies.name AS company_name', 'jb_companies.description AS company_description')
            ->leftJoin('jb_companies', 'jb_jobs.company_id', '=', 'jb_companies.id')
            ->join('jb_jobs_skills', 'jb_jobs.id', '=', 'jb_jobs_skills.job_id')
            ->join('jb_job_skills', 'jb_jobs_skills.job_skill_id', '=', 'jb_job_skills.id')
            ->whereIn('jb_job_skills.id', $favoriteSkills)
            ->get();

        $resultArray = $queryResult->toArray();*/


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





        //dd($resultArray);

        // you have auth details, with that find all the skills of thet auth person


        // match skills and the job required skills and then  put in the data array


        //$nameSnippet = Str::slug($resultArray->name, '-');





       // $data = ['account' => $account];
       $data = ['account' => $account, 'resultArray' => $resultArray];
       return JobBoardHelper::view('dashboard.jobmatch', $data);
    }










}

