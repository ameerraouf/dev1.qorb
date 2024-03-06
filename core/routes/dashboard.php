<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\MenusController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\EventsController;
use App\Http\Controllers\Dashboard\TopicsController;
use App\Http\Controllers\Dashboard\BannersController;
use App\Http\Controllers\Dashboard\PackageController;
use App\Http\Controllers\Dashboard\SocietyController;
use App\Http\Controllers\Dashboard\ContactsController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\WebmailsController;
use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\SpecialistController;
use App\Http\Controllers\Dashboard\SubServiceController;

use App\Http\Controllers\Dashboard\SupervisorController;
use App\Http\Controllers\Dashboard\FileManagerController;
use App\Http\Controllers\Dashboard\MainServiceController;
use App\Http\Controllers\Dashboard\CommonQuestionController;

// <<<<<<< HEAD
use App\Http\Controllers\Dashboard\WebmasterBannersController;
// =======



// >>>>>>> 2704ee87b2e7b7b7c6687a1e91124fa1b7313a1b
use App\Http\Controllers\Dashboard\WebmasterLicenseController;
use App\Http\Controllers\Dashboard\WebmasterSectionsController;
use App\Http\Controllers\Dashboard\WebmasterSettingsController;
use App\Http\Controllers\Dashboard\PurchaseTransactionController;
use App\Http\Controllers\Dashboard\EarlyDetectionReportController;
use App\Http\Controllers\Dashboard\FinancialTransactionController;

