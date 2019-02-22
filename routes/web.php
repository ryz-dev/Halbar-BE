<?php

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

/* Route Admin */
Route::group(['namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'dtcms'], function () {

        /* Dashboard */
        Route::group(['prefix' => '/'], function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
        });

        /* Messages */
        Route::group(['prefix' => '/mail'], function () {
            Route::get('/', 'MessagesController@index')->name('messages');
            Route::get('/propsal', 'MessagesController@proposal')->name('proposal');
            Route::get('/compose', 'MessagesController@compose')->name('messages_create');
            Route::post('/send', 'MessagesController@send')->name('messages_send');
            Route::get('/detail/{id?}', 'MessagesController@detail')->name('messages_detail');
            Route::get('/detail/sent/{id?}', 'MessagesController@detail_sent')->name('messages_detail_sent');
            Route::post('/reply', 'MessagesController@reply')->name('messages_reply');
            Route::post('/delete', 'MessagesController@delete')->name('messages_delete');
            Route::get('/sent', 'MessagesController@sent')->name('messages_sent');
            Route::get('/trash', 'MessagesController@trash')->name('messages_trash');
        });

        /* Messages */
        Route::group(['prefix' => '/subscribers'], function () {
            Route::get('/', 'SubscribersController@index')->name('subscribers');
            Route::post('/store', 'SubscribersController@store')->name('subscribers_store');
            Route::post('/delete', 'SubscribersController@delete')->name('subscribers_delete');
        });

        /* Menus */
        Route::group(['prefix' => '/menus'], function () {
            Route::get('/', 'MenusController@index')->name('menus');
            Route::get('/{option?}', 'MenusController@index')->name('menus');
            Route::post('/store', 'MenusController@store')->name('menus_store');
            Route::post('/update', 'MenusController@update')->name('menus_update');
            Route::post('/delete', 'MenusController@delete')->name('menus_delete');
            Route::post('/drag', 'MenusController@drag')->name('menus_drag');
        });

        /* Slideshow */
        Route::group(['prefix' => '/slideshow'], function () {
            Route::get('/', 'SlideshowController@index')->name('slideshow');
            Route::get('/create', 'SlideshowController@create')->name('slideshow_create');
            Route::post('/store', 'SlideshowController@store')->name('slideshow_store');
            Route::get('/edit/{id?}', 'SlideshowController@edit')->name('slideshow_edit');
            Route::put('/update/{id?}', 'SlideshowController@update')->name('slideshow_update');
            Route::post('/delete', 'SlideshowController@delete')->name('slideshow_delete');
        });

        /* About */
        Route::group(['prefix' => '/about'], function () {
            Route::get('/', 'AboutController@index')->name('about');
            Route::post('/update', 'AboutController@update')->name('about_update');
            Route::get('/employees', 'AboutController@employees')->name('about_employees');
            Route::post('/employees/store', 'AboutController@employeesStore')->name('about_employees_store');
            Route::get('/employees/edit/{id?}', 'AboutController@employeesEdit')->name('about_employees_edit');
            Route::post('/employees/update', 'AboutController@employeesUpdate')->name('about_employees_update');
            Route::post('/employees/delete', 'AboutController@employeesdelete')->name('about_employees_delete');
        });

        /* Portfolio */
        Route::group(['prefix' => '/portfolio'], function () {
            Route::get('/', 'PortfolioController@index')->name('portfolio');
            Route::get('/create', 'PortfolioController@create')->name('portfolio_create');
            Route::post('/store', 'PortfolioController@store')->name('portfolio_store');
            Route::get('/edit/{id?}', 'PortfolioController@edit')->name('portfolio_edit');
            Route::put('/update/{id?}', 'PortfolioController@update')->name('portfolio_update');
            Route::post('/delete', 'PortfolioController@delete')->name('portfolio_delete');
        });

        /* Testimonials */
        Route::group(['prefix' => '/testimonials'], function () {
            Route::get('/', 'TestimonialsController@index')->name('testimonials');
            Route::get('/create', 'TestimonialsController@create')->name('testimonials_create');
            Route::post('/store', 'TestimonialsController@store')->name('testimonials_store');
            Route::get('/edit/{id?}', 'TestimonialsController@edit')->name('testimonials_edit');
            Route::put('/update/{id?}', 'TestimonialsController@update')->name('testimonials_update');
            Route::post('/delete', 'TestimonialsController@delete')->name('testimonials_delete');
        });

        /* Client */
        Route::group(['prefix' => '/client'], function () {
            Route::get('/', 'ClientController@index')->name('client');
            Route::get('/create', 'ClientController@create')->name('client_create');
            Route::post('/store', 'ClientController@store')->name('client_store');
            Route::get('/edit/{id?}', 'ClientController@edit')->name('client_edit');
            Route::put('/update/{id?}', 'ClientController@update')->name('client_update');
            Route::post('/delete', 'ClientController@delete')->name('client_delete');
        });

        /* Services */
        Route::group(['prefix' => '/services'], function () {
            Route::get('/', 'ServicesController@index')->name('services');
            Route::get('/create', 'ServicesController@create')->name('services_create');
            Route::post('/store', 'ServicesController@store')->name('services_store');
            Route::get('/edit/{id?}', 'ServicesController@edit')->name('services_edit');
            Route::put('/update/{id?}', 'ServicesController@update')->name('services_update');
            Route::post('/delete', 'ServicesController@delete')->name('services_delete');
        });

        /* Event */
        Route::group(['prefix' => '/event'], function () {
            Route::get('/', 'EventController@index')->name('event');
            Route::get('/create', 'EventController@create')->name('event_create');
            Route::post('/store', 'EventController@store')->name('event_store');
            Route::get('/edit/{id?}', 'EventController@edit')->name('event_edit');
            Route::put('/update/{id?}', 'EventController@update')->name('event_update');
            Route::post('/delete', 'EventController@delete')->name('event_delete');
        });

        /* Career */
        Route::group(['prefix' => '/career'], function () {
            Route::get('/', 'CareerController@index')->name('career');
            Route::get('/create', 'CareerController@create')->name('career_create');
            Route::post('/store', 'CareerController@store')->name('career_store');
            Route::get('/edit/{id?}', 'CareerController@edit')->name('career_edit');
            Route::put('/update/{id?}', 'CareerController@update')->name('career_update');
            Route::post('/delete', 'CareerController@delete')->name('career_delete');
        });

        /* Archive */
        Route::group(['prefix' => '/archive'], function () {

            /* Route archive group */
            Route::get('/', 'ArchiveController@index')->name('archive');
            Route::get('/create', 'ArchiveController@create')->name('archive_group_create');
            Route::post('/store', 'ArchiveController@store')->name('archive_group_store');
            Route::get('/edit/{id}', 'ArchiveController@edit')->name('archive_group_edit')->where('id', '[0-9]+');
            Route::put('/update/{id}', 'ArchiveController@update')->name('archive_group_update')->where('id', '[0-9]+');
            Route::post('/delete', 'ArchiveController@delete')->name('archive_group_delete');

            /* Route archive items */
            Route::get('/items/{id}', 'ArchiveController@itemArchive')->name('item_archive')->where('id', '[0-9]+');
            Route::get('/items/create/{id}', 'ArchiveController@itemCreate')->name('item_archive_create')->where('id', '[0-9]+');
            Route::post('/items/store', 'ArchiveController@itemStore')->name('item_archive_store');
            Route::get('/items/edit/{id}', 'ArchiveController@itemEdit')->name('item_archive_edit')->where('id', '[0-9]+');
            Route::put('/items/update/{id?}', 'ArchiveController@itemUpdate')->name('item_archive_update')->where('id', '[0-9]+');
            Route::post('/items/delete', 'ArchiveController@itemDelete')->name('item_archive_delete');
        });

        /* Pricing */
        Route::group(['prefix' => '/pricing'], function () {

            /* Route pricing group */
            Route::get('/', 'PriceController@index')->name('pricing');
            Route::get('/create', 'PriceController@create')->name('pricing_group_create');
            Route::post('/store', 'PriceController@store')->name('pricing_group_store');
            Route::get('/edit/{id}', 'PriceController@edit')->name('pricing_group_edit')->where('id', '[0-9]+');
            Route::put('/update/{id}', 'PriceController@update')->name('pricing_group_update')->where('id', '[0-9]+');
            Route::post('/delete', 'PriceController@delete')->name('pricing_group_delete');

            /* Route pricing items */
            Route::get('/items/{id}', 'PriceController@itempricing')->name('item_pricing')->where('id', '[0-9]+');
            Route::get('/items/create/{id}', 'PriceController@itemCreate')->name('item_pricing_create')->where('id', '[0-9]+');
            Route::post('/items/store', 'PriceController@itemStore')->name('item_pricing_store');
            Route::get('/items/edit/{id}', 'PriceController@itemEdit')->name('item_pricing_edit')->where('id', '[0-9]+');
            Route::put('/items/update/{id?}', 'PriceController@itemUpdate')->name('item_pricing_update')->where('id', '[0-9]+');
            Route::post('/items/delete', 'PriceController@itemDelete')->name('item_pricing_delete');
        });


        /* Media */
        Route::group(['prefix' => '/media'], function () {
            Route::get('/', 'MediaController@index')->name('media');
            Route::get('/create', 'MediaController@create')->name('media_create');
            Route::post('/store', 'MediaController@store')->name('media_store');
            Route::get('/edit/{id}', 'MediaController@edit')->name('media_edit');
            Route::put('/update/{id}', 'MediaController@update')->name('media_update');
            Route::post('/delete', 'MediaController@delete')->name('media_delete');
        });

        /* Images */
        Route::group(['prefix' => '/album/list'], function () {
            Route::get('/{id?}', 'ImagesController@index')->name('images');
            Route::post('/data/store', 'ImagesController@store')->name('images_store');
            Route::post('/data/delete', 'ImagesController@delete')->name('images_delete');
            Route::get('/ajax/images', 'ImagesController@list')->name('images_list');
        });

        /* Froala */
        Route::group(['prefix' => 'froala'], function () {
            Route::get('/', 'ImagesController@showImages')->name('list_image');
            Route::post('/upload', 'ImagesController@uploadImages')->name('upload_image');
            Route::get('/list-menus', 'MenusController@listMenu')->name('list_menu');
        });

        /* Posts */
        Route::group(['prefix' => '/posts'], function () {
            Route::get('/', 'PostsController@index')->name('posts');
            Route::get('/create', 'PostsController@create')->name('posts_create');
            Route::post('/store', 'PostsController@store')->name('posts_store');
            Route::get('/{slug?}', 'PostsController@detail')->name('posts_detail');
            Route::post('/comment/store', 'PostsController@comment_store')->name('comment_store');
            Route::get('/category/{category?}', 'PostsController@view_category')->name('posts_view_category');
            Route::get('/edit/{id?}', 'PostsController@edit')->name('posts_edit');
            Route::put('/update/{id?}', 'PostsController@update')->name('posts_update');
            Route::post('/delete', 'PostsController@delete')->name('posts_delete');
        });

        /* Posts Category */
        Route::group(['prefix' => '/category'], function () {
            Route::get('/', 'CategoryController@index')->name('category');
            Route::get('/create', 'CategoryController@create')->name('category_create');
            Route::post('/store', 'CategoryController@store')->name('category_store');
            Route::get('/edit/{id?}', 'CategoryController@edit')->name('category_edit');
            Route::put('/update/{id?}', 'CategoryController@update')->name('category_update');
            Route::post('/delete', 'CategoryController@delete')->name('category_delete');
        });

        /* Pages */
        Route::group(['prefix' => '/pages'], function () {
            Route::get('/', 'PagesController@index')->name('pages');
            Route::get('/create', 'PagesController@create')->name('pages_create');
            Route::post('/store', 'PagesController@store')->name('pages_store');
            Route::get('/{slug?}', 'PagesController@detail')->name('pages_detail');
            Route::get('/edit/{id?}', 'PagesController@edit')->name('pages_edit');
            Route::put('/update/{id?}', 'PagesController@update')->name('pages_update');
            Route::post('/delete', 'PagesController@delete')->name('pages_delete');
        });

        /* Templates */
        Route::group(['prefix' => '/templates'], function () {
            Route::get('/', 'TemplateController@list')->name('templates_list');
            Route::get('/set/{path?}', 'TemplateController@set')->name('templates_set');
            Route::get('/customizer', 'TemplateController@customizer')->name('templates_customizer');
            Route::post('/customizer/setup', 'TemplateController@setup')->name('templates_customizer_setup');
        });

        /* Screenshot */
        Route::group(['prefix'=>''], function () {
            Route::get('/screenshot/templates/{path}/{img}', function ($path, $img) {
                $path = resource_path('/views/front/'.$path.'/'.$img);
                if (!File::exists($path)) {
                    return response()->json(['message' => 'Screenshot not found.'], 404);
                }
                $file = File::get($path);
                $type = File::mimeType($path);
                $response = Response::make($file, 200);
                $response->header("Content-Type", $type);
                return $response;
            })->name('screenshot');
        });

        /* Team */
        Route::group(['prefix' => '/team'], function () {
            Route::get('/', 'TeamController@index')->name('team');
            Route::get('/add', 'TeamController@create')->name('team_add');
            Route::post('/store', 'TeamController@store')->name('team_add_store');
            Route::get('/edit/{id?}', 'TeamController@edit')->name('team_edit');
            Route::put('/update/{id?}', 'TeamController@update')->name('team_edit_update');
            Route::post('/delete', 'TeamController@delete')->name('team_delete');
            Route::get('/profile', 'TeamController@profile')->name('profile');
        });

        /* Setting */
        Route::group(['prefix' => '/setting'], function () {
            Route::get('/', 'SettingController@index')->name('setting');
            Route::post('/generate/keytoken', 'SettingController@keytoken')->name('key_token');
            Route::post('/update', 'SettingController@update')->name('setting_update');
        });

        /* Sharing */
        Route::group(['prefix' => '/sharing'], function () {
            Route::get('/', 'SharingController@index')->name('sharing');
        });

        /* Help */
        Route::get('/help', function () {
            return view('admin.help.index');
        })->name('help');
    });
});

