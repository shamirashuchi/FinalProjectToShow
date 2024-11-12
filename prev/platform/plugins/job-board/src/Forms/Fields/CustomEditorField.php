<?php

namespace Botble\JobBoard\Forms\Fields;

use JobBoardHelper;
use Kris\LaravelFormBuilder\Fields\FormField;

class CustomEditorField extends FormField
{
    protected function getTemplate(): string
    {
        return JobBoardHelper::viewPath('dashboard.forms.fields.custom-editor');
    }
}
