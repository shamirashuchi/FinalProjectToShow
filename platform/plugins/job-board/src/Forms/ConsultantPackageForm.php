<?php

namespace Botble\JobBoard\Forms;

use Assets;
use Illuminate\Support\Facades\DB;
use Botble\Base\Forms\FormAbstract;
use Botble\JobBoard\Models\Package;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Http\Requests\PackageRequest;
use Botble\JobBoard\Repositories\Interfaces\CurrencyInterface;
use Botble\JobBoard\Repositories\Interfaces\ConsultantPackageInterface;
use JobBoardHelper;

class ConsultantPackageForm extends FormAbstract
{
    protected CurrencyInterface $currencyRepository;

    public function __construct(CurrencyInterface $currencyRepository)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
    }

    private function add_custom_script(): void
    {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function () {
            console.log("DOM fully loaded and parsed");
            const dateTimeUtc = moment().utc();
            console.log("dateTimeUtc:", dateTimeUtc.format("ddd, DD MMM YYYY HH:mm:ss"));

            const selectorOptions = moment.tz.names()
                .reduce((memo, tz) => {
                    memo.push({
                        name: tz,
                        offset: moment.tz(tz).utcOffset()
                    });
                    return memo;
                }, [])
                .sort((a, b) => a.offset - b.offset)
                .reduce((memo, tz) => {
                    const timezone = tz.offset ? moment.tz(tz.name).format("Z") : "";
                    return memo.concat(`<option value="${tz.name}">(GMT${timezone}) ${tz.name}</option>`);
                }, "");

            console.log("selectorOptions:", selectorOptions);
            document.querySelector(".js-Selector").innerHTML = selectorOptions;

            document.querySelector(".js-Selector").addEventListener("change", e => {
                const timestamp = dateTimeUtc.unix();
                const offset = moment.tz(e.target.value).utcOffset() * 60;
                const dateTimeLocal = moment.unix(timestamp + offset).utc();
                document.querySelector(".js-TimeLocal").innerHTML = dateTimeLocal.format("ddd, DD MMM YYYY HH:mm:ss");
            });

            document.querySelector(".js-Selector").value = "Europe/Madrid";
            const event = new Event("change");
            document.querySelector(".js-Selector").dispatchEvent(event);
        });
    </script>';
    }


    public function buildForm(): void
    {
        Assets::addScripts(['input-mask', 'moment', 'moment-timezone'])
            ->addScriptsDirectly([
                'https://momentjs.com/downloads/moment.js',
                'https://momentjs.com/downloads/moment-timezone-with-data.js',
            ]);
        $currencies = $this->currencyRepository->pluck('title', 'id');

        $this
            ->setupModel(new Package())
            ->setValidatorClass(PackageRequest::class)
            ->withCustomFields()
            ->setFormOption('template', JobBoardHelper::viewPath('dashboard.forms.base'))
            ->add('region', 'customSelect', [
                'label' => 'Timezone',
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group',
                ],
                'attr' => [
                    'class' => 'form-control js-Selector',
                ],
            ])
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('credits', 'number', [
                'label' => 'Credits',
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('currency_id', 'customSelect', [
                'label' => trans('plugins/job-board::package.currency'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'choices' => $currencies,
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('start_time', 'datetime-local', [
                'label' => 'Start Time',
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'placeholder' => 'Select start time',
                    'class' => 'form-control',
                ],
            ])
            ->add('end_time', 'datetime-local', [
                'label' => 'End Time',
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group col-md-6',
                ],
                'attr' => [
                    'placeholder' => 'Select end time',
                    'class' => 'form-control',
                ],
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');

        $this->add_custom_script();
    }
}
