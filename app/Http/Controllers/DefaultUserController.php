<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserModel as MainModel;
use App\Models\CartModel as CartModel;
use App\Models\CartDetailModel as CartDetailModel;
use App\Models\FavoriteModel as FavoriteModel;
use App\Models\ProductModel as ProductModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\SizeModel as SizeModel;
use App\Models\ColorModel as ColorModel;
use App\Models\SkuModel as SkuModel;
use App\Models\MemberModel as MemberModel;
use App\Models\RatingModel as RatingModel;
use App\Models\RefundModel as RefundModel;
use App\Models\RefundDetailModel as RefundDetailModel;
use App\Http\Requests\UserRequest as MainRequest;

use Illuminate\Support\Facades\Auth as Auth;
use Cart;
use Mail;
 
class DefaultUserController extends Controller
{
    private $pathViewController = 'default.pages.user.';
    private $controllerName     = 'user';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {   
        $userInfo = Auth::user();
        $this->params['id'] = $userInfo['id'];
        
        $item           = $this->model->getItem($this->params, ['task' => 'get-item']);

        $cartModel      = new CartModel();
        $total          = $cartModel->getItem($this->params, ['task' => 'default-user-get-sum-total-item']);

        $memberModel    = new MemberModel();
        $members        = $memberModel->listItems($this->params, ['task' => 'default-user-list-items']);
        $maxMember      = $memberModel->getItem($this->params, ['task' => 'default-user-get-max-item']);
        
        if($item == null) return redirect()->route('home');
        return view($this->pathViewController.'index', [
            'active'        => 'user',
            'target'        => 'detail',
            'user'          => $item,
            'total'         => $total,
            'members'       => $members,
            'maxMember'     => $maxMember,
            'title'         => 'Thông tin tài khoản',
            'header'        => 'Tài khoản',
        ]);
    }

    public function postUpdate(MainRequest $request)
    {   
        if($request->method() == "POST"){
            $params = $request->all();
            $url = '';

            if($params['option'] == 'password'){
                $url = '/' . $params['option'];
                $this->model->saveItem($params, ['task' => 'default-edit-password']);
            }

            if($params['option'] == '')
                $this->model->saveItem($params, ['task' => 'default-edit-item']);

            
            return redirect()->route($this->controllerName . $url)->with('artiz_notify_success', 'Updated Successfully!!!');
        }
    }

    public function check(MainRequest $request)
    {
        $item = false;
       
        if(Auth::attempt(['email' => Auth::user()->email, 'password' => $request->confirm_password], true))
            $item = true; 
       

        return $item;
    }

    public function password(MainRequest $request)
    {
        $userInfo = Auth::user();
        $this->params['id'] = $userInfo['id'];
        

        $item = $this->model->getItem($this->params, ['task' => 'get-item']);

        return view($this->pathViewController.'password', [
            'active'        => 'user',
            'target'        => 'password',
            'user'          => $item,
            'title'         => 'Đổi mật khẩu',
            'header'        => 'Đổi mật khẩu',
        ]);
    }

    public function history(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id'] = $userInfo['id'];
        $this->params['id'] = $request['id'] ?? '';

        $this->params['pagination']['totalItemsPerPage'] = 20;
        

        $cartModel          = new CartModel();
        $items              = $cartModel->listItems($this->params, ['task' => 'default-history-list-items']);

        $cartDetailModel    = new CartDetailModel();
        $details            = $cartDetailModel->listItems($this->params, ['task' => 'default-history-list-items']);

        $refundModel        = new RefundModel();
        $refund             = $refundModel->listItems($this->params, ['task' => 'default-list-items']);

        return view($this->pathViewController.'history', [
            'items'         => $items,
            'details'       => $details,
            'refund'        => $refund,
            'active'        => 'user',
            'target'        => 'history',
            'title'         => 'Lịch sử đơn hàng',
            'header'        => 'Lịch sử đơn hàng',
        ]);
    }

