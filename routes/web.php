<?php
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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


 Auth::routes();

// Paginas Publicas
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/about','HomeController@about');
Route::get('/terms-of-service','HomeController@terms_of_service');
Route::get('/privacy-policy','HomeController@privacy_policy');
Route::get('/user-lock-screen', 'HomeController@userLock')->name('user.lock');


// Login redes Sociales
$s = 'social.';
Route::get('/social/redirect/{provider}', [
	'as' => $s . 'redirect',
	'uses' => 'SocialController@getSocialRedirect'
]);
Route::get('/social/handle/{provider}', [
	'as' => $s . 'handle',
	'uses' => 'SocialController@getSocialHandle'
]);


//RUTAS PROTEGIDAS
// locale route
Route::get('lang/{locale}', [LanguageController::class, 'swap'])->middleware('auth');;


// Dashboard
Route::get('/dashboard', 'Backend\DashboardController@index')->name('hotel.dashboard')->middleware('auth');
Route::get('/company-profile', 'CompanyController@index')->name('company.index')->middleware('auth');
Route::post('/company', 'CompanyController@update')->name('company.update')->middleware('auth');

//Hotel
Route::get('/hotel-manager', 'HotelController@index')->name('hotel.index')->middleware('auth');
Route::get('/hotel-manager/create', 'HotelController@create')->name('hotel.create')->middleware('auth');
Route::post('/hotel-manager', 'HotelController@store')->name('hotel.store')->middleware('auth');
Route::get('/hotel-manager/{hotel}', 'HotelController@show')->name('hotel.show')->middleware('auth');
Route::get('/hotel-manager/{hotel}/edit', 'HotelController@edit')->name('hotel.edit')->middleware('auth');
Route::put('/hotel-manager/{hotel}', 'HotelController@update')->name('hotel.update')->middleware('auth');
Route::delete('/hotel-manager/{hotel}', 'HotelController@destroy')->name('hotel.destroy')->middleware('auth');
// amenities
Route::resource('amenities', 'AmenityController')->middleware('auth');
// Image
Route::delete('/images/{image}', 'ImageController@destroy')->name('images.destroy')->middleware('auth');

// Blocks
Route::resource('blocks', 'BlockController')->middleware('auth');
// Floors
Route::resource('floors', 'FloorController')->middleware('auth');



// Room Types
Route::resource('room-types', 'RoomTypeController')->middleware('auth');

//Room Taxes/Fees
Route::resource('room-taxes', 'RoomTaxController')->middleware('auth');
Route::delete('/hotel-manager/delete/{id}', 'RoomTaxController@deleteDetail')->name('room-taxes.deletedetail')->middleware('auth');
//AccountCode
Route::post('accountcode', 'AccountCodeController@store')->name('accountcode.store')->middleware('auth');
Route::post('accountcode/list', 'AccountCodeController@list')->name('accountcode.list')->middleware('auth');

//TaxApplied
Route::get('taxapplied', 'TaxAppliedController@index')->name('taxapplied')->middleware('auth');

//Rooms
Route::resource('rooms', 'RoomController')->middleware('auth');
Route::resource('sort-rooms', 'SortRoomController')->middleware('auth');
//Other Areas Hotel
Route::resource('other-hotel-area', 'OtherHotelAreaController')->middleware('auth');
//Display Color
Route::resource('display-color', 'DisplayColor')->middleware('auth');
//Phone Extension
Route::resource('phone-extensions', 'PhoneExtensionController')->middleware('auth');
Route::post('phone-extensions/save', 'PhoneExtensionController@saveChanges')->middleware('auth');

//Season
Route::resource('seasons-attribute', 'SeasonAttributeController')->middleware('auth');
// Admin Season
Route::resource('admin-season', 'SeasonController')->middleware('auth');

// Admin Season
Route::resource('special-periods', 'SpecialPeriodController')->middleware('auth');

//default-settings
Route::resource('default-settings', 'DefaultSettingController')->middleware('auth');

