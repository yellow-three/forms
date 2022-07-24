<?php

/**
 * Admin Route/s
 */
Route::group([
    'as' => 'voyager.forms.',
    'prefix' => 'admin/forms/',
    'middleware' => ['web', 'admin.user'],
    'namespace' => '\YellowThree\VoyagerForms\Http\Controllers'
], function () {
    Route::post('sort', ['uses' => "InputController@sort", 'as' => 'sort']);
});

Route::group([
    'as' => 'voyager.enquiries.',
    'prefix' => 'admin/enquiries/',
    'middleware' => ['web', 'admin.user'],
    'namespace' => '\YellowThree\VoyagerForms\Http\Controllers'
], function () {
    Route::get('{id}/file/{fileKey}', ['uses' => "EnquiryController@getFile", 'as' => 'file']);
});


/**
 * Front-end Route/s
 */
Route::group([
    'as' => 'voyager.enquiries.',
    'middleware' => ['web'],
    'namespace' => '\YellowThree\VoyagerForms\Http\Controllers'
], function () {
    Route::post('voyager-forms-submit-enquiry/{id}', ['uses' => "EnquiryController@submit", 'as' => 'submit']);
});