// Admin Routes
Route::group(['prefix'=>env('BACKEND_PATH'),'middleware'=>'admin'],function(){
    Route::get('/', [DashboardController::class, 'index'])->name('adminHome');
    //Search
    Route::get('/search', [DashboardController::class, 'search'])->name('adminSearch');
    Route::post('/find', [DashboardController::class, 'find'])->name('adminFind');


    // Webmaster
    Route::get('/webmaster', [WebmasterSettingsController::class, 'edit'])->name('webmasterSettings');
    Route::post('/webmaster', [WebmasterSettingsController::class, 'update'])->name('webmasterSettingsUpdate');
    Route::post('/webmaster/languages/store', [WebmasterSettingsController::class, 'language_store'])->name('webmasterLanguageStore');
    Route::post('/webmaster/languages/store', [WebmasterSettingsController::class, 'language_store'])->name('webmasterLanguageStore');
    Route::post('/webmaster/languages/update', [WebmasterSettingsController::class, 'language_update'])->name('webmasterLanguageUpdate');
    Route::get('/webmaster/languages/destroy/{id}', [WebmasterSettingsController::class, 'language_destroy'])->name('webmasterLanguageDestroy');
    Route::get('/webmaster/seo/repair', [WebmasterSettingsController::class, 'seo_repair'])->name('webmasterSEORepair');

    Route::post('/webmaster/mail/smtp', [WebmasterSettingsController::class, 'mail_smtp_check'])->name('mailSMTPCheck');
    Route::post('/webmaster/mail/test', [WebmasterSettingsController::class, 'mail_test'])->name('mailTest');


    Route::post('/webmaster-license', [WebmasterLicenseController::class, 'index'])->name('licenseCheck');

    // Webmaster Banners
    Route::get('/webmaster/banners', [WebmasterBannersController::class, 'index'])->name('WebmasterBanners');
    Route::get('/webmaster/banners/create', [WebmasterBannersController::class, 'create'])->name('WebmasterBannersCreate');
    Route::post('/webmaster/banners/store', [WebmasterBannersController::class, 'store'])->name('WebmasterBannersStore');
    Route::get('/webmaster/banners/{id}/edit', [WebmasterBannersController::class, 'edit'])->name('WebmasterBannersEdit');
    Route::post('/webmaster/banners/{id}/update', [WebmasterBannersController::class, 'update'])->name('WebmasterBannersUpdate');
    Route::get('/webmaster/banners/destroy/{id}',
        [WebmasterBannersController::class, 'destroy'])->name('WebmasterBannersDestroy');
    Route::post('/webmaster/banners/updateAll',
        [WebmasterBannersController::class, 'updateAll'])->name('WebmasterBannersUpdateAll');

    // Webmaster Sections
    Route::get('/webmaster/sections', [WebmasterSectionsController::class, 'index'])->name('WebmasterSections');
    Route::get('/webmaster/sections/create', [WebmasterSectionsController::class, 'create'])->name('WebmasterSectionsCreate');
    Route::post('/webmaster/sections/store', [WebmasterSectionsController::class, 'store'])->name('WebmasterSectionsStore');
    Route::get('/webmaster/sections/{id}/edit', [WebmasterSectionsController::class, 'edit'])->name('WebmasterSectionsEdit');
    Route::post('/webmaster/sections/{id}/update',
        [WebmasterSectionsController::class, 'update'])->name('WebmasterSectionsUpdate');

    Route::post('/webmaster/sections/{id}/seo', [WebmasterSectionsController::class, 'seo'])->name('WebmasterSectionsSEOUpdate');

    Route::get('/webmaster/sections/destroy/{id}',
        [WebmasterSectionsController::class, 'destroy'])->name('WebmasterSectionsDestroy');
    Route::post('/webmaster/sections/updateAll',
        [WebmasterSectionsController::class, 'updateAll'])->name('WebmasterSectionsUpdateAll');

    // Webmaster Sections :Custom Fields
    Route::get('/webmaster/{webmasterId}/fields', [WebmasterSectionsController::class, 'webmasterFields'])->name('webmasterFields');
    Route::get('/{webmasterId}/fields/create', [WebmasterSectionsController::class, 'fieldsCreate'])->name('webmasterFieldsCreate');
    Route::post('/webmaster/{webmasterId}/fields/store', [WebmasterSectionsController::class, 'fieldsStore'])->name('webmasterFieldsStore');
    Route::get('/webmaster/{webmasterId}/fields/{field_id}/edit', [WebmasterSectionsController::class, 'fieldsEdit'])->name('webmasterFieldsEdit');
    Route::post('/webmaster/{webmasterId}/fields/{field_id}/update', [WebmasterSectionsController::class, 'fieldsUpdate'])->name('webmasterFieldsUpdate');
    Route::get('/webmaster/{webmasterId}/fields/destroy/{field_id}', [WebmasterSectionsController::class, 'fieldsDestroy'])->name('webmasterFieldsDestroy');
    Route::post('/webmaster/{webmasterId}/fields/updateAll', [WebmasterSectionsController::class, 'fieldsUpdateAll'])->name('webmasterFieldsUpdateAll');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'updateSiteInfo'])->name('settingsUpdateSiteInfo');

    // Ad. Banners
    Route::get('/banners', [BannersController::class, 'index'])->name('Banners');
    Route::get('/banners/create/{sectionId}', [BannersController::class, 'create'])->name('BannersCreate');
    Route::post('/banners/store', [BannersController::class, 'store'])->name('BannersStore');
    Route::get('/banners/{id}/edit', [BannersController::class, 'edit'])->name('BannersEdit');
    Route::post('/banners/{id}/update', [BannersController::class, 'update'])->name('BannersUpdate');
    Route::get('/banners/destroy/{id?}', [BannersController::class, 'destroy'])->name('BannersDestroy');
    Route::post('/banners/updateAll', [BannersController::class, 'updateAll'])->name('BannersUpdateAll');

    // Sections
    Route::get('/{webmasterId}/categories', [CategoriesController::class, 'index'])->name('categories');
    Route::get('/{webmasterId}/categories/create', [CategoriesController::class, 'create'])->name('categoriesCreate');
    Route::post('/{webmasterId}/categories/store', [CategoriesController::class, 'store'])->name('categoriesStore');
    Route::get('/{webmasterId}/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categoriesEdit');
    Route::post('/{webmasterId}/categories/{id}/update', [CategoriesController::class, 'update'])->name('categoriesUpdate');
    Route::post('/{webmasterId}/categories/{id}/seo', [CategoriesController::class, 'seo'])->name('categoriesSEOUpdate');
    Route::get('/{webmasterId}/categories/destroy/{id?}', [CategoriesController::class, 'destroy'])->name('categoriesDestroy');
    Route::post('/{webmasterId}/categories/updateAll', [CategoriesController::class, 'updateAll'])->name('categoriesUpdateAll');

    // Topics
    Route::get('/{webmasterId}/topics', [TopicsController::class, 'index'])->name('topics');
    Route::post('/topics-list', [TopicsController::class, 'list'])->name('topicsList');
    Route::get('/{webmasterId}/view/{id}', [TopicsController::class, 'view'])->name('topicView');
    Route::get('/{webmasterId}/topics/create', [TopicsController::class, 'create'])->name('topicsCreate');
    Route::post('/{webmasterId}/topics/store', [TopicsController::class, 'store'])->name('topicsStore');
    Route::get('/{webmasterId}/topics/{id}/edit', [TopicsController::class, 'edit'])->name('topicsEdit');
    Route::post('/{webmasterId}/topics/{id}/update', [TopicsController::class, 'update'])->name('topicsUpdate');
    Route::get('/{webmasterId}/topics/destroy/{id?}', [TopicsController::class, 'destroy'])->name('topicsDestroy');
    Route::post('/{webmasterId}/topics/updateAll', [TopicsController::class, 'updateAll'])->name('topicsUpdateAll');
    Route::get('/{webmasterId}/print', [TopicsController::class, 'print'])->name('topicsPrint');
    // Topics :SEO
    Route::post('/{webmasterId}/topics/{id}/seo', [TopicsController::class, 'seo'])->name('topicsSEOUpdate');
    // Topics :Photos
    Route::post('/topics/upload', [TopicsController::class, 'upload'])->name('topicsPhotosUpload');
    Route::post('/{webmasterId}/topics/{id}/photos', [TopicsController::class, 'photos'])->name('topicsPhotosEdit');
    Route::get('/{webmasterId}/topics/{id}/photos/{photo_id}/destroy',
        [TopicsController::class, 'photosDestroy'])->name('topicsPhotosDestroy');
    Route::post('/{webmasterId}/topics/{id}/photos/updateAll',
        [TopicsController::class, 'photosUpdateAll'])->name('topicsPhotosUpdateAll');


    Route::post('/topics-import', [TopicsController::class, 'import'])->name('topicsImport');



    // Topics :Files
    Route::get('/{webmasterId}/topics/{id}/files', [TopicsController::class, 'topicsFiles'])->name('topicsFiles');
    Route::get('/{webmasterId}/topics/{id}/files/create',
        [TopicsController::class, 'filesCreate'])->name('topicsFilesCreate');
    Route::post('/{webmasterId}/topics/{id}/files/store',
        [TopicsController::class, 'filesStore'])->name('topicsFilesStore');
    Route::get('/{webmasterId}/topics/{id}/files/{file_id}/edit',
        [TopicsController::class, 'filesEdit'])->name('topicsFilesEdit');
    Route::post('/{webmasterId}/topics/{id}/files/{file_id}/update',
        [TopicsController::class, 'filesUpdate'])->name('topicsFilesUpdate');
    Route::get('/{webmasterId}/topics/{id}/files/destroy/{file_id}',
        [TopicsController::class, 'filesDestroy'])->name('topicsFilesDestroy');
    Route::post('/{webmasterId}/topics/{id}/files/updateAll',
        [TopicsController::class, 'filesUpdateAll'])->name('topicsFilesUpdateAll');


    // Topics :Related
    Route::get('/{webmasterId}/topics/{id}/related', [TopicsController::class, 'topicsRelated'])->name('topicsRelated');
    Route::get('/relatedLoad/{id}', [TopicsController::class, 'topicsRelatedLoad'])->name('topicsRelatedLoad');
    Route::get('/{webmasterId}/topics/{id}/related/create',
        [TopicsController::class, 'relatedCreate'])->name('topicsRelatedCreate');
    Route::post('/{webmasterId}/topics/{id}/related/store',
        [TopicsController::class, 'relatedStore'])->name('topicsRelatedStore');
    Route::get('/{webmasterId}/topics/{id}/related/destroy/{related_id}',
        [TopicsController::class, 'relatedDestroy'])->name('topicsRelatedDestroy');
    Route::post('/{webmasterId}/topics/{id}/related/updateAll',
        [TopicsController::class, 'relatedUpdateAll'])->name('topicsRelatedUpdateAll');
    // Topics :Comments
    Route::get('/{webmasterId}/topics/{id}/comments', [TopicsController::class, 'topicsComments'])->name('topicsComments');
    Route::get('/{webmasterId}/topics/{id}/comments/create',
        [TopicsController::class, 'commentsCreate'])->name('topicsCommentsCreate');
    Route::post('/{webmasterId}/topics/{id}/comments/store',
        [TopicsController::class, 'commentsStore'])->name('topicsCommentsStore');
    Route::get('/{webmasterId}/topics/{id}/comments/{comment_id}/edit',
        [TopicsController::class, 'commentsEdit'])->name('topicsCommentsEdit');
    Route::post('/{webmasterId}/topics/{id}/comments/{comment_id}/update',
        [TopicsController::class, 'commentsUpdate'])->name('topicsCommentsUpdate');
    Route::get('/{webmasterId}/topics/{id}/comments/destroy/{comment_id}',
        [TopicsController::class, 'commentsDestroy'])->name('topicsCommentsDestroy');
    Route::post('/{webmasterId}/topics/{id}/comments/updateAll',
        [TopicsController::class, 'commentsUpdateAll'])->name('topicsCommentsUpdateAll');
    // Topics :Maps
    Route::get('/{webmasterId}/topics/{id}/maps', [TopicsController::class, 'topicsMaps'])->name('topicsMaps');
    Route::get('/{webmasterId}/topics/{id}/maps/create', [TopicsController::class, 'mapsCreate'])->name('topicsMapsCreate');
    Route::post('/{webmasterId}/topics/{id}/maps/store', [TopicsController::class, 'mapsStore'])->name('topicsMapsStore');
    Route::get('/{webmasterId}/topics/{id}/maps/{map_id}/edit', [TopicsController::class, 'mapsEdit'])->name('topicsMapsEdit');
    Route::post('/{webmasterId}/topics/{id}/maps/{map_id}/update',
        [TopicsController::class, 'mapsUpdate'])->name('topicsMapsUpdate');
    Route::get('/{webmasterId}/topics/{id}/maps/destroy/{map_id}',
        [TopicsController::class, 'mapsDestroy'])->name('topicsMapsDestroy');
    Route::post('/{webmasterId}/topics/{id}/maps/updateAll',
        [TopicsController::class, 'mapsUpdateAll'])->name('topicsMapsUpdateAll');

    // keditor
    Route::get('/keditor/{topic_id?}', [TopicsController::class, 'keditor'])->name('keditor');
    Route::get('/keditor-snippets', [TopicsController::class, 'keditor_snippets'])->name('keditorSnippets');
    Route::post('/keditor-save', [TopicsController::class, 'keditor_save'])->name('keditorSave');

    // Contacts Groups
    Route::post('/contacts/storeGroup', [ContactsController::class, 'storeGroup'])->name('contactsStoreGroup');
    Route::get('/contacts/{id}/editGroup', [ContactsController::class, 'editGroup'])->name('contactsEditGroup');
    Route::post('/contacts/{id}/updateGroup', [ContactsController::class, 'updateGroup'])->name('contactsUpdateGroup');
    Route::get('/contacts/destroyGroup/{id}', [ContactsController::class, 'destroyGroup'])->name('contactsDestroyGroup');
    // Contacts
    Route::get('/contacts/{group_id?}', [ContactsController::class, 'index'])->name('contacts');
    Route::post('/contacts/store', [ContactsController::class, 'store'])->name('contactsStore');
    Route::post('/contacts/search', [ContactsController::class, 'search'])->name('contactsSearch');
    Route::get('/contacts/{id}/edit', [ContactsController::class, 'edit'])->name('contactsEdit');
    Route::post('/contacts/{id}/update', [ContactsController::class, 'update'])->name('contactsUpdate');
    Route::get('/contacts/destroy/{id}', [ContactsController::class, 'destroy'])->name('contactsDestroy');
    Route::post('/contacts/updateAll', [ContactsController::class, 'updateAll'])->name('contactsUpdateAll');

    // WebMails Groups
    Route::post('/webmails/storeGroup', [WebmailsController::class, 'storeGroup'])->name('webmailsStoreGroup');
    Route::get('/webmails/{id}/editGroup', [WebmailsController::class, 'editGroup'])->name('webmailsEditGroup');
    Route::post('/webmails/{id}/updateGroup', [WebmailsController::class, 'updateGroup'])->name('webmailsUpdateGroup');
    Route::get('/webmails/destroyGroup/{id}', [WebmailsController::class, 'destroyGroup'])->name('webmailsDestroyGroup');
    // WebMails
    Route::post('/webmails/store', [WebmailsController::class, 'store'])->name('webmailsStore');
    Route::post('/webmails/search', [WebmailsController::class, 'search'])->name('webmailsSearch');
    Route::get('/webmails/{id}/edit', [WebmailsController::class, 'edit'])->name('webmailsEdit');
    Route::get('/webmails/{group_id?}/{wid?}/{stat?}/{contact_email?}', [WebmailsController::class, 'index'])->name('webmails');
    Route::post('/webmails/{id}/update', [WebmailsController::class, 'update'])->name('webmailsUpdate');
    Route::get('/webmails/destroy/{id}', [WebmailsController::class, 'destroy'])->name('webmailsDestroy');
    Route::post('/webmails/updateAll', [WebmailsController::class, 'updateAll'])->name('webmailsUpdateAll');

    // Calendar
    Route::get('/calendar', [EventsController::class, 'index'])->name('calendar');
    Route::get('/calendar/create', [EventsController::class, 'create'])->name('calendarCreate');
    Route::post('/calendar/store', [EventsController::class, 'store'])->name('calendarStore');
    Route::get('/calendar/{id}/edit', [EventsController::class, 'edit'])->name('calendarEdit');
    Route::post('/calendar/{id}/update', [EventsController::class, 'update'])->name('calendarUpdate');
    Route::get('/calendar/destroy/{id}', [EventsController::class, 'destroy'])->name('calendarDestroy');
    Route::get('/calendar/updateAll', [EventsController::class, 'updateAll'])->name('calendarUpdateAll');
    Route::post('/calendar/{id}/extend', [EventsController::class, 'extend'])->name('calendarExtend');

    // Analytics
    Route::get('/ip/{ip_code?}', [AnalyticsController::class, 'ip'])->name('visitorsIP');
    Route::post('/ip/search', [AnalyticsController::class, 'search'])->name('visitorsSearch');
    Route::post('/analytics/{stat}', [AnalyticsController::class, 'filter'])->name('analyticsFilter');
    Route::get('/analytics/{stat?}', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/visitors', [AnalyticsController::class, 'visitors'])->name('visitors');

    // Users & Permissions
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/create/', [UsersController::class, 'create'])->name('usersCreate');
    Route::post('/users/store', [UsersController::class, 'store'])->name('usersStore');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('usersEdit');
    Route::post('/users/{id}/update', [UsersController::class, 'update'])->name('usersUpdate');
    Route::get('/users/destroy/{id}', [UsersController::class, 'destroy'])->name('usersDestroy');
    Route::post('/users/updateAll', [UsersController::class, 'updateAll'])->name('usersUpdateAll');

    Route::get('/users/permissions/create/', [UsersController::class, 'permissions_create'])->name('permissionsCreate');
    Route::post('/users/permissions/store', [UsersController::class, 'permissions_store'])->name('permissionsStore');
    Route::get('/users/permissions/{id}/edit', [UsersController::class, 'permissions_edit'])->name('permissionsEdit');
    Route::post('/users/permissions/{id}/update', [UsersController::class, 'permissions_update'])->name('permissionsUpdate');
    Route::post('/users/permissions/{id}/save', [UsersController::class, 'update_custom_home'])->name('permissionsHomePageUpdate');
    Route::get('/users/permissions/destroy/{id}', [UsersController::class, 'permissions_destroy'])->name('permissionsDestroy');

    Route::post('/permissions-links/store', [UsersController::class, 'links_store'])->name('customLinksStore');
    Route::post('/permissions-links/update', [UsersController::class, 'links_update'])->name('customLinksUpdate');
    Route::get('/permissions-links/edit/{id?}/{p_id?}', [UsersController::class, 'links_edit'])->name('customLinksEdit');
    Route::get('/permissions-links/destroy/{id?}/{p_id?}', [UsersController::class, 'links_destroy'])->name('customLinksDestroy');
    Route::get('/permissions-links/list/{p_id?}', [UsersController::class, 'links_list'])->name('customLinksList');


    // Menus
    Route::post('/menus/store/parent', [MenusController::class, 'storeMenu'])->name('parentMenusStore');
    Route::get('/menus/parent/{id}/edit', [MenusController::class, 'editMenu'])->name('parentMenusEdit');
    Route::post('/menus/{id}/update/{ParentMenuId}', [MenusController::class, 'updateMenu'])->name('parentMenusUpdate');
    Route::get('/menus/parent/destroy/{id}', [MenusController::class, 'destroyMenu'])->name('parentMenusDestroy');

    Route::get('/menus/{ParentMenuId?}', [MenusController::class, 'index'])->name('menus');
    Route::get('/menus/create/{ParentMenuId?}', [MenusController::class, 'create'])->name('menusCreate');
    Route::post('/menus/store/{ParentMenuId?}', [MenusController::class, 'store'])->name('menusStore');
    Route::get('/menus/{id}/edit/{ParentMenuId?}', [MenusController::class, 'edit'])->name('menusEdit');
    Route::post('/menus/{id}/update', [MenusController::class, 'update'])->name('menusUpdate');
    Route::get('/menus/destroy/{id}', [MenusController::class, 'destroy'])->name('menusDestroy');
    Route::post('/menus/updateAll', [MenusController::class, 'updateAll'])->name('menusUpdateAll');

    // Packages
    Route::get('/packages', [PackageController::class, 'index'])->name('packages');
    Route::get('/packages/create/', [PackageController::class, 'create'])->name('packagesCreate');
    Route::post('/packages/store', [PackageController::class, 'store'])->name('packagesStore');
    Route::get('/packages{id}/edit', [PackageController::class, 'edit'])->name('packagesEdit');
    Route::post('packages/{id}/update', [PackageController::class, 'update'])->name('packagesUpdate');
    Route::get('/packages/destroy/{id}', [PackageController::class, 'destroy'])->name('packagesDestroy');
    Route::post('/packages/updateAll', [PackageController::class, 'updateAll'])->name('packagesUpdateAll');

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/create/', [RoleController::class, 'create'])->name('rolesCreate');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('rolesStore');
    Route::get('/roles{id}/edit', [RoleController::class, 'edit'])->name('rolesEdit');
    Route::post('roles/{id}/update', [RoleController::class, 'update'])->name('rolesUpdate');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('rolesDestroy');
    Route::post('/roles/updateAll', [RoleController::class, 'updateAll'])->name('rolesUpdateAll');

    // Employees
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::get('/employees/create/', [EmployeeController::class, 'create'])->name('employeesCreate');
    Route::post('/employees/store', [EmployeeController::class, 'store'])->name('employeesStore');
    Route::get('/employees{id}/edit', [EmployeeController::class, 'edit'])->name('employeesEdit');
    Route::post('employees/{id}/update', [EmployeeController::class, 'update'])->name('employeesUpdate');
    Route::get('/employees/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employeesDestroy');
    Route::post('/employees/updateAll', [EmployeeController::class, 'updateAll'])->name('employeesUpdateAll');

// <<<<<<< HEAD
    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::post('/clients/updateAll', [ClientController::class, 'updateAll'])->name('clientsUpdateAll');

// SET CHILD TO SPECIALIST AND SUPERVISOR


    Route::get('/set-child-to',[DashboardController::class, 'setChildToPage'])->name('SetChildTo');
    Route::get('/set-child-to/create',[DashboardController::class, 'setChildToCreatePage'])->name('SetChildPage');
    Route::get('/set-child-to/edit/{id}',[DashboardController::class, 'setChildToEditPage'])->name('SetChildEditPage');
    Route::post('/set-child-to/store',[DashboardController::class, 'setChild'])->name('SetChild');
    Route::post('/set-child-to/update/{id}',[DashboardController::class, 'updateChild'])->name('UpdateSetChild');


    // Society
    Route::get('/societies', [SocietyController::class, 'index'])->name('societies');
    Route::get('/societies/create/', [SocietyController::class, 'create'])->name('societiesCreate');
    Route::post('/societies/store', [SocietyController::class, 'store'])->name('societiesStore');
    Route::get('/societies{id}/edit', [SocietyController::class, 'edit'])->name('societiesEdit');
    Route::post('societies/{id}/update', [SocietyController::class, 'update'])->name('societiesUpdate');
    Route::get('/societies/destroy/{id}', [SocietyController::class, 'destroy'])->name('societiesDestroy');
    Route::post('/societies/updateAll', [SocietyController::class, 'updateAll'])->name('societiesUpdateAll');
    Route::get('/societies/change_status/{id}', [SocietyController::class, 'change_status'])->name('societies.change_status');

    Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
    Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

    Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
    Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

// =======

// Society
Route::get('/societies', [SocietyController::class, 'index'])->name('societies');
Route::get('/societies/create/', [SocietyController::class, 'create'])->name('societiesCreate');
Route::post('/societies/store', [SocietyController::class, 'store'])->name('societiesStore');
Route::get('/societies{id}/edit', [SocietyController::class, 'edit'])->name('societiesEdit');
Route::post('societies/{id}/update', [SocietyController::class, 'update'])->name('societiesUpdate');
Route::get('/societies/destroy/{id}', [SocietyController::class, 'destroy'])->name('societiesDestroy');
Route::post('/societies/updateAll', [SocietyController::class, 'updateAll'])->name('societiesUpdateAll');
Route::get('/societies/change_status/{id}', [SocietyController::class, 'change_status'])->name('societies.change_status');

Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

    Route::get('file-manager', [FileManagerController::class, 'index'])->name('FileManager');
    Route::get('files-manager', [FileManagerController::class, 'manager'])->name('FilesManager');

// >>>>>>> 2704ee87b2e7b7b7c6687a1e91124fa1b7313a1b

    // Clear Cache
    Route::get('/cache-clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return redirect()->back()->with('doneMessage', __('backend.cashClearDone'));
    })->name('cacheClear');
    // Menus

    // Financial Transaction
    Route::get('/financial-transactions', [FinancialTransactionController::class, 'index'])->name('financial-transactions');
    Route::get('/financial-transactions/create/', [FinancialTransactionController::class, 'create'])->name('financialTransactionsCreate');
    Route::post('/financial-transactions/store', [FinancialTransactionController::class, 'store'])->name('financialTransactionsStore');
    Route::get('/financial-transactions/{id}/edit', [FinancialTransactionController::class, 'edit'])->name('financialTransactionsEdit');
    Route::post('/financial-transactions/{id}/update', [FinancialTransactionController::class, 'update'])->name('financialTransactionsUpdate');
    Route::get('/financial-transactions/destroy/{id}', [FinancialTransactionController::class, 'destroy'])->name('financialTransactionsDestroy');
    Route::post('/financial-transactions/updateAll', [FinancialTransactionController::class, 'updateAll'])->name('financialTransactionsUpdateAll');

    // Common Questions
    Route::get('/common-questions', [CommonQuestionController::class, 'index'])->name('CommonQuestions');
    Route::get('/common-questions/create/', [CommonQuestionController::class, 'create'])->name('CommonQuestionsCreate');
    Route::post('/common-questions/store', [CommonQuestionController::class, 'store'])->name('CommonQuestionsStore');
    Route::get('/common-questions/{id}/edit', [CommonQuestionController::class, 'edit'])->name('CommonQuestionsEdit');
    Route::post('/common-questions/{id}/update', [CommonQuestionController::class, 'update'])->name('CommonQuestionsUpdate');
    Route::get('/common-questions/destroy/{id}', [CommonQuestionController::class, 'destroy'])->name('CommonQuestionsDestroy');
    Route::post('/common-questions/updateAll', [CommonQuestionController::class, 'updateAll'])->name('CommonQuestionsUpdateAll');

    // Main Services
    Route::get('/main-services', [MainServiceController::class, 'index'])->name('MainServices');
    Route::get('/main-services/create/', [MainServiceController::class, 'create'])->name('MainServicesCreate');
    Route::post('/main-services/store', [MainServiceController::class, 'store'])->name('MainServicesStore');
    Route::get('/main-services/{id}/edit', [MainServiceController::class, 'edit'])->name('MainServicesEdit');
    Route::post('/main-services/{id}/update', [MainServiceController::class, 'update'])->name('MainServicesUpdate');
    Route::get('/main-services/destroy/{id}', [MainServiceController::class, 'destroy'])->name('MainServicesDestroy');
    Route::post('/main-services/updateAll', [MainServiceController::class, 'updateAll'])->name('MainServicesUpdateAll');

    // Sub Services
    Route::get('/sub-services', [SubServiceController::class, 'index'])->name('SubServices');
    Route::get('/sub-services/create/', [SubServiceController::class, 'create'])->name('SubServicesCreate');
    Route::post('/sub-services/store', [SubServiceController::class, 'store'])->name('SubServicesStore');
    Route::get('/sub-services/{id}/edit', [SubServiceController::class, 'edit'])->name('SubServicesEdit');
    Route::post('/sub-services/{id}/update', [SubServiceController::class, 'update'])->name('SubServicesUpdate');
    Route::get('/sub-services/destroy/{id}', [SubServiceController::class, 'destroy'])->name('SubServicesDestroy');
    Route::post('/sub-services/updateAll', [SubServiceController::class, 'updateAll'])->name('SubServicesUpdateAll');

    // Reports
    Route::get('/early-detection-reports', [EarlyDetectionReportController::class, 'EarlyDetectionReports'])->name('EarlyDetectionReports');
    Route::post('/early-detection-reports-ajax-create/{id}', [EarlyDetectionReportController::class, 'AjaxCreate'])->name('EarlyDetectionReports-AjaxCreate');
    Route::get('/chlidren-early-detection-reports/{id}', [EarlyDetectionReportController::class, 'ShowEarlyDetectionReports'])->name('ShowEarlyDetectionReports');
    Route::get('/chlidren-early-detection-reports/{id}/edit', [EarlyDetectionReportController::class, 'EditEarlyDetectionReports'])->name('EditEarlyDetectionReports');
    Route::post('/chlidren-early-detection-reports/{id}/update', [EarlyDetectionReportController::class, 'UpdateEarlyDetectionReports'])->name('UpdateEarlyDetectionReports');
    Route::get('/early-detection-reports-create/{id}', [EarlyDetectionReportController::class, 'EarlyDetectionReportsCreate'])->name('EarlyDetectionReportsCreate');
    Route::post('/chlidren-early-detection-reports/store', [EarlyDetectionReportController::class, 'StoreEarlyDetectionReports'])->name('StoreEarlyDetectionReports');

    // PurchaseTransactions
    Route::get('/purchase-transactions', [PurchaseTransactionController::class, 'index'])->name('PurchaseTransactions');
    Route::get('/societies/change_status/{id}', [PurchaseTransactionController::class, 'change_status'])->name('PurchaseTransactionsChangeStatus');
});

