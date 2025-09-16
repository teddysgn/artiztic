<?php
 
namespace App\Models;
use App\Models\CategoryModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class FavoriteModel extends AdminModel
{
    const CREATED_AT        = null;
    const UPDATED_AT        = null;

    public function __construct(){
        $this->table        = 'favorite';
        $this->folderUpload = 'favorite';
        $this->fieldSearchAccepted = [
            'u.fullname',
            'p.name',
        ];
        
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $this->table        = 'favorite as f';
            $query = self::select('f.id', 'f.user_id', 'f.product_id', 'u.fullname as user_name', 'p.name as product_name', 'p.picture1 as product_picture')
                                    ->leftJoin('user as u', 'f.user_id', '=', 'u.id')
                                    ->leftJoin('product as p', 'f.product_id', '=', 'p.id');
            
    
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
            $query = self::select('id', 'user_id', 'product_id')
                                    ->where('user_id', '=', $params['user_id']);
            $result = $query->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'user_id', 'product_id')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'default-get-item'){
            $result = self::select('id', 'user_id', 'product_id')
                        ->where('user_id', '=', $params['user_id'])
                        ->where('product_id', '=', $params['product_id'])
                        ->first();
            if($result) $result = $result->toArray();
        }
        
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;
      
        if($option['task'] == 'add-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            self::insert($data);

            $result = 'remove';
        }

        if($option['task'] == 'remove-item'){
            $result = self::where('user_id', '=', $params['user_id'])
                        ->where('product_id', '=', $params['product_id'])
                        ->delete();

            $result = 'add';
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

    public function dashboard($params = null, $option = null){
        $result = null;

        // Summary
        if($option['task'] == 'list-items-all'){
            $this->table        = 'favorite as f';
            $query = self::select(DB::raw("COUNT(f.id) as count, p.name as product_name, p.picture1 as product_picture"))
                            ->leftJoin('product as p', 'f.product_id', '=', 'p.id')
                            ->groupBy(DB::raw("f.product_id, product_name, product_picture"));
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(5);
            }
            $result = $query->get()->toArray();
        }     

        return $result;
    }
}