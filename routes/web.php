<?php

use Illuminate\Support\Facades\Config;
use App\Mail\SubscriptionMail;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DefaultUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OccasionController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SkuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ArtizController;
use App\Http\Controllers\NewsController;


$prefixAdmin    = config('artiz.url.prefix_admin');
$prefixDefault  = config('artiz.url.prefix_default');

Route::get('/', [HomeController::class, 'index']);

// admin
Route::group(['prefix' => $prefixAdmin, 'middleware' => ['permission.admin', 'check.online']], function (){
    //===================================== Dashboard =======================================
    $prefix = 'dashboard';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = DashboardController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::match(array('GET', 'POST'), 'order', [$controller, 'order'])->name($prefix . '/order');
        Route::match(array('GET', 'POST'), 'user', [$controller, 'user'])->name($prefix . '/user');
        Route::match(array('GET', 'POST'), 'product', [$controller, 'product'])->name($prefix . '/product');
        Route::match(array('GET', 'POST'), 'search', [$controller, 'search'])->name($prefix . '/search');
    });

    //===================================== Product =======================================
    $prefix = 'product';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = ProductController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('ajax/', [$controller, 'ajax'])->name($prefix . '/ajax');
        Route::get('ajax-form/', [$controller, 'ajaxForm'])->name($prefix . '/ajax-form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::get('change-type-{type}/{id}', [$controller, 'type'])->where('id', '[0-9]+')->name($prefix . '/type');
        Route::get('change-category-{category}/{id}', [$controller, 'category'])->where('id', '[0-9]+')->name($prefix . '/category');
        Route::get('change-occasion-{occasion}/{id}', [$controller, 'occasion'])->where('id', '[0-9]+')->name($prefix . '/occasion');
        Route::get('change-collection-{collection}/{id}', [$controller, 'collection'])->where('id', '[0-9]+')->name($prefix . '/collection');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Detail =======================================
    $prefix = 'detail';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = DetailController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('ajax/', [$controller, 'ajax'])->name($prefix . '/ajax');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Outfit =======================================
    $prefix = 'outfit';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = OutfitController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('ajax/', [$controller, 'ajax'])->name($prefix . '/ajax');
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Category =======================================
    $prefix = 'category';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = CategoryController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== News =======================================
    $prefix = 'news';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = NewsController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Collection =======================================
    $prefix = 'collection';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = CollectionController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Occasion =======================================
    $prefix = 'occasion';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = OccasionController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Color =======================================
    $prefix = 'color';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = ColorController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Size =======================================
    $prefix = 'size';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = SizeController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== SKU =======================================
    $prefix = 'sku';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = SkuController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
        Route::get('check', [$controller, 'check'])->name($prefix . '/check');
    });

    //===================================== User =======================================
    $prefix = 'user';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = UserController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9]+')->name($prefix . '/delete');
        Route::get('change-level-{level}/{id}', [$controller, 'level'])->where('id', '[0-9]+')->name($prefix . '/level');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9]+')->name($prefix . '/status');
        Route::post('change-password', [$controller, 'changePassword'])->name($prefix . '/change-password');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Coupon =======================================
    $prefix = 'coupon';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = CouponController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/delete');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/status');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
        Route::post('generate', [$controller, 'generate'])->name($prefix . '/generate');
    });

    //===================================== Member =======================================
    $prefix = 'member';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = MemberController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('form/{id?}', [$controller, 'form'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/delete');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
    });

    //===================================== Favorite =======================================
    $prefix = 'favorite';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = FavoriteController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
    });

    //===================================== Rating & Review =======================================
    $prefix = 'rating';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = RatingController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('/filter', [$controller, 'filter'])->name($prefix . '/filter');
        Route::get('form/{id}', [$controller, 'form'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/form');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->name($prefix . '/status');
    });

    //===================================== Cart =======================================
    $prefix = 'cart';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = CartController::class;
        Route::get('/', [$controller, 'show'])->name($prefix);
        Route::get('/filter', [$controller, 'filter'])->name($prefix . '/filter');
        Route::get('form/{id}', [$controller, 'form'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/form');
        Route::get('delete/{id}', [$controller, 'delete'])->where('id', '[0-9a-zA-Z_-]+')->name($prefix . '/delete');
        Route::post('save', [$controller, 'save'])->name($prefix . '/save');
        Route::get('change-status-{status}/{id}', [$controller, 'status'])->name($prefix . '/status');
        Route::get('change-cancel-{cancel}/{id}', [$controller, 'cancel'])->name($prefix . '/cancel');
        Route::get('change-refund-{refund}/{id}', [$controller, 'refund'])->name($prefix . '/refund');
    });
});

