<?php

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
*/

// YouSign callback
Route::get('/signature/callback/{signatoryId}', 'Front\DocumentsController@signatureCallback')->name('signature_callback');

// Stripe webhooks
Route::post('/stripe/webhook', 'WebhookController@handleWebhook');


/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
*/

// Guest routes
Route::group(['middleware' => ['web', 'localizationRedirect'], 'namespace' => 'Front', 'prefix' => LaravelLocalization::setLocale()], function () {

   // Home
   Route::get('/', 'HomeController@index')->name('home');

   // Pages
   Route::get('/equipe', 'PagesController@team')->name('team');
   Route::get('/legal', 'PagesController@legal')->name('legal');
   Route::get('/concept', 'PagesController@concept')->name('concept');
   Route::get('/cursus', 'PagesController@prices')->name('cursus');
   Route::get('/help', 'PagesController@help')->name('help');
   Route::get('/terms', 'PagesController@terms')->name('terms');
   Route::get('/profil/{slug}', 'PagesController@profile')->name('profile');
   Route::get('/documents', 'PagesController@terms')->name('document');

   Route::get('/contact', 'PagesController@contact')->name('contact');
   Route::post('/contact', 'PagesController@sendContactEmail')->name('contact_post');

   // Login routes
   Route::get('/login', 'Auth\LoginController@index')->name('login');
   Route::post('/login', 'Auth\LoginController@login')->name('authenticate');
   Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

   Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password_reset_email');
   Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password_reset_send');
   Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password_reset_form');
   Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password_reset');

   Route::post('password/create', 'Auth\LoginController@createPassword')->name('password_create');

   // Registration routes
   Route::get('/register', 'Auth\RegisterController@index')->name('register');
   Route::post('/register', 'Auth\RegisterController@registrationRedirect')->name('registration_redirect');

   Route::get('/register/{type}', 'Auth\RegisterController@showRegistrationForm')->name('registration_form');
   Route::post('/register/validate_user','Auth\RegisterController@validateUser');
   Route::post('/register/validate_company','Auth\RegisterController@validateCompany');
   Route::post('/register/validate_coupon','Auth\RegisterController@validateCoupon');
   Route::post('/register/autocomplete_company','Auth\RegisterController@autocompleteCompany');

   Route::post('/register/{type}', 'Auth\RegisterController@register')->name('register_user');

   Route::get('/activate/{id}/{code}', 'UserController@activate')->name('activate');

   // Project teaser
   Route::get('/match/{id}', 'MatchesController@showTeaser')->name('match_teaser');
   Route::get('/match/{id}/decline', 'MatchesController@decline')->name('match_decline');
   Route::post('/match/{id}/decline', 'MatchesController@declineTeaser')->name('match_decline_teaser');

   // YouSign
   Route::get('/signature/{signatoryId}', 'DocumentsController@signature')->name('sign_document');

   // Newsletter
   Route::post('/newsletter', 'NewsletterController@subscribe')->name('newsletter');

   // Serve document
   Route::get('/documents/{id}', 'DocumentsController@serve')->name('serve_document');

});

