<?php

return [
    'name' => 'Job Applications',
    'edit' => 'View job application',
    'tables' => [
        'email' => 'Email',
        'phone' => 'Phone',
        'name' => 'Name',
        'first_name' => 'First name',
        'last_name' => 'Last name',
        'time' => 'Time',
        'message' => 'Summary',
        'resume' => 'Resume',
        'cover_letter' => 'Cover Letter',
        'position' => 'Position',
    ],
    'information' => 'Information',
    'email' => [
        'header' => 'Email',
        'title' => 'We received a new job application from the website!',
        'success' => 'Applied successfully!',
        'failed' => 'Can\'t apply on this time, please try again later!',
    ],
    'first_name.required' => 'First name is required',
    'last_name.required' => 'Last name is required',
    'phone.required' => 'Phone is required',
    'email.required' => 'Email is required',
    'email.email' => 'The email address is not valid',
    'message.required' => 'Message is required',
    'sender' => 'Sender',
    'sender_email' => 'Email',
    'statuses' => [
        'pending' => 'Pending',
        'checked' => 'Checked',
    ],
];
