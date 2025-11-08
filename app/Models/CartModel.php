<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
use Carbon\Carbon;
 
class CartModel extends AdminModel
{
    public function __construct(){
        $this->table = 'cart';
        $this->folderUpload = 'cart';
        $this->fieldSearchAccepted = [
            'c.id',
            'u.fullname'
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $this->table        = 'cart as c';
            $query = self::select('c.id as identify', 'c.total', 'c.status', 'c.note', 'c.payment_method', 'c.invoice', 'c.status', 'c.cancel', 'c.cancel_date', 'c.reason_cancel', 'c.cancel_by', 'c.created', 'u.fullname as customer', 'co.value as coupon_value')
                                    ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                                    ->leftJoin('coupon as co', 'c.coupon', '=', 'co.code');
            
            if($params['filter']['status'] != 'all'){
                $query->where('c.status', '=', $params['filter']['status']);
            }

            if($params['filter']['method'] != 'all'){
                $query->where('c.payment_method', '=', $params['filter']['method']);
            }

            if($params['filter']['cancel'] != 'all'){
                $query->where('c.cancel', '=', $params['filter']['cancel']);
            }

            // Search
            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if($params['filter']['order_by'] != 'all'){
                switch($params['filter']['order_by']){
                    case 'today';
                        $query->whereRaw('Date(c.created) = CURDATE()');
                        break;
                    case 'last_week';
                        $query->whereRaw('Date(c.created) >= DATE(NOW()) - INTERVAL 7 DAY');
                        break; 
                    case 'last_month';
                        $query->whereRaw('MONTH(c.created) = MONTH(CURRENT_TIMESTAMP) AND YEAR(c.created) = YEAR(CURRENT_TIMESTAMP)');
                        break;
                }
            }

            if($params['filter']['sort_by'] != 'all'){
                switch($params['filter']['sort_by']){
                    case 'newest';
                        $query->orderBy('c.created', 'desc');
                        break; 
                    case 'latest';
                        $query->orderBy('c.created', 'asc');
                        break; 
                }
            } else {
                $query->orderBy('c.created', 'desc');
            }

            $result = $query->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($option['task'] == 'dashboard-list-items'){
            $result = self::select(DB::raw("COUNT(id) as count , DATE(created) as date"))->groupBy(DB::raw("date"))->get()->toArray();
        }

        if($option['task'] == 'default-list-items'){
            $result = self::select('id', 'name', 'price', 'size', 'color', 'quantity', 'picture')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-history-list-items'){
            $query = self::select('id as cart_id', 'total', 'discount', 'coupon_value', 'payment_method', 'created', 'status', 'cancel', 'cancel_date', 'cancel_by', 'modified')
                            ->where('user_id', '=', $params['user_id']);
            $result = $query->orderBy('created', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }


        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $this->table        = 'cart as c';
            $result = self::select('c.id as cart_id', 'c.fullname', 'c.email', 'c.address', 'c.phone', 'c.subtotal', 'c.total', 'c.discount', 'c.member', 'c.coupon_value', 'c.status', 'c.cancel', 'c.reason_cancel', 'c.cancel_date', 'c.cancel_by', 'c.created',  'u.fullname as user_name')
                                    ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                                    ->where('c.id', '=', $params['id'])
                                    ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-item-to-info-user'){
            $this->table        = 'cart as c';
            $result = self::select('c.id as cart_id', 'u.fullname as user_fullname', 'u.email as user_email')
                                    ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                                    ->where('c.id', '=', $params['id'])
                                    ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-get-item'){
            $this->table        = 'cart as c';
            $result = self::select('c.id')
                            ->leftJoin('cart_detail as cd', 'c.id', '=', 'cd.cart_id')
                            ->where('cd.product_id', '=', $params['product_id'])
                            ->where('c.status', '=', 'delivered')
                            ->where('c.user_id', '=', Auth::user()->id)
                            ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-user-get-sum-total-item'){
            $result = self::select('total')
                            ->where('user_id', '=', Auth::user()->id)
                            ->where('status', '=', 'delivered')
                            ->where('cancel', '=', 'default');
            if($result) $result = $result->get()->toArray();
        }

        if($option['task'] == 'default-history-get-item'){
            $this->table        = 'cart as c';
            $result = self::select('c.id as cart_id', 'c.fullname', 'c.created', 'c.payment_method', 'c.email', 'c.address', 'c.phone', 'c.total', 'c.status', 'c.cancel', 'c.cancel_date', 'c.cancel_by', 'c.reason_cancel', 'u.fullname as user_name', 'subtotal', 'total', 'member', 'coupon_value', 'discount', 'c.modified')
                            ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                            ->where('c.id', '=', $params['id'])
                            ->where('c.user_id', '=', Auth::user()->id)
                            ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-cancel-get-item'){
            $this->table        = 'cart as c';
            $result = self::select('c.id as cart_id', 'c.fullname', 'c.created', 'c.payment_method', 'c.email', 'c.address', 'c.phone', 'c.total', 'c.status', 'c.cancel', 'c.cancel_date', 'c.cancel_by', 'c.reason_cancel', 'u.fullname as user_name', 'subtotal', 'total', 'member', 'coupon_value', 'discount')
                            ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                            ->where('c.id', '=', $params['id'])
                            ->where('c.user_id', '=', Auth::user()->id)
                            ->first();
            if($result) $result = $result->toArray();
        }

        return $result;
    }

    public function countItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'count-status'){
            $this->table        = 'cart as c';
            $query = self::groupBy('c.status')
                        ->select(DB::raw('COUNT(`c`.`id`) AS `count`, `c`.`status`'))
                        ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                        ->leftJoin('coupon as co', 'c.coupon', '=', 'co.code');

            if($params['filter']['method'] != 'all'){
                $query->where('c.payment_method', '=', $params['filter']['method']);
            }

            if($params['filter']['cancel'] != 'all'){
                $query->where('c.cancel', '=', $params['filter']['cancel']);
            }
                            

            // Search
            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if($params['filter']['order_by'] != 'all'){
                switch($params['filter']['order_by']){
                    case 'today';
                        $query->whereRaw('Date(c.created) = CURDATE()');
                        break;
                    case 'last_week';
                        $query->whereRaw('Date(c.created) >= DATE(NOW()) - INTERVAL 7 DAY');
                        break; 
                    case 'last_month';
                        $query->whereRaw('MONTH(c.created) = MONTH(CURRENT_TIMESTAMP) AND YEAR(c.created) = YEAR(CURRENT_TIMESTAMP)');
                        break;
                }
            }

            if($params['filter']['sort_by'] != 'all'){
                switch($params['filter']['sort_by']){
                    case 'newest';
                        $query->orderBy('c.created', 'desc');
                        break; 
                    case 'latest';
                        $query->orderBy('c.created', 'asc');
                        break; 
                }
            }

            $result = $query->get()->toArray();
        }

