<?php

Route::group(['namespace' => 'Botble\JobBoard\Http\Controllers\Fronts', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::post('review/create', [
            'as' => 'public.reviews.create',
            'uses' => 'ReviewController@store',
            'middleware' => 'account',
        ]);

        Route::get('review/load-more', [
            'as' => 'public.reviews.load-more',
            'uses' => 'ReviewController@loadMore',
        ]);
    });
});

Route::group(['namespace' => 'Botble\JobBoard\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/job-board', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'reviews', 'as' => 'reviews.'], function () {
            Route::resource('', 'ReviewController')
                ->only(['index', 'destroy'])
                ->parameters(['' => 'review']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'ReviewController@deletes',
                'permission' => 'reviews.destroy',
            ]);
        });
    });
});
