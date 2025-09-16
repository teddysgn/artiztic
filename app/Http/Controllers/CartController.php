<?php
 
namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Auth;
use Cart;
use Mail;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\CartModel as MainModel;
use App\Models\CartDetailModel as CartDetailModel;
use App\Models\CouponModel as CouponModel;
use App\Models\MemberModel as MemberModel;
use App\Models\ProductModel as ProductModel;
use App\Models\SkuModel as SkuModel;
use App\Models\RefundModel as RefundModel;
use App\Models\RefundDetailModel as RefundDetailModel;
use App\Http\Requests\CategoryRequest as MainRequest;

 
class CartController extends Controller
{
    private $pathViewController = 'default.pages.cart.';
    private $controllerName     = 'cart';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function show(Request $request)
    {   
        $this->params['filter']['sort_by']  = $request->input('sort_by', 'all');
        $this->params['filter']['order_by'] = $request->input('order_by', 'all');
        $this->params['filter']['status']   = $request->input('filter_status', 'all');
        $this->params['filter']['cancel']   = $request->input('filter_cancel', 'all');
        $this->params['filter']['method']   = $request->input('filter_method', 'all');
        $this->params['search']['field']    = $request->input('search_field', 'name');
        $this->params['search']['value']    = $request->input('search_value', '');

        $items              = $this->model->listItems($this->params, ['task' => 'list-items']);
        $countByStatus      = $this->model->countItems($this->params, ['task' => 'count-status']);
        $countByCancel      = $this->model->countItems($this->params, ['task' => 'count-cancel']);
        $countByMethod      = $this->model->countItems($this->params, ['task' => 'count-method']);

        $refundModel = new RefundModel();
        $refund = $refundModel->listItems($this->params, ['task' => 'list-items']);

        return view('admin.pages.cart.index', [
            'params'            => $this->params,
            'items'             => $items,
            'countByStatus'     => $countByStatus,
            'countByCancel'     => $countByCancel,
            'countByMethod'     => $countByMethod,
            'refund'            => $refund,
            'header'            => 'Carts - List'
        ]);
    }

    public function form(Request $request)
    {
        $item = '';
        
        if($request->id != null){
            $this->params['id']     = $request->id;
            $cartDetailModel        = new CartDetailModel();
            $items                  = $cartDetailModel->listItems($this->params, ['task' => 'list-items']);
            $cart                   = $this->model->getItem($this->params, ['task' => 'get-item']);

            $refundModel            = new RefundModel();
            $refund                 = $refundModel->getItem($this->params, ['task' => 'get-item']);

            $refundDetails = null;
            if($refund != null){
                $refundDetailModel      = new RefundDetailModel();
                $refundDetails          = $refundDetailModel->listItems($refund, ['task' => 'list-items']);
            }
                
        }

        return view('admin.pages.cart.form', [
            'items'             => $items,
            'cart'              => $cart,
            'refund'            => $refund,
            'refundDetails'     => $refundDetails,
            'header'            => 'Cart - Details'
        ]);
    }

    public function save(Request $request)
    {
        if($request->method() == 'POST'){
            $this->params = $request->all();
        
            $this->model->saveItem($this->params, ['task' => 'order-cancel']);
            $cartDetailModel = new CartDetailModel();
            $items          = $cartDetailModel->listItems($this->params, ['task' => 'list-items']);
           
            foreach($items as $key => $value){
                $detail['id']       = $value['product_id'];
                $detail['quantity'] = $value['quantity'];
                $detail['size']     = $value['size'];
                $detail['color']    = $value['color'];
                $detail['category'] = $value['category_name'];
                $detail['style']    = $value['product_style'];

                $productModel = new ProductModel();
                $productModel->saveItem($detail, ['task' => 'update-quantity']);

                $skuModel = new SkuModel();
                $skuModel->saveItem($detail, ['task' => 'update-quantity']);
            }

      
            $cart           = $this->model->getItem($this->params, ['task' => 'get-item']);
            $user           = $this->model->getItem($this->params, ['task' => 'get-item-to-info-user']);

            Mail::send('admin.pages.mail.artiz', compact('user', 'cart', 'items'), function($email) use($user){
                $email->subject('ARTIZ - ORDER CANCELLATION NOTIFICATION');
                $email->to($user['user_email'], $user['user_fullname']);
            });

            return redirect()->route($this->controllerName)->with('artiz_notify', 'Updated Successfully');
        }
    }

    public function delete(Request $request)
    {
        $this->params['id']               =   $request->id;
        $this->model->deleteItem($this->params, ['task' => 'delete-item']);
        return redirect()->route($this->controllerName)->with('artiz_notify', 'Deleted Successfully!!!');
    }

    public function status(Request $request)
    {
        $this->params['currentStatus']    = $request->status;
        $this->params['id']               =   $request->id;

        if($request->status == 'delivered'){
            $cart           = $this->model->getItem($this->params, ['task' => 'get-item']);
            $user           = $this->model->getItem($this->params, ['task' => 'get-item-to-info-user']);

            Mail::send('admin.pages.mail.delivered', compact('user', 'cart'), function($email) use($user){
                $email->subject('ARTIZ - THANKS FOR SHOPPING WITH ARTIZ');
                $email->to($user['user_email'], $user['user_fullname']);
            });
        }

        $this->model->saveItem($this->params, ['task' => 'change-status']);
        return response()->json([
            'message' => 'Status',
        ]);
    }

