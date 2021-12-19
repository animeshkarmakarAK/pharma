<?php

use Illuminate\Support\Facades\Route;

Route::get('/success', [\App\Http\Controllers\HomeController::class, 'success'])->name('success');
Route::get('/fail', [\App\Http\Controllers\HomeController::class, 'fail'])->name('fail');
Route::get('/cancel', [\App\Http\Controllers\HomeController::class, 'cancel'])->name('cancel');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/check-unique-user-email', [App\Http\Controllers\Admin\UserController::class, 'checkUserEmailUniqueness'])->name('users.check-unique-user-email');
});

Route::post('ipn-handler', [App\Http\Controllers\Frontend\YouthController::class, 'ipnHandler'])->name('api-ipn-handler');
Route::post('youth-bulk-import', [App\Http\Controllers\YouthManagementController::class, 'importYouth'])->name('api-youth-bulk-import');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::resources([
        'institutes' => App\Http\Controllers\InstituteController::class,
        'courses' => App\Http\Controllers\CourseController::class,
        'branches' => App\Http\Controllers\BranchController::class,
        'training-centers' => App\Http\Controllers\TrainingCenterController::class,
        'programmes' => App\Http\Controllers\ProgrammeController::class,
        'batches' => App\Http\Controllers\BatchController::class,
        'galleries' => App\Http\Controllers\GalleryController::class,
        'gallery-categories' => App\Http\Controllers\GalleryCategoryController::class,
        'sliders' => App\Http\Controllers\SliderController::class,
        'static-page' => App\Http\Controllers\StaticPageController::class,
        'videos' => App\Http\Controllers\VideoController::class,
        'video-categories' => App\Http\Controllers\VideoCategoryController::class,
        'events' => App\Http\Controllers\EventController::class,
        'intro-videos' => App\Http\Controllers\IntroVideoController::class,
        'question-answers' => App\Http\Controllers\QuestionAnswerController::class,
        'examination-types' => App\Http\Controllers\ExaminationTypeController::class,
        'examinations' => App\Http\Controllers\ExaminationController::class,
        'examination-results' => App\Http\Controllers\ExaminationResultController::class,
        'routines' => App\Http\Controllers\RoutineController::class,
        'examination-routines' => App\Http\Controllers\ExaminationRoutineController::class,

    ]);

    /**********Routine**********/
    Route::get('weekly-routine', [App\Http\Controllers\RoutineController::class, 'weeklyRoutine'])->name('weekly-routine');
    Route::post('weekly-routine/filter', [App\Http\Controllers\RoutineController::class, 'weeklyRoutineFilter'])->name('weekly-routine.filter');
    /***************************/

    /**********ExaminationRoutine**********/
    Route::get('examination-routine', [App\Http\Controllers\ExaminationRoutineController::class, 'examinationRoutine'])->name('examination-routine');
    Route::post('examination-routine/filter', [App\Http\Controllers\ExaminationRoutineController::class, 'examinationRoutineFilter'])->name('examination-routine.filter');
    /***************************/
    Route::put('youth-course-enroll-accept/{youth_course_enroll_id}', [App\Http\Controllers\Frontend\YouthRegistrationController::class, 'acceptYouthCourseEnroll'])->name('youth-course-enroll-accept');
    Route::put('youth-course-enroll-reject/{youth_course_enroll_id}', [App\Http\Controllers\Frontend\YouthRegistrationController::class, 'rejectYouthCourseEnroll'])->name('youth-course-enroll-reject');
    Route::put('youth-accept-all', [App\Http\Controllers\YouthController::class, 'youthAcceptNowAll'])->name('youth-accept-now-all');
    Route::put('youth-reject-all', [App\Http\Controllers\YouthController::class, 'youthRejectNowAll'])->name('youth-reject-now-all');

    Route::post('static-page/image-upload', [App\Http\Controllers\StaticPageController::class, 'imageUpload'])->name('staticPage.imageUpload');
    Route::post('institutes/datatable', [App\Http\Controllers\InstituteController::class, 'getDatatable'])->name('institutes.datatable');
    Route::post('branches/datatable', [App\Http\Controllers\BranchController::class, 'getDatatable'])->name('branches.datatable');
    Route::post('training-centers/datatable', [App\Http\Controllers\TrainingCenterController::class, 'getDatatable'])->name('training-centers.datatable');
    Route::post('courses/datatable', [App\Http\Controllers\CourseController::class, 'getDatatable'])->name('courses.datatable');
    Route::post('programmes/datatable', [App\Http\Controllers\ProgrammeController::class, 'getDatatable'])->name('programmes.datatable');
    Route::post('batches/datatable', [App\Http\Controllers\BatchController::class, 'getDatatable'])->name('batches.datatable');
    Route::post('gallery/datatable', [App\Http\Controllers\GalleryController::class, 'getDatatable'])->name('gallery.datatable');
    Route::post('gallery-categories/datatable', [App\Http\Controllers\GalleryCategoryController::class, 'getDatatable'])->name('gallery-categories.datatable');
    Route::post('sliders/datatable', [App\Http\Controllers\SliderController::class, 'getDatatable'])->name('sliders.datatable');
    Route::post('static-page/datatable', [App\Http\Controllers\StaticPageController::class, 'getDatatable'])->name('static-page.datatable');
    Route::post('videos/datatable', [App\Http\Controllers\VideoController::class, 'getDatatable'])->name('videos.datatable');
    Route::post('video-categories/datatable', [App\Http\Controllers\VideoCategoryController::class, 'getDatatable'])->name('video-categories.datatable');
    Route::post('events/datatable', [App\Http\Controllers\EventController::class, 'getDatatable'])->name('events.datatable');
    Route::post('intro-videos/datatable', [App\Http\Controllers\IntroVideoController::class, 'getDatatable'])->name('intro-videos.datatable');
    Route::post('question-answers/datatable', [App\Http\Controllers\QuestionAnswerController::class, 'getDatatable'])->name('question-answers.datatable');

    Route::get('batches/{id}/youths', [App\Http\Controllers\YouthBatchController::class, 'index'])->name('batches.youths');
    Route::get('batches/{id}/trainer-mapping', [App\Http\Controllers\BatchController::class, 'trainerMapping'])->name('batches.trainer-mapping');
    Route::post('batches/trainer-mapping-update', [App\Http\Controllers\BatchController::class, 'trainerMappingUpdate'])->name('batches.trainer-mapping-update');
    Route::post('batches/{id}/youths-import', [App\Http\Controllers\YouthBatchController::class, 'importYouth'])->name('batches.youths-import');

    Route::post('batches/{id}/youths/datatable', [App\Http\Controllers\YouthBatchController::class, 'getDatatable'])->name('batches.youths.datatable');

    Route::get('youth-registrations', [App\Http\Controllers\YouthRegistrationManagementController::class, 'index'])
        ->name('youth.registrations.index');
    Route::post('youth-registrations/datatable', [App\Http\Controllers\YouthRegistrationManagementController::class, 'getDatatable'])
        ->name('youth.registrations.datatable');

    Route::resource('batches', App\Http\Controllers\BatchController::class);

    Route::get('batch-on-going/{batch}', [App\Http\Controllers\BatchController::class, 'batchOnGoing'])
        ->name('batch-on-going');
    Route::get('batch-complete/{batch}', [App\Http\Controllers\BatchController::class, 'batchComplete'])
        ->name('batch-complete');

    Route::post('programmes/check-programme-code', [App\Http\Controllers\ProgrammeController::class, 'checkCode'])->name('check-programme-code');
    Route::post('institutes/check-institute-code', [App\Http\Controllers\InstituteController::class, 'checkCode'])->name('check-institute-code');
    Route::post('static-page/check-page-id', [App\Http\Controllers\StaticPageController::class, 'checkCode'])->name('check-page-id');
    Route::post('courses/check-course-code', [App\Http\Controllers\CourseController::class, 'checkCode'])->name('check-course-code');
    Route::post('batches/check-batch-code', [App\Http\Controllers\BatchController::class, 'checkCode'])->name('check-batch-code');
    Route::post('batches/batch-training-centers', [App\Http\Controllers\BatchController::class, 'batchTrainingCenter'])->name('batch-training-centers');

    Route::resource('visitor-feedback', App\Http\Controllers\Frontend\VisitorFeedbackController::class)->only(['index', 'destroy', 'show']);
    Route::post('visitor-feedback/datatable', [App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'getDatatable'])->name('visitor-feedback.datatable');
    Route::post('featured-galleries', [\App\Http\Controllers\GalleryCategoryController::class, 'updateFeaturedGalleries'])->name('gallery-album.change-featured');

    Route::get('youths', [App\Http\Controllers\YouthManagementController::class, 'index'])
        ->name('youths.index');
    Route::post('youths/datatable', [App\Http\Controllers\YouthManagementController::class, 'getDatatable'])
        ->name('youths.datatable');
    Route::post('youths/add-to-organization', [App\Http\Controllers\YouthManagementController::class, 'addYouthToOrganization'])
        ->name('youths.add-to-organization');

    Route::post('youths/youth-assigned-organizations', [App\Http\Controllers\YouthManagementController::class, 'getYouthAssignedOrganizations'])
        ->name('youths.youth-assigned-organization');


    Route::get('youth-accept-list', [App\Http\Controllers\YouthController::class, 'youthAcceptList'])
        ->name('youth.accept-list');
    Route::post('youth-accept-list/datatable', [App\Http\Controllers\YouthController::class, 'getAcceptDatatable'])
        ->name('youth.acceptlist.datatable');

    Route::post('youth-accept-list/add-to-batch', [App\Http\Controllers\YouthRegistrationManagementController::class, 'addYouthToBatch'])
        ->name('youth.add-to-batch');

    Route::put('youth-accept-list/{youth}', [App\Http\Controllers\YouthRegistrationManagementController::class, 'addSingleYouthToBatch'])
        ->name('youth.add-single-youth-to-batch');


    Route::get('youths/certificate/course/{youth_course_enroll}', [App\Http\Controllers\YouthManagementController::class, 'youthCertificateCourseWise'])
        ->name('youths.certificate');

    Route::get('youths/certificate/{youth}', [App\Http\Controllers\YouthManagementController::class, 'youthCertificateList'])
        ->name('youths.certificate.course');

    Route::post('examination-types/datatable', [App\Http\Controllers\ExaminationTypeController::class, 'getDatatable'])->name('examination-types.datatable');
    Route::post('examinations/datatable', [App\Http\Controllers\ExaminationController::class, 'getDatatable'])->name('examinations.datatable');
    Route::get('examinations/status/{id?}', [App\Http\Controllers\ExaminationController::class, 'examinationStatus'])->name('examinations.status');
    Route::post('examinations/code_check', [App\Http\Controllers\ExaminationController::class, 'examinationCodeCheck'])->name('examinations.examinationCodeCheck');
    Route::post('examination-results/datatable', [App\Http\Controllers\ExaminationResultController::class, 'getDatatable'])->name('examination-results.datatable');
    Route::get('examination-results/get-youths/{examination_id?}', [App\Http\Controllers\ExaminationResultController::class, 'getYouths'])->name('examination-results.get-youths');
    Route::post('routines/datatable', [App\Http\Controllers\RoutineController::class, 'getDatatable'])->name('routines.datatable');
    Route::post('examination-routines/datatable', [App\Http\Controllers\ExaminationRoutineController::class, 'getDatatable'])->name('examination-routines.datatable');
});