    public function tracking(Request $request)
    {
        $this->params['id'] = $request['id'] ?? '';
        if($this->params['id'] != ''){
            $userInfo = Auth::user();
            $this->params['user_id'] = $userInfo['id'];
    
            $cartModel              = new CartModel();
            $item                   = $cartModel->getItem($this->params, ['task' => 'default-history-get-item']);
            if($item != null){
                $item['created']        = date('H:i:s d/m/Y', strtotime($item['created']));
                $item['cancel_date']    = date('H:i:s d/m/Y', strtotime($item['cancel_date']));
                $item['modified']       = strtotime($item['modified']);
            }

    
            $cartDetailModel        = new CartDetailModel();
            $details                = $cartDetailModel->listItems($this->params, ['task' => 'default-history-list-items']);

            $refundModel            = new RefundModel();
            $refund                 = $refundModel->getItem($this->params, ['task' => 'default-history-get-item']);
    
            return response()->json([
                'item'          => $item,
                'details'       => $details,
                'refund'        => $refund,
            ]);
        } else {
            return view($this->pathViewController.'tracking', [
                'active'        => 'user',
                'target'        => 'tracking',
                'title'         => 'Tìm kiếm đơn hàng',
                'header'        => 'Tìm kiếm đơn hàng'
            ]);
        }
    }

    public function historyDetail(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id'] = $userInfo['id'];
        $this->params['id'] = $request['id'];
        

        $cartModel          = new CartModel();
        $item               = $cartModel->getItem($this->params, ['task' => 'default-history-get-item']);

        if($item == null) {
            return redirect()->route('user/history');
        } else {
            $cartDetailModel    = new CartDetailModel();
            $details            = $cartDetailModel->listItems($this->params, ['task' => 'default-history-list-items']);
    
            $refundModel        = new RefundModel();
            $refund             = $refundModel->getItem($this->params, ['task' => 'default-history-get-item']);
           
            return view($this->pathViewController.'history-detail', [
                'item'          => $item,
                'details'       => $details,
                'refund'        => $refund,
                'active'        => 'user',
                'target'        => 'history',
                'title'         => 'Lịch sử đơn hàng - Chi tiết',
                'header'        => 'Chi tiết đơn hàng'
            ]);
        }

        
    }

    public function historyRefund(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id'] = $userInfo['id'];
        $this->params['id'] = $request['id'] ?? '';

        $cartDetailModel    = new CartDetailModel();
        $details            = $cartDetailModel->listItems($this->params, ['task' => 'default-history-list-items']);

        $colorModel         = new ColorModel();
        $colors             = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

        return response()->json([
            'details'       => $details,
            'colors'        => $colors,
        ]);
    }

    public function historyCheckSKU(Request $request)
    {
        $this->params['product_id']     = $request->product_id;
        $this->params['color']          = $request->color;
        $this->params['style']          = $request->style;

        $skuModel           = new SkuModel();
        $sizes              = $skuModel->listItems($this->params, ['task' => 'default-refund-list-items-by-size']);

        $sizeModel          = new SizeModel();
        $sizeSlb            = $sizeModel->listItems(null, ['task' => 'quick-view-list-items']);

        return response()->json([
            'sizes'       => $sizes,
            'sizeSlb'       => $sizeSlb,
        ]);
    }

    public function cancel(Request $request)
    {
        $params             = $request->all();
        $cartModel          = new CartModel();
        $item               = $cartModel->saveItem($params, ['task' => 'request-cancel']);
        $cart               = $cartModel->getItem($params, ['task' => 'default-cancel-get-item']);


        $cartDetailModel    = new CartDetailModel();
        $cartDetail         = $cartDetailModel->listItems($params, ['task' => 'default-cancel-list-items']);

        Mail::send('default.pages.mail.cancel', compact('cartDetail', 'cart'), function($email) {
            $email->subject('ARTIZ - NEW CANCEL REQUEST');
            $email->to('hoangvu.pcx@gmail.com', 'Administrator');
        });

        Mail::send('default.pages.mail.cancelDefault', compact('cartDetail', 'cart'), function($email) {
            $email->subject('ARTIZ - CANCEL REQUEST SENT');
            $email->to(Auth::user()->email, Auth::user()->fullname);
        });

        return response()->json([
            'message' => 'Chờ xác nhận hủy',
            'time'    => date_format(date_create($item), 'H:i:s d/m/Y'),
            'user'    => Auth::user()->fullname,
            'reason'  => $params['reason_cancel'],
        ]);
    }

