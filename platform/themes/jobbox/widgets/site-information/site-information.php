<?php

use Botble\Widget\AbstractWidget;

class SiteInformationWidget extends AbstractWidget
{
    protected $widgetDirectory = 'site-information';

    public function __construct()
    {
        parent::__construct([
            'name' => __('Site Information'),
            'description' => __('Site information like social links, short description and logo at the bottom of the page'),
            'logo' => null,
            'introduction' => null,
            'socials' => ['facebook', 'twitter', 'linkedin'],
            'facebook_url' => null,
            'twitter_url' => null,
            'linkedin_url' => null,
        ]);
    }
}
