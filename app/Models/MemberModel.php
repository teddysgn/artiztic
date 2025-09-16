<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class MemberModel extends AdminModel
{
    public function __construct(){
        $this->table = 'member';
        $this->folderUpload = 'member';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'name', 'discount', 'min', 'created', 'created_by', 'modified', 'modified_by');

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

        if($option['task'] == 'default-list-items'){
            $result = self::select('id', 'name', 'price', 'size', 'color', 'quantity', 'picture')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-user-list-items'){
            $result = self::select('id', 'name', 'discount', 'min')
                            ->orderBy('min', 'asc')
                            ->get()
                            ->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'discount', 'min')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-get-item'){
                $result = self::select('id', 'name', 'discount')
                ->where('id', '=', $params['id'])
                ->first();
                if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-user-get-max-item'){
            $result = self::select(DB::raw('MAX(`min`) AS `max`'))
                            ->first();
            if($result) $result = $result->toArray();
    }
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;
       
        if($option['task'] == 'add-item'){
            $params['min'] = str_replace(',', '', $params['min']);
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by']     = Auth::user()->fullname;
            $data['created']        = date('Y-m-d H:i:s');
           
            self::insert($data);
            return $data['id'];
        }

        if($option['task'] == 'edit-item'){
            $params['min'] = str_replace(',', '', $params['min']);

            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
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
            $result = self::where('id', $params['id'])
                        ->delete();
        }
        return $result;
    }
}