<?php
 
namespace App\Models;
use App\Models\CategoryModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class CartDetailModel extends AdminModel
{
    public function __construct(){
        $this->table = 'cart_detail';
        $this->folderUpload = 'cart_detail';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $this->table        = 'cart_detail as cd';
            $query = self::select('cd.id', 'cd.cart_id as identify', 'cd.product_id', 'cd.size', 'cd.color', 'cd.quantity', 'p.picture1 as product_picture1', 'p.name as product_name', 'p.price as product_price', 'p.discount as product_discount', 'p.style as product_style', 'ca.name as category_name')
                                    ->leftJoin('product as p', 'cd.product_id', '=', 'p.id')
                                    ->leftJoin('category as ca', 'p.category_id', '=', 'ca.id')
                                    ->where('cd.cart_id', '=', $params['id']);
            $result = $query->orderBy('product_id', 'desc')
                            ->get()->toArray();
        }

        if($option['task'] == 'default-list-items'){
            $result = self::select('id', 'name', 'price', 'size', 'color', 'quantity', 'picture')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-history-list-items'){
            $this->table        = 'cart_detail as cd';
            $query = self::select('cd.id', 'cd.cart_id as identify', 'cd.product_id', 'cd.price', 'cd.discount', 'cd.size', 'cd.color', 'cd.quantity', 'p.style as style', 'p.picture1 as product_picture1', 'p.name as product_name', 'p.price as product_price', 'p.size as product_size', 'p.color as product_color', 'p.style as product_style', 'c.total')
                                    ->leftJoin('product as p', 'cd.product_id', '=', 'p.id')
                                    ->leftJoin('cart as c', 'cd.cart_id', '=', 'c.id');
            if($params['id'] != ''){
                $query->where('cd.cart_id', '=', $params['id']);
            }
            $result = $query->orderBy('cd.id', 'desc')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-exchange-list-items'){
            $this->table        = 'cart_detail as cd';
            $query = self::select('cd.id', 'cd.cart_id as identify', 'cd.product_id', 'cd.size', 'cd.color', 'cd.quantity', 'p.picture1 as product_picture1', 'p.name as product_name', 'p.price as product_price', 'p.discount as product_discount', 'p.style as product_style', 'ca.name as category_name')
                                    ->leftJoin('product as p', 'cd.product_id', '=', 'p.id')
                                    ->leftJoin('category as ca', 'p.category_id', '=', 'ca.id')
                                    ->where('cd.cart_id', '=', $params['cart_id']);
            $result = $query->orderBy('product_id', 'desc')
                            ->get()->toArray();
        }

        if($option['task'] == 'default-cancel-list-items'){
            $this->table        = 'cart_detail as cd';
            $query = self::select('cd.id', 'cd.cart_id as identify', 'cd.product_id', 'cd.size', 'cd.color', 'cd.quantity', 'p.picture1 as product_picture1', 'p.name as product_name', 'p.price as product_price', 'p.discount as product_discount', 'ca.name as category_name')
                                    ->leftJoin('product as p', 'cd.product_id', '=', 'p.id')
                                    ->leftJoin('category as ca', 'p.category_id', '=', 'ca.id')
                                    ->where('cd.cart_id', '=', $params['id']);
            $result = $query->orderBy('product_id', 'desc')
                            ->get()->toArray();
        }


        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'product_id', 'price', 'quantity', 'picture_profile')
                        ->where('id', '=', $params['id'])
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
}