//Specialist Routes
Route::group(['prefix'=>env('SPECIALIST_PATH'),'middleware'=>'specialist'],function(){
    Route::get('/', [SpecialistController::class, 'index'])->name('specialistHome');
    Route::get('/childrens', [SpecialistController::class , 'showChildrens'])->name('Childrens');
    Route::get('/report/create/{id}', [SpecialistController::class, 'createReportPage'])->name('ReportCreate');
    Route::get('/report/edit/{id}', [SpecialistController::class, 'editReportPage'])->name('ReportEdit');
    Route::post('/report/update/{id}', [SpecialistController::class, 'updateReport'])->name('ReportUpdate');
    Route::post('/report/create/{id}', [SpecialistController::class, 'storeReport'])->name('ReportStore');
    Route::get('/report/show/{id}', [SpecialistController::class, 'showReportPage'])->name('ReportShow');
    Route::get('/children/reports/{id}', [SpecialistController::class, 'showChildrenReports'])->name('ChildrenReports');
    Route::get('/file/download/{name}', [SpecialistController::class, 'fileDownload'])->name('DownloadFile');
    Route::get('/children/reports/{id}', [SpecialistController::class, 'showChildrenReports'])->name('ChildrenReports');

    Route::get('/consulting-report/show/{id}', [SpecialistController::class, 'showConsultingReportPage'])->name('ConsultingReportShow');
    Route::get('/children/consulting-reports/{id}', [SpecialistController::class, 'showChildrenConsultingReports'])->name('ChildrenConsultingReports');
    Route::get('/consulting-report/create/{id}', [SpecialistController::class, 'createConsultingReportPage'])->name('ConsultingReportCreate');
    Route::get('/consulting-report/edit/{id}', [SpecialistController::class, 'editConsultingReportPage'])->name('ConsultingReportEdit');
    Route::post('/consulting-report/create/{id}', [SpecialistController::class, 'storeConsultingReport'])->name('ConsultingReportStore');
    Route::post('/consulting-report/update/{id}', [SpecialistController::class, 'updateConsultingReport'])->name('ConsultingReportUpdate');


    Route::get('/status-report/show/{id}', [SpecialistController::class, 'showStatusReportPage'])->name('StatushowVbmapPage');
    Route::get('/children/status-reports/{id}', [SpecialistController::class, 'showChildrenStatusReports'])->name('ChildrenStatusReports');
    Route::get('/status-report/create/{id}', [SpecialistController::class, 'createStatusReportPage'])->name('StatucreateVbmapPage');
    Route::get('/status-report/edit/{id}', [SpecialistController::class, 'editStatusReportPage'])->name('StatueditVbmapPage');
    Route::post('/status-report/create/{id}', [SpecialistController::class, 'storeStatusReport'])->name('StatustoreVbmap');
    Route::post('/status-report/update/{id}', [SpecialistController::class, 'updateStatusReport'])->name('StatuupdateVbmap');


    Route::get('/profile', [SpecialistController::class, 'showProfile'])->name('Profile');
    Route::post('/profile/update', [SpecialistController::class, 'updateProfile'])->name('profileUpdate');

    Route::get('/transactions', [SpecialistController::class, 'showFTransactions'])->name('FTransactions');
});