        if($option['task'] == 'count-cancel'){
            $this->table        = 'cart as c';
            $query = self::groupBy('c.cancel')
                        ->select(DB::raw('COUNT(`c`.`id`) AS `count`, `c`.`cancel`'))
                        ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                        ->leftJoin('coupon as co', 'c.coupon', '=', 'co.code');

            if($params['filter']['method'] != 'all'){
                $query->where('c.payment_method', '=', $params['filter']['method']);
            }

            if($params['filter']['status'] != 'all'){
                $query->where('c.status', '=', $params['filter']['status']);
            }
                            

            // Search
            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if($params['filter']['order_by'] != 'all'){
                switch($params['filter']['order_by']){
                    case 'today';
                        $query->whereRaw('Date(c.created) = CURDATE()');
                        break;
                    case 'last_week';
                        $query->whereRaw('Date(c.created) >= DATE(NOW()) - INTERVAL 7 DAY');
                        break; 
                    case 'last_month';
                        $query->whereRaw('MONTH(c.created) = MONTH(CURRENT_TIMESTAMP) AND YEAR(c.created) = YEAR(CURRENT_TIMESTAMP)');
                        break;
                }
            }

            if($params['filter']['sort_by'] != 'all'){
                switch($params['filter']['sort_by']){
                    case 'newest';
                        $query->orderBy('c.created', 'desc');
                        break; 
                    case 'latest';
                        $query->orderBy('c.created', 'asc');
                        break; 
                }
            }

            $result = $query->get()->toArray();
        }