    public function cancel(Request $request)
    {
        $this->params['currentCancel']  = $request->cancel;
        $this->params['id']             =   $request->id;
        
        $cartDetailModel = new CartDetailModel();
        $items           = $cartDetailModel->listItems($this->params, ['task' => 'list-items']);
        
        $cart            = $this->model->getItem($this->params, ['task' => 'get-item']);
        $user            = $this->model->getItem($this->params, ['task' => 'get-item-to-info-user']);
        if($request->cancel == 'approved'){  
            foreach($items as $key => $value){
                $detail['id']       = $value['product_id'];
                $detail['quantity'] = $value['quantity'];
                $detail['size']     = $value['size'];
                $detail['color']    = $value['color'];
                $detail['category'] = $value['category_name'];
                $detail['style']    = $value['product_style'];

                $productModel = new ProductModel();
                $productModel->saveItem($detail, ['task' => 'update-quantity']);

                $skuModel = new SkuModel();
                $skuModel->saveItem($detail, ['task' => 'update-quantity']);
            }

            Mail::send('admin.pages.mail.cancel', compact('user', 'cart', 'items'), function($email) use($user){
                $email->subject('ARTIZ - ORDER CANCELLATION NOTIFICATION');
                $email->to($user['user_email'], $user['user_fullname']);
            });
        }

        if($request->cancel == 'deny'){  

            Mail::send('admin.pages.mail.deny', compact('user', 'cart', 'items'), function($email) use($user){
                $email->subject('ARTIZ - ORDER CANCELLATION NOTIFICATION');
                $email->to($user['user_email'], $user['user_fullname']);
            });
        }
        $this->model->saveItem($this->params, ['task' => 'change-cancel']);
        return response()->json([
            'message' => 'Cancel',
        ]);
    }

    public function refund(Request $request)
    {
        $this->params['currentRefund']      = $request->refund;
        $this->params['id']                 = $request->id;


        $refundModel = new RefundModel();
        $refundId = $refundModel->saveItem($this->params, ['task' => 'change-status']);
        
        return response()->json([
            'message' => 'Refund',
        ]);
    }

    public function checkout(Request $request)
    {
        $params['id']       = Auth::user()->member_id;
        $memberModel        = new MemberModel();
        $member             = $memberModel->getItem($params, ['task' => 'default-get-item']);

        return view($this->pathViewController.'checkout', [
            'active'       => 'cart',
            'member'       => $member,
            'header'        => 'Thanh toán'
        ]);
    }

    public function success(Request $request)
    {
        if(session('order_id'))
            return view($this->pathViewController.'success', [
                'active'       => 'cart',
                'header'        => 'Order Successfully'
            ]);
        else
            return redirect()->route('home');
    }

    public function submit(Request $request)
    {
        $params['user_id']          = Auth::user()->id;
        $params['email']            = $request->email;
        $params['note']             = $request->note;
        $params['fullname']         = $request->fullname;
        $params['address']          = $request->address;
        $params['phone']            = $request->phone;
        $params['total']            = $request->totalHidden;
        $params['subtotal']         = $request->subtotal;
        $params['shipping_city']    = $request->shipping_city;
        $params['coupon']           = $request->coupon;
        $params['member']           = $request->member;
        $params['discount']         = $request->discount;
        $params['coupon_value']     = $request->coupon_value;
        $params['payment_method']   = $request->payment_method;
        $params['invoice']          = $request->invoice;
        $params['created']          = date('Y-m-d H:i:s');

        $item = $this->model->saveItem($params, ['task' => 'add-item']);
        
        $cart['cart_id']    = $item;
        $cartDetailModel = new CartDetailModel();
        foreach(Cart::content() as $key => $value){
            $cart['product_id'] = $value->id;
            $cart['quantity']   = $value->qty;
            $cart['price']      = $value->price - ($value->options->discount * $value->price) / 100;
            $cart['color']      = $value->options->color;
            $cart['size']       = $value->options->size;
            $cart['style']      = $value->options->style;
            $cart['discount']   = $value->options->discount;

            $productModel       = new ProductModel();
            $productModel->saveItem($cart, ['task' => 'update-quantity-submit-cart']);

            $skuModel           = new SkuModel();
            $skuModel->saveItem($cart, ['task' => 'update-quantity-submit-cart']);

            $cartDetailModel->saveItem($cart, ['task' => 'add-item']);
        }

        $couponModel = new CouponModel();
        $couponModel->saveItem($params['coupon'], ['task' => 'default-update-status']);

        $user = Auth::user();

        $request->session()->put('order_id', $item);
        Mail::send('default.pages.mail.order', compact('params', 'cart'), function($email) use($user){
            $email->subject('ARTIZ - THANKS FOR YOUR PURCHASE');
            $email->to($user['email'], $user['fullname']);
        }, [
            'params' => $params,
            'cart'  => $cart
        ]);

        Mail::send('default.pages.mail.admin', compact('params', 'cart'), function($email) use($user){
            $email->subject('ARTIZ - NEW ORDER');
            $email->to('hoangvu.pcx@gmail.com', 'Administrator');
        }, [
            'params' => $params,
            'cart'  => $cart
        ]);
        $request->session()->pull('order_id');
        
        Cart::destroy();

        return redirect()->route('cart/success')->with('order_id', $item);
    }

    public function checkCoupon(Request $request)
    {
        $this->params['coupon']    = $request->coupon;

        $couponModel = new CouponModel();
        $item = $couponModel->getItem($this->params, ['task' => 'default-get-item']);
        return response()->json([
            'item' => $item,
        ]);
    }


}