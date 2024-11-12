<?php

use Botble\Base\Forms\FormAbstract;
use Botble\JobBoard\Forms\Fields\CustomImageField;
use Botble\Location\Models\City;
use Botble\Blog\Models\Post;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Category;
use Botble\JobBoard\Models\Job;
use Botble\Page\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

register_page_template([
    'default' => 'Default',
    'page-detail' => __('Page detail'),
]);

register_sidebar([
    'id' => 'footer_sidebar',
    'name' => __('Footer sidebar'),
    'description' => __('Widgets in footer of page'),
]);

register_sidebar([
    'id' => 'pre_footer_sidebar',
    'name' => __('Pre footer sidebar'),
    'description' => __('Widgets at the bottom of the page.'),
]);

register_sidebar([
    'id' => 'blog_sidebar',
    'name' => __('Blog sidebar'),
    'description' => __('Widgets at the right of the page.'),
]);

register_sidebar([
    'id' => 'candidate_sidebar',
    'name' => __('Candidate sidebar'),
    'description' => __('Widgets at the right of the page candidate detail.'),
]);

register_sidebar([
    'id' => 'company_sidebar',
    'name' => __('Company sidebar'),
    'description' => __('Widgets at the right of the page company detail.'),
]);

RvMedia::setUploadPathAndURLToPublic();
RvMedia::addSize('featured', 403, 257);

Menu::addMenuLocation('footer-menu', 'Footer navigation');

add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function (FormAbstract $form, ?Model $data) {
    switch (get_class($data)) {
        case Account::class:
            $form
                ->add('cover_image', 'mediaImage', [
                    'label' => __('Cover Image'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'cover_image', true),
                ]);
            break;
        case Category::class:
            $form
                ->addAfter('status', 'job_category_image', 'mediaImage', [
                    'label' => __('Image'),
                    'value' => MetaBox::getMetaData($data, 'job_category_image', true),
                    'attr' => [
                        'placeholder' => __('Image'),
                        'class' => ['form-control'],
                    ],
                ]);
            break;
        case City::class:
            $form
                ->addAfter('is_default', 'city_image', 'mediaImage', [
                    'label' => __('Image'),
                    'label_attr' => ['class' => 'image-data'],
                    'value' => MetaBox::getMetaData($data, 'city_image', true),
                    'attr' => [
                        'placeholder' => __('Image'),
                        'class' => ['image-data'],
                    ],
                ]);
            break;
        case Post::class:
            $form
                ->add('cover_image', 'mediaImage', [
                    'label' => __('Cover Image'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'cover_image', true),
                ])
                ->addAfter('status', 'time_to_read', 'number', [
                    'label' => __('Time to read'),
                    'value' => MetaBox::getMetaData($data, 'time_to_read', true),
                    'attr' => [
                        'placeholder' => __('Time to read (minute)'),
                        'class' => ['image-data'],
                    ],
                ]);
            break;
        case Page::class:
            $form
                ->add('background_breadcrumb', 'mediaImage', [
                    'label' => __('Background Breadcrumb'),
                    'label_attr' => ['class' => 'control-label'],
                    'value' => MetaBox::getMetaData($data, 'background_breadcrumb', true),
                ]);
            break;
        case Job::class:
            if (auth()->check()) {
                $form
                    ->addAfter('moderation_status', 'featured_image', 'mediaImage', [
                        'label' => __('Featured Image'),
                        'label_attr' => ['class' => 'control-label'],
                        'value' => MetaBox::getMetaData($data, 'featured_image', true),
                    ]);
            } else {
                $form
                    ->addCustomField('customImage', CustomImageField::class)
                    ->addAfter('status', 'featured_image', 'customImage', [
                        'label' => __('Featured Image'),
                        'label_attr' => ['class' => 'control-label'],
                        'value' => MetaBox::getMetaData($data, 'featured_image', true),
                    ]);
            }

            break;
    }

    return $form;
}, 120, 3);

add_action([BASE_ACTION_AFTER_CREATE_CONTENT, BASE_ACTION_AFTER_UPDATE_CONTENT], function (string $screen, Request $request, $data): void
{
    if ($data instanceof City && $request->has('city_image')) {
        MetaBox::saveMetaBoxData($data, 'city_image', $request->input('city_image'));
    }

    if ($data instanceof Post && $request->has('time_to_read')) {
        MetaBox::saveMetaBoxData($data, 'time_to_read', $request->input('time_to_read'));
    }

    if ($data instanceof Category && $request->has('job_category_image')) {
        MetaBox::saveMetaBoxData($data, 'job_category_image', $request->input('job_category_image'));
    }

    if ($data instanceof Account && $request->has('cover_image')) {
        MetaBox::saveMetaBoxData($data, 'cover_image', $request->input('cover_image'));
    }

    if ($data instanceof Post) {
        MetaBox::saveMetaBoxData($data, 'cover_image', $request->input('cover_image'));
    }

    if ($data instanceof Page) {
        MetaBox::saveMetaBoxData($data, 'background_breadcrumb', $request->input('background_breadcrumb'));
    }

    if ($data instanceof Job && $request->has('featured_image')) {
        MetaBox::saveMetaBoxData($data, 'featured_image', $request->input('featured_image'));
    }
}, 120, 3);

function get_lat_long_theme_option(): ?string
{
    $center = theme_option('latitude_longitude_center_on_jobs_page', '');
    $latLng = '';
    if ($center) {
        $center = explode(',', $center);
        if (count($center) == 2) {
            $latLng = json_encode([trim($center[0]), trim($center[1])]);
        }
    }

    if (! $latLng) {
        $latLng = json_encode([43.615134, -76.393186]);
    }

    return $latLng;
}
