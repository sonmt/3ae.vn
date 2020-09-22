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

Route::group(['prefix'=>'admin','namespace'=>'Admin', 'middleware' => ['admin']],function(){
    Route::get('home', 'AdminController@home');
    Route::resource('posts', 'PostController');
    Route::get('posts-show', 'PostController@anyDatatables')->name('datatable_post');
    Route::get('posts-visiable', 'PostController@visiable')->name('visable_post');
    Route::get('posts-indexhot', 'PostController@indexHot')->name('index_hot');

    Route::resource('comments', 'CommentController');
    Route::get('comments-show', 'CommentController@anyDatatables')->name('datatable_comment');

    Route::resource('products', 'ProductController');
    Route::get('products-show', 'ProductController@anyDatatables')->name('datatable_product');

    Route::resource('contact', 'ContactController');

    Route::resource('book', 'BookController');
    Route::get('export-books', 'BookController@exportToExcel')->name('exportBooks');

    Route::resource('templates', 'TemplateController');
    Route::resource('type-information', 'TypeInformationController');
    Route::resource('type-input', 'TypeInputController');
    Route::resource('type-sub-post', 'TypeSubPostController');
    Route::resource('categories', 'CategoryController');
    Route::resource('category-products', 'CategoryProductController');
    Route::group(['prefix' => '{typePost}'], function($typePost){
        // Files
        Route::resource('sub-posts', 'SubPostController');
        Route::get('sub-posts-show', 'SubPostController@anyDatatables')->name('datatable_sub_posts');
    });
    Route::resource('information', 'InformationController', ['only' => [
        'index', 'store'
    ]]);
    Route::resource('menus', 'MenuController');
    Route::resource('users', 'UserController');

    Route::resource('subcribe-email', 'SubcribeEmailController');
    Route::get('subcribe-email-anyDatabase', 'SubcribeEmailController@anyDatatables')->name('subcribe-email-data');
    Route::get('export-email', 'SubcribeEmailController@exportToExcel')->name('exportEmail');

    Route::post('group-mail/create', 'GroupMailController@store')->name('group_mail.create');
    Route::delete('group-mail/{groupMail}', 'GroupMailController@destroy')->name('group_mail.destroy');
    Route::post('send-mail', 'SubcribeEmailController@send')->name('subcribe-email_send');

    Route::get('hinh-thuc-thanh-toan', 'OrderController@setting')->name('method_payment');
    Route::post('cap-nhat-ngan-hang', 'OrderController@updateBank')->name('bank');
    Route::post('cap-nhat-ma-giam-gia', 'OrderController@updateCodeSale')->name('code_sale');
    Route::post('cap-nhat-phi-ship', 'OrderController@updateShip')->name('cost_ship');
    Route::post('cap-nhat-tinh-diem', 'OrderController@updateSetting')->name('updateSetting');

    Route::get('don-hang', 'OrderController@listOrder')->name('orderAdmin');
    Route::delete('don-hang/{order}', 'OrderController@deleteOrder')->name('orderAdmin.destroy');

    Route::post('cap-nhat-trang-thai-don-hang', 'OrderController@updateStatusOrder')->name('orderUpdateStatus');

    Route::resource('languages', 'LanguageController');
});
//dang nhap
Route::group(['prefix'=>'admin', 'namespace'=>'Admin' ],function(){
    Route::get('/','LoginController@showLoginForm');
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('login','LoginController@login');
    Route::get('logout','LoginController@logout');
    Route::post('logout','LoginController@logout')->name('logout');
    //reset password
    Route::get('password/reset','LoginController@getReset');
    Route::post('password/reset','LoginController@postReset');
});

Route::get('sitemap.xml', 'Site\SitemapsController@index');

Route::group(['namespace'=>'Site'], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('ngon-ngu', 'LanguageController@index')->name('change_language');
});
Route::group(['prefix'=> '{languageCurrent}', 'namespace'=>'Site'], function( $languageCurrent) {
    Route::get('/', 'HomeController@index')->name('home');
//    Route::get('/cua-hang/{cate_slug}', 'ProductCategoryController@index');
  //  Route::get('/tim-kiem', 'ProductCategoryController@search')->name('search_product');
    //Route::get('/tim-kiem-ajax', 'ProductCategoryController@searchAjax')->name('search_product_ajax');
  //  Route::get('rating', 'ProductController@Rating')->name('rating');
    Route::get('/tim-kiem', 'CategoryController@search')->name('search');

//    Route::get('/dang-ky','RegisterController@showRegistrationForm')->name('register');
//    Route::post('/dang-ky','RegisterController@register');

//    Route::post('/quen-mat-khau','PersonController@forgetPassword')->name('forget_password');
//    Route::post('/dang-nhap','LoginController@login');
//    Route::get('dang-xuat','LoginController@logout');
//    Route::post('dang-xuat','LoginController@logout')->name('logoutHome');
//    Route::get('cblogin','LoginController@callbackLogin');

//    Route::get('login/google', 'LoginController@redirectToProvider')->name('google_login');
////   Route::get('login/google/callback', 'LoginController@handleProviderCallback');

//    Route::get('/thong-tin-ca-nhan','PersonController@index');
//    Route::post('/thong-tin-ca-nhan','PersonController@store');
//    Route::get('/doi-mat-khau','PersonController@resetPassword');
//    Route::post('/doi-mat-khau','PersonController@storeResetPassword');
//    Route::get('/don-hang-ca-nhan','PersonController@orderPerson');

    Route::get('/lien-he','ContactController@index')->name('lien-he');
    Route::get('/contact','ContactController@index')->name('contact');

    Route::post('submit/contact','ContactController@submit')->name('sub_contact');
    Route::post('submit/book','ContactController@submitBook')->name('sub_book');

   // Route::post('/binh-luan', 'CommentController@index')->name('comment');
   /// Route::post('/xoa-binh-luan', 'CommentController@delete');

    //Route::get('loc-san-pham', 'ProductCategoryController@filter');

    /*===== đặt hàng  ===== */
   // Route::post('/dat-hang', 'OrderController@addToCart')->name('addToCart');
    //Route::get('/dat-hang', 'OrderController@order')->name('order');
   // Route::get('/xoa-don-hang', 'OrderController@deleteItemCart')->name('deleteItemCart');

    //Route::post('/gui-don-hang', 'OrderController@send')->name('send');

    /*===== subcribe email   ===== */
    Route::post('subcribe-email', 'SubcribeEmailController@index')->name('subcribe_email');

    
    /*===== Thương hiệu =====*/
    Route::get('/xem-them-image', 'SubPostController@nextImageLibrary')->name('next_image');
    Route::get('/thu-vien-hinh-anh', 'SubPostController@nextVideoLibrary')->name('next_video');
    Route::get('/picture-library', 'SubPostController@nextVideoLibrary')->name('next_video_en');
    Route::group(['prefix' => 'logo'], function(){
        // Files
        Route::get('/{markTrade}', 'SubPostController@logo')->name('logo');
        Route::get('/{markTrade}/thuc-don/{cateLogo}', 'SubPostController@logo')->name('logo-menus');
        Route::get('/{markTrade}/{food}', 'SubPostController@detailMenu')->name('show-detail-food');

    });

    Route::get('{cate_slug}/{post_slug}', 'PostController@index')->name('post');
    Route::get('{cate_slug}', 'CategoryController@index')->name('category');

    Route::get('/{type_sub_post}/{sub_post_slug}', 'SubPostController@index')->name('sub_post_detail');
});
