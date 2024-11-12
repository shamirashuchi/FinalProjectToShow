<?php

namespace Botble\JobBoard\Forms\Fronts;

use Botble\JobBoard\Forms\JobApplicationForm;
use Botble\JobBoard\Http\Requests\EditJobApplicationRequest;
use Botble\JobBoard\Models\JobApplication;
use JobBoardHelper;

class ApplicantForm extends JobApplicationForm
{
    public function buildForm(): void
    {
        parent::buildForm();

        $this
            ->setupModel(new JobApplication())
            ->withCustomFields()
            ->setValidatorClass(EditJobApplicationRequest::class)
            ->setActionButtons(view('plugins/job-board::account.forms.actions')->render())
            ->setFormOption('template', JobBoardHelper::viewPath('dashboard.forms.base'));
    }
}
