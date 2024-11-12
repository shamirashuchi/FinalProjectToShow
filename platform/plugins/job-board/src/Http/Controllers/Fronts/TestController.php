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


class TestController extends Controller
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
        $data = ['account' => $account];
       return JobBoardHelper::view('dashboard.test', $data);
    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'verified' => 'required'
    ]);
    
    // Get the currently authenticated user's account
    $account = auth('account')->user();
    
    // Check if the account has enough credits to send a verification request
    if (JobBoardHelper::isEnabledCreditsSystem() && $account->credits < 1) {
        return redirect()->back()->withErrors(['credits' => __('You do not have enough credits to send a verification request.')]);
    }
    
    if (JobBoardHelper::isEnabledCreditsSystem() && $account->credits >= 1) {
        $account->credits--;
        $account->save();
    
        // Update the account's verified column
        Account::where('id', $account->id)
               ->update(['verified' => $validatedData['verified']]);
    }
    
    return redirect()->back()->with('success', 'Account updated successfully.');

    
    }

    
    
    
    
    
    
}