//room-prices
Route::resource('room-prices', 'RoomPriceController')->middleware('auth');
Route::post('roomprice', 'RoomPriceController@roomprice')->middleware('auth');
Route::post('saveroomtypeweb', 'RoomPriceController@saveroomtypeweb')->middleware('auth');
Route::post('saveroomprice', 'RoomPriceController@saveroomprice')->middleware('auth');
Route::get('room-prices/history/{id}/{category}/{categoryid}', 'RoomPriceController@history')->name('room-price.history')->middleware('auth');
Route::post('room-prices/roompricepolicies', 'RoomPriceController@roompricepolicies')->name('room-price.roompricepolicies')->middleware('auth');
Route::post('room-prices/saveroompricepolicies', 'RoomPriceController@saveroompricepolicies')->name('room-price.saveroompricepolicies')->middleware('auth');
Route::post('room-prices/deleteroompricepolicies', 'RoomPriceController@deleteroompricepolicies')->name('room-price.deleteroompricepolicies')->middleware('auth');


//cancellation-policy
Route::resource('cancellation-policy', 'CancellationPolicyController')->middleware('auth');

//booking-policy
Route::resource('booking-policy', 'BookingPolicyController')->middleware('auth');

//departments
Route::resource('departments', 'PropertyDepartmentController')->middleware('auth');

//POS
//pospoints
Route::resource('pospoints', 'PosPointController')->middleware('auth');

//productcategories
Route::resource('productcategories', 'ProductCategoryController')->middleware('auth');

//productsubcategories
Route::resource('productsubcategories', 'ProductSubcategoryController')->middleware('auth');
Route::post('productsubcategories/list', 'ProductSubcategoryController@list')->name('productsubcategories.list')->middleware('auth');

//productsubcategories
Route::resource('products', 'ProductController')->middleware('auth');
//measurement-units
Route::resource('measurement-units', 'MeasurementUnitController')->middleware('auth');
//inclusions
Route::resource('inclusions', 'InclusionController')->middleware('auth');


//PosProductController
Route::post('posproduct/list', 'PosProductController@list')->name('posproduct.list')->middleware('auth');
Route::post('posproduct/current_price', 'PosProductController@current_price')->name('posproduct.current_price')->middleware('auth');

//packages-master
Route::resource('packages-master', 'PackagesMasterController')->middleware('auth');
Route::post('packages-master/filterpackage', 'PackagesMasterController@filterPackage')->middleware('auth');
Route::post('packages-master/attachpackage', 'PackagesMasterController@attachPackage')->name('package.attachPackage')->middleware('auth');

//frontdesk-packages
Route::resource('frontdesk-packages', 'FrontDeskPackageController')->middleware('auth');
Route::post('frontdesk-packages/activationdate', 'FrontDeskPackageController@activationDate')->name("frontdesk-packages.activationdate")->middleware('auth');
Route::post('frontdesk-packages/deletedate', 'FrontDeskPackageController@deleteDate')->name("frontdesk-packages.deletedate")->middleware('auth');
Route::put('frontdesk-packages/feature/{id}', 'FrontDeskPackageController@featured')->name("frontdesk-packages.feature")->middleware('auth');
Route::post('frontdesk-packages/pricelist', 'FrontDeskPackageController@pricelist')->name("frontdesk-packages.pricelist")->middleware('auth');
Route::post('frontdesk-packages/weekdayslist', 'FrontDeskPackageController@weekdayslist')->name("frontdesk-packages.weekdayslist")->middleware('auth');

//early-bird-discount
Route::resource('early-bird-discount', 'DiscountEarlyBirdController')->middleware('auth');
//last-minute-discount
Route::resource('last-minute-discount', 'DiscountLastMinuteController')->middleware('auth');

//dynamic-pricing
Route::resource('dynamic-pricing', 'DiscountDynamicPricingController')->middleware('auth');
//long-stay-discount
Route::resource('long-stay-discount', 'DiscountLongStayController')->middleware('auth');


//Calendar
Route::get('calendar', 'CalendarController@index')->name("calendar.index")->middleware('auth');
Route::post('calendar/getinformation', 'CalendarController@getInformation')->name("calendar.index")->middleware('auth');
Route::post('calendar/housekeeping/getinformation', 'CalendarController@getInformation')->name("calendar.index")->middleware('auth');
Route::get('calendar/housekeeping', 'CalendarController@housekeeping')->name('calendar.housekeeping')->middleware('auth');

