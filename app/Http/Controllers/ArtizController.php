<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
 
class ArtizController extends Controller
{
    private $pathViewController = 'default.pages.artiz.';
    private $controllerName     = 'artiz';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        view()->share('controllerName', $this->controllerName);
    }

    public function index(Request $request)
    {   
        return view($this->pathViewController.'index', [
            'active'        => 'service',
            'header'        => 'Dịch vụ khách hàng'
        ]);
    }

    public function exchanges(Request $request)
    {   
        return view($this->pathViewController.'exchange', [
            'active'        => 'service',
            'header'        => 'Chính sách đổi hàng'
        ]);
    }

    public function information(Request $request)
    {   
        return view($this->pathViewController.'information', [
            'active'        => 'service',
            'header'        => 'Chính sách bảo mật'
        ]);
    }

    public function payments(Request $request)
    {   
        return view($this->pathViewController.'payments', [
            'active'        => 'service',
            'header'        => 'Phương thức thanh toán'
        ]);
    }
    
    public function shipping(Request $request)
    {   
        return view($this->pathViewController.'shipping', [
            'active'        => 'service',
            'header'        => 'Thời gian giao hàng'
        ]);
    }

    public function termOfUse(Request $request)
    {   
        return view($this->pathViewController.'termOfUse', [
            'active'        => 'service',
            'header'        => 'Điều khoản của Artiz'
        ]);
    }

    public function faqs(Request $request)
    {   
        return view($this->pathViewController.'faqs', [
            'active'        => 'service',
            'header'        => 'Câu hỏi thường gặp'
        ]);
    }
    
    public function faqsShipping(Request $request)
    {   
        return view($this->pathViewController.'faqs-shipping', [
            'active'        => 'service',
            'header'        => 'Hỏi đáp - Giao hàng'
        ]);
    }

    public function faqsExchange(Request $request)
    {   
        return view($this->pathViewController.'faqs-exchange', [
            'active'        => 'service',
            'header'        => 'Hỏi đáp - Đổi & Trả hàng'
        ]);
    }

    public function faqsPayments(Request $request)
    {   
        return view($this->pathViewController.'faqs-payments', [
            'active'        => 'service',
            'header'        => 'Hỏi đáp - Phương thức thanh toán'
        ]);
    }

    public function faqsInformation(Request $request)
    {   
        return view($this->pathViewController.'faqs-information', [
            'active'        => 'service',
            'header'        => 'Hỏi đáp - Tài khoản và Đơn hàng'
        ]);
    }
    
}