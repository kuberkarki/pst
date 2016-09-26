<?php
Route::group(['middleware' => 'web'], function () {
    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register all of the routes for an application.
    | It's a breeze. Simply tell Laravel the URIs it should respond to
    | and give it the Closure to execute when that URI is requested.
    |
    */
   
 


   /*Route::get('/', function () {
    return redirect()->route('order');
});*/
     Route::group(array('middleware' => 'SentinelUser'), function () {
        Route::get('order', ['as' => 'order', 'uses' => 'OrderController@getOrder']);
        Route::post('checkout', ['as' => 'checkout', 'uses' => 'OrderController@getOrder']);
        Route::post('order', ['as' => 'order-post', 'uses' => 'OrderController@postOrder']);
        Route::post('apply_coupon', ['as' => 'applycoupon', 'uses' => 'FrontEndController@applycoupon']);
        Route::post('remove_coupon', ['as' => 'removecoupon', 'uses' => 'FrontEndController@removecoupon']);
        Route::get('clear-cart', ['as' => 'clear-cart', 'uses' => 'FrontEndController@clearcart']);
        Route::post('cart', 'OrderController@cart');
        Route::get('cart', ['as' => 'cart', 'uses' => 'OrderController@cart']);
        Route::get('confirmation', array('as' => 'confirmation', 'uses' => 'OrderController@confirmation'));
        Route::get('order-detail/{id}', array('as' => 'order-detail', 'uses' => 'OrderController@detail'));
        Route::get('search/{q}/{ajax}', array('as' => 'search', 'uses' => 'FrontEndController@search'));
    }); 

     


   /*Route::post('cart',function(){
        return "here";
   });*/

    /**
     * Model binding into route
     */
   /* Route::model('blogcategory', 'App\BlogCategory'); 
    Route::model('blog', 'App\Blog');
    Route::model('file', 'App\File');
    Route::model('task', 'App\Task');*/
    Route::model('users', 'App\User');

    Route::pattern('slug', '[a-z0-9- _]+');

    Route::group(array('prefix' => 'admin'), function () {

        # Error pages should be shown without requiring login
        Route::get('404', function () {
            return View('admin/404');
        });
        Route::get('500', function () {
            return View::make('admin/500');
        });

        # Lock screen
        Route::get('lockscreen', function () {
            return View::make('admin/lockscreen');
        });

        # All basic routes defined here
        Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
        Route::post('signin', 'AuthController@postSignin');
        Route::post('signup', array('as' => 'signup', 'uses' => 'AuthController@postSignup'));
        Route::post('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@postForgotPassword'));
        Route::get('login2', function () {
            return View::make('admin/login2');
        });

        # Register2
        Route::get('register2', function () {
            return View::make('admin/register2');
        });
        Route::post('register2', array('as' => 'register2', 'uses' => 'AuthController@postRegister2'));

        # Forgot Password Confirmation
        Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
        Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

        # Logout
        Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

        # Account Activation
        Route::get('activate/{userId}/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));
    });

    Route::group(array('prefix' => 'admin', 'middleware' => 'SentinelAdmin'), function () {
        # Dashboard / Index
        Route::get('/', array('as' => 'dashboard', 'uses' => 'JoshController@showHome'));


        # User Management
        Route::group(array('prefix' => 'users'), function () {
            Route::get('/', array('as' => 'users', 'uses' => 'UsersController@index'));
            Route::get('create', 'UsersController@create');
            Route::post('create', 'UsersController@store');
            Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@destroy'));
            Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
            Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
            Route::get('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
            Route::post('{userId}/passwordreset', array('as' => 'passwordreset', 'uses' => 'UsersController@passwordreset'));
        });
        Route::resource('users', 'UsersController');
        //åRoute::resource('products', 'ProductController');

        Route::get('deleted_users', array('as' => 'deleted_users', 'before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'));

        # Group Management
        Route::group(array('prefix' => 'groups'), function () {
            Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@index'));
            Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@create'));
            Route::post('create', 'GroupsController@store');
            Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@edit'));
            Route::post('{groupId}/edit', 'GroupsController@update');
            Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@destroy'));
            Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
            Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
        });
        /*Route::group(array('prefix' => 'category'), function () {
            Route::get('/', array('as' => 'categories', 'uses' => 'CategoryController@index'));
            Route::get('create', array('as' => 'create/category', 'uses' => 'CategoryController@create'));
            Route::post('create', 'CategoryController@store');
            Route::get('{category}/edit', array('as' => 'update/category', 'uses' => 'CategoryController@edit'));
            Route::post('{category}/edit', 'categoryController@update');
            Route::get('{category}/delete', array('as' => 'delete/category', 'uses' => 'CategoryController@destroy'));
            Route::get('{category}/confirm-delete', array('as' => 'confirm-delete/category', 'uses' => 'CategoryController@getModalDelete'));
            Route::get('{category}/restore', array('as' => 'restore/category', 'uses' => 'ategoryController@getRestore'));
        });*/
        /*routes for blog*/
        /*Route::group(array('prefix' => 'blog'), function () {
            Route::get('/', array('as' => 'blogs', 'uses' => 'BlogController@index'));
            Route::get('create', array('as' => 'create/blog', 'uses' => 'BlogController@create'));
            Route::post('create', 'BlogController@store');
            Route::get('{blog}/edit', array('as' => 'update/blog', 'uses' => 'BlogController@edit'));
            Route::post('{blog}/edit', 'BlogController@update');
            Route::get('{blog}/delete', array('as' => 'delete/blog', 'uses' => 'BlogController@destroy'));
            Route::get('{blog}/confirm-delete', array('as' => 'confirm-delete/blog', 'uses' => 'BlogController@getModalDelete'));
            Route::get('{blog}/restore', array('as' => 'restore/blog', 'uses' => 'BlogController@getRestore'));
            Route::get('{blog}/show', array('as' => 'blog/show', 'uses' => 'BlogController@show'));
            Route::post('{blog}/storecomment', array('as' => 'restore/blog', 'uses' => 'BlogController@storecomment'));
        });*/

        /*routes for blog category*/
        /*Route::group(array('prefix' => 'blogcategory'), function () {
            Route::get('/', array('as' => 'blogcategories', 'uses' => 'BlogCategoryController@index'));
            Route::get('create', array('as' => 'create/blogcategory', 'uses' => 'BlogCategoryController@create'));
            Route::post('create', 'BlogCategoryController@store');
            Route::get('{blogcategory}/edit', array('as' => 'update/blogcategory', 'uses' => 'BlogCategoryController@edit'));
            Route::post('{blogcategory}/edit', 'BlogCategoryController@update');
            Route::get('{blogcategory}/delete', array('as' => 'delete/blogcategory', 'uses' => 'BlogCategoryController@destroy'));
            Route::get('{blogcategory}/confirm-delete', array('as' => 'confirm-delete/blogcategory', 'uses' => 'BlogCategoryController@getModalDelete'));
            Route::get('{blogcategory}/restore', array('as' => 'restore/blogcategory', 'uses' => 'BlogCategoryController@getRestore'));
        });*/

        /*routes for file*/
        /*Route::group(array('prefix' => 'file'), function () {
            Route::post('create', 'FileController@store');
            Route::post('createmulti', 'FileController@postFilesCreate');
            Route::delete('delete', 'FileController@delete');
        });*/

        /*routes for product*/
        Route::group(array('prefix' => 'product'), function () {
            Route::get('/', array('as'=>'admin.product','uses'=>'ProductController@index'));
            Route::get('{ProductId}/edit', array('as'=>'admin.product.edit','uses'=>'ProductController@edit'));
            Route::post('{ProductId}/edit',array('as'=>'admin.product.update','uses'=>'ProductController@update'));
            Route::get('{ProductId}/generate', array('as'=>'admin.product.generate','uses'=>'ProductController@generatethumb'));
            Route::get('{ProductId}/regenerate', array('as'=>'admin.product.regenerate','uses'=>'ProductController@regeneratethumb'));
           
        });

        /*routes for product*/
        Route::group(array('prefix' => 'order'), function () {
            Route::get('/', array('as'=>'admin.order','uses'=>'OrderController@index'));
            Route::get('{OrderId}/edit', array('as'=>'admin.order.open','uses'=>'OrderController@open'));
            Route::get('{OrderId}/deliver',array('as'=>'admin.order.deliver','uses'=>'OrderController@deliver'));
           
            Route::get('/quickinvoice', array('as'=>'admin.order.quickinvoice','uses'=>'OrderController@invoiceindex'));
            
            Route::get('{OrderId}/invoice',array('as'=>'admin.order.invoice','uses'=>'OrderController@invoice'));
           
        });

        //Route::resource('photo', 'PhotoController');
        // Page
        Route::get('pages', 'PageController@index');
        Route::get('page/create', 'PageController@create');
        Route::post('page', 'PageController@store');
        Route::get('page/{pageId}/edit', 'PageController@edit');
        Route::put('page/{pageId}', 'PageController@update');
        Route::post('page/do', 'PageController@postDo');
        Route::post('page/save-order', 'PageController@saveOrder');

        /*Route::get('crop_demo', function () {
            return redirect('admin/imagecropping');
        });
        Route::post('crop_demo', 'JoshController@crop_demo');*/

        /* laravel example routes */
        # datatables
       /* Route::get('datatables', 'DataTablesController@index');
        Route::get('datatables/data', array('as' => 'admin.datatables.data', 'uses' => 'DataTablesController@data'));
*/
        //tasks section
       /* Route::post('task/create', 'TaskController@store');
        Route::get('task/data', 'TaskController@data');
        Route::post('task/{task}/edit', 'TaskController@update');
        Route::post('task/{task}/delete', 'TaskController@delete');*/


        # Remaining pages will be called from below controller method
        # in real world scenario, you may be required to define all routes manually

        Route::get('{name?}', 'JoshController@showView');

    });

    Route::get('main-page/{slug?}',array('as'=>'main-page','uses'=>'FrontEndController@mainpage'));

#FrontEndController
    Route::get('saveapi', 'SF_OutboundMessageController@saveApiData');
    Route::post('outboundmsg_ordernumber', 'SF_OutboundMessageController@postOutboundMsgOrdernumber');
    Route::post('outboundmsg_saveImage', 'SF_OutboundMessageController@saveImageToCloudinary');
    
    Route::get('login', array('as' => 'login', 'uses' => 'FrontEndController@getLogin'));
    Route::post('login', 'FrontEndController@postLogin');
    //Route::get('register', array('as' => 'register', 'uses' => 'FrontEndController@getRegister'));
    //Route::post('register', 'FrontEndController@postRegister');
    Route::get('activate/{userId}/{activationCode}', array('as' => 'activate', 'uses' => 'FrontEndController@getActivate'));
    Route::get('forgot-password', array('as' => 'forgot-password', 'uses' => 'FrontEndController@getForgotPassword'));
    Route::post('forgot-password', 'FrontEndController@postForgotPassword');
# Forgot Password Confirmation
    Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'FrontEndController@getForgotPasswordConfirm'));
    Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
# My account display and update details
    Route::group(array('middleware' => 'SentinelUser'), function () {
        Route::get('my-account', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
        Route::put('my-account', 'FrontEndController@update');
        Route::get('products/{current_category?}',array('as'=>'products','uses'=>'ProductController@products'));
        Route::get('products/details/{ProductId}',array('as'=>'product','uses'=>'ProductController@detail'));

        Route::get('/', array('as' => 'home', 'uses' => 'FrontEndController@index'));
    });
    Route::get('logout', array('as' => 'logout', 'uses' => 'FrontEndController@getLogout'));
# contact form
    Route::post('contact', array('as' => 'contact', 'uses' => 'FrontEndController@postContact'));

#frontend views
    

    /*Route::get('blog', array('as' => 'blog', 'uses' => 'BlogController@getIndexFrontend'));
    Route::get('blog/{slug}/tag', 'BlogController@getBlogTagFrontend');
    Route::get('blogitem/{slug?}', 'BlogController@getBlogFrontend');
    Route::post('blogitem/{blog}/comment', 'BlogController@storeCommentFrontend');*/

     
    Route::get('syncContactFromSF', array('as' => 'syncContactFromSF', 'uses' => 'FrontEndController@synccontact'));

    Route::get('{name?}', 'JoshController@showFrontEndView');


# End of frontend views

});
