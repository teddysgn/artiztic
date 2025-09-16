<?php
 
namespace App\Http\Controllers;
 
use App\Models\UserModel;
use App\Models\CartModel;
use App\Models\RefundModel;
use App\Models\ProductModel;
use App\Models\CartDetailModel;
use App\Models\SkuModel;
use App\Models\FavoriteModel;
use App\Models\RatingModel;
use App\Models\CacheModel;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;

 
class DashboardController extends Controller
{
    private $pathViewController = 'admin.pages.dashboard.';
    private $controllerName     = 'dashboard';

    public function __construct()
    {
        view()->share('controllerName', $this->controllerName);
    }

    public function show(Request $request) {
        return view($this->pathViewController.'index');
    }

    public function order(Request $request) {
        $params = null;
        if($request)
            $params = $request->all();
        $params['view_by'] = $request->view_by ? $request->view_by : 'default';
       
        $cartModel                          = new CartModel();
        $refundModel                        = new RefundModel();
        $skuModel                           = new SkuModel();
        $cartDetailModel                    = new CartDetailModel();

        //Summary
        $countAllOrder                      = $cartModel->dashboard($params, ['task' => 'count-items-all']);
        $countDeliveredOrder                = $cartModel->dashboard($params, ['task' => 'count-items-delivered']);
        $countCancelledOrder                = $cartModel->dashboard($params, ['task' => 'count-items-cancelled']);
        $averageOrderValue                  = $cartModel->dashboard($params, ['task' => 'average-order-value']);
        $sumTotalRevenue                    = $cartModel->dashboard($params, ['task' => 'sum-revenue']);
        $sumTotalRevenueCashOnDelivery      = $cartModel->dashboard($params, ['task' => 'sum-revenue-cash-on-delivery']);
        $sumTotalRevenueMobileBanking       = $cartModel->dashboard($params, ['task' => 'sum-revenue-mobile-banking']);
        $countRefundedOrder                 = $refundModel->dashboard($params, ['task' => 'count-items-refunded']);

        // Bar Chart - Cart
        $chartAllOrder                      = $cartModel->dashboard($params, ['task' => 'list-items-all']);
        $chartDeliveredOrder                = $cartModel->dashboard($params, ['task' => 'list-items-delivered']);
        $chartCancelledOrder                = $cartModel->dashboard($params, ['task' => 'list-items-cancelled']);
        $chartRefundedOrder                 = $refundModel->dashboard($params, ['task' => 'list-items-refunded']);

        // Bar Chart - Sold
        // $chartProductSold                   = $cartModel->dashboard($params, ['task' => 'list-items-sold']);
        $chartProductSold                   = $skuModel->dashboard($params, ['task' => 'list-items-sold']);

        // Bar Chart - Customers
        $chartCustomer                      = $cartModel->dashboard($params, ['task' => 'list-items-customer']);

        // Bar Chart - Revenue Month
        $chartByThisMonth                   = $cartModel->dashboard($params, ['task' => 'list-items-this-month']);
        $sumTotalRevenueByThisMonth         = $cartModel->dashboard($params, ['task' => 'sum-revenue-this-month']);
        $chartByPreviousMonth               = $cartModel->dashboard($params, ['task' => 'list-items-previous-month']);
        $sumTotalRevenueByPreviousMonth     = $cartModel->dashboard($params, ['task' => 'sum-revenue-previous-month']);

        // Line Chart - Revenue Week
        $chartByThisWeek                    = $cartModel->dashboard($params, ['task' => 'list-items-this-week']);
        $sumTotalRevenueByThisWeek          = $cartModel->dashboard($params, ['task' => 'sum-revenue-this-week']);
        $chartByPreviousWeek                = $cartModel->dashboard($params, ['task' => 'list-items-previous-week']);
        $sumTotalRevenueByPreviousWeek      = $cartModel->dashboard($params, ['task' => 'sum-revenue-previous-week']);

        // Table
        $tableListOrderByDate               = $cartModel->dashboard($params, ['task' => 'list-items-by-date']); 

        return view($this->pathViewController.'order', [
            // Summary
            'countAllOrder'                     => $countAllOrder['count'],
            'countDeliveredOrder'               => $countDeliveredOrder['count'],
            'countCancelledOrder'               => $countCancelledOrder['count'],
            'countRefundedOrder'                => $countRefundedOrder['count'],
            'sumTotalRevenue'                   => $sumTotalRevenue,
            'averageOrderValue'                 => $averageOrderValue,
            'sumTotalRevenueCashOnDelivery'     => $sumTotalRevenueCashOnDelivery,
            'sumTotalRevenueMobileBanking'      => $sumTotalRevenueMobileBanking,

            // Bar Chart - Cart
            'chartAllOrder'                     => $chartAllOrder,
            'chartDeliveredOrder'               => $chartDeliveredOrder,
            'chartCancelledOrder'               => $chartCancelledOrder,
            'chartRefundedOrder'                => $chartRefundedOrder,

            // Bar Chart - Sold
            'chartProductSold'                  => $chartProductSold,

            // Bar Chart - Customer
            'chartCustomer'                     => $chartCustomer,

            // Bar Chart - Revenue Month
            'chartByThisMonth'                  => $chartByThisMonth,
            'sumTotalRevenueByThisMonth'        => $sumTotalRevenueByThisMonth,
            'chartByPreviousMonth'              => $chartByPreviousMonth,
            'sumTotalRevenueByPreviousMonth'    => $sumTotalRevenueByPreviousMonth,

            // Line Chart - Revenue Week
            'chartByThisWeek'                   => $chartByThisWeek,
            'sumTotalRevenueByThisWeek'         => $sumTotalRevenueByThisWeek,
            'chartByPreviousWeek'               => $chartByPreviousWeek,
            'sumTotalRevenueByPreviousWeek'     => $sumTotalRevenueByPreviousWeek,

            // Table
            'tableListOrderByDate'              => $tableListOrderByDate,

            // KPI
            'kpiWeek'                           => 10000000, // 10M
            'kpiMonth'                          => 50000000, // 50M
            'params'                            => $params,
        ]);
    }