    public function exchange(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id']    = $userInfo['id'];
        $this->params['id']         = $request['id'] ?? '';
        $this->params['cart_id']    = $request['id'] ?? '';
        $refundModel                = new RefundModel();
        $check                      = $refundModel->getItem($this->params, ['task' => 'default-get-item']);

        if($check == null){
            $cartDetailModel    = new CartDetailModel();
            $details            = $cartDetailModel->listItems($this->params, ['task' => 'default-history-list-items']);
    
            $colorModel         = new ColorModel();
            $colors             = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

            if($details == null){
                return redirect()->route('user/history');
            } else {
                return view($this->pathViewController.'exchange', [
                    'active'        => 'user',
                    'details'       => $details,
                    'colors'        => $colors,
                    'params'        => $this->params,
                    'header'        => 'Đổi hàng',
                ]);
            }
        } else {
            return redirect()->route('user/history-detail', ['id' => $this->params['id']]);
        }

        
    }

    public function exchangeDetail(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id']    = $userInfo['id'];
        $this->params['id']         = $request['id'] ?? '';
        $this->params['cart_id']    = $request['id'] ?? '';

        $cartDetailModel        = new CartDetailModel();
        $items                  = $cartDetailModel->listItems($this->params, ['task' => 'list-items']);

        $cartModel              = new CartModel();
        $cart                   = $cartModel->getItem($this->params, ['task' => 'get-item']);

        $refundModel            = new RefundModel();
        $refund                 = $refundModel->getItem($this->params, ['task' => 'get-item']);

        $refundDetails = null;
        if($refund != null){
            $refundDetailModel      = new RefundDetailModel();
            $refundDetails          = $refundDetailModel->listItems($refund, ['task' => 'list-items']);
        }

        return view($this->pathViewController.'exchange-detail', [
            'active'            => 'user',
            'items'             => $items,
            'cart'              => $cart,
            'refund'            => $refund,
            'refundDetails'     => $refundDetails,
            'params'            => $this->params,
            'header'            => 'Chi tiết đổi hàng',
        ]);

        
    }

    public function exchangeProduct(Request $request)
    {
        $this->params['id']         = $request['id'] ?? '';

        $productModel   = new ProductModel();
        $item           = $productModel->getItem($this->params, ['task' => 'default-get-item']);
        $products       = $productModel->listItems($item, ['task' => 'default-exchange-list-items']);

        return response()->json([
            'products'      => $products,
            'item'          => $item,
        ]);
    }

    public function exchangeColor(Request $request)
    {
        $this->params['id']         = $request['id'] ?? '';

        $productModel       = new ProductModel();
        $item               = $productModel->getItem($this->params, ['task' => 'default-get-item']);

        $colorModel         = new ColorModel();
        $colors             = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

        return response()->json([
            'item'          => $item,
            'colorSlb'      => $colors,
        ]);
    }