Route::group(['as' => 'frontend.'], function () {
    Route::get('ssp-registration', [\App\Http\Controllers\HomeController::class, 'sspRegistrationForm'])->name('ssp-registration');
    Route::post('ssp-registration', [\App\Http\Controllers\InstituteController::class, 'SSPRegistration'])->name('ssp-registration');

    Route::get('youth-registration/success/{accessKey}', [App\Http\Controllers\Frontend\YouthRegistrationController::class, 'registrationSuccess'])->name('youth-registration.success');
    Route::get('youth-login', [App\Http\Controllers\Frontend\YouthLoginController::class, 'loginForm'])->name('youth.login-form');
    Route::get('youth-password-reset', [App\Http\Controllers\Frontend\YouthLoginController::class, 'passwordResetForm'])->name('youth.password-reset');
    Route::post('youth-login', [App\Http\Controllers\Frontend\YouthLoginController::class, 'login'])->name('youth.login-submit');
    Route::post('youth-logout', [App\Http\Controllers\Frontend\YouthLoginController::class, 'logout'])->name('youth.logout-submit');

    Route::get('youth-profile', [App\Http\Controllers\Frontend\YouthController::class, 'index'])->name('youth');
    Route::get('youth-enrolled-courses', [App\Http\Controllers\Frontend\YouthController::class, 'youthEnrolledCourses'])->name('youth-enrolled-courses');
    Route::get('youth-certificate-view/{youth_course_enroll}', [App\Http\Controllers\Frontend\YouthController::class, 'youthCertificateView'])->name('youth-certificate-view');
    Route::post('youth-enrolled-courses/datatable', [App\Http\Controllers\Frontend\YouthController::class, 'youthCourseGetDatatable'])->name('youth-courses-datatable');
    Route::post('youth-profile/youth-course-enroll-pay-now/{youth_course_enroll_id}', [App\Http\Controllers\Frontend\YouthController::class, 'youthCourseEnrollPayNow'])->name('youth-course-enroll-pay-now');
    Route::get('youth-current-organization', [App\Http\Controllers\Frontend\YouthController::class, 'youthCurrentOrganization'])->name('youth-current-organization');

    Route::get('youth-certificate', [App\Http\Controllers\Frontend\YouthController::class, 'certificate'])->name('certificate');
    Route::get('youth-certificate/download', [App\Http\Controllers\Frontend\YouthController::class, 'certificateDownload'])->name('certificate.download');
    Route::get('youth-certificate-two', [App\Http\Controllers\Frontend\YouthController::class, 'certificateTwo'])->name('certificate-two');

    Route::resources([
        'trainee-registrations' => App\Http\Controllers\Frontend\YouthRegistrationController::class,
    ]);

    Route::post('youth/recover-access-key-by-email', [\App\Http\Controllers\Frontend\YouthController::class, 'sendMailToRecoverAccessKey'])->name('youth.recover-access-key');
    Route::post('youth/registration-success-email', [\App\Http\Controllers\Frontend\YouthController::class, 'sendMailToRegistrationSuccess'])->name('youth.registration-success-mail');
    Route::get('youth/check-unique-email', [\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthEmailUniqueness'])->name('youth.check-unique-email');
    Route::get('youth/check-unique-nid', [\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniqueNID'])->name('youth.check-unique-nid');
    Route::get('youth/check-unique-birth_certificate_no', [\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniqueBirthCertificateNo'])->name('youth.check-unique-birth_certificate_no');
    Route::get('youth/check-unique-passport-no', [\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniquePassportId'])->name('youth.check-unique-passport-no');

    Route::post('institute-events', [App\Http\Controllers\Frontend\EventPageController::class, 'instituteEvent'])->name('institute-events');
    Route::post('institute-events-date', [App\Http\Controllers\Frontend\EventPageController::class, 'instituteEventDate'])->name('institute-events-date');
    Route::get('/institute-list', [App\Http\Controllers\Frontend\InstitutePageController::class, 'index'])->name('institute-list');
    Route::get('institute-details/{id}', [App\Http\Controllers\Frontend\InstitutePageController::class, 'details'])->name('institute-details');
});

$routesWithoutInstituteSlug = function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('main');
    Route::get('courses-search', [App\Http\Controllers\Frontend\CourseSearchController::class, 'findCourse'])->name('course_search');
    Route::get('course-details/{course_id}', [App\Http\Controllers\Frontend\CourseSearchController::class, 'courseDetails'])->name('course-details');
    Route::get('course-apply/{course_id}', [App\Http\Controllers\Frontend\CourseSearchController::class, 'courseApply'])->name('course-apply');

    Route::get('skill-videos', [App\Http\Controllers\Frontend\YouthController::class, 'videos'])->name('skill_videos');
    Route::get('skill-videos/{video_id}', [App\Http\Controllers\Frontend\YouthController::class, 'singleVideo'])->name('skill-single-video');
    Route::get('advice-page', [App\Http\Controllers\Frontend\YouthController::class, 'advicePage'])->name('advice-page');
    Route::get('general-ask-page', [App\Http\Controllers\Frontend\YouthController::class, 'generalAskPage'])->name('general-ask-page');
    Route::get('contact-us-page', [App\Http\Controllers\Frontend\YouthController::class, 'contactUsPage'])->name('contact-us-page');
    Route::post('visitor-feedback-store', [App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'store'])->name('visitor-feedback.store');
    Route::get('yearly-training-calendar', [App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'index'])->name('yearly-training-calendar.index');
    Route::post('yearly-training-calendar-ajax', [App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'allEvent'])->name('yearly-training-calendar.all-event');
    Route::get('fiscal-year', [App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'fiscalYear'])->name('fiscal-year');
    Route::get('venue-list/{id}', [App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'venueList'])->name('venue-list');

    Route::post('venue-list-search', [App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'venueListSearch'])->name('venue-list-search');

    Route::get('gallery-categories', [\App\Http\Controllers\Frontend\GalleryCategoryPageController::class, 'allGalleryCategoryPage'])->name('gallery-categories');
    Route::get('gallery-categories/{galleryCategory}', [\App\Http\Controllers\Frontend\GalleryCategoryPageController::class, 'singleGalleryCategoryPage'])->name('gallery-category');

    Route::get('events/{event}', [\App\Http\Controllers\Frontend\EventPageController::class, 'singleEventPage'])->name('single-event');
    Route::get('sc/{page_id}', [App\Http\Controllers\Frontend\StaticContentController::class, 'index'])
        ->name('static-content.show');
};

Route::group(['as' => 'frontend.'], $routesWithoutInstituteSlug);
Route::group(['prefix' => '{instituteSlug?}', 'as' => 'frontend.', 'middleware' => ['detect-institute']], $routesWithoutInstituteSlug);
