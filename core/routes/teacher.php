<?php

use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Teacher\ChildrenController;
use App\Http\Controllers\Teacher\HomeController;
use Illuminate\Support\Facades\Route;


Route::prefix('teacher')->group(function(){

    Route::get('login', [TeacherLoginController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('login/submit', [TeacherLoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [TeacherLoginController::class, 'logout'])->name('teacher.logout');
    Route::get('Register', [TeacherLoginController::class, 'showRegisterForm'])->name('teacher.register');
    Route::post('Register/submit', [TeacherLoginController::class, 'store'])->name('Register.submit');
});

// Route::get('/teacherhome', function () {
//     return 'hello';
// $2y$10$nob3NA3ZE26PfyYPJSzQDegQ1DVTYuEDSnjuE8rTHTFv9h2E46IWO
// })->name('teacherhome');
Route::group(['middleware'=>'auth:teacher'],function(){

    Route::get('/teacherhome', [HomeController::class, 'index'])->name('teacher.teacherhome');
    // children routes
    Route::controller(ChildrenController::class)->group(function(){
        Route::resource('childrens',ChildrenController::class)->except('show');
        Route::post('/childrens/remove_image','remove_image')->name('childrens.remove_image');
    });


    Route::get('/teacher/reports/{id}', [HomeController::class, 'showChildrenReports'])->name('TeacherReports');
    Route::get('/teacher/consulting-reports/{id}', [HomeController::class, 'showChildrenConsultingReports'])->name('TeacherConsultingReports');
    Route::get('/teacher/status-reports/{id}', [HomeController::class, 'showChildrenStatusReports'])->name('TeacherStatusReports');
    Route::get('/teacher/profile', [HomeController::class, 'showTeacherProfile'])->name('TeacherProfile');
    Route::post('/teacher/profile', [HomeController::class, 'updateTeacherProfile'])->name('teacherProfileUpdate');

    Route::get('/teacher/packages', [HomeController::class, 'showPackages'])->name('TeacherPackages');

    Route::get('/children/vbmap/{id}', [HomeController::class, 'showChildrenVbmap'])->name('TshowChildrenVbmap');
    Route::get('/children/treatment-plan/{id}', [HomeController::class, 'showChildrenTreatmentPlan'])->name('TshowChildrenTreatmentPlan');
    Route::get('/children/final-reports/{id}', [HomeController::class, 'showChildrenFinalReports'])->name('TshowChildrenFinalReports');
    Route::post('/teacher/subscribe/', [HomeController::class, 'SubscribePackage'])->name('SubscribePackage');
    Route::get('/teacher/getSubServices/{id}', [HomeController::class, 'getSubServices'])->name('getSubServices');
    Route::get('/teacher/subscriptions/', [HomeController::class, 'showSubscriptionsPage'])->name('TshowSubscriptionsPage');


    // Route::match(array('GET','POST'), 'verify-certificate', [CertificateVerifyController::class, 'verifyCertificate'])->name('verify_certificate');
    // Route::match(array('GET','POST'),'/payment-notify-subscription/{id}', [PaymentApiController::class, 'paymentSubscriptionNotifier'])->name('paymentNotify.subscription');
    // Route::match(array('GET','POST'),'/payment-notify-wallet-recharge/{id}', [PaymentApiController::class, 'paymentWalletRechargeNotifier'])->name('paymentNotify.wallet_recharge');

});
//
