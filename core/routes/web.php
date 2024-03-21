<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\PaymentApiController;
use App\Http\Controllers\SocietyReplyController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Dashboard\SocietyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Language Route
Route::post('/lang', [LanguageController::class, 'index'])->middleware('LanguageSwitcher')->name('lang');
// For Language direct URL link
Route::get('/lang/{lang}', [LanguageController::class, 'change'])->middleware('LanguageSwitcher')->name('langChange');
Route::get('/locale/{lang}', [LanguageController::class, 'locale'])->middleware('LanguageSwitcher')->name('localeChange');
// .. End of Language Route

// No Permission
Route::get('/403', function () {
    return view('errors.403');
})->name('NoPermission');


// Not Found
Route::get('/404', [HomeController::class, 'error_404'])->name('NotFound');

// Backend Routes
Route::get('/login', function () {
    return redirect('/');
});
Route::get('/register', function () {
    return redirect('/');
});

// RSS Feed Routes
if (env("RSS_STATUS", 0)) {
    Route::feeds();
}

// Social Auth
Route::get('/oauth/{driver}', [SocialAuthController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('/oauth/{driver}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

// Route::Group(['prefix' => env('BACKEND_PATH')], function () {
    Auth::routes();
// });
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// Start of Frontend Routes
// ../site map
Route::get('/sitemap.xml', [SiteMapController::class, 'siteMap'])->name('siteMap');
Route::get('/{lang}/sitemap', [SiteMapController::class, 'siteMap'])->name('siteMapByLang');

Route::get('/', [HomeController::class, 'HomePage'])->name('Home');

Route::post('/form-submit', [HomeController::class, 'formSubmit'])->name('formSubmit');

// ../home url
Route::get('/home', [HomeController::class, 'HomePage'])->name('HomePage');
Route::get('/{lang?}/home', [HomeController::class, 'HomePageByLang'])->name('HomePageByLang');
// ../subscribe to newsletter submit  (ajax url)
Route::post('/subscribe', [HomeController::class, 'subscribeSubmit'])->name('subscribeSubmit');
// ../Comment submit  (ajax url)
Route::post('/comment', [HomeController::class, 'commentSubmit'])->name('commentSubmit');
// ../Order submit  (ajax url)
Route::post('/order', [HomeController::class, 'orderSubmit'])->name('orderSubmit');
// ..Custom URL for contact us page ( www.site.com/contact )
Route::get('/contact', [HomeController::class, 'ContactPage'])->name('contactPage');
Route::get('/{lang?}/contact', [HomeController::class, 'ContactPageByLang'])->name('contactPageByLang');
// ../contact message submit  (ajax url)
Route::post('/contact/submit', [HomeController::class, 'ContactPageSubmit'])->name('contactPageSubmit');
// ..if page by name ( ex: www.site.com/about )
Route::get('/topic/{id}', [HomeController::class, 'topic'])->name('FrontendPage');
// ..if page by user id ( ex: www.site.com/user )
Route::get('/user/{id}', [HomeController::class, 'userTopics'])->name('FrontendUserTopics');
Route::get('/{lang?}/user/{id}', [HomeController::class, 'userTopicsByLang'])->name('FrontendUserTopicsByLang');
// ../search
Route::get('/search', [HomeController::class, 'searchTopics'])->name('searchTopics');

// ..Topics url  ( ex: www.site.com/news/topic/32 )
Route::get('/{section}/topic/{id}', [HomeController::class, 'topic'])->name('FrontendTopic');
Route::get('/{lang?}/{section}/topic/{id}', [HomeController::class, 'topicByLang'])->name('FrontendTopicByLang');

// ..Sub category url for Section  ( ex: www.site.com/products/2 )
Route::get('/{section}/{cat}', [HomeController::class, 'topics'])->name('FrontendTopicsByCat');
Route::get('/{lang?}/{section}/{cat}', [HomeController::class, 'topicsByLang'])->name('FrontendTopicsByCatWithLang');

// ..Section url by name  ( ex: www.site.com/news )
Route::get('/{section}', [HomeController::class, 'topics'])->name('FrontendTopics');
Route::get('/{lang?}/{section}', [HomeController::class, 'topicsByLang'])->name('FrontendTopicsByLang');

// ..SEO url  ( ex: www.site.com/title-here )
Route::get('/{seo_url_slug}', [HomeController::class, 'SEO'])->name('FrontendSEO');
Route::get('/{lang?}/{seo_url_slug}', [HomeController::class, 'SEOByLang'])->name('FrontendSEOByLang');

// ..if page by name and language( ex: www.site.com/ar/about )
Route::get('/{lang?}/topic/{id}', [HomeController::class, 'topicByLang'])->name('FrontendPageByLang');

Route::get('/common-questions', [HomeController::class, 'CommonQuestions'])->name('FrontendCommonQuestions');
Route::get('/{lang?}/common-questions', [HomeController::class, 'CommonQuestionsByLang'])->name('FrontendCommonQuestionsByLang');

Route::get('/society', [HomeController::class, 'Society'])->name('FrontendSociety');
Route::get('/{lang?}/society', [HomeController::class, 'SocietyByLang'])->name('FrontendSocietyByLang');

Route::post('/societies/store', [SocietyController::class, 'store'])->name('societyStore');
Route::get('/show-society/{value}', [HomeController::class, 'showSociety'])->name('showSociety');
Route::post('/replySociety/{id}', [SocietyReplyController::class, 'replySociety'])->name('replySociety');

Route::get('/packages', [HomeController::class, 'Packages'])->name('FrontendPackages');
Route::get('/{lang?}/packages', [HomeController::class, 'PackagesByLang'])->name('FrontendPackagesByLang');

Route::get('/main-services', [HomeController::class, 'MainServices'])->name('FrontendMainServices');
Route::get('/{lang?}/main-services', [HomeController::class, 'MainServicesByLang'])->name('FrontendMainServicesByLang');
Route::get('/show-main-service/{value}', [HomeController::class, 'showMainService'])->name('showMainService');

Route::post('/get-sub-services', [HomeController::class, 'GetSubServices'])->name('GetSubService');

Route::get('/checkout/{id}', [HomeController::class, 'checkout'])->name('checkout');
Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
Route::match(array('GET','POST'),'/payment-notify/{id}', [PaymentApiController::class, 'paymentNotifier'])->name('paymentNotify');
Route::match(array('GET','POST'),'payment-cancel/{id}', [PaymentApiController::class, 'paymentCancel'])->name('paymentCancel');

// .. End of Frontend Route