    public function refund(Request $request)
    {
        $params = $request->all();

        $refund['cart_id']      = $params['cart_id'];
        $refund['reason']       = $params['reason_refund'];
        $refund['amount']       = $params['amount'];
        $refundModel            = new RefundModel();
        $check                  = $refundModel->getItem($refund, ['task' => 'default-get-item']);
       
        if($check == null){
            $item = $refundModel->saveItem($refund, ['task' => 'add-item']);
            foreach($params['product'] as $key => $value){
                if($value != null){
                    $detail['refund_id']    = $item;
                    $detail['product_id']   = $params['old_product'][$key];
                    $detail['to_product']   = $params['product'][$key];
                    $detail['id']           = $params['old_product'][$key];
                    $detail['quantity']     = $params['quantity'][$key];
                    $detail['color']        = $params['old_color'][$key];
                    $detail['to_color']     = $params['color'][$key];
                    $detail['size']         = $params['old_size'][$key];
                    $detail['to_size']      = $params['size'][$key];
    
                    // Exchange to Another Product
                    if($detail['product_id'] != $detail['to_product']){
                        $productModel = new ProductModel();
                        $product['id']           = $params['old_product'][$key];
                        $product['product_id']   = $params['product'][$key];
                        $product['quantity']     = $params['quantity'][$key];
                        $productModel->saveItem($product, ['task' => 'update-quantity-submit-cart']);
                        $productModel->saveItem($product, ['task' => 'update-quantity']);
                    }
    
                    $refundDetailModel = new RefundDetailModel();
                    $refundDetailModel->saveItem($detail, ['task' => 'add-item']);
        
                    $old['id']         = $params['old_product'][$key];
                    $old['quantity']   = $params['quantity'][$key];
                    $old['color']      = $params['old_color'][$key];
                    $old['size']       = $params['old_size'][$key];
    
                    $skuModel = new SkuModel();
                    $skuModel->saveItem($old, ['task' => 'update-quantity']);
    
                    $new['product_id'] = $params['product'][$key];
                    $new['quantity']   = $params['quantity'][$key];
                    $new['color']      = $params['color'][$key];
                    $new['size']       = $params['size'][$key];
                    $skuModel->saveItem($new, ['task' => 'update-quantity-submit-cart']);
                }
            }
            $refundDetailModel  = new RefundDetailModel();
            $itemExchange       = $refundDetailModel->listItems($item, ['task' => 'default-exchange-list-items']);

            $itemRefund         = $refundModel->getItem($item, ['task' => 'default-exchange-get-item']);

            $cartDetailModel    = new CartDetailModel();
            $itemDetail         = $cartDetailModel->listItems($refund, ['task' => 'default-exchange-list-items']);

           
            
            Mail::send('default.pages.mail.exchange', compact('refund', 'itemExchange', 'itemRefund', 'itemDetail'), function($email) {
                $email->subject('ARTIZ - NEW EXCHANGE REQUEST');
                $email->to('hoangvu.pcx@gmail.com', 'Administrator');
            });

            Mail::send('default.pages.mail.exchangeDefault', compact('refund', 'itemExchange', 'itemRefund', 'itemDetail'), function($email) {
                $email->subject('ARTIZ - EXCHANGE REQUEST SENT');
                $email->to(Auth::user()->email, Auth::user()->fullname);
            });
        }
        return redirect()->route('user/history-detail', ['id' => $refund['cart_id']]);
    }

    public function favorite(Request $request)
    {
        $userInfo = Auth::user();

        $params['product_id'] = $request->product_id;
        $params['user_id']    = $userInfo['id'];

        $type = $request->type;
        
        $favoriteModel          = new FavoriteModel();
        if($type == 'add')
            $item              = $favoriteModel->saveItem($params, ['task' => 'add-item']);
        else
            $item              = $favoriteModel->saveItem($params, ['task' => 'remove-item']);

        $productModel           = new ProductModel();
        $items                  = $productModel->listItems($params, ['task' => 'default-list-items-wishlist']);

        return response()->json([
            'items'            => $items,
            'item'             => $item,
        ]);
        
    }

    public function wishlist(Request $request)
    {
        $userInfo = Auth::user();
        $this->params['user_id']    = $userInfo['id'];

        $productModel       = new ProductModel();
        $items              = $productModel->listItems($this->params, ['task' => 'default-list-items-wishlist']);
        
        return view($this->pathViewController.'wishlist', [
            'active'        => 'user',
            'target'        => 'wishlist',
            'items'         => $items,
            'title'         => 'Danh sách yêu thích',
            'header'        => 'Danh sách yêu thích'
        ]);
    }

