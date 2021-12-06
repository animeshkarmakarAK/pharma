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
        'events' => Module\CourseManagement\App\Http\Controllers\EventController::class,
        'intro-videos' => Module\CourseManagement\App\Http\Controllers\IntroVideoController::class,
        'question-answers' => Module\CourseManagement\App\Http\Controllers\QuestionAnswerController::class,

        'examination-types' => Module\CourseManagement\App\Http\Controllers\ExaminationTypeController::class,
        'examinations' => Module\CourseManagement\App\Http\Controllers\ExaminationController::class,
        'examination-results' => Module\CourseManagement\App\Http\Controllers\ExaminationResultController::class,
        'routines' => Module\CourseManagement\App\Http\Controllers\RoutineController::class,
    ]);

    /**********Routine**********/
    Route::get('weekly-routine', [Module\CourseManagement\App\Http\Controllers\RoutineController::class, 'weeklyRoutine'])->name('weekly-routine');
    Route::post('weekly-routine/filter', [Module\CourseManagement\App\Http\Controllers\RoutineController::class, 'weeklyRoutineFilter'])->name('weekly-routine.filter');
    /***************************/
    Route::put('youth-course-enroll-accept/{youth_course_enroll_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class, 'acceptYouthCourseEnroll'])->name('youth-course-enroll-accept');
    Route::put('youth-course-enroll-reject/{youth_course_enroll_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class, 'rejectYouthCourseEnroll'])->name('youth-course-enroll-reject');
    Route::put('youth-accpet-all', [Module\CourseManagement\App\Http\Controllers\YouthController::class, 'youthAcceptNowAll'])->name('youth-accept-now-all');
    Route::put('youth-reject-all', [Module\CourseManagement\App\Http\Controllers\YouthController::class, 'youthRejectNowAll'])->name('youth-reject-now-all');

//    Route::put('youth-course-enroll-accept/{youth_course_enroll_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class, 'acceptYouthCourseEnroll'])->name('youth-course-enroll-accept');

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
    Route::post('events/datatable', [Module\CourseManagement\App\Http\Controllers\EventController::class, 'getDatatable'])->name('events.datatable');
    Route::post('intro-videos/datatable', [Module\CourseManagement\App\Http\Controllers\IntroVideoController::class, 'getDatatable'])->name('intro-videos.datatable');
    Route::post('question-answers/datatable', [Module\CourseManagement\App\Http\Controllers\QuestionAnswerController::class, 'getDatatable'])->name('question-answers.datatable');

    Route::get('batches/{id}/youths', [Module\CourseManagement\App\Http\Controllers\YouthBatchController::class, 'index'])->name('batches.youths');
    Route::post('batches/{id}/youths-import', [Module\CourseManagement\App\Http\Controllers\YouthBatchController::class, 'importYouth'])->name('batches.youths-import');

    Route::post('batches/{id}/youths/datatable', [Module\CourseManagement\App\Http\Controllers\YouthBatchController::class, 'getDatatable'])->name('batches.youths.datatable');

    Route::get('youth-registrations', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'index'])
        ->name('youth.registrations.index');
    Route::post('youth-registrations/datatable', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'getDatatable'])
        ->name('youth.registrations.datatable');


    Route::resource('batches', Module\CourseManagement\App\Http\Controllers\BatchController::class);

    Route::get('batch-on-going/{batch}', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'batchOnGoing'])
        ->name('batch-on-going');
    Route::get('batch-complete/{batch}', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'batchComplete'])
        ->name('batch-complete');

    Route::post('programmes/check-programme-code', [Module\CourseManagement\App\Http\Controllers\ProgrammeController::class, 'checkCode'])->name('check-programme-code');
    Route::post('institutes/check-institute-code', [Module\CourseManagement\App\Http\Controllers\InstituteController::class, 'checkCode'])->name('check-institute-code');
    Route::post('static-page/check-page-id', [Module\CourseManagement\App\Http\Controllers\StaticPageController::class, 'checkCode'])->name('check-page-id');
    Route::post('courses/check-course-code', [Module\CourseManagement\App\Http\Controllers\CourseController::class, 'checkCode'])->name('check-course-code');
    Route::post('batches/check-batch-code', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'checkCode'])->name('check-batch-code');
    Route::post('batches/batch-training-centers', [Module\CourseManagement\App\Http\Controllers\BatchController::class, 'batchTrainingCenter'])->name('batch-training-centers');

    Route::resource('visitor-feedback', Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class)->only(['index', 'destroy', 'show']);
    Route::post('visitor-feedback/datatable', [Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'getDatatable'])->name('visitor-feedback.datatable');
    Route::post('featured-galleries', [\Module\CourseManagement\App\Http\Controllers\GalleryCategoryController::class, 'updateFeaturedGalleries'])->name('gallery-album.change-featured');

    Route::get('youths', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'index'])
        ->name('youths.index');
    Route::post('youths/datatable', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'getDatatable'])
        ->name('youths.datatable');
    Route::post('youths/add-to-organization', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'addYouthToOrganization'])
        ->name('youths.add-to-organization');

    Route::post('youths/youth-assigned-organizations', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'getYouthAssignedOrganizations'])
        ->name('youths.youth-assigned-organization');


    Route::get('youth-accept-list', [Module\CourseManagement\App\Http\Controllers\YouthController::class, 'youthAcceptList'])
        ->name('youth.accept-list');
    Route::post('youth-accept-list/datatable', [Module\CourseManagement\App\Http\Controllers\YouthController::class, 'getAcceptDatatable'])
        ->name('youth.acceptlist.datatable');

    Route::post('youth-accept-list/add-to-batch', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'addYouthToBatch'])
        ->name('youth.add-to-batch');

    Route::put('youth-accept-list/{youth}', [Module\CourseManagement\App\Http\Controllers\YouthRegistrationManagementController::class, 'addSingleYouthToBatch'])
        ->name('youth.add-single-youth-to-batch');


    Route::get('youths/certificate/course/{youth_course_enroll}', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'youthCertificateCourseWise'])
        ->name('youths.certificate');

    Route::get('youths/certificate/{youth}', [Module\CourseManagement\App\Http\Controllers\YouthManagementController::class, 'youthCertificateList'])
        ->name('youths.certificate.course');

    Route::post('examination-types/datatable', [Module\CourseManagement\App\Http\Controllers\ExaminationTypeController::class, 'getDatatable'])->name('examination-types.datatable');
    Route::post('examinations/datatable', [Module\CourseManagement\App\Http\Controllers\ExaminationController::class, 'getDatatable'])->name('examinations.datatable');
    Route::get('examinations/status/{id?}', [Module\CourseManagement\App\Http\Controllers\ExaminationController::class, 'status'])->name('examinations.status');
    Route::post('examination-results/datatable', [Module\CourseManagement\App\Http\Controllers\ExaminationResultController::class, 'getDatatable'])->name('examination-results.datatable');
    //Route::get('examination-results/get-youths/{batch_id?}', [Module\CourseManagement\App\Http\Controllers\ExaminationResultController::class, 'getYouths'])->name('examination-results.get-youths');
    Route::get('examination-results/get-youths/{examination_id?}', [Module\CourseManagement\App\Http\Controllers\ExaminationResultController::class, 'getYouths'])->name('examination-results.get-youths');
    Route::post('routines/datatable', [Module\CourseManagement\App\Http\Controllers\RoutineController::class, 'getDatatable'])->name('routines.datatable');
});

