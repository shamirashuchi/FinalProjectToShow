<?php

use Carbon\Carbon;

app()->booted(function () {
    theme_option()
        ->setSection([
            'title' => __('Styles'),
            'id' => 'opt-text-subsection-style',
            'subsection' => true,
            'icon' => 'fa fa-palette',
        ])
        ->setField([
           'id' => 'copyright',
           'section_id' => 'opt-text-subsection-general',
           'type' => 'text',
           'label' => __('Copyright'),
           'attributes' => [
               'name' => 'copyright',
               'value' => __('Copyright © :year. JobBox all right reserved', ['year' => Carbon::now()->format('Y')]),
               'options' => [
                   'class' => 'form-control',
                   'placeholder' => __('Change copyright'),
                   'data-counter' => 250,
               ],
           ],
           'helper' => __('Copyright on footer of site'),
        ])
        ->setField([
           'id' => 'introduction',
           'section_id' => 'opt-text-subsection-general',
           'type' => 'text',
           'label' => __('Introduction'),
           'attributes' => [
               'name' => 'introduction',
               'value' => __('JobBox is the heart of the design community and the best resource to discover and connect with designers and jobs worldwide.'),
               'options' => [
                   'class' => 'form-control',
                   'placeholder' => __('Change introduction'),
                   'data-counter' => 250,
               ],
           ],
           'helper' => __('Introduction on footer of site'),
        ])
        ->setField([
            'id' => 'app_advertisement',
            'section_id' => 'opt-text-subsection-general',
            'type' => 'text',
            'label' => __('App advertisement'),
            'attributes' => [
               'name' => 'app_advertisement',
               'value' => __('Download our Apps and get extra 15% Discount on your first Order&mldr;!'),
               'options' => [
                   'class' => 'form-control',
                   'placeholder' => __('Change app advertisement'),
                   'data-counter' => 250,
               ],
            ],
            'helper' => __('App advertisement on footer of site'),
        ])
        ->setField([
            'id' => 'blog_page_template',
            'section_id' => 'opt-text-subsection-blog',
            'type' => 'customSelect',
            'label' => __('Blog page template'),
            'attributes' => [
                'name' => 'blog_page_template',
                'list' => ['blog_gird_1' => __('Blog Gird 1'), 'blog_gird_2' => __('Blog Gird 2')],
                'value' => '',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => 'background_breadcrumb',
            'section_id' => 'opt-text-subsection-blog',
            'type' => 'mediaImage',
            'label' => __('Background Breadcrumb'),
            'attributes' => [
                'name' => 'background_breadcrumb',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'background_blog_single',
            'section_id' => 'opt-text-subsection-blog',
            'type' => 'mediaImage',
            'label' => __('Background Blog Single'),
            'attributes' => [
                'name' => 'background_blog_single',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'auth_background_image_1',
            'section_id' => 'opt-text-subsection-job-board',
            'type' => 'mediaImage',
            'label' => __('Authentication background image 1'),
            'attributes' => [
                'name' => 'auth_background_image_1',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'auth_background_image_2',
            'section_id' => 'opt-text-subsection-job-board',
            'type' => 'mediaImage',
            'label' => __('Authentication background image 2'),
            'attributes' => [
                'name' => 'auth_background_image_2',
                'value' => null,
            ],
        ])
        ->setField([
            'id' => 'show_map_on_jobs_page',
            'section_id' => 'opt-text-subsection-job-board',
            'type' => 'customSelect',
            'label' => __('Show map on jobs page?'),
            'attributes' => [
                'name' => 'show_map_on_jobs_page',
                'list' => [
                    'yes' => trans('core/base::base.yes'),
                    'no' => trans('core/base::base.no'),
                ],
                'value' => 'yes',
            ],
        ])
        ->setField([
            'id' => 'latitude_longitude_center_on_jobs_page',
            'section_id' => 'opt-text-subsection-job-board',
            'type' => 'text',
            'label' => __('Latitude longitude center on jobs page'),
            'attributes' => [
                'name' => 'latitude_longitude_center_on_jobs_page',
                'value' => '43.615134, -76.393186',
                'options' => [
                    'class' => 'form-control',
                ],
            ],
        ])
        ->setField([
            'id' => '404_page_image',
            'section_id' => 'opt-text-subsection-page',
            'type' => 'mediaImage',
            'label' => __('404 page image'),
            'attributes' => [
                'name' => '404_page_image',
                'value' => '',
            ],
        ])
        ->setField([
            'id' => 'primary_font',
            'section_id' => 'opt-text-subsection-style',
            'type' => 'googleFonts',
            'label' => __('Primary font'),
            'attributes' => [
                'name' => 'primary_font',
                'value' => 'Plus Jakarta Sans',
            ],
        ])
        ->setField([
            'id' => 'primary_color',
            'section_id' => 'opt-text-subsection-style',
            'type' => 'customColor',
            'label' => __('Primary color'),
            'attributes' => [
                'name' => 'primary_color',
                'value' => '#3C65F5',
            ],
        ])
        ->setField([
            'id' => 'secondary_color',
            'section_id' => 'opt-text-subsection-style',
            'type' => 'customColor',
            'label' => __('Secondary color'),
            'attributes' => [
                'name' => 'secondary_color',
                'value' => '#05264E',
            ],
        ])
        ->setField([
            'id' => 'border_color_2',
            'section_id' => 'opt-text-subsection-style',
            'type' => 'customColor',
            'label' => __('Border color'),
            'attributes' => [
                'name' => 'border_color_2',
                'value' => '#E0E6F7',
            ],
        ]);
});
