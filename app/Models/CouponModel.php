<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class CouponModel extends AdminModel
{
    public function __construct(){
        $this->table = 'coupon';
        $this->folderUpload = 'coupon';
        $this->fieldSearchAccepted = [
            'id',
            'name',
            'code',
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'code', 'name', 'value', 'maximum', 'status', 'expired', 'created', 'created_by', 'modified', 'modified_by');
            
            if($params['filter']['status'] != 'all'){
                $query->where('status', '=', $params['filter']['status']);
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

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
                            
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'code', 'value', 'status', 'expired', 'maximum')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-get-item'){
            $result = self::select('id', 'name', 'value', 'maximum')
            ->where('code', '=', $params['coupon'])
            ->where('status', '=', 'active')
            ->where('expired', '>=', date('Y-m-d', time()))
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
        if($option['task'] == 'default-update-status'){
            self::where('code', $params)->update(['status' => 'inactive']);
        }

        if($option['task'] == 'change-status'){
            $status = $params['currentStatus'] == 'active' ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if($option['task'] == 'add-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created'] = date('Y-m-d H:i:s');
            $data['created_by'] = Auth::user()->fullname;
           
            self::insert($data);
            return $data['id'];
        }

        if($option['task'] == 'add-item-multiple'){
            for($i = 0; $i < $params['quantity_multiple']; $i++){
                $data['code']       = Str::random(8);
                $data['value']      = $params['value_multiple'];
                $data['name']       = $params['name_multiple'];
                $data['status']     = $params['status_multiple'];
                $data['expired']    = $params['expired_multiple'];
                $data['maximum']    = $params['maximum_multiple'];
                $data['created']    = date('Y-m-d H:i:s');
                $data['created_by'] = Auth::user()->fullname;
                self::insert($data);
            }
        }

        if($option['task'] == 'edit-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = Auth::user()->fullname;
            $data['modified'] = date('Y-m-d H:i:s');
            self::where('id', $params['id'])
               ->update($data);
        }

        return $result;
    }

    public function deleteItem($params = null, $option = null){
        $result = null;
        if($option['task'] = 'delete-item'){
            $result = self::where('id', $params['id'])
                        ->delete();
        }
        return $result;
    }
}