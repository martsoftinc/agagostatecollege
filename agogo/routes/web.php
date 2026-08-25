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








Route::get('/', function () {
    return view('welcome');
});







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



});






























// User login and routes


Route::get('studentportal', [LoginControllerStudent::class, 'showStudentLoginForm'])->name('student.login');
Route::post('student/login', [LoginControllerStudent::class, 'login'])->name('auth.student.login');
Route::post('student/logout', [LoginControllerStudent::class, 'logout'])->name('student.logout');



    // Forgot pincode routes
Route::get('student/forgot-pincode', [ForgotPincodeController::class, 'showForgotForm'])->name('student.forgot-pincode');
Route::post('student/forgot-pincode', [ForgotPincodeController::class, 'sendPincode']);


Route::middleware(['auth', 'user'])->group(function () {


Route::get('/user-dashboard', function () {
    return view('users.dashboard');
})->name('dashboard');


Route::get('/user/profile',          [UserProfileController::class, 'show'])->name('user.profile');
Route::put('user/profile',          [UserProfileController::class, 'updateProfile'])->name('user.profile.update');
Route::put('user/profile/password', [UserProfileController::class, 'updatePassword'])->name('user.profile.password');
Route::post('user/profile/2fa',     [UserProfileController::class, 'toggle2FA'])->name('user.profile.2fa');


Route::get('student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('student/notices', [StudentNoticeController::class, 'index'])->name('student.notices.index');
Route::get('student/notices/{notice}', [StudentNoticeController::class, 'show'])->name('student.notices.show');


    


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




Route::get('admin/admissions', [AdmissionController::class, 'adminIndex'])->name('admissions.index');
Route::get('admin/admissions/{id}', [AdmissionController::class, 'adminShow'])->name('admissions.show');
Route::put('admin/admissions/{id}', [AdmissionController::class, 'adminUpdate'])->name('admissions.update');
Route::delete('admin/admissions/{id}', [AdmissionController::class, 'adminDestroy'])->name('admissions.destroy');
Route::get('admin/admissions/export/csv', [AdmissionController::class, 'adminExport'])->name('admissions.export');
Route::post('admin/admissions/{id}/resend-payment', [AdmissionController::class, 'resendPaymentLink'])->name('admissions.resend-payment');
Route::post('admin/admissions/{id}/send-sms', [AdmissionController::class, 'sendCustomSms'])->name('admissions.send-sms');
    
    // Add this for AJAX SMS sending
Route::post('admin/admissions/{id}/send-sms-ajax', [AdmissionController::class, 'sendCustomSmsAjax'])->name('admissions.send-sms-ajax');


// Classes & Streams Management
Route::get('admin/classes', [ClassController::class, 'index'])->name('admin.classes.index');
Route::post('admin/classes/store', [ClassController::class, 'storeClass'])->name('admin.classes.store');
Route::post('admin/streams/store', [ClassController::class, 'storeStream'])->name('admin.streams.store');
Route::post('admin/class-streams/assign', [ClassController::class, 'assignStream'])->name('admin.class-streams.assign');

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


Route::get('admin/lesson-plans', [AdminLessonPlanController::class, 'index'])->name('admin.lesson-plans.index');
Route::get('admin/lesson-plans/{lessonPlan}', [AdminLessonPlanController::class, 'show'])->name('admin.lesson-plans.show');
Route::get('admin/lesson-plans/{lessonPlan}/pdf', [AdminLessonPlanController::class, 'downloadPdf'])->name('admin.lesson-plans.pdf');



Route::get('admin/notices', [NoticeController::class, 'index'])->name('admin.notices.index');
Route::post('admin/notices', [NoticeController::class, 'store'])->name('admin.notices.store');
Route::put('admin/notices/{notice}', [NoticeController::class, 'update'])->name('admin.notices.update');
Route::delete('admin/notices/{notice}', [NoticeController::class, 'destroy'])->name('admin.notices.destroy');










#});


// ── Two-Factor Challenge (guest: user not fully logged in yet) ────────────────
// Note: uses a custom middleware below — NOT the 'auth' middleware

Route::get('/two-factor-challenge',  [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
Route::post('/two-factor-challenge', [TwoFactorController::class, 'verifyChallenge'])->name('two-factor.verify');
Route::post('/two-factor-challenge/resend', [TwoFactorController::class, 'resend'])->name('two-factor.resend');


//Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
