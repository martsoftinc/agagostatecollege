<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentIdFinderController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\Admin\LessonPlanController as AdminLessonPlanController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\NoticeController as TeacherNoticeController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\NoticeController as StudentNoticeController;
use App\Http\Controllers\LoginControllerStudent;
use App\Http\Controllers\Auth\ForgotPincodeController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\Admin\ExeatController;
use App\Http\Controllers\Student\ExeatController as StudentExeatController ;
use App\Http\Controllers\Admin\DisciplinaryRecordController;
use App\Http\Controllers\Student\DisciplinaryRecordController as StudentDisciplinaryRecordController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Admin\AcademicSetupController;
use App\Http\Controllers\Teacher\ScoreController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\Teacher\StudentFinderController;
use App\Http\Controllers\Student\ReportController;
use App\Http\Controllers\Student\PerformanceController;
use App\Http\Controllers\Teacher\PerformanceController as TeacherPerformanceController;
use App\Http\Controllers\Admin\PerformanceController as AdminPerformanceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomePageController;









Route::get('/', [HomePageController::class, 'index'])->name('welcomepage');




Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::view('/pta', 'pta')->name('pta');
Route::view('/contact', 'pages/contact')->name('contact');
Route::view('/programmes', 'pages/programmes')->name('programmes');
Route::view('/about', 'pages/about')->name('about');
Route::view('/calender', 'pages/calender')->name('calender');
Route::view('/connect', 'pages/connect')->name('connect');
Route::view('/leadership', 'pages/leadership')->name('leadership');

#Route::view('/student', 'student.index')->name('student');

Route::view('student/idfinder', 'student.idfinder')->name('idfinder');


#Route::view('studentportal', 'auth.studentportal')->name('studentportal');
Route::get('/student-id-finder', [StudentIdFinderController::class, 'index']);


//Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');


// Register Routes
#Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
#Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');


