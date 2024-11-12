<?php

namespace Botble\JobBoard\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;

class ConsulatntPackageRequest extends Request
{
    protected function formatTime($time)
    {
        return Carbon::parse($time)->format('H:i');
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'region' => 'required',
            'credits' => 'numeric|required|min:0',
            'currency_id' => 'required',
            'order' => 'required|integer|min:0|max:127',
            'status' => Rule::in(BaseStatusEnum::values()),
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => [
                'required',
                'date_format:Y-m-d\TH:i',
                'after:start_time',
                function ($attribute, $value, $fail) {
                    $startTime = Carbon::parse($this->input('start_time'));
                    $endTime = Carbon::parse($value);
                    if ($endTime->diffInMinutes($startTime) >= 720) {
                        $fail('The end time must be less than 12 hours after the start time.');
                    }
                },
            ],
        ];
    }
}