        if($option['task'] == 'count-method'){
            $this->table        = 'cart as c';
            $query = self::groupBy('payment_method')
                        ->select(DB::raw('COUNT(`c`.`id`) AS `count`, `c`.`payment_method`'))
                        ->leftJoin('user as u', 'c.user_id', '=', 'u.id')
                        ->leftJoin('coupon as co', 'c.coupon', '=', 'co.code');

            if($params['filter']['status'] != 'all'){
                $query->where('c.status', '=', $params['filter']['status']);
            }

            if($params['filter']['cancel'] != 'all'){
                $query->where('c.cancel', '=', $params['filter']['cancel']);
            }
                            

            // Search
            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            if($params['filter']['order_by'] != 'all'){
                switch($params['filter']['order_by']){
                    case 'today';
                        $query->whereRaw('Date(c.created) = CURDATE()');
                        break;
                    case 'last_week';
                        $query->whereRaw('Date(c.created) >= DATE(NOW()) - INTERVAL 7 DAY');
                        break; 
                    case 'last_month';
                        $query->whereRaw('MONTH(c.created) = MONTH(CURRENT_TIMESTAMP) AND YEAR(c.created) = YEAR(CURRENT_TIMESTAMP)');
                        break;
                }
            }

            if($params['filter']['sort_by'] != 'all'){
                switch($params['filter']['sort_by']){
                    case 'newest';
                        $query->orderBy('c.created', 'desc');
                        break; 
                    case 'latest';
                        $query->orderBy('c.created', 'asc');
                        break; 
                }
            }

            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;

        if($option['task'] == 'change-status'){
            self::where('id', $params['id'])->update([
                'status'        => $params['currentStatus'],
                'modified'      => date('Y-m-d H:i:s'),
                'modified_by'   => Auth::user()->fullname
            ]);
        }

        if($option['task'] == 'change-cancel'){
            self::where('id', $params['id'])->update(['cancel' => $params['currentCancel']]);
        }

        if($option['task'] == 'request-cancel'){
            $result = date('Y-m-d H:i:s');
            self::where('id', $params['id'])->update([
                'cancel'        => 'pending',
                'reason_cancel' => $params['reason_cancel'],
                'cancel_date'   => $result,
                'cancel_by'     => Auth::user()->fullname,
            ]);
        }

        if($option['task'] == 'order-cancel'){
            self::where('id', $params['id'])->update([
                'cancel'        => 'approved',
                'reason_cancel' => $params['reason_cancel'],
                'cancel_date'   => date('Y-m-d H:i:s'),
                'cancel_by'     => 'Artiz',
            ]);
        }

        if ($option['task'] == 'add-item') {
            $userModel = new UserModel();
            $infoUser = $userModel->getItem(Auth::user(), ['task' => 'get-item']);
            $dataUser = [];
        
            // 🧩 Cập nhật thông tin người dùng nếu trống
            if (empty($infoUser['phone']) && !empty($params['phone'])) {
                $dataUser['phone'] = $params['phone'];
            }
        
            if (empty($infoUser['address']) && !empty($params['address'])) {
                $dataUser['address'] = $params['address'];
            }
        
            if (!empty($dataUser)) {
                UserModel::where('id', Auth::user()->id)->update($dataUser);
            }
        
            // 🔑 Tạo ID ngẫu nhiên cho item
            $id = Str::random(8);
        
            // 🧾 Xử lý hóa đơn (invoice)
            if (!empty($params['invoice'])) {
                $folderPath = $this->folderUpload . '/' . $id;
                $disk = Storage::disk('artiz_storage');
        
                // 🧱 Tạo thư mục nếu chưa có, set quyền ghi
                if (!$disk->exists($folderPath)) {
                    $fullPath = $disk->path($folderPath);
                    @mkdir($fullPath, 0775, true);
                    @chmod($fullPath, 0775);
                }
        
                // 📎 Lưu file invoice
                $invoice = $params['invoice'];
                $params['invoice'] = Str::random(10) . '.' . $invoice->clientExtension();
                $invoice->storeAs($folderPath, $params['invoice'], 'artiz_storage');
            }
        
            // 💾 Chuẩn bị dữ liệu lưu vào DB
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['id']     = $id;
            $data['status'] = 'pending';
        
            self::insert($data);
        
            return $data['id'];
        }


        if($option['task'] == 'edit-item'){
            $data['status']         = $params['status'];
            $data['modified_by']    = Auth::user()->fullname;
            $data['modified']       = date('Y-m-d H:i:s');
            self::where('id', $params['id'])
               ->update($data);
        }

        return $result;
    }