    public function cart(Request $request)
    {
        $items = Cart::content();

        $sizeModel          = new SizeModel();
        $size               = $sizeModel->listItems(null, ['task' => 'list-items-in-selectbox']);

        $colorModel          = new ColorModel();
        $color               = $colorModel->listItems(null, ['task' => 'quick-view-list-items']);

        $params['id']       = Auth::user()->member_id;
        $memberModel        = new MemberModel();
        $member             = $memberModel->getItem($params, ['task' => 'default-get-item']);

        return view($this->pathViewController.'cart', [
            'active'        => 'cart',
            'member'        => $member,
            'items'         => $items,
            'sizeSlb'       => $size,
            'colorSlb'      => $color,
            'header'        => 'Chi tiết giỏ hàng',
        ]);
    }

    public function checkSku(Request $request){
        $items = Cart::content();
        $this->params['size']   = $request->size;
        $this->params['color']  = $request->color;
        $this->params['id']     = $request->id;
        $this->params['style']  = $request->style;
        $quantity = 0;
        foreach($items as $key => $value){
            if($value->id == $this->params['id'] && $value->options->color == $this->params['color'] && $value->options->size == $this->params['size']){
                $quantity += $value->qty;
            }
        }

        $skuModel           = new SkuModel();
        $stock              = $skuModel->getItem($this->params, ['task' => 'default-get-item-by-stock']);

        return response()->json([
            'stock'   => $stock['stock'],
            'quantity'   => $quantity,
        ]);
    }

    public function addToCart(Request $request)
    {
        $params['id'] = $request->id;
        $productModel = new ProductModel();
        $product = $productModel->getItem($params, ['task' => 'default-get-item']); 
        Cart::add([
            'id'        => $product->id, 
            'name'      => $product->name, 
            'price'     => $product->price, 
            'qty'       => $request->qty, 
            'options'   => [
                'picture'   => $product->picture1,
                'discount'  => $product->discount,
                'quantity'  => $product->quantity,
                'style'     => $product->style,
                'size'      => $request->size,
                'color'     => $request->color,
                'sizeDB'    => $product->size,
                'colorDB'   => $product->color,
            ],
        ]);

        $totalCart = Cart::count();

        return response()->json([
            'message'   => 'success',
            'total'     => $totalCart
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $rowId = $request->id;
        Cart::remove($rowId);
        return redirect()->back();
      
    }

    public function destroyCart(Request $request)
    {
        Cart::destroy();
        return redirect()->back();
    }

    public function updateCart(Request $request)
    {
        $rowId = $request->id;
        $item = Cart::get($rowId);
        

        $qty = $request->qty;
        $size = $request->size;
        $color = $request->color;

        $options = $item->options->merge(['size' => $size, 'color' => $color]);

        Cart::update(
            $rowId, [
            'qty' => $qty, 
            'options' => $options
        ]);

        

        
         return redirect()->back();
      
    }

    public function addRating(Request $request)
    {
        if($request->method() == "POST"){
            $params = $request->all();

            $cartModel      = new cartModel();
            $checkProduct   = $cartModel->getItem($params, ['task' => 'default-get-item']);

            if($checkProduct != null){
                $ratingModel    = new RatingModel();
                $checkRating    = $ratingModel->getItem($params, ['task' => 'default-get-item']);
                if(!isset($request->rating)){
                    $message = 'Đánh giá sản phẩm phải có ít nhất 1 sao (*)!';
                    return redirect()->back()->with('artiz_notify_error', $message);
                }
    
                if($checkRating != null){
                    $message = 'Bạn đã đánh giá cho sản phẩm này!';
                    return redirect()->back()->with('artiz_notify_error', $message);
                } else {
                    $ratingModel->saveItem($params, ['task' => 'add-item']);
                    $message = 'Cảm ơn bạn đã đánh giá. Đánh giá sẽ cuất hiện khi Artiz xác nhận!';
                    return redirect()->back()->with('artiz_notify_success', $message);
                }
            } else {
                $message = 'Bạn phải mua sản phẩm này trước, sau đó bạn sẽ được phép đánh giá!';
                return redirect()->back()->with('artiz_notify_error', $message);
            }
        }
    }

}