// Email verification
Route::get('/verify-email',  [EmailVerificationController::class, 'showVerificationForm'])->name('verification.notice')->middleware('auth');
Route::post('/verify-email', [EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('auth');
Route::post('/verify-email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('auth');


//Password reset route
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password/send-code', [ForgotPasswordController::class, 'sendResetCode'])->name('password.send-code');
Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyCodeForm'])->name('password.verify-code');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
Route::post('/resend-code', [ForgotPasswordController::class, 'resendCode'])->name('password.resend');

Route::get('/admission', [AdmissionController::class, 'index'])->name('admission.index');
Route::post('/admission', [AdmissionController::class, 'store'])->name('admission.store');
Route::get('/admission/verify-payment', [AdmissionController::class, 'verifyPayment'])->name('admission.verify-payment');

// SMS test routes (remove in production)
Route::get('/test-sms', [AdmissionController::class, 'testSms'])->name('test.sms');
Route::get('/check-sms-balance', [AdmissionController::class, 'checkSmsBalance'])->name('check.sms.balance');
//Users Route









// Teacher Routes
Route::middleware(['auth', 'teacher'])->group(function () {


Route::get('/lesson-plans', [LessonPlanController::class, 'index'])->name('lesson-plans.index');

// Show form to create a new lesson plan
Route::get('/lesson-plans/create', [LessonPlanController::class, 'create'])->name('lesson-plans.create');

// Save a new lesson plan
Route::post('/lesson-plans', [LessonPlanController::class, 'store'])->name('lesson-plans.store');

// View a single lesson plan
Route::get('/lesson-plans/{lesson_plan}', [LessonPlanController::class, 'show'])->name('lesson-plans.show');

// Show form to edit an existing lesson plan
Route::get('/lesson-plans/{lesson_plan}/edit', [LessonPlanController::class, 'edit'])->name('lesson-plans.edit');

// Update an existing lesson plan
Route::put('/lesson-plans/{lesson_plan}', [LessonPlanController::class, 'update'])->name('lesson-plans.update');

// Delete a lesson plan
Route::delete('/lesson-plans/{lesson_plan}', [LessonPlanController::class, 'destroy'])->name('lesson-plans.destroy');

// Manage sharing permissions for private lesson plans
Route::post('/lesson-plans/{lesson_plan}/share', [LessonPlanController::class, 'share'])->name('lesson-plans.share');

Route::get('lesson-plans/{lessonPlan}/pdf', [LessonPlanController::class, 'downloadPdf'])->name('lesson-plans.pdf');


Route::get('teacher/dashboard', [DashboardController::class, 'index'])->name('teacher');
Route::get('teacher/notices', [TeacherNoticeController::class, 'index'])->name('teacher.notices.index');
Route::get('teacher/notices/{notice}', [TeacherNoticeController::class, 'show'])->name('teacher.notices.show');

Route::get('teacher/scores', [ScoreController::class, 'index'])->name('teacher.scores.index');
Route::get('teacher/scores/{classStream}/{subject}', [ScoreController::class, 'enter'])->name('teacher.scores.enter');
Route::post('teacher/scores/{classStream}/{subject}', [ScoreController::class, 'store'])->name('teacher.scores.store');

Route::get('/teacher/student-finder', [StudentFinderController::class, 'studentFinder'])->name('teacher.student-finder');



Route::get('/teacher/profile', [TeacherProfileController::class, 'show'])->name('teacher.profile');
Route::put('/teacher/profile', [TeacherProfileController::class, 'update'])->name('teacher.profile.update');
Route::put('/teacher/profile/password', [TeacherProfileController::class, 'updatePassword'])->name('teacher.profile.password');
Route::post('/teacher/profile/2fa', [TeacherProfileController::class, 'toggle2FA'])->name('teacher.profile.2fa');

Route::prefix('teacher')->name('teacher.')->group(function () {

Route::get('/performance', [TeacherPerformanceController::class, 'index'])->name('performance.index');
});


});






























// User login and routes


Route::get('studentportal', [LoginControllerStudent::class, 'showStudentLoginForm'])->name('student.login');
Route::post('student/login', [LoginControllerStudent::class, 'login'])->name('auth.student.login');
Route::post('student/logout', [LoginControllerStudent::class, 'logout'])->name('student.logout');



    // Forgot pincode routes
Route::get('student/forgot-pincode', [ForgotPincodeController::class, 'showForgotForm'])->name('student.forgot-pincode');
Route::post('student/forgot-pincode', [ForgotPincodeController::class, 'sendPincode']);


Route::middleware(['auth', 'user'])->group(function () {

Route::get('/student/contact', function () {
    return view('student.contact');
})->name('student.contact');

Route::get('/user/profile',          [UserProfileController::class, 'show'])->name('user.profile');
Route::put('user/profile',          [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
Route::put('user/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');
Route::post('user/profile/2fa',     [UserProfileController::class, 'toggle2FA'])->name('user.profile.2fa');


Route::get('student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('student/notices', [StudentNoticeController::class, 'index'])->name('student.notices.index');
Route::get('student/notices/{notice}', [StudentNoticeController::class, 'show'])->name('student.notices.show');


Route::get('/pincode/change', [PincodeController::class, 'edit'])->name('student.pincode.edit');
Route::put('/pincode/change', [PincodeController::class, 'update'])->name('pincode.update');    



Route::get('student/exeats', [StudentExeatController::class, 'index'])->name('student.exeats.index');
Route::get('student/exeats/{exeat}', [StudentExeatController::class, 'show'])->name('student.exeats.show');

Route::get('student/disciplinary', [StudentDisciplinaryRecordController::class, 'index'])->name('student.disciplinary.index');
Route::get('student/disciplinary/{disciplinary}', [StudentDisciplinaryRecordController::class, 'show'])->name('student.disciplinary.show');


Route::prefix('student')->name('student.')->middleware(['auth'])->group(function () {
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{semester}', [ReportController::class, 'show'])->name('reports.show');
Route::get('/reports/{semester}/download', [ReportController::class, 'download'])->name('reports.download');
Route::get('/performance', [PerformanceController::class, 'index'])->name('performance.index');
});


});

















//Admin routes
#Route::middleware(['auth', 'admin','verify'])->group(function () {
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/home', function () {
    return view('users.dashboard');
})->name('home');

//Profile Management
Route::get('/admin/profile',          [ProfileController::class, 'show'])->name('admin.profile');
Route::put('/profile',          [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
Route::post('/profile/2fa',     [ProfileController::class, 'toggle2FA'])->name('admin.profile.2fa');




Route::get('/admin/admissions', [AdmissionController::class, 'adminIndex'])->name('admin.admissions.index');
Route::get('/admin/admissions/{id}', [AdmissionController::class, 'adminShow'])->name('admin.admissions.show');
Route::put('/admin/admissions/{id}', [AdmissionController::class, 'adminUpdate'])->name('admin.admissions.update');
Route::delete('/admin/admissions/{id}', [AdmissionController::class, 'adminDestroy'])->name('admin.admissions.destroy');
Route::get('/admin/admissions/export/csv', [AdmissionController::class, 'adminExport'])->name('admin.admissions.export');
Route::post('/admin/admissions/{id}/resend-payment', [AdmissionController::class, 'resendPaymentLink'])->name('admin.admissions.resend-payment');
Route::post('/admin/admissions/{id}/send-sms', [AdmissionController::class, 'sendCustomSms'])->name('admin.admissions.send-sms');
    
    // Add this for AJAX SMS sending
Route::post('admin/admissions/{id}/send-sms-ajax', [AdmissionController::class, 'sendCustomSmsAjax'])->name('admin.admissions.send-sms-ajax');


// Classes & Streams Management
Route::get('admin/classes', [ClassController::class, 'index'])->name('admin.classes.index');
Route::post('admin/classes/store', [ClassController::class, 'storeClass'])->name('admin.classes.store');
Route::post('admin/streams/store', [ClassController::class, 'storeStream'])->name('admin.streams.store');
Route::post('admin/class-streams/assign', [ClassController::class, 'assignStream'])->name('admin.class-streams.assign');

Route::get('/subjects', [SubjectController::class, 'index'])->name('admin.subjects.index');
Route::post('/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');
Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('admin.subjects.update');
Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

// Assign subjects to ClassStream
Route::post('/class-streams/{classStream}/subjects', [ClassController::class, 'assignSubject'])->name('admin.class-streams.assign-subject');

Route::delete('/class-streams/{classStream}/subjects/{subject}', [ClassController::class, 'removeSubject'])->name('admin.class-streams.remove-subject');
Route::get('/class-streams/{classStream}/subjects', [ClassController::class, 'manageSubjects'])->name('admin.class-streams.subjects');


// Update
Route::put('admin/classes/{schoolClass}', [ClassController::class, 'updateClass'])->name('admin.classes.update');
Route::put('admin/streams/{stream}', [ClassController::class, 'updateStream'])->name('admin.streams.update');
Route::put('admin/class-streams/{classStream}', [ClassController::class, 'updateClassStream'])->name('admin.class-streams.update');

Route::delete('admin/classes/{schoolClass}', [ClassController::class, 'destroyClass'])->name('admin.classes.destroy');
Route::delete('admin/streams/{stream}', [ClassController::class, 'destroyStream'])->name('admin.streams.destroy');
Route::delete('admin/class-streams/{classStream}', [ClassController::class, 'destroyClassStream'])->name('admin.class-streams.destroy');

Route::get('admin/staff', [StaffController::class, 'index'])->name('admin.staff.index');
Route::post('admin/staff', [StaffController::class, 'store'])->name('admin.staff.store');
Route::put('admin/staff/{user}', [StaffController::class, 'update'])->name('admin.staff.update');
Route::delete('admin/staff/{user}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');


Route::get('admin/students', [StudentController::class, 'index'])->name('admin.students.index');
Route::post('admin/students', [StudentController::class, 'store'])->name('admin.students.store');
Route::get('admin/students/{student}', [StudentController::class, 'show'])->name('admin.students.show');
Route::put('admin/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');
Route::delete('admin/students/{student}', [StudentController::class, 'destroy'])->name('admin.students.destroy');

    
    // Bulk actions
Route::post('admin/students/bulk-status', [StudentController::class, 'bulkStatus'])->name('admin.students.bulk-status');
Route::post('admin/students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('admin.students.bulk-delete');

Route::patch('admin/students/{student}/status', [StudentController::class, 'updateStatus'])->name('admin.students.update-status');
Route::put('admin/students/{student}', [StudentController::class, 'update'])->name('admin.students.update');

Route::post('admin/students/batch-wassce', [StudentController::class, 'batchWassce'])->name('admin.students.batch-wassce');

Route::get('admin/students/export-csv', [StudentController::class, 'exportCsv'])->name('admin.students.export-csv');

Route::get('students/export', [StudentController::class, 'export'])->name('admin.students.export');
Route::post('students/import', [StudentController::class, 'import'])->name('admin.students.import');


Route::get('admin/lesson-plans', [AdminLessonPlanController::class, 'index'])->name('admin.lesson-plans.index');
Route::get('admin/lesson-plans/{lessonPlan}', [AdminLessonPlanController::class, 'show'])->name('admin.lesson-plans.show');
Route::get('admin/lesson-plans/{lessonPlan}/pdf', [AdminLessonPlanController::class, 'downloadPdf'])->name('admin.lesson-plans.pdf');



Route::get('admin/notices', [NoticeController::class, 'index'])->name('admin.notices.index');
Route::post('admin/notices', [NoticeController::class, 'store'])->name('admin.notices.store');
Route::put('admin/notices/{notice}', [NoticeController::class, 'update'])->name('admin.notices.update');
Route::delete('admin/notices/{notice}', [NoticeController::class, 'destroy'])->name('admin.notices.destroy');


Route::get('admin/exeats', [ExeatController::class, 'index'])->name('admin.exeats.index');
Route::post('admin/exeats', [ExeatController::class, 'store'])->name('admin.exeats.store');
Route::put('admin/exeats/{exeat}', [ExeatController::class, 'update'])->name('admin.exeats.update');
Route::delete('admin/exeats/{exeat}', [ExeatController::class, 'destroy'])->name('admin.exeats.destroy');
Route::patch('admin/exeats/{exeat}/return', [ExeatController::class, 'markReturned'])->name('admin.exeats.return');



Route::get('admin/disciplinary', [DisciplinaryRecordController::class, 'index'])->name('admin.disciplinary.index');
Route::post('admin/disciplinary', [DisciplinaryRecordController::class, 'store'])->name('admin.disciplinary.store');
Route::put('admin/disciplinary/{disciplinary}', [DisciplinaryRecordController::class, 'update'])->name('admin.disciplinary.update');
Route::delete('admin/disciplinary/{disciplinary}', [DisciplinaryRecordController::class, 'destroy'])->name('admin.disciplinary.destroy');
Route::patch('admin/disciplinary/{disciplinary}/resolve', [DisciplinaryRecordController::class, 'markResolved'])->name('admin.disciplinary.resolve');



Route::get('/academic-setup', [AcademicSetupController::class, 'index'])->name('admin.academic-setup.index');
Route::post('/academic-setup/years', [AcademicSetupController::class, 'storeYear'])->name('admin.academic-setup.store-year');
Route::patch('/academic-setup/years/{academicYear}/current', [AcademicSetupController::class, 'setCurrentYear'])->name('admin.academic-setup.set-current-year');
Route::patch('/academic-setup/semesters/{semester}/current', [AcademicSetupController::class, 'setCurrentSemester'])->name('admin.academic-setup.set-current-semester');
Route::patch('/academic-setup/semesters/{semester}/lock', [AcademicSetupController::class, 'toggleLock'])->name('admin.academic-setup.toggle-lock');
Route::put('/academic-setup/weights', [AcademicSetupController::class, 'updateWeights'])->name('admin.academic-setup.update-weights');


Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('admin/performance', [AdminPerformanceController::class, 'index'])->name('admin.performance.index');

Route::resource('admin/posts', PostController::class)
    ->except(['show'])
    ->names('admin.posts');

Route::post('admin/posts/upload-image', [PostController::class, 'uploadImage'])
         ->name('admin.posts.upload-image');



#});


// ── Two-Factor Challenge (guest: user not fully logged in yet) ────────────────
// Note: uses a custom middleware below — NOT the 'auth' middleware

Route::get('/two-factor-challenge',  [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorController::class, 'verifyChallenge'])->name('two-factor.verify');
Route::post('/two-factor-challenge/resend', [TwoFactorController::class, 'resend'])->name('two-factor.resend');


//Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