/* Maintenance */
Route::group(['namespace' => 'Front'], function () {
    Route::get('/503', 'MaintenanceController@maintenance')->name('maintenance');
});

/* FrontEnd */
Route::group(['middleware' => ['maintenance'], 'namespace' => 'Front'], function () {

    /* Root */
    // Route::get('/', 'HomeController@index')->name('front_home');

    /* About or Profil */
    // Route::get('/profil', 'AboutController@about')->name('front_about');
    // Route::get('/profil/{id?}/{slug?}', 'AboutController@aboutSub')->name('front_aboutSub');

    /* Portofolio */
    // Route::get('/works', 'PortofolioController@portfolio')->name('front_portfolio');
    // Route::get('/works/{id?}/{slug?}', 'PortofolioController@portfolioDetail')->name('front_portfolio_detail');

    /* Blogs */
    // Route::get('/blog/category/{category?}', 'BlogsController@filterCategory')->name('category_blog');
    // Route::get('/blog/{id}/{slug?}', 'BlogsController@blogDetail')->name('front_blog_detail')->where('id', '[0-9]+');
    // Route::post('/blog/search', 'BlogsController@blogSearch')->name('front_blog_search');

    /* Event */
    // Route::get('/agenda-kegiatan', 'EventController@event')->name('front_event');
    // Route::get('/agenda-kegiatan/{id?}', 'EventController@eventDetail')->name('front_event_detail');

    /* Gallery */
    // Route::get('/galeri', 'GalleryController@gallery')->name('front_gallery');
    // Route::get('/galeri/{id?}', 'GalleryController@galleryDetail')->name('front_gallery_detail');

    /* Pages */
    // Route::get('/page/{id}/{slug?}', 'PagesController@pages')->name('front_pages')->where('id', '[0-9]+');

    /* Contact */
    // Route::get('/contact', 'ContactController@contact')->name('front_contact');
    // Route::post('/contact-submit', 'ContactController@contactSubmit')->name('front_contact_submit');

    /* Download */
    // Route::get('/archive/{id?}', 'ArchiveController@detailArchive')->name('front_details_archive');
    // Route::post('/archive/search/{key?}', 'ArchiveController@searchArchive')->name('front_search_archive');
});