Route::group(['prefix' => 'course-management', 'as' => 'course_management::'], function () {
    Route::get('{instituteSlug?}/courses-search', [Module\CourseManagement\App\Http\Controllers\Frontend\CourseSearchController::class, 'findCourse'])->name('course_search');
    Route::get('course-details-ajax/{publish_course_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\CourseSearchController::class, 'courseDetails'])->name('course-details.ajax');

    Route::get('youth-profile', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'index'])->name('youth');
    Route::get('youth-enrolled-courses', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'youthEnrolledCourses'])->name('youth-enrolled-courses');
    Route::get('youth-certificate-view/{youth_course_enroll}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'youthCertificateView'])->name('youth-certificate-view');
    Route::post('youth-enrolled-courses/datatable', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'youthCourseGetDatatable'])->name('youth-courses-datatable');
    Route::post('youth-profile/youth-course-enroll-pay-now/{youth_course_enroll_id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'youthCourseEnrollPayNow'])->name('youth-course-enroll-pay-now');
    Route::get('youth-current-organization', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'youthCurrentOrganization'])->name('youth-current-organization');

    Route::get('youth-certificate', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'certificate'])->name('certificate');
    Route::get('youth-certificate/download', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'certificateDownload'])->name('certificate.download');
    Route::get('youth-certificate-two', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'certificateTwo'])->name('certificate-two');


    Route::get('skill-videos', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'videos'])->name('youth.skill_videos');
    Route::get('skill-videos/{skill_video}', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'singleVideo'])->name('youth.skill-single-video');
    Route::get('advice-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'advicePage'])->name('advice-page');
    Route::get('general-ask-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'generalAskPage'])->name('general-ask-page');
    Route::get('contact-us-page', [Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'contactUsPage'])->name('contact-us-page');
    Route::post('visitor-feedback-store', [Module\CourseManagement\App\Http\Controllers\Frontend\VisitorFeedbackController::class, 'store'])->name('visitor-feedback.store');
    Route::get('yearly-training-calendar', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'index'])->name('yearly-training-calendar.index');
    Route::post('yearly-training-calendar-ajax', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'allEvent'])->name('yearly-training-calendar.all-event');
    Route::get('fiscal-year', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'fiscalYear'])->name('fiscal-year');
    Route::get('venue-list/{id}', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'venueList'])->name('venue-list');

