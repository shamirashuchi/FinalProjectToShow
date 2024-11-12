<?php

namespace Botble\JobBoard\Forms;

use BaseHelper;
use Botble\Base\Forms\FormAbstract;
use Botble\JobBoard\Http\Requests\AccountMeetingRequest;
use Botble\JobBoard\Models\Event;

class AccountMeetingForm extends FormAbstract
{
    protected $template = 'core/base::forms.form-content-only';

    public function buildForm(): void
    {
        $data = $this->getData();

        $this
            ->setupModel(new Event())
            ->setValidatorClass(AccountMeetingRequest::class)
            ->withCustomFields()
            ->setFormOptions([
                'url' => route('accounts.meet.create.store'),
            ])
            ->add('account_id', 'hidden', [
                'label' => 'Account',
                'label_attr' => ['class' => 'control-label required'],
                'value' => $data['account']->id ?? $this->getModel()->account_id,
            ])
           // Day Field (Select)
           ->add('day', 'select', [
            'label' => __('Day'),
            'label_attr' => ['class' => 'control-label'],
            'default_value' => old('day'),
            'choices' => [
                '' => __('Select Day'),
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                'Wednesday' => 'Wednesday',
                'Thursday' => 'Thursday',
                'Friday' => 'Friday',
                'Saturday' => 'Saturday',
                'Sunday' => 'Sunday',
            ],
            'attr' => [
                'class' => 'form-control @error(\'day\') is-invalid @enderror',
            ],
        ])
        // Start Time Field (Input type: time)
        ->add('start_time', 'text', [
            'label' => __('Start Time'),
            'label_attr' => ['class' => 'control-label'],
            'value' => old('start_time'),
            'attr' => [
                'class' => 'form-control @error(\'start_time\') is-invalid @enderror',
                'type' => 'time',
            ],
        ])
        // End Time Field (Input type: time)
        ->add('end_time', 'text', [
            'label' => __('End Time'),
            'label_attr' => ['class' => 'control-label'],
            'value' => old('end_time'),
            'attr' => [
                'class' => 'form-control @error(\'end_time\') is-invalid @enderror',
                'type' => 'time',
            ],
        ])
        // Date Field (Input type: date)
        ->add('date', 'text', [
            'label' => __('Date'),
            'label_attr' => ['class' => 'control-label'],
            'value' => old('date'),
            'attr' => [
                'class' => 'form-control @error(\'date\') is-invalid @enderror',
                'type' => 'date',
            ],
        ])
            ->setBreakFieldPoint('status');
    }
}