//Restaurant 
Route::get('restaurant','RestaurantController@index')->middleware('auth');
Route::post('restaurant/getinformation','RestaurantController@getInformation')->middleware('auth');
//Tasks
Route::get('/developers/task', 'DevelopersController@index')->name('developers.index')->middleware('auth');
Route::get('/developers/create-task', 'DevelopersController@create')->name('developers.create-task')->middleware('auth');
Route::get('/developers/show/{id}', 'DevelopersController@show')->name('developers.show-task')->middleware('auth');
Route::get('/developers/edit/{id}', 'DevelopersController@editTask')->name('developers.edit-task')->middleware('auth');
Route::post('developers/create-task', 'DevelopersController@store')->name('developers.create-task')->middleware('auth');
Route::post('developers/update-task/{task}', 'DevelopersController@updateTask')->name('developers.update-task')->middleware('auth');

Route::get('/developers/create-category', 'DevelopersController@createCategory')->name('developers.create-category')->middleware('auth');
Route::post('developers/create-category', 'DevelopersController@storeCategory')->name('developers.store-category')->middleware('auth');

Route::get('/developers/create-subcategory', 'DevelopersController@createSubcategory')->name('developers.create-subcategory')->middleware('auth');
Route::post('developers/create-subcategory', 'DevelopersController@storeSubcategory')->name('developers.store-subcategory')->middleware('auth');

Route::get('/developers/create-developer', 'DevelopersController@createDeveloper')->name('developers.create-developer')->middleware('auth');
Route::post('developers/create-developer', 'DevelopersController@storeDeveloper')->name('developers.store-developer')->middleware('auth');

///long-stay-discount