    public function deleteItem($params = null, $option = null){
        $result = null;
        if($option['task'] = 'delete-item'){
            $item = self::getItem($params, ['task' => 'get-name']);
            Storage::disk('artiz_storage')->deleteDirectory($this->folderUpload . '/' . $item['name']);
            $result = self::where('id', $params['id'])
                        ->delete();
        }
        return $result;
    }

    public function dashboard($params = null, $option = null){
        $result = null;

        // Summary
        if($option['task'] == 'count-items-all'){
            $query = self::select(DB::raw("COUNT(id) as count"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }

            $result = $query->get()->first();
        }

        if($option['task'] == 'count-items-delivered'){
            $query = self::select(DB::raw("COUNT(id) as count"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->where('status', 'delivered')
                            ->get()->first();
        }

        if($option['task'] == 'count-items-cancelled'){
            $query = self::select(DB::raw("COUNT(id) as count"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->where('cancel', 'approved')
                            ->get()->first();
        }

        if($option['task'] == 'average-order-value'){
            $querySum   = self::select(DB::raw("(REPLACE(total, '.', '')) as total"));
                if(isset($params['from-date']) && isset($params['to-date'])){
                    $from   = date('Y-m-d', strtotime($params['from-date']));
                    $to     = date('Y-m-d', strtotime($params['to-date']));

                    $querySum->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
                }
            $resultSum = $querySum->get()->toArray();

            $queryCount = self::select(DB::raw("COUNT(id) as count"));
                if(isset($params['from-date']) && isset($params['to-date'])){
                    $from   = date('Y-m-d', strtotime($params['from-date']));
                    $to     = date('Y-m-d', strtotime($params['to-date']));

                    $queryCount->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
                }
            $resultCount = $queryCount->get()->first();

            $sum = 0;
            foreach($resultSum as $key => $value)
                $sum += $value['total'];

            $result = $sum > 0 ? $sum / $resultCount['count'] : 0;
        }

        if($option['task'] == 'sum-revenue'){
            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $resultSum = $query->where('status', 'delivered')
                                ->get()->toArray();

            $sum = 0;
            foreach($resultSum as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        if($option['task'] == 'sum-revenue-cash-on-delivery'){
            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $resultSum = $query->where('payment_method', 'cash on delivery')
                                ->where('status', 'delivered')
                                ->get()->toArray();

            $sum = 0;
            foreach($resultSum as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        if($option['task'] == 'sum-revenue-mobile-banking'){
            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $resultSum = $query->where('payment_method', 'mobile banking')
                                ->where('status', 'delivered')
                                ->get()->toArray();

            $sum = 0;
            foreach($resultSum as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }


        // Bar Chart - Cart
        if($option['task'] == 'list-items-all'){
            $query = self::select(DB::raw("COUNT(id) as count , DATE(created) as date"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->groupBy(DB::raw("date"))
            ->get()->toArray();
        }

        if($option['task'] == 'list-items-delivered'){
            $query = self::select(DB::raw("COUNT(id) as count , DATE(created) as date"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->where('status', 'delivered')
                            ->groupBy(DB::raw("date"))
                            ->get()->toArray();
        }

        if($option['task'] == 'list-items-cancelled'){
            $query = self::select(DB::raw("COUNT(id) as count , DATE(created) as date"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->where('cancel', 'approved')
                            ->groupBy(DB::raw("date"))
                            ->get()->toArray();
        }

        // Bar Chart - Sold
        // if($option['task'] == 'list-items-sold'){
        //     $this->table        = 'cart as c';
        //     $query   = self::select(DB::raw("SUM(cd.quantity) as sum, COUNT(cd.product_id) as count, p.name as product_name, p.picture1 as product_picture"))
        //                 ->leftJoin('cart_detail as cd', 'cd.cart_id', '=', 'c.id')
        //                 ->rightJoin('product as p', 'cd.product_id', '=', 'p.id')
        //                 ->where('c.cancel', 'default');
        //     if(isset($params['from-date']) && isset($params['to-date'])){
        //         $from   = date('Y-m-d', strtotime($params['from-date']));
        //         $to     = date('Y-m-d', strtotime($params['to-date']));

        //         $query->whereRaw("DATE(c.created) >= '$from' AND DATE(c.created) <= '$to'");
        //     }
        //     $result = $query->groupBy(DB::raw("cd.product_id, product_name, product_picture"))
        //                     ->orderBy('sum', 'desc')
        //                     ->limit(10)
        //                     ->get()->toArray();
        // }
        
        // Bar Chart - Customer
        if($option['task'] == 'list-items-customer'){
            $this->table        = 'cart as c';
            $query = self::select(DB::raw("(SUM(REPLACE(c.total, '.', ''))) as sum, COUNT(c.id) as count, u.fullname as user_fullname"))
                            ->leftJoin('user as u', 'c.user_id', '=', 'u.id');
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(c.created) >= '$from' AND DATE(c.created) <= '$to'");
            }
            $query->where('c.status', 'delivered')
                ->where('c.cancel', 'default')
                ->groupBy(DB::raw("user_fullname"));
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(10);
            }
            $result = $query->get()->toArray();
        }
        // Line Chart - Revenue Week
        if($option['task'] == 'list-items-this-week'){
            $now = Carbon::now();

            // This week
            $startThisWeek      = $now->startOfWeek()->format('Y-m-d');
            $endThisWeek        = $now->endOfWeek()->format('Y-m-d');
          
            $result = self::select(DB::raw("SUM(REPLACE(total, '.', '')) as sum, DAYNAME(DATE(created)) AS date"))
                            ->whereRaw("DATE(created) >= '$startThisWeek' AND DATE(created) <= '$endThisWeek'")
                            ->where('status', 'delivered')
                            ->groupBy(DB::raw("date"))
                            ->orderBy('date')
                            ->get()->toArray();
        }

        if($option['task'] == 'sum-revenue-this-week'){
            $now = Carbon::now();

            // This week
            $startThisWeek      = $now->startOfWeek()->format('Y-m-d');
            $endThisWeek        = $now->endOfWeek()->format('Y-m-d');

            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"))
                            ->whereRaw("DATE(created) >= '$startThisWeek' AND DATE(created) <= '$endThisWeek'")
                            ->where('status', 'delivered')
                            ->get()->toArray();

            $sum = 0;
            foreach($query as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        if($option['task'] == 'list-items-previous-week'){
            $now = Carbon::now();

            // Previous Week
            $startPreviousWeek  = $now->startOfWeek()->subWeek()->format('Y-m-d');
            $endPreviousWeek    = $now->endOfWeek()->format('Y-m-d');

          
            $result = self::select(DB::raw("SUM(REPLACE(total, '.', '')) as sum, DAYNAME(DATE(created)) AS date"))
                        ->whereRaw("DATE(created) >= '$startPreviousWeek' AND DATE(created) <= '$endPreviousWeek'")
                        ->where('status', 'delivered')
                        ->groupBy(DB::raw("date"))
                        ->orderBy('date')
                        ->get()->toArray();
        }

        if($option['task'] == 'sum-revenue-previous-week'){
            $now = Carbon::now();

            // This week
            $startPreviousWeek  = $now->startOfWeek()->subWeek()->format('Y-m-d');
            $endPreviousWeek    = $now->endOfWeek()->format('Y-m-d');

            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"))
                            ->whereRaw("DATE(created) >= '$startPreviousWeek' AND DATE(created) <= '$endPreviousWeek'")
                            ->where('status', 'delivered')
                            ->get()->toArray();

            $sum = 0;
            foreach($query as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        // Bar Chart - Revenue Month
        if($option['task'] == 'list-items-this-month'){
            $now = Carbon::now();

            // This Month
            $startThisMonth      = $now->startOfMonth()->format('Y-m-d');
            $endThisMonth        = $now->endOfMonth()->format('Y-m-d');
            
            $result = self::select(DB::raw("SUM(REPLACE(total, '.', '')) as sum, (DAY(created)) AS date"))
                            ->whereRaw("DATE(created) >= '$startThisMonth' AND DATE(created) <= '$endThisMonth'")
                            ->where('status', 'delivered')
                            ->groupBy(DB::raw("date"))
                            ->orderBy('date')
                            ->get()->toArray();
        }

        if($option['task'] == 'sum-revenue-this-month'){
            $now = Carbon::now();

            // This week
            $startThisMonth      = $now->startOfMonth()->format('Y-m-d');
            $endThisMonth        = $now->endOfMonth()->format('Y-m-d');

            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"))
                            ->whereRaw("DATE(created) >= '$startThisMonth' AND DATE(created) <= '$endThisMonth'")
                            ->where('status', 'delivered')
                            ->get()->toArray();

            $sum = 0;
            foreach($query as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        if($option['task'] == 'list-items-previous-month'){
            $now = Carbon::now();

            // Previous Month
            $startPreviousMonth  = $now->startOfMonth()->subMonth()->format('Y-m-d');
            $endPreviousMonth    = $now->endOfMonth()->format('Y-m-d');

          
            $result = self::select(DB::raw("SUM(REPLACE(total, '.', '')) as sum,(DAY(created)) AS date"))
                        ->whereRaw("DATE(created) >= '$startPreviousMonth' AND DATE(created) <= '$endPreviousMonth'")
                        ->where('status', 'delivered')
                        ->groupBy(DB::raw("date"))
                        ->orderBy('date')
                        ->get()->toArray();
        }

        if($option['task'] == 'sum-revenue-previous-month'){
            $now = Carbon::now();

            // This week
            $startPreviousMonth  = $now->startOfMonth()->subMonth()->format('Y-m-d');
            $endPreviousMonth    = $now->endOfMonth()->format('Y-m-d');

            $query = self::select(DB::raw("(REPLACE(total, '.', '')) as total"))
                            ->whereRaw("DATE(created) >= '$startPreviousMonth' AND DATE(created) <= '$endPreviousMonth'")
                            ->where('status', 'delivered')
                            ->get()->toArray();

            $sum = 0;
            foreach($query as $key => $value)
                $sum += $value['total'];

            $result = $sum;
        }

        // Table
        if($option['task'] == 'list-items-by-date'){
            $this->table        = 'cart as c';
            $result   = self::select(DB::raw("SUM(REPLACE(c.total, '.', '')) as sum, DATE(c.created) as date, SUM(cd.quantity) / COUNT(cd.cart_id) as quantity" ))
                        ->leftJoin('cart_detail as cd', 'c.id', '=', 'cd.cart_id')
                        ->where('status', 'delivered')
                        ->groupBy(DB::raw("date"))
                        ->orderBy('date', 'desc')
                        ->limit(7)
                        ->get()->toArray();
            
        }

        // User Action
        if($option['task'] == 'count-items-have-order'){
            $query = self::select(DB::raw("COUNT(user_id) as count"))
                            ->groupBy('user_id')
                            ->get()->toArray();
            $result = count($query);
        }

        return $result;
    }
}