// Default
Route::group(['prefix' => $prefixDefault, 'middleware' => ['check.online']], function (){
    //===================================== HOME =======================================
    $prefix = '';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = HomeController::class;
        Route::get('/', [$controller, 'index'])->name('home');
        Route::get('/shop-by', [$controller, 'shopBy'])->name('shop-by');
        Route::get('/sales', [$controller, 'sales'])->name('sales');
        Route::get('/collection', [$controller, 'collection'])->name('collections');
        Route::get('/about', [$controller, 'about'])->name('about');
        Route::get('/news', [$controller, 'news'])->name('home/news');
        Route::get('/contact', [$controller, 'contact'])->name('contact');
        Route::get('/admin', [DashboardController::class, 'show'])->name('admin');
    });

    //===================================== SHOP =======================================
    $prefix = 'shop';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = HomeController::class;
        Route::get('/', [$controller, 'shop'])->where('id', '[0-9]+')->name($prefix);
        Route::get('/search-ajax', [$controller, 'ajax'])->name($prefix . '/search-ajax');
        Route::get('/category/{category_id}', [$controller, 'shop'])->where('category_id', '[0-9]+')->name($prefix . '/category');
        Route::get('/collection/{collection_id}', [$controller, 'shop'])->where('collection_id', '[0-9]+')->name($prefix . '/collection');
        Route::get('/occasion/{occasion_id}', [$controller, 'shop'])->where('occasion_id', '[0-9]+')->name($prefix . '/occasion');
        Route::get('/load-more', [$controller, 'loadMore'])->name($prefix. '/load-more');
        Route::get('/filter', [$controller, 'shopFilter'])->name($prefix . '/filter');
        Route::get('detail-ajax', [$controller, 'detailAjax'])->name($prefix . '/detail-ajax');
        Route::get('detail-quick-view', [$controller, 'detailQuickView'])->name($prefix . '/detail-quick-view');
        Route::get('detail/{name}-{id}', [$controller, 'detail'])
            ->where('name', '[0-9a-zA-Z_-]+')
            ->where('id', '[0-9]+')
            ->name($prefix . '/detail');
        Route::get('/update-view', [$controller, 'updateView'])->name($prefix . '/update-view');
        Route::get('/check-wishlist', [$controller, 'checkWishlist'])->name($prefix . '/check-wishlist');
    });

    //===================================== NEW IN =======================================
    $prefix = 'new-in';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = HomeController::class;
        Route::get('/', [$controller, 'newin'])->name($prefix);
    });

    //===================================== CART =======================================
    $prefix = 'cart';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = CartController::class;
        Route::get('/checkout', [$controller, 'checkout'])->name($prefix . '/checkout')->middleware('auth.login');
        Route::post('/submit', [$controller, 'submit'])->name($prefix . '/submit')->middleware('auth.login');
        Route::get('/success', [$controller, 'success'])->name($prefix . '/success');
        Route::get('/check-coupon', [$controller, 'checkCoupon'])->name($prefix . '/check-coupon');
    });

    //===================================== LOGIN =======================================
    $prefix = 'auth';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = AuthController::class;
        Route::get('/login', [$controller, 'login'])->name($prefix . '/login')->middleware('check.login');
        Route::post('/postLogin', [$controller, 'postLogin'])->name($prefix . '/postLogin');
        Route::get('/register', [$controller, 'register'])->name($prefix . '/register');
        Route::post('/postRegister', [$controller, 'postRegister'])->name($prefix . '/postRegister');
        Route::get('/logout', [$controller, 'logout'])->name($prefix . '/logout');

        //===================================== FORGET PASSWORD =======================================
        Route::get('/forget-password', [$controller, 'forgetPassword'])->name($prefix . '/forget-password');
        Route::post('/post-forget-password', [$controller, 'postForgetPassword'])->name($prefix . '/post-forget-password');
        Route::get('/recovery/{user}/{token}', [$controller, 'recovery'])->name($prefix . '/recovery');
        Route::post('/recovery/{user}/{token}', [$controller, 'postRecovery']);
        
        Route::get('/mail', [$controller, 'mail'])->name($prefix . '/mail');
        
    });

    //===================================== NOTIFY =======================================
    $prefix = 'notify';
    Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = NotifyController::class;
        Route::get('/no-permission', [$controller, 'noPermission'])->name($prefix . '/no-permission');
        
    });

     //===================================== USER =======================================
     $prefix = 'user';
     Route::group(['prefix' => $prefix, 'middleware' => ['auth.login']], function () use($prefix){
         $controller = DefaultUserController::class;

         //===================================== INFORMATION =======================================
         Route::get('/', [$controller, 'index'])->name($prefix . '/profile');
         Route::get('/password', [$controller, 'password'])->name($prefix . '/password');
         Route::get('/check-password', [$controller, 'check'])->name($prefix . '/check-password');
         Route::post('/postUpdate', [$controller, 'postUpdate'])->name($prefix . '/postUpdate');
         Route::get('/favorite/{product_id?}', [$controller, 'favorite'])->where('product_id', '[0-9]+')->name($prefix . '/favorite');
         Route::get('/wishlist', [$controller, 'wishlist'])->name($prefix . '/wishlist');

         //===================================== HISTORY & TRACKING & CANCEL & REFUND =======================================
         Route::get('/history', [$controller, 'history'])->name($prefix . '/history');
         Route::get('/tracking', [$controller, 'tracking'])->name($prefix . '/tracking');
         Route::get('/search-history', [$controller, 'searchHistory'])->name($prefix . '/search-history');
         Route::get('/history-detail/{id}', [$controller, 'historyDetail'])->name($prefix . '/history-detail');
         Route::get('/cancel', [$controller, 'cancel'])->name($prefix . '/cancel');
         Route::get('/exchange/{id}', [$controller, 'exchange'])->name($prefix . '/exchange');
         Route::get('/exchange-detail/{id}', [$controller, 'exchangeDetail'])->name($prefix . '/exchange-detail');
         Route::get('/exchange-to-product', [$controller, 'exchangeProduct'])->name($prefix . '/exchange-to-product');
         Route::get('/exchange-to-color', [$controller, 'exchangeColor'])->name($prefix . '/exchange-to-color');
         Route::post('/refund', [$controller, 'refund'])->name($prefix . '/refund');
         Route::get('/history-refund', [$controller, 'historyRefund'])->name($prefix . '/history-refund');
         Route::get('/history-sku', [$controller, 'historyCheckSKU'])->name($prefix . '/history-sku');

         //===================================== CART =======================================
         Route::get('/cart', [$controller, 'cart'])->name($prefix . '/cart');
         Route::get('/cart/add/{id}', [$controller, 'addToCart'])->name($prefix . '/cart/add');
         Route::get('/cart/remove/{id}', [$controller, 'removeFromCart'])->name($prefix . '/cart/remove');
         Route::get('/cart/destroy', [$controller, 'destroyCart'])->name($prefix . '/cart/destroy');
         Route::post('/cart/update/{id?}', [$controller, 'updateCart'])->name($prefix . '/cart/update');
         Route::post('/add-rating', [$controller, 'addRating'])->name($prefix . '/add-rating');
         Route::get('/check-sku', [$controller, 'checkSku'])->name($prefix . '/check-sku');
         
     });

     //===================================== CUSTOMER SERVICE =======================================
     $prefix = 'customer-service';
     Route::group(['prefix' => $prefix], function () use($prefix){
        $controller = ArtizController::class;
        Route::get('/', [$controller, 'index'])->name($prefix);
        Route::get('exchanges', [$controller, 'exchanges'])->name($prefix . '/exchanges');
        Route::get('information-collection', [$controller, 'information'])->name($prefix . '/information-collection');
        Route::get('shipping', [$controller, 'shipping'])->name($prefix . '/shipping');
        Route::get('payments', [$controller, 'payments'])->name($prefix . '/payments');
        Route::get('term-of-use', [$controller, 'termOfUse'])->name($prefix . '/term-of-use');

        // FAQS
        Route::get('frequently-asked-questions', [$controller, 'faqs'])->name($prefix . '/frequently-asked-questions');
        Route::get('frequently-asked-questions/shipping', [$controller, 'faqsShipping'])->name($prefix . '/frequently-asked-questions/shipping');
        Route::get('frequently-asked-questions/exchange', [$controller, 'faqsExchange'])->name($prefix . '/frequently-asked-questions/exchange');
        Route::get('frequently-asked-questions/payments', [$controller, 'faqsPayments'])->name($prefix . '/frequently-asked-questions/payments');
        Route::get('frequently-asked-questions/information', [$controller, 'faqsInformation'])->name($prefix . '/frequently-asked-questions/information');
    });
});

