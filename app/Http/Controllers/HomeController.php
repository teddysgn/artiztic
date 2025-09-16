<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as Auth;

use App\Models\ProductModel as ProductModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\OccasionModel as OccasionModel;
use App\Models\CollectionModel as CollectionModel;
use App\Models\OutfitModel as OutfitModel;
use App\Models\SizeModel as SizeModel;
use App\Models\ColorModel as ColorModel;
use App\Models\DetailModel as DetailModel;
use App\Models\FavoriteModel as FavoriteModel;
use App\Models\RatingModel as RatingModel;
use App\Models\NewsModel as NewsModel;
use App\Models\SkuModel as SkuModel;

 
class HomeController extends Controller
{
    private $pathViewController = 'default.pages.home.';
    private $controllerName     = 'home';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 12;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {   
        $productModel = new ProductModel();
        $items = $productModel->listItems(null, ['task' => 'default-list-products-6']);
        return view($this->pathViewController.'index', [
            'items'        => $items,
            'active'       => 'home',
            'header'       => 'Home',
        ]);
    }

    public function shop(Request $request)
    {
        $this->params = $request->all();
      
        $this->params['pagination']['totalItemsPerPage'] = 12;

        $this->params['category_id']    = $request->category_id ?? 'all';
        $this->params['occasion_id']    = $request->occasion_id ?? 'all';
        $this->params['collection_id']  = $request->collection_id ?? 'all';
        $this->params['color_id']       = $request->input('color_id', 'all');
        $this->params['size_id']        = $request->input('size_id', 'all');
        $this->params['price_id']       = $request->input('price_id', 'all');
        $this->params['key']            = $request->input('key', '');

        $productModel = new ProductModel();
        $items              = $productModel->listItems($this->params, ['task' => 'default-list-products']);
        if(empty($items)) return redirect()->route('shop');

        $categoryModel      = new CategoryModel();
        $categories         = $categoryModel->listItems(null, ['task' => 'list-items-in-selectbox']);
        $category           = $categoryModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameCategory       = $category['name'] ?? '';

        $occasionModel      = new OccasionModel();
        $occasions          = $occasionModel->listItems(null, ['task' => 'list-items-in-selectbox']);
        $occasion           = $occasionModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameOccasion       = $occasion['name'] ?? '';

        $collectionModel    = new CollectionModel();
        $collections        = $collectionModel->listItems(null, ['task' => 'default-list-items-in-selectbox']);
        $collection         = $collectionModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameCollection     = $collection['name'] ?? '';

        $colorModel         = new ColorModel();
        $colors             = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);
        $color              = $colorModel->getItem($this->params, ['task' => 'default-get-item']);
        $colorHex              = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);
        $nameColor          = $color['name'] ?? '';

        $sizeModel          = new SizeModel();
        $sizes              = $sizeModel->listItems(null, ['task' => 'list-items-in-selectbox']);
        $size               = $sizeModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameSize           = $size['name'] ?? '';

        $namePrice = 'all';
        switch($this->params['price_id']){
            case 1: 
                $namePrice = 'Under 1M';
                break;
            case 2: 
                $namePrice = '1M - 3M';
                break;
            case 3: 
                $namePrice = '3M - 6M';
                break;
            case 4: 
                $namePrice = '6M - 10M';
                break;
        }

        $params['user_id'] = 0;
        if(Auth::check())
            $params['user_id'] = Auth::user()->id;

        $favoriteModel      = new FavoriteModel();
        $favorites          = $favoriteModel->listItems($params, ['task' => 'default-list-items']);

        $button = true;

        if(count($items) < $this->params['pagination']['totalItemsPerPage']){
            $button = false;
        }

        return view($this->pathViewController.'shop', [
            'items'             => $items,
            'params'            => $this->params,
            'categories'        => $categories,
            'occasions'         => $occasions,
            'collections'       => $collections,
            'sizeSlb'           => $sizes,
            'colorSlb'          => $colors,
            'nameCategory'      => $nameCategory,
            'nameOccasion'      => $nameOccasion,
            'nameCollection'    => $nameCollection,
            'nameColor'         => $nameColor,
            'nameSize'          => $nameSize,
            'namePrice'         => $namePrice,
            'colorHex'          => $colorHex,
            'button'            => $button,
            'favorites'         => $favorites,
            'active'            => 'shop',
            'header'            => 'Sản phẩm',
        ]);
    }

    public function checkWishlist(Request $request){
        $params['product_id'] = $request->id;
        $params['user_id'] = Auth::user()->id;
        
        $favoriteModel = new FavoriteModel();
        $item = $favoriteModel->getItem($params, ['task' => 'default-get-item']);

        return response()->json([
            'item'             => $item,
        ]);
    }

    public function detail(Request $request)
    {
        $this->params = $request->all();
        $params['product_id']   = $request->id;
        $userInfo = Auth::user();
        
        $productModel = new ProductModel();
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $productModel->getItem($this->params, ['task' => 'get-item']);
            $request->session()->forget('recent.'.$request->id);
            $item['recent'] = time();
            $request->session()->put('recent.'.$request->id, $item);
            $recent = $request->session()->get('recent');

            $outfitModel = new OutfitModel();
            $outfit      = $outfitModel->listItems($this->params, ['task' => 'default-list-items']);
            $data = [];
            foreach($outfit as $key => $value){
                    array_shift($value);
                foreach($value as $keyA => $valueA){
                    array_push($data, $valueA);
                }
            }

            $this->params['picture'] = array_flip(array_unique(array_filter($data)));
            $picture      = $productModel->listItems($this->params, ['task' => 'default-list-pictures']);
        }
        
        $this->params['category_id'] = $item['category_id'];
        $itemsRelated       = $productModel->listItems($this->params, ['task' => 'default-list-related-products']);

        $itemsFeatured      = $productModel->listItems($this->params, ['task' => 'default-list-featured-products']);

        $colorModel         = new ColorModel();
        $color              = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

        $sizeModel          = new SizeModel();
        $size               = $sizeModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $skuModel           = new SkuModel();
        $sku                = $skuModel->listItems($item, ['task' => 'default-list-items']);

        $ratingModel        = new RatingModel();
        $rating             = $ratingModel->listItems($params, ['task' => 'default-list-items']);
        $sumRating          = $ratingModel->sumItems($params, ['task' => 'sum-rating']);
        $countRating        = $ratingModel->countItems($params, ['task' => 'count-rating']);


        if($countRating['count'] > 0){
            $avgRating          = round($sumRating['sum'] / $countRating['count'], 2);
            $avgStarRating      = round($sumRating['sum'] / $countRating['count']);
        } else {
            $avgRating          = 0;
            $avgStarRating      = 0;
        }

        $favorite = null;
        if($userInfo != null){
            $params['user_id']      = $userInfo['id'];
            $favoriteModel          = new FavoriteModel();
            $favorite               = $favoriteModel->getItem($params, ['task' => 'default-get-item']);
        }    

        return view($this->pathViewController.'detail', [
            'item'          => $item,
            'itemsRelated'  => $itemsRelated,
            'itemsFeatured' => $itemsFeatured,
            'picture'       => $picture,
            'sizeSlb'       => $size,
            'colorSlb'      => $color,
            'favorite'      => $favorite,
            'rating'        => $rating,
            'countRating'   => $countRating,
            'avgStarRating' => $avgStarRating,
            'avgRating'     => $avgRating,
            'recent'        => $recent,
            'active'        => 'detail',
            'header'        => $item['name'],
        ]);
    }

    public function updateView(Request $request)
    {
        $params             = $request->all();
        
        $productModel       = new ProductModel();
        $item               = $productModel->saveItem($params, ['task' => 'update-view']);

        return response()->json([
            'item'             => $item,
        ]);
    }

    public function detailQuickView(Request $request)
    {
        $params['product_id'] = $request->id;
        
        $productModel       = new ProductModel();
        $item               = $productModel->getItem($params['product_id'], ['task' => 'quick-view-get-item']);

        $colorModel         = new ColorModel();
        $color              = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

        $sizeModel          = new SizeModel();
        $size               = $sizeModel->listItems(null, ['task' => 'quick-view-list-items']);

        return response()->json([
            'item'             => $item,
            'colorSlb'         => $color,
            'sizeSlb'          => $size,
        ]);
    }

    public function detailAjax(Request $request)
    {
        $this->params['color_id']   = $request->color;
        $this->params['style']      = $request->style;
        
        $detailModel        = new DetailModel();
        $items              = $detailModel->getItem($this->params, ['task' => 'default-get-item-by-color']);

        $colorModel         = new ColorModel();
        $color              = $colorModel->getItem($this->params, ['task' => 'default-get-item']);
        
        $skuModel           = new SkuModel();
        $sizes              = $skuModel->listItems($this->params, ['task' => 'default-list-items-by-size']);

        $sizeModel          = new SizeModel();
        $sizeSlb            = $sizeModel->listItems(null, ['task' => 'quick-view-list-items']);

        $items['color']     = $color['name'];

        return response()->json([
            'items'             => $items,
            'sizes'             => $sizes,
            'sizeSlb'           => $sizeSlb,
        ]);
    }

    public function newin(Request $request)
    {
        $this->params['user_id'] = 0;
        if(Auth::check())
            $this->params['user_id'] = Auth::user()->id;

        $productModel = new ProductModel();
        $items = $productModel->listItems($this->params, ['task' => 'default-list-items-new']);

        $favoriteModel      = new FavoriteModel();
        $favorites          = $favoriteModel->listItems($this->params, ['task' => 'default-list-items']);


        return view($this->pathViewController.'new-in', [
            'items'         => $items,
            'favorites'     => $favorites,
            'params'        => $this->params,
            'active'        => 'new-in',
            'header'        => 'Sản phẩm mới',
        ]);
    }

    public function shopBy(Request $request)
    {
        $categoryModel      = new CategoryModel();
        $categories         = $categoryModel->listItems(null, ['task' => 'default-list-items']);

        $collectionModel    = new CollectionModel();
        $collections        = $collectionModel->listItems(null, ['task' => 'default-list-items']);

        $occasionModel      = new OccasionModel();
        $occasions          = $occasionModel->listItems(null, ['task' => 'default-list-items']);
       
        return view($this->pathViewController.'shop-by', [
            'categories'    => $categories,
            'collections'   => $collections,
            'occasions'     => $occasions,
            'active'        => 'shop-by',
            'header'        => 'Shop By',
        ]);
    }
    
    public function sales(Request $request)
    {
        $this->params['user_id'] = 0;
        if(Auth::check())
            $this->params['user_id'] = Auth::user()->id;

        $productModel       = new ProductModel();
        $sales              = $productModel->listItems($this->params, ['task' => 'default-list-items-sales']);

        $favoriteModel      = new FavoriteModel();
        $favorites          = $favoriteModel->listItems($this->params, ['task' => 'default-list-items']);
       
        return view($this->pathViewController.'sales', [
            'sales'         => $sales,
            'favorites'     => $favorites,
            'params'        => $this->params,
            'active'        => 'sales',
            'header'        => 'Sales',
        ]);
    }

    public function collection(Request $request)
    {
        $collectionModel    = new CollectionModel();
        $collections        = $collectionModel->listItems($this->params, ['task' => 'default-list-items']);
        
        return view($this->pathViewController.'collection', [
            'collections'   => $collections,
            'active'        => 'collection',
            'header'        => 'Collections',
        ]);
    }

    public function shopFilter(Request $request)
    {
        $this->params['pagination']['totalItemsPerPage'] = 12;
        $this->params['category_id']    = $request->input('category_id', 'all');
        $this->params['occasion_id']    = $request->input('occasion_id', 'all');
        $this->params['collection_id']  = $request->input('collection_id', 'all');
        $this->params['color_id']       = $request->input('color_id', 'all');
        $this->params['size_id']        = $request->input('size_id', 'all');
        $this->params['price_id']       = $request->input('price_id', 'all');
        $this->params['key']            = $request->input('key', '');
        $this->params['sort']           = $request->input('sort', '');
        $this->params['view']           = $request->input('view', '');

        $productModel       = new ProductModel();
        $items              = $productModel->listItems($this->params, ['task' => 'default-list-products-ajax']);

        $categoryModel      = new CategoryModel();
        $category           = $categoryModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameCategory       = $category['name'] ?? '';

        $occasionModel      = new OccasionModel();
        $occasion           = $occasionModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameOccasion       = $occasion['name'] ?? '';

        $collectionModel    = new CollectionModel();
        $collection         = $collectionModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameCollection     = $collection['name'] ?? '';

        $colorModel         = new ColorModel();
        $color              = $colorModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameColor          = $color['name'] ?? '';

        $sizeModel          = new SizeModel();
        $size               = $sizeModel->getItem($this->params, ['task' => 'default-get-item']);
        $nameSize           = $size['name'] ?? '';

        $namePrice = 'all';
        switch($this->params['price_id']){
            case 1: 
                $namePrice = 'Under 1M';
                break;
            case 2: 
                $namePrice = '1M - 3M';
                break;
            case 3: 
                $namePrice = '3M - 6M';
                break;
            case 4: 
                $namePrice = '6M - 10M';
                break;
        }

        $params['user_id'] = 0;
        if(Auth::check())
            $params['user_id'] = Auth::user()->id;

        $favoriteModel      = new FavoriteModel();
        $favorites          = $favoriteModel->listItems($params, ['task' => 'default-list-items']);

        $button = true;

        if(count($items) < $this->params['pagination']['totalItemsPerPage']){
            $button = false;
        }

        return response()->json([
            'items'             => $items,
            'category'          => $this->params['category_id'],
            'occasion'          => $this->params['occasion_id'],
            'collection'        => $this->params['collection_id'],
            'color'             => $this->params['color_id'],
            'size'              => $this->params['size_id'],
            'price'             => $this->params['price_id'],
            'nameCategory'      => $nameCategory,
            'nameOccasion'      => $nameOccasion,
            'nameCollection'    => $nameCollection,
            'nameColor'         => $nameColor,
            'nameSize'          => $nameSize,
            'button'            => $button,
            'favorites'         => $favorites,
            'namePrice'         => $namePrice,
        ]);
    }

    public function loadMore(Request $request)
    {
        $this->params['start'] = $request->input('start', '0');
        $this->params['limit'] = $request->input('limit', '12');

        $this->params['category_id']    = $request->input('category_id', 'all');
        $this->params['occasion_id']    = $request->input('occasion_id', 'all');
        $this->params['collection_id']  = $request->input('collection_id', 'all');
        $this->params['color_id']       = $request->input('color_id', 'all');
        $this->params['size_id']        = $request->input('size_id', 'all');
        $this->params['price_id']       = $request->input('price_id', 'all');
        $this->params['key']            = $request->input('key', '');
        $this->params['sort']           = $request->input('sort', '');

        $productModel       = new ProductModel();
        $items              = $productModel->listItems($this->params, ['task' => 'default-load-more-products-ajax']);

        $params['user_id'] = 0;
        if(Auth::check())
            $params['user_id'] = Auth::user()->id;

        $favoriteModel      = new FavoriteModel();
        $favorites          = $favoriteModel->listItems($params, ['task' => 'default-list-items']);


        $button = true;

        if(count($items) < $this->params['limit']){
            $button = false;
        }

        return response()->json([
            'items'             => $items,
            'button'            => $button,
            'favorites'         => $favorites,
        ]);
        
    }

    public function ajax(Request $request)
    {
        $this->params['category_id']    = $request->input('category_id', 'all');
        $this->params['occasion_id']    = $request->input('occasion_id', 'all');
        $this->params['collection_id']  = $request->input('collection_id', 'all');
        $this->params['color_id']       = $request->input('color_id', 'all');
        $this->params['size_id']        = $request->input('size_id', 'all');
        $this->params['price_id']       = $request->input('price_id', 'all');
        $this->params['key']            = $request->input('key', '');
        $this->params['sort']           = $request->input('sort', '');

        $productModel       = new ProductModel();
        $items = $productModel->listItems($this->params, ['task' => 'list-items-ajax']);
       
        return $items;
    }

    public function about(Request $request)
    {
        return view($this->pathViewController.'about', [
            'active'        => 'about',
            'header'        => 'Về Artiz',
        ]);
    }

    public function contact(Request $request)
    {
        return view($this->pathViewController.'contact', [
            'active'        => 'contact',
            'header'        => 'Liên hệ',
        ]);
    }

    public function news(Request $request)
    {
        $newsModel      = new NewsModel();
        $items          = $newsModel->listItems($this->params, ['task' => 'default-list-items']);
        return view($this->pathViewController.'news', [
            'active'        => 'news',
            'header'        => 'Tin tức',
            'items'         => $items
        ]);
    }
}