// Authenticated user routes
Route::group(['middleware' => ['auth', 'localizationRedirect'], 'namespace' => 'Front', 'prefix' => LaravelLocalization::setLocale()], function () {

   /*
   |--------------------------------------------------------------------------
   | Project routes
   |--------------------------------------------------------------------------
   */
   Route::get('/projects', 'DashboardController@index')->name('projects');

   // Routes for all users who can view projects
   Route::group(['middleware' => ['project']], function() {
      Route::get('/projects/{id}/overview', 'ProjectsController@overview')->name('project_overview');

      Route::get('/projects/{id}/view/{step}', 'ProjectsController@view')->name('project_view');
      Route::get('/projects/{id}/preview/{step}', 'ProjectsController@preview')->name('project_preview');
      Route::get('/projects/{id}/steering', 'ProjectsController@steering')->name('project_steering');
      Route::post('/projects/{id}/requirements', 'ProjectsController@updateRequirements')->name('project_loi_requirements');

      Route::get('/projects/{id}/download', 'ProjectsController@download')->name('project_download');
   });

   // Routes for all users with admin rights
   Route::group(['middleware' => ['project:admin']], function() {
      Route::get('/projects/{id}/edit/{step}', 'ProjectsController@edit')->name('project_edit');
      Route::get('/projects/{id}/guests', 'ProjectsController@guests')->name('project_guests');

      Route::post('/projects/{id}/upload_file', 'ProjectsController@uploadFile')->name('project_upload_file');

      Route::post('/projects/{id}/steering', 'ProjectsController@updateSteering')->name('project_update_steering');
      Route::post('/projects/{id}/guests/new', 'ProjectsController@addGuest')->name('project_add_guest');
      Route::delete('/projects/{id}/guests/{userId}', 'ProjectsController@deleteGuest')->name('project_delete_guest');
      Route::post('/projects/{id}/guests/{userId}/switch_role', 'ProjectsController@switchGuestRole')->name('project_switch_guest_role');

      Route::get('/projects/create', 'ProjectsController@create')->name('project_create');
      Route::post('/projects/create', 'ProjectsController@createFromPreform')->name('project_store');

      Route::post('/projects/{id}/edit/{step}', 'ProjectsController@update')->name('project_update');

      Route::post('/projects/{id}/request_validation', 'ProjectsController@requestValidation')->name('request_validation');
      Route::post('/projects/{id}/generate_licence', 'ProjectsController@generateLicence')->name('project_generate_licence');
      Route::post('/projects/{id}/send_licence', 'ProjectsController@sendLicence')->name('project_send_licence');

      Route::post('/projects/{id}/lock', 'ProjectsController@lock')->name('project_lock');
      Route::post('/projects/{id}/unlock', 'ProjectsController@unlock')->name('project_unlock');

      Route::post('/projects/{id}/project_cancel', 'ProjectsController@cancelProject')->name('project_cancel');

      Route::get('/projects/{id}/search/{logs?}', 'MatchingController@search')->name('project_match_making');

      Route::get('/projects/{id}/results', 'MatchingController@showResults')->name('project_matching_results');
      Route::post('/projects/{id}/results', 'MatchingController@storeSelection')->name('store_selection');
      Route::post('/projects/{id}/add_investor', 'MatchingController@addInvestor')->name('add_investor');

      Route::post('/projects/{id}/annex_documents', 'ProjectsController@addAnnexDocuments')->name('annex_documents');

   });



   /*
   |--------------------------------------------------------------------------
   | Matches routes
   |--------------------------------------------------------------------------
   */
   Route::group(['middleware' => ['match']], function() {
      Route::get('/match/{id}/overview', 'MatchesController@overview')->name('match_overview');
      Route::get('/match/{id}/discussion', 'MatchesController@discussion')->name('match_discussion');
      Route::get('/match/{id}/project/{step}', 'MatchesController@project')->name('match_project');
      Route::post('/match/{id}/discussion', 'MatchesController@sendMessage')->name('match_send_message');
      Route::post('/match/{id}/update_signatory', 'MatchesController@updateSignatory')->name('match_update_signatory');

      // Match documents
      Route::get('/match/{id}/document/{type}', 'MatchesController@viewDocument')->name('match_view_document');
      Route::get('/match/{id}/document/{type}/upload', 'MatchesController@showUploadForm')->name('match_upload_form')->middleware('match:strategy');
      Route::post('/match/{id}/document/{type}/upload', 'MatchesController@uploadDocument')->name('match_upload')->middleware('match:strategy');

      // NDA
      Route::get('/match/{id}/nda', 'NdaController@view')->name('match_view_nda');
      Route::get('/match/{id}/nda/edit', 'NdaController@edit')->name('match_edit_nda');

      // Download
      Route::get('/match/{id}/download', 'MatchesController@download')->name('match_download');
   });

   // Routes for users with admin rights
   Route::group(['middleware' => ['match:admin']], function() {
      Route::post('/match/{id}/send_mail', 'MatchesController@sendMatchingMail')->name('match_send_mail');
      Route::post('/match/{id}/stop', 'MatchesController@stop')->name('match_stop');

      // Accept or decline documents
      Route::post('/match/{id}/document/{type}/accept', 'MatchesController@acceptDocument')->name('match_accept_document');
      Route::post('/match/{id}/document/{type}/decline', 'MatchesController@declineDocument')->name('match_decline_document');

      // Accept or decline NDA
      Route::post('/match/{id}/nda/edit', 'NdaController@update')->name('match_update_nda');
      Route::post('/match/{id}/nda/accept', 'NdaController@accept')->name('match_accept_nda');
      Route::get('/match/{id}/nda/cancel', 'NdaController@cancel')->name('match_cancel_nda');
      Route::post('/match/{id}/nda/bypass', 'NdaController@bypass')->name('match_bypass_nda');
   });


   /*
   |--------------------------------------------------------------------------
   | Parameters routes
   |--------------------------------------------------------------------------
   */
   Route::get('/parameters/personal', 'ParametersController@personal')->name('parameters_personal');
   Route::get('/parameters/company', 'ParametersController@company')->name('parameters_company');
   Route::get('/parameters/subscription', 'ParametersController@subscription')->name('parameters_subscription');
   Route::get('/parameters/users', 'ParametersController@users')->name('parameters_users');

   Route::post('/parameters/update_personal', 'ParametersController@updatePersonalInfo')->name('update_personal_info');
   Route::post('/parameters/update_email', 'ParametersController@updateEmail')->name('update_email');
   Route::post('/parameters/update_password', 'ParametersController@updatePassword')->name('update_password');
   Route::post('/parameters/update_company', 'ParametersController@updateCompany')->name('update_company');

   Route::post('/parameters/update_credit_card', 'ParametersController@updateCreditCard')->name('update_credit_card');
   Route::post('/parameters/update_sepa', 'ParametersController@updateSepa')->name('update_sepa');
   Route::post('/parameters/upgrade_subscription', 'ParametersController@upgradeSubscription')->name('upgrade_subscription');
   Route::post('/parameters/renew_subscription', 'ParametersController@renewSubscription')->name('renew_subscription');
   Route::post('/parameters/cancel_subscription', 'ParametersController@cancelSubscription')->name('cancel_subscription');
   Route::post('/parameters/user_billing_informations', 'ParametersController@userBilling')->name('user_billing_informations');

   Route::get('/invoices/{id}', 'ParametersController@downloadInvoice')->name('download_invoice');


   /*
   |--------------------------------------------------------------------------
   | Company management routes
   |--------------------------------------------------------------------------
   */
   Route::get('/company/information', 'CompanyController@information')->name('company_information');
   Route::post('/company/information', 'CompanyController@updateInformation')->name('company_information_update');

   Route::get('/company/strategies', 'CompanyController@strategies')->name('company_strategies');
   Route::get('/company/strategy/request', 'CompanyController@requestStrategyCreation')->name('company_request_strategy_creation');
   Route::post('/company/strategy/request', 'CompanyController@sendStrategyCreationRequest')->name('send_strategy_creation_request');

   Route::get('/company/strategy/{id}/update', 'CompanyController@requestStrategyUpdate')->name('company_request_strategy_update');
   Route::post('/company/strategy/{id}/update', 'CompanyController@sendStrategyUpdateRequest')->name('send_strategy_update_request');
   Route::post('/company/strategy/{strategyId}/switch_user', 'CompanyController@switchUserStrategy')->name('switch_user_strategy');

   Route::get('/company/members', 'CompanyController@members')->name('company_members');
   Route::post('/company/{companyId}/add_user', 'CompanyController@addUser')->name('add_company_user');
   Route::post('/company/{companyId}/delete_user/{userId}', 'CompanyController@deleteUser')->name('delete_company_user');
   Route::post('/company/{companyId}/accept_user/{userId}', 'CompanyController@acceptUser')->name('accept_company_user');
   Route::post('/company/{companyId}/decline_user/{userId}', 'CompanyController@declineUser')->name('decline_company_user');
   Route::post('/company/{companyId}/switch_role/{userId}', 'CompanyController@switchUserRole')->name('switch_user_role');

   Route::post('/company/{companyId}/add_associate', 'CompanyController@addAssociate')->name('add_associate');
   Route::delete('/company/{companyId}/delete_associate/{userId}', 'CompanyController@deleteAssociate')->name('delete_associate');

   // Account
   Route::post('/account/send_activation_link', 'UserController@sendActivationLink')->name('send_activation_link');


   /*
   |--------------------------------------------------------------------------
   | FAQ
   |--------------------------------------------------------------------------
   */
   Route::get('/help/dashboard', 'DashboardController@faq')->name('help_dashbord');


   /*
   |--------------------------------------------------------------------------
   | Get user by email
   |--------------------------------------------------------------------------
   */
   Route::post('/users/search/{type?}', 'UserController@getByEmail');

});