/*



Route::get('/modern', 'DashboardController@dashboardModern');
Route::get('/ecommerce', 'DashboardController@dashboardEcommerce');


// Application Route
Route::get('/app-email', 'ApplicationController@emailApp');
Route::get('/app-email/content', 'ApplicationController@emailContentApp');
Route::get('/app-chat', 'ApplicationController@chatApp');
Route::get('/app-todo', 'ApplicationController@todoApp');
Route::get('/app-kanban', 'ApplicationController@kanbanApp');
Route::get('/app-file-manager', 'ApplicationController@fileManagerApp');
Route::get('/app-contacts', 'ApplicationController@contactApp');
Route::get('/app-calendar', 'ApplicationController@calendarApp');
Route::get('/app-invoice-list', 'ApplicationController@invoiceList');
Route::get('/app-invoice-view', 'ApplicationController@invoiceView');
Route::get('/app-invoice-edit', 'ApplicationController@invoiceEdit');
Route::get('/app-invoice-add', 'ApplicationController@invoiceAdd');
Route::get('/eCommerce-products-page', 'ApplicationController@ecommerceProduct');
Route::get('/eCommerce-pricing', 'ApplicationController@eCommercePricing');

// User profile Route
Route::get('/user-profile-page', 'UserProfileController@userProfile');

// Page Route
Route::get('/page-contact', 'PageController@contactPage');
Route::get('/page-blog-list', 'PageController@pageBlogList');
Route::get('/page-search', 'PageController@searchPage');
Route::get('/page-knowledge', 'PageController@knowledgePage');
Route::get('/page-knowledge/licensing', 'PageController@knowledgeLicensingPage');
Route::get('/page-knowledge/licensing/detail', 'PageController@knowledgeLicensingPageDetails');
Route::get('/page-timeline', 'PageController@timelinePage');
Route::get('/page-faq', 'PageController@faqPage');
Route::get('/page-faq-detail', 'PageController@faqDetailsPage');
Route::get('/page-account-settings', 'PageController@accountSetting');
Route::get('/page-blank', 'PageController@blankPage');
Route::get('/page-collapse', 'PageController@collapsePage');

// Media Route
Route::get('/media-gallery-page', 'MediaController@mediaGallery');
Route::get('/media-hover-effects', 'MediaController@hoverEffect');

// User Route
Route::get('/page-users-list', 'UserController@usersList');
Route::get('/page-users-view', 'UserController@usersView');
Route::get('/page-users-edit', 'UserController@usersEdit');

// Authentication Route
Route::get('/user-login', 'AuthenticationController@userLogin');
Route::get('/user-register', 'AuthenticationController@userRegister');
Route::get('/user-forgot-password', 'AuthenticationController@forgotPassword');
Route::get('/user-lock-screen', 'AuthenticationController@lockScreen');

// Misc Route
Route::get('/page-404', 'MiscController@page404');
Route::get('/page-maintenance', 'MiscController@maintenancePage');
Route::get('/page-500', 'MiscController@page500');

// Card Route
Route::get('/cards-basic', 'CardController@cardBasic');
Route::get('/cards-advance', 'CardController@cardAdvance');
Route::get('/cards-extended', 'CardController@cardsExtended');

// Css Route
Route::get('/css-typography', 'CssController@typographyCss');
Route::get('/css-color', 'CssController@colorCss');
Route::get('/css-grid', 'CssController@gridCss');
Route::get('/css-helpers', 'CssController@helpersCss');
Route::get('/css-media', 'CssController@mediaCss');
Route::get('/css-pulse', 'CssController@pulseCss');
Route::get('/css-sass', 'CssController@sassCss');
Route::get('/css-shadow', 'CssController@shadowCss');
Route::get('/css-animations', 'CssController@animationCss');
Route::get('/css-transitions', 'CssController@transitionCss');

// Basic Ui Route
Route::get('/ui-basic-buttons', 'BasicUiController@basicButtons');
Route::get('/ui-extended-buttons', 'BasicUiController@extendedButtons');
Route::get('/ui-icons', 'BasicUiController@iconsUI');
Route::get('/ui-alerts', 'BasicUiController@alertsUI');
Route::get('/ui-badges', 'BasicUiController@badgesUI');
Route::get('/ui-breadcrumbs', 'BasicUiController@breadcrumbsUI');
Route::get('/ui-chips', 'BasicUiController@chipsUI');
Route::get('/ui-chips', 'BasicUiController@chipsUI');
Route::get('/ui-collections', 'BasicUiController@collectionsUI');
Route::get('/ui-navbar', 'BasicUiController@navbarUI');
Route::get('/ui-pagination', 'BasicUiController@paginationUI');
Route::get('/ui-preloader', 'BasicUiController@preloaderUI');

// Advance UI Route
Route::get('/advance-ui-carousel', 'AdvanceUiController@carouselUI');
Route::get('/advance-ui-collapsibles', 'AdvanceUiController@collapsibleUI');
Route::get('/advance-ui-toasts', 'AdvanceUiController@toastUI');
Route::get('/advance-ui-tooltip', 'AdvanceUiController@tooltipUI');
Route::get('/advance-ui-dropdown', 'AdvanceUiController@dropdownUI');
Route::get('/advance-ui-feature-discovery', 'AdvanceUiController@discoveryFeature');
Route::get('/advance-ui-media', 'AdvanceUiController@mediaUI');
Route::get('/advance-ui-modals', 'AdvanceUiController@modalUI');
Route::get('/advance-ui-scrollspy', 'AdvanceUiController@scrollspyUI');
Route::get('/advance-ui-tabs', 'AdvanceUiController@tabsUI');
Route::get('/advance-ui-waves', 'AdvanceUiController@wavesUI');
Route::get('/fullscreen-slider-demo', 'AdvanceUiController@fullscreenSlider');

// Extra components Route
Route::get('/extra-components-range-slider', 'ExtraComponentsController@rangeSlider');
Route::get('/extra-components-sweetalert', 'ExtraComponentsController@sweetAlert');
Route::get('/extra-components-nestable', 'ExtraComponentsController@nestAble');
Route::get('/extra-components-treeview', 'ExtraComponentsController@treeView');
Route::get('/extra-components-ratings', 'ExtraComponentsController@ratings');
Route::get('/extra-components-tour', 'ExtraComponentsController@tour');
Route::get('/extra-components-i18n', 'ExtraComponentsController@i18n');
Route::get('/extra-components-highlight', 'ExtraComponentsController@highlight');

// Basic Tables Route
Route::get('/table-basic', 'BasicTableController@tableBasic');

// Data Table Route
Route::get('/table-data-table', 'DataTableController@dataTable');

// Form Route
Route::get('/form-elements', 'FormController@formElement');
Route::get('/form-select2', 'FormController@formSelect2');
Route::get('/form-validation', 'FormController@formValidation');
Route::get('/form-masks', 'FormController@masksForm');
Route::get('/form-editor', 'FormController@formEditor');
Route::get('/form-file-uploads', 'FormController@fileUploads');
Route::get('/form-layouts', 'FormController@formLayouts');
Route::get('/form-wizard', 'FormController@formWizard');

// Charts Route
Route::get('/charts-chartjs', 'ChartController@chartJs');
Route::get('/charts-chartist', 'ChartController@chartist');
Route::get('/charts-sparklines', 'ChartController@sparklines');


 */
