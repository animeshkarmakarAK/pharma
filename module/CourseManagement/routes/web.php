<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/course-management', 'as' => 'course_management::admin.', 'middleware' => ['auth']], function () {
    Route::resources([
        'institutes' => Module\CourseManagement\App\Http\Controllers\InstituteController::class,
        'courses' => Module\CourseManagement\App\Http\Controllers\CourseController::class,
        'branches' => Module\CourseManagement\App\Http\Controllers\BranchController::class,
        'training-centers' => Module\CourseManagement\App\Http\Controllers\TrainingCenterController::class,
        'application-form-types' => Module\CourseManagement\App\Http\Controllers\ApplicationFormTypeController::class,
        'programmes' => Module\CourseManagement\App\Http\Controllers\ProgrammeController::class,
        'publish-courses' => Module\CourseManagement\App\Http\Controllers\PublishCourseController::class,
        'batches' => Module\CourseManagement\App\Http\Controllers\BatchController::class,
        'galleries' => Module\CourseManagement\App\Http\Controllers\GalleryController::class,
        'gallery-categories' => Module\CourseManagement\App\Http\Controllers\GalleryCategoryController::class,
        'sliders' => Module\CourseManagement\App\Http\Controllers\SliderController::class,
        'static-page' => Module\CourseManagement\App\Http\Controllers\StaticPageController::class,
        'videos' => Module\CourseManagement\App\Http\Controllers\VideoController::class,
        'video-categories' => Module\CourseManagement\App\Http\Controllers\VideoCategoryController::class,
    ]);
    Route::post('static-page/image-upload', [Module\CourseManagement\App\Http\Controllers\StaticPageController::class, 'imageUpload'])->name('staticPage.imageUpload');
    Route::post('institutes/datatable', [Module\CourseManagement\App\Http\Controllers\InstituteController::class, 'getDatatable'])->name('institutes.datatable');
    Route::post('branches/datatable', [Module\CourseManagement\App\Http\Controllers\BranchController::class, 'getDatatable'])->name('branches.datatable');
    Route::post('training-centers/datatable', [Module\CourseManagement\App\Http\Controllers\TrainingCenterController::class, 'getDatatable'])->name('training-centers.datatable');
    Route::post('courses/datatable', [Module\CourseManagement\App\Http\Controllers\CourseController::class, 'getDatatable'])->name('courses.datatable');
    Route::post('application-form-types/datatable', [Module\CourseManagement\App\Http\Controllers\ApplicationFormTypeController::class, 'getDatatable'])->name('application-form-types.datatable');
    Route::post('programmes/datatable', [Module\CourseManagement\App\Http\Controllers\ProgrammeController::class, 'getDatatable'])->name('programmes.datatable');
    Route::post('publish-courses/datatable', [Module\CourseManagement\App\Http\Controllers\PublishCourseController::class, 'getDatatable'])->name('publish-courses.datatable');
    Route::post('batches/datatable', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'getDatatable'])->name('batches.datatable');
    Route::post('gallery/datatable', [Module\CourseManagement\App\Http\Controllers\GalleryController::class, 'getDatatable'])->name('gallery.datatable');
    Route::post('gallery-categories/datatable', [Module\CourseManagement\App\Http\Controllers\GalleryCategoryController::class, 'getDatatable'])->name('gallery-categories.datatable');
    Route::post('sliders/datatable', [Module\CourseManagement\App\Http\Controllers\SliderController::class, 'getDatatable'])->name('sliders.datatable');
    Route::post('static-page/datatable', [Module\CourseManagement\App\Http\Controllers\StaticPageController::class, 'getDatatable'])->name('static-page.datatable');
    Route::post('videos/datatable', [Module\CourseManagement\App\Http\Controllers\VideoController::class, 'getDatatable'])->name('videos.datatable');
    Route::post('video-categories/datatable', [Module\CourseManagement\App\Http\Controllers\VideoCategoryController::class, 'getDatatable'])->name('video-categories.datatable');

    Route::get('batches/{id}/youths', [Module\CourseManagement\App\Http\Controllers\YouthBatchController::class, 'index'])->name('batches.youths');
    Route::post('batches/{id}/youths/datatable', [Module\CourseManagement\App\Http\Controllers\YouthBatchController::class, 'getDatatable'])->name('batches.youths.datatable');

    Route::get('youth-registrations', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'index'])
        ->name('youth.registrations.index');
    Route::post('youth-registrations/datatable', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'getDatatable'])
        ->name('youth.registrations.datatable');
    Route::post('youth-registrations/add-to-batch', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'addYouthToBatch'])
        ->name('youth.add-to-batch');

    Route::resource('batches', Module\CourseManagement\App\Http\Controllers\BatchController::class);

    Route::post('programmes/check-programme-code', [Module\CourseManagement\App\Http\Controllers\ProgrammeController::class, 'checkCode'])->name('check-programme-code');
    Route::post('institutes/check-institute-code', [Module\CourseManagement\App\Http\Controllers\InstituteController::class, 'checkCode'])->name('check-institute-code');
    Route::post('static-page/check-page-id', [Module\CourseManagement\App\Http\Controllers\StaticPageController::class, 'checkCode'])->name('check-page-id');
    Route::post('courses/check-course-code', [Module\CourseManagement\App\Http\Controllers\CourseController::class, 'checkCode'])->name('check-course-code');
    Route::post('batches/check-batch-code', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'checkCode'])->name('check-batch-code');

    Route::resource('visitor-feedback', Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class)->only(['index', 'destroy', 'show']);
    Route::post('visitor-feedback/datatable', [Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'getDatatable'])->name('visitor-feedback.datatable');
    Route::get('featured-galleries', [\Module\CourseManagement\App\Http\Controllers\GalleryCategoryController::class, 'featuredGalleries'])->name('gallery-album.featured');
    Route::post('featured-galleries', [\Module\CourseManagement\App\Http\Controllers\GalleryCategoryController::class, 'changeFeaturedGalleries'])->name('gallery-album.change-featured');
});