//    Route::post('venue-list', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'venueListSearch'])->name('venue-list-search');
    Route::post('venue-list-search', [Module\CourseManagement\App\Http\Controllers\Frontend\YearlyTrainingCalendarController::class, 'venueListSearch'])->name('venue-list-search');

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
    Route::get('youth/check-unique-nid', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniqueNID'])->name('youth.check-unique-nid');
    Route::get('youth/check-unique-birth_certificate_no', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniqueBirthCertificateNo'])->name('youth.check-unique-birth_certificate_no');
    Route::get('youth/check-unique-passport-no', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthController::class, 'checkYouthUniquePassportId'])->name('youth.check-unique-passport-no');
    Route::get('gallery-categories', [\Module\CourseManagement\App\Http\Controllers\Frontend\galleryCategoryPageController::class, 'allGalleryCategoryPage'])->name('gallery-categories');
    Route::get('gallery-categories/{galleryCategory}', [\Module\CourseManagement\App\Http\Controllers\Frontend\galleryCategoryPageController::class, 'singleGalleryCategoryPage'])->name('gallery-category');

    Route::get('events/{event}', [\Module\CourseManagement\App\Http\Controllers\Frontend\EventPageController::class, 'singleEventPage'])->name('single-event');
    Route::post('institute-events', [Module\CourseManagement\App\Http\Controllers\Frontend\EventPageController::class, 'instituteEvent'])->name('institute-events');
    Route::post('institute-events-date', [Module\CourseManagement\App\Http\Controllers\Frontend\EventPageController::class, 'instituteEventDate'])->name('institute-events-date');
    Route::post('publish-course-training-centers', [\Module\CourseManagement\App\Http\Controllers\Frontend\YouthRegistrationController::class, 'publishCourseTrainingCenter'])->name('publish-course-training-centers');
    Route::post('ssp-registration', [\Module\CourseManagement\App\Http\Controllers\InstituteController::class, 'SSPRegistration'])->name('ssp-registration');

    Route::get('{instituteSlug?}/institute-page', [Module\CourseManagement\App\Http\Controllers\Frontend\InstitutePageController::class, 'index'])->name('institute-page');
    Route::get('institute-details/{id}', [Module\CourseManagement\App\Http\Controllers\Frontend\InstitutePageController::class, 'details'])->name('institute-details');
});
