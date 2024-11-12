<?php

use Botble\JobBoard\Http\Controllers\AccountEducationController;
use Botble\JobBoard\Http\Controllers\AccountExperienceController;

Route::group(['namespace' => 'Botble\JobBoard\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/job-board', 'middleware' => 'auth'], function () {
        Route::get('settings', [
            'as' => 'job-board.settings',
            'uses' => 'JobBoardController@getSettings',
        ]);

        Route::post('settings', [
            'as' => 'job-board.settings.post',
            'uses' => 'JobBoardController@postSettings',
            'permission' => 'job-board.settings',
        ]);

        Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
            Route::resource('', 'JobController')->parameters(['' => 'job']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobController@deletes',
                'permission' => 'jobs.destroy',
            ]);

            Route::get('{id}/analytics', [
                'as' => 'analytics',
                'uses' => 'JobController@analytics',
                'permission' => 'jobs.index',
            ]);
        });

        Route::group(['prefix' => 'job-types', 'as' => 'job-types.'], function () {
            Route::resource('', 'JobTypeController')
                ->parameters(['' => 'job-type']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobTypeController@deletes',
                'permission' => 'job-types.destroy',
            ]);
        });

        Route::group(['prefix' => 'job-skills', 'as' => 'job-skills.'], function () {
            Route::resource('', 'JobSkillController')->parameters(['' => 'job-skill']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobSkillController@deletes',
                'permission' => 'job-skills.destroy',
            ]);
        });

        Route::group(['prefix' => 'job-shifts', 'as' => 'job-shifts.'], function () {
            Route::resource('', 'JobShiftController')->parameters(['' => 'job-shift']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobShiftController@deletes',
                'permission' => 'job-shifts.destroy',
            ]);
        });

        Route::group(['prefix' => 'job-experiences', 'as' => 'job-experiences.'], function () {
            Route::resource('', 'JobExperienceController')->parameters(['' => 'job-experience']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobExperienceController@deletes',
                'permission' => 'job-experiences.destroy',
            ]);
        });

        Route::group(['prefix' => 'language-levels', 'as' => 'language-levels.'], function () {
            Route::resource('', 'LanguageLevelController')->parameters(['' => 'language-level']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'LanguageLevelController@deletes',
                'permission' => 'language-levels.destroy',
            ]);
        });

        Route::group(['prefix' => 'career-levels', 'as' => 'career-levels.'], function () {
            Route::resource('', 'CareerLevelController')
                ->parameters(['' => 'career-level']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'CareerLevelController@deletes',
                'permission' => 'career-levels.destroy',
            ]);
        });

        Route::group(['prefix' => 'functional-areas', 'as' => 'functional-areas.'], function () {
            Route::resource('', 'FunctionalAreaController')
                ->parameters(['' => 'functional-area']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'FunctionalAreaController@deletes',
                'permission' => 'functional-areas.destroy',
            ]);
        });

        Route::group(['prefix' => 'job-categories', 'as' => 'job-categories.'], function () {
            Route::resource('', 'CategoryController')
                ->parameters(['' => 'job-category']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'CategoryController@deletes',
                'permission' => 'job-categories.destroy',
            ]);
        });

        Route::group(['prefix' => 'degree-types', 'as' => 'degree-types.'], function () {
            Route::resource('', 'DegreeTypeController')
                ->parameters(['' => 'degree-type']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'DegreeTypeController@deletes',
                'permission' => 'degree-types.destroy',
            ]);
        });

        Route::group(['prefix' => 'degree-levels', 'as' => 'degree-levels.'], function () {
            Route::resource('', 'DegreeLevelController')
                ->parameters(['' => 'degree-levels']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'DegreeLevelController@deletes',
                'permission' => 'degree-levels.destroy',
            ]);
        });

        Route::group(['prefix' => 'tags', 'as' => 'job-board.tag.'], function () {
            Route::resource('', 'TagController')
                ->parameters(['' => 'tag']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'TagController@deletes',
                'permission' => 'job-board.tag.destroy',
            ]);

            Route::get('all', [
                'as' => 'all',
                'uses' => 'TagController@getAllTags',
                'permission' => 'job-board.tag.index',
            ]);
        });

        Route::group(['prefix' => 'accounts', 'as' => 'accounts.'], function () {
            Route::resource('', 'AccountController')->parameters(['' => 'account']);

            Route::group(['prefix' => 'educations', 'as' => 'educations.'], function () {
                Route::resource('', AccountEducationController::class)->parameters(['' => 'education']);
                Route::get('{id}/{accountId}/edit-modal', [AccountEducationController::class, 'editModal'])->name('edit-modal');
            });

            Route::group(['prefix' => 'experiences', 'as' => 'experiences.'], function () {
                Route::resource('', AccountExperienceController::class)->parameters(['' => 'experience']);
                Route::get('{id}/{accountId}/edit-modal', [AccountExperienceController::class, 'editModal'])->name('edit-modal');
            });

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'AccountController@deletes',
                'permission' => 'accounts.destroy',
            ]);

            Route::get('list', [
                'as' => 'list',
                'uses' => 'AccountController@getList',
                'permission' => 'accounts.index',
            ]);

            Route::post('credits/{id}', [
                'as' => 'credits.add',
                'uses' => 'TransactionController@postCreate',
                'permission' => 'accounts.edit',
            ]);

            Route::get('all-employers', [
                'as' => 'all-employers',
                'uses' => 'AccountController@getAllEmployers',
                'permission' => 'accounts.index',
            ]);
        });

        Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
            Route::resource('', 'PackageController')->parameters(['' => 'package']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'PackageController@deletes',
                'permission' => 'packages.destroy',
            ]);
        });

        Route::group(['prefix' => 'companies', 'as' => 'companies.'], function () {
            Route::resource('', 'CompanyController')->parameters(['' => 'company']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'CompanyController@deletes',
                'permission' => 'companies.destroy',
            ]);

            Route::get('list', [
                'as' => 'list',
                'uses' => 'CompanyController@getList',
                'permission' => 'companies.index',
            ]);

            Route::get('all', [
                'as' => 'all',
                'uses' => 'CompanyController@getAllCompanies',
                'permission' => 'companies.index',
            ]);

            Route::get('{id}/analytics', [
                'as' => 'analytics',
                'uses' => 'CompanyController@analytics',
                'permission' => 'companies.index',
            ]);
        });

        Route::get('ajax/companies/{id}', 'CompanyController@ajaxGetCompany')
            ->name('ajax.company.show');
        Route::post('ajax/companies', 'CompanyController@ajaxCreateCompany')
            ->name('ajax.company.create');

        Route::group(['prefix' => 'job-applications', 'as' => 'job-applications.'], function () {
            Route::resource('', 'JobApplicationController')
                ->except(['create', 'store'])
                ->parameters(['' => 'job-application']);
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'JobApplicationController@deletes',
                'permission' => 'job-applications.destroy',
            ]);
        });

        Route::group(['prefix' => 'invoices', 'as' => 'invoice.'], function () {
            Route::resource('', 'InvoiceController')
                ->parameters(['' => 'invoice'])
                ->except(['create', 'store', 'update']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'InvoiceController@deletes',
                'permission' => 'invoice.destroy',
            ]);

            Route::get('generate-invoice/{id}', [
                'as' => 'generate-invoice',
                'uses' => 'InvoiceController@getGenerateInvoice',
                'permission' => 'invoice.edit',
            ]);
        });

        Route::prefix('invoice-template')->name('invoice-template.')->group(function () {
            Route::get('/', [
                'as' => 'index',
                'uses' => 'InvoiceTemplateController@index',
                'permission' => 'invoice-template.index',
            ]);

            Route::put('/', [
                'as' => 'update',
                'uses' => 'InvoiceTemplateController@update',
                'permission' => 'invoice-template.index',
            ]);

            Route::post('reset', [
                'as' => 'reset',
                'uses' => 'InvoiceTemplateController@reset',
                'permission' => 'invoice-template.index',
            ]);

            Route::get('preview', [
                'as' => 'preview',
                'uses' => 'InvoiceTemplateController@preview',
                'permission' => 'invoice-template.index',
            ]);
        });
    });
});