    public function product(Request $request) {
        $params = null;
        if($request)
            $params = $request->all();
        $params['view_by'] = $request->view_by ? $request->view_by : 'default';
       
        $productModel                       = new ProductModel();
        $ratingModel                        = new RatingModel();
        $favoriteModel                      = new FavoriteModel();
        $skuModel                           = new SkuModel();
        
        //Summary
        $countAllProduct                    = $productModel->dashboard($params, ['task' => 'count-items-all']);
        $sumInventoryProduct                = $productModel->dashboard($params, ['task' => 'sum-items-inventory']);
        $sumSoldProduct                     = $skuModel->dashboard($params, ['task' => 'sum-items-sold']);
        $countDiscountProduct               = $productModel->dashboard($params, ['task' => 'count-items-discount']);

        // Bar Chart - Rating
        $ratingHighestProduct               = $ratingModel->dashboard($params, ['task' => 'list-items-rating-highest']);
        $ratingLowestProduct                = $ratingModel->dashboard($params, ['task' => 'list-items-rating-lowest']);

        // Bar Chart - Inventory & Sold
        $inventoryAndSoldProduct            = $skuModel->dashboard($params, ['task' => 'list-items-inventory-sold']);

        // Bar Chart - Distribution
        $categoriesDistribution             = $productModel->dashboard($params, ['task' => 'list-items-in-category']);
        $occasionsDistribution              = $productModel->dashboard($params, ['task' => 'list-items-in-occasion']);
        $collectionsDistribution            = $productModel->dashboard($params, ['task' => 'list-items-in-collection']);

        // Table
        $favoriteProduct                    = $favoriteModel->dashboard($params, ['task' => 'list-items-all']);
        $viewProduct                        = $productModel->dashboard($params, ['task' => 'list-items-view']);

        return view($this->pathViewController.'product', [
            // Summary
            'countAllProduct'               => $countAllProduct['count'],
            'sumInventoryProduct'           => $sumInventoryProduct['sum'],
            'sumSoldProduct'                => $sumSoldProduct['sum'],
            'countDiscountProduct'          => $countDiscountProduct['count'],

            // Bar Chart - Rating
            'ratingHighestProduct'          => $ratingHighestProduct,
            'ratingLowestProduct'           => $ratingLowestProduct,

            // Bart Chart - Inventory & Sold
            'inventoryAndSoldProduct'       => $inventoryAndSoldProduct,

            // Bar Chart - Distribution
            'categoriesDistribution'        => $categoriesDistribution,
            'occasionsDistribution'         => $occasionsDistribution,
            'collectionsDistribution'       => $collectionsDistribution,

            // Table
            'favoriteProduct'               => $favoriteProduct,
            'viewProduct'                   => $viewProduct,

            'params'                        => $params,
        ]);
    }

    public function user(Request $request) {
        $params = null;
        if($request)
            $params = $request->all();
        $params['view_by'] = $request->view_by ? $request->view_by : 'default';
       
        $userModel                          = new UserModel();
        $cartModel                          = new CartModel();
        $cacheModel                         = new CacheModel();
        
        //Summary
        $countAllUser                       = $userModel->dashboard($params, ['task' => 'count-items-all']);
        $countUserHaveOrder                 = $cartModel->dashboard($params, ['task' => 'count-items-have-order']);
        $countUserRecentlyAccess            = $cacheModel->listItems($params, ['task' => 'list-items']);

        // Table      
        $tableListUser                      = $userModel->dashboard($params, ['task' => 'list-items-activity']);

        return view($this->pathViewController.'user', [
            // Summary
            'countAllUser'                  => $countAllUser['count'],
            'countUserHaveOrder'            => $countUserHaveOrder,
            'countUserRecentlyAccess'       => $countUserRecentlyAccess['count'],

            // Table
            'tableListUser'                 => $tableListUser,
           
            // Params
            'params'                        => $params,
        ]);
    }

    public function search(Request $request){
        $params = $request->all();

        $productModel                       = new ProductModel();
        $item = $productModel->dashboard($params, ['task' => 'list-items-inventory-sold']);
        return $item;

    }
}