Route::group(['prefix' => 'course-management', 'as' => 'course_management::'], function () {
    Route::get('courses-search', [Module\CourseManagement\App\Http\Controllers\Frontend\CourseSearchController::class, 'findCourse'])->name('course_search');
    Route::get('course-details-ajax/{publish_course_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\CourseSearchController::class, 'courseDetails'])->name('course-details.ajax');

    Route::get('youth-profile/{id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'index'])->name('youth');
    Route::get('skill-videos', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'videos'])->name('youth.skill_videos');
    Route::get('advice-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'advicePage'])->name('advice-page');
    Route::get('general-ask-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'generalAskPage'])->name('general-ask-page');
    Route::get('contact-us-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'contactUsPage'])->name('contact-us-page');
    Route::post('visitor-feedback-store', [Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'store'])->name('visitor-feedback.store');
    Route::get('yearly-training-calendar', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'index'])->name('yearly-training-calendar.index');
    Route::post('yearly-training-calendar-ajax', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'allEvent'])->name('yearly-training-calendar.all-event');

    Route::resources([
        'youth-registrations' => Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class,
    ]);

    Route::get('youth-registration/success/{accessKey}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class, 'registrationSuccess'])->name('youth-registration.success');
    Route::get('youth-login', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthLoginController::class, 'loginForm'])->name('youth.login-form');
    Route::get('youth-password-reset', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthLoginController::class, 'passwordResetForm'])->name('youth.password-reset');
    Route::post('youth-login', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthLoginController::class, 'login'])->name('youth.login-submit');
    Route::post('youth-logout', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthLoginController::class, 'logout'])->name('youth.logout-submit');

    Route::get('sc/{page_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\StaticContentController::class, 'index'])
        ->name('static-content.show');

    Route::post('youth/recover-access-key-by-email', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'sendMailToRecoverAccessKey'])->name('youth.recover-access-key');
    Route::post('youth/registration-success-email', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'sendMailToRegistrationSuccess'])->name('youth.registration-success-mail');
    Route::get('youth/check-unique-email', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthEmailUniqueness'])->name('youth.check-unique-email');


});