/*
|--------------------------------------------------------------------------
| Back-end Routes
|--------------------------------------------------------------------------
*/

// Admin login routes
Route::group(['middleware' => ['web'], 'namespace' => 'Back', 'prefix' => 'admin'], function () {
   Route::get('/login', 'Auth\LoginController@showLoginForm');
   Route::post('/login', 'Auth\LoginController@login')->name('admin_login');
   Route::get('/logout', 'Auth\LoginController@logout');
});

// Access granted to admins only
Route::group(['middleware' => ['admin'], 'namespace' => 'Back', 'prefix' => 'admin'], function () {
   // Home
   Route::get('/', 'DashboardController@index')->name('admin_home');

   // Users
   Route::resource('/users', 'UsersController');
   Route::post('/users/search', 'UsersController@search');
   Route::post('/users/{id}/cancel_subscription', 'UsersController@cancelSubscription');

   Route::post('/users/export', 'UsersController@export');

   // Companies
   Route::resource('/companies', 'CompaniesController');

   Route::post('/companies/add_strategy', 'CompaniesController@addStrategy');
   Route::post('/companies/popup_create_strategy', 'CompaniesController@popupCreateStrategy');
   Route::post('/companies/popup_edit_strategy', 'CompaniesController@popupEditStrategy');

   Route::post('/companies/popup_create_user', 'CompaniesController@popupCreateUser');
   Route::post('/companies/popup_edit_user', 'CompaniesController@popupEditUser');
   Route::post('/companies/{companyId}/user', 'CompaniesController@addUser');
   Route::put('/companies/{companyId}/user/{userId}', 'CompaniesController@editUser');
   Route::delete('/companies/{companyId}/user/{userId}', 'CompaniesController@removeUser');

   Route::post('/companies/popup_create_representative', 'CompaniesController@popupCreateRepresentative');
   Route::post('/companies/{companyId}/representative', 'CompaniesController@changeRepresentative');

   Route::post('/companies/export', 'CompaniesController@export');

   // Strategies
   Route::resource('/strategies', 'StrategiesController');
   Route::post('/strategies/{id}/attach_users', 'StrategiesController@attachUsers');
   Route::get('/strategies/{id}/duplicate', 'StrategiesController@duplicate');

   // Projects
   Route::get('/projects', 'ProjectsController@index');
   Route::get('/projects/{id}/edit', 'ProjectsController@edit')->name('admin_edit_project');
   Route::get('/projects/{id}/view/{step}', 'ProjectsController@view');
   Route::get('/projects/{id}/run', 'ProjectsController@runAlgorithm');
   Route::post('/projects/{id}/confirm', 'ProjectsController@confirm');
   Route::post('/projects/{id}/decline', 'ProjectsController@decline');
   Route::get('/projects/{id}/download', 'ProjectsController@download');
   Route::post('/projects/{id}/cancel', 'ProjectsController@cancel');

   // Invoices
   Route::get('/invoices', 'InvoicesController@index');
   Route::get('/invoices/{id}/download', 'InvoicesController@downloadInvoice');

   // Documents
   Route::get('/documents/{id}', 'DocumentsController@serve');

   // Check admin password
   Route::post('/check_password', 'DashboardController@checkPassword');
});
