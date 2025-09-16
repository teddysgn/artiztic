<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class RefundDetailModel extends AdminModel
{
    public function __construct(){
        $this->table = 'refund_detail';
        $this->folderUpload = 'refund_detail';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $this->table        = 'refund_detail as rd';
            $query = self::select('rd.id', 'rd.quantity', 'rd.color', 'rd.size', 'rd.product_id', 'rd.to_color', 'rd.to_size', 'rd.to_product', 'p.name as product_name', 'p.picture1 as product_picture1', 'p.style as product_style', 'ca.name as category_name')
                            ->leftJoin('product as p', 'rd.to_product', '=', 'p.id')
                            ->leftJoin('category as ca', 'p.category_id', '=', 'ca.id')
                            ->where('rd.refund_id', '=', $params['id']);

            $result = $query->orderBy('product_id', 'desc')
                            ->get()->toArray();
        }

        if($option['task'] == 'default-exchange-list-items'){
            $this->table        = 'refund_detail as rd';
            $result = self::select('rd.id', 'rd.quantity', 'rd.color', 'rd.size', 'rd.product_id', 'rd.to_color', 'rd.to_size', 'rd.to_product', 'p.name as product_name', 'p.picture1 as product_picture1', 'p.style as product_style', 'ca.name as category_name')
                            ->leftJoin('product as p', 'rd.to_product', '=', 'p.id')
                            ->leftJoin('category as ca', 'p.category_id', '=', 'ca.id')
                            ->where('rd.refund_id', '=', $params)
                            ->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'ordering', 'status', 'picture_profile')
                        ->where('id', '=', $params['id'])
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
                ->where('cart_id', $params['id'])
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
            $status = $params['currentStatus'] == 'active' ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if($option['task'] == 'add-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            self::insert($data);
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
}