//Supervisor Routes
Route::group(['prefix'=>env('SUPERVISOR_PATH'),'middleware'=>'supervisor'],function(){
    Route::get('/', [SupervisorController::class, 'index'])->name('supervisorHome');
    Route::get('/childrens', [SupervisorController::class , 'showChildrens'])->name('SChildrens');
    Route::get('/children/vbmap/{id}', [SupervisorController::class, 'showChildrenVbmap'])->name('showChildrenVbmap');
    Route::get('/vbmap/create/{id}', [SupervisorController::class, 'createVbmapPage'])->name('createVbmapPage');
    Route::get('/vbmap/edit/{id}', [SupervisorController::class, 'editVbmapPage'])->name('editVbmapPage');
    Route::get('/vbmap/show/{id}', [SupervisorController::class, 'showVbmapPage'])->name('showVbmapPage');
    Route::get('/file/download/{name}', [SupervisorController::class, 'fileDownload'])->name('SDownloadFile');
    Route::post('/vbmap/update/{id}', [SupervisorController::class, 'updateVbmap'])->name('updateVbmap');
    Route::post('/vbmap/create/{id}', [SupervisorController::class, 'storeVbmap'])->name('storeVbmap');

    Route::get('/treatment-plan/show/{id}', [SupervisorController::class, 'showTreatmentPlanPage'])->name('showTreatmentPlanPage');
    Route::get('/children/treatment-plan/{id}', [SupervisorController::class, 'showChildrenTreatmentPlan'])->name('showChildrenTreatmentPlan');
    Route::get('/treatment-plan/create/{id}', [SupervisorController::class, 'createTreatmentPlanPage'])->name('createTreatmentPlanPage');
    Route::get('/treatment-plan/edit/{id}', [SupervisorController::class, 'editTreatmentPlanPage'])->name('editTreatmentPlanPage');
    Route::post('/treatment-plan/create/{id}', [SupervisorController::class, 'storeTreatmentPlan'])->name('storeTreatmentPlan');
    Route::post('/treatment-plan/update/{id}', [SupervisorController::class, 'updateTreatmentPlan'])->name('updateTreatmentPlan');

    Route::get('/consulting-report/show/{id}', [SupervisorController::class, 'showConsultingReportPage'])->name('showConsultingReportPage');
    Route::get('/children/consulting-reports/{id}', [SupervisorController::class, 'showChildrenConsultingReports'])->name('showChildrenConsultingReports');
    Route::get('/consulting-report/create/{id}', [SupervisorController::class, 'createConsultingReportPage'])->name('createConsultingReportPage');
    Route::get('/consulting-report/edit/{id}', [SupervisorController::class, 'editConsultingReportPage'])->name('editConsultingReportPage');
    Route::post('/consulting-report/create/{id}', [SupervisorController::class, 'storeConsultingReport'])->name('storeConsultingReport');
    Route::post('/consulting-report/update/{id}', [SupervisorController::class, 'updateConsultingReport'])->name('updateConsultingReport');

    Route::get('/final-report/show/{id}', [SupervisorController::class, 'showFinalReportPage'])->name('SStatushowVbmapPage');
    Route::get('/children/final-reports/{id}', [SupervisorController::class, 'showChildrenFinalReports'])->name('showChildrenFinalReports');
    Route::get('/final-report/create/{id}', [SupervisorController::class, 'createFinalReportPage'])->name('createFinalReportPage');
    Route::get('/final-report/edit/{id}', [SupervisorController::class, 'editFinalReportPage'])->name('editFinalReportPage');
    Route::post('/final-report/create/{id}', [SupervisorController::class, 'storeFinalReport'])->name('storeFinalReport');
    Route::post('/final-report/update/{id}', [SupervisorController::class, 'updateFinalReport'])->name('updateFinalReport');


    Route::get('/profile', [SupervisorController::class, 'showProfile'])->name('SProfile');
    Route::post('/profile/update', [SupervisorController::class, 'updateProfile'])->name('SprofileUpdate');

    Route::get('/transactions', [SupervisorController::class, 'showFTransactions'])->name('SFTransactions');
});
