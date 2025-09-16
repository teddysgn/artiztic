<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class RefundModel extends AdminModel
{
    public function __construct(){
        $this->table = 'refund';
        $this->folderUpload = 'refund';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'cart_id', 'status', 'reason', 'created', 'created_by');

            $result = $query->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-list-items'){
            $result = self::select('id', 'cart_id', 'status', 'reason', 'created', 'created_by')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'list-items-in-selectbox'){
            $result = self::select('id', 'name')
                        ->where('status', '=', 'active')
                        ->orderBy('name', 'asc')
                        ->pluck('name', 'id')
                        ->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'status', 'reason', 'created', 'created_by', 'amount', 'cart_id')
                        ->where('cart_id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-name'){
            $result = self::select('id', 'name')
                        ->where('id', '=', $params['id'])
                        ->first();
        }

        if($option['task'] == 'default-get-item'){
            $result = self::select('id', 'status', 'reason', 'created', 'created_by')
                        ->where('cart_id', '=', $params['cart_id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-history-get-item'){
            $result = self::select('id', 'cart_id', 'status', 'reason', 'created', 'created_by')
                        ->where('cart_id', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-exchange-get-item'){
            $this->table        = 'refund as r';
            $result = self::select('r.id', 'r.cart_id', 'r.status', 'r.reason', 'r.amount', 'r.created', 'r.created_by', 'c.address', 'c.phone', 'c.fullname', 'c.email')
                        ->leftJoin('cart as c', 'r.cart_id', '=', 'c.id')
                        ->where('r.id', $params)
                        ->first();
            if($result) $result = $result->toArray();
    }

        
        return $result;
    }

    public function countItems($params = null, $option = null){
        $result = null;
        if($option['task'] = 'count-status'){
            $query = self::groupBy('status')
                        ->select(DB::raw('COUNT(`id`) AS `count`, `status`'));
                            

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

            $result = $query->get()->toArray();
        }
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;

        if($option['task'] == 'change-status'){
            self::where('cart_id', $params['id'])->update(['status' => $params['currentRefund']]);
            return self::where('cart_id', $params['id'])->get('id')->first();
        }

        if($option['task'] == 'add-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['status']         = 'pending';
            $data['created_by']     = Auth::user()->fullname;
            $data['created']        = date('Y-m-d H:i:s');
            self::insert($data);
            return DB::getPdo()->lastInsertId();
        }

        if($option['task'] == 'edit-item'){
            $item = self::getItem($params, ['task' => 'get-name']);

            if(!empty($params['picture_profile'])){
                $params['picture_profile'] = $this->deletePictureAndChangeNameDirectory($params['picture_profile'], $params['hidden_picture_profile'], $item['name']);
            }
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = 'admin';
            $data['modified'] = date('Y-m-d H:i:s');
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

        if($option['task'] == 'count-items-refunded'){
            $query = self::select(DB::raw("COUNT(id) as count"));if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->where('status', 'approved')
                            ->get()->first();
        }

        if($option['task'] == 'list-items-refunded'){
            $query = self::select(DB::raw("COUNT(id) as count , DATE(created) as date"));
            if(isset($params['from-date']) && isset($params['to-date'])){
                $from   = date('Y-m-d', strtotime($params['from-date']));
                $to     = date('Y-m-d', strtotime($params['to-date']));

                $query->whereRaw("DATE(created) >= '$from' AND DATE(created) <= '$to'");
            }
            $result = $query->groupBy(DB::raw("date"))
                            ->get()->toArray();
        }

        
        return $result;
    }
}