<?php
 
namespace App\Models;
use App\Models\SkuModel as MainModel;
use App\Models\ProductModel;
use App\Models\ColorModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class SkuModel extends AdminModel
{
    public function __construct(){
        $this->table = 'sku';
        $this->folderUpload = 'sku';
        $this->fieldSearchAccepted = [
            'id',
            'barcode',
            'style',
            'color',
            'size',
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'barcode', 'size', 'quantity', 'stock', 'color', 'style', 'created', 'created_by');
            
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
            $result = self::select('id', 'size', 'quantity', 'stock', 'color', 'style')
                            ->where('style', '=', $params['style'])
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'default-list-items-by-size'){
            $colorModel   = new ColorModel();
            $color        = $colorModel->getitem($params['color_id'], ['task' => 'get-name']);
            $result = self::select('id', 'stock', 'size')
                        ->where('style', '=', $params['style'])
                        ->where('color', '=', $color['name'])
                        ->where('stock', '>', '0')
                        ->get()
                        ->toArray();
        }

        if($option['task'] == 'default-refund-list-items-by-size'){
            $result = self::select('id', 'stock', 'size')
                        ->where('style', '=', $params['style'])
                        ->where('color', '=', $params['color'])
                        ->where('stock', '>', '0')
                        ->get()
                        ->toArray();
        }

        

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'style', 'color', 'size', 'quantity')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'check-item'){
            $result = self::select('id', 'stock', 'quantity')
                        ->where('barcode', '=', $params)
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-item-quantity'){
            $result = self::select('id', 'stock')
                        ->where('barcode', 'LIKE', $params)
                        ->first();
        }

        if($option['task'] == 'default-get-item-by-stock'){
            $result = self::select('id', 'stock')
                        ->where('style', '=', $params['style'])
                        ->where('color', '=', $params['color'])
                        ->where('size', '=', $params['size'])
                        ->where('stock', '>', '0')
                        ->first();
        }

        
        return $result;
    }

    public function countItems($params = null, $option = null){
        $result = null;
        
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;

        if($option['task'] == 'update-quantity'){
            $productModel   = new ProductModel();
            $category       = $productModel->getitem($params['id'], ['task' => 'get-category-name']);
            $barcode        = 'ARTIZ-' . Str::upper($category['category_name']) . '-' . Str::upper($params['color'] . '-' . $params['size'] . '-' . $category['style']);
         
            $sku            = $this->getItem($barcode, ['task' => 'get-item-quantity']);
            
            $data['stock'] = $sku['stock'] + $params['quantity'];
            $result = self::where('id', $sku['id'])
               ->update($data);
        }

        if($option['task'] == 'update-quantity-submit-cart'){
            $productModel   = new ProductModel();
            $category       = $productModel->getitem($params['product_id'], ['task' => 'get-category-name']);
            $barcode        = 'ARTIZ-' . Str::upper($category['category_name']) . '-' . Str::upper($params['color'] . '-' . $params['size'] . '-' . $category['style']);
           
            $sku            = $this->getItem($barcode, ['task' => 'get-item-quantity']);           
            $data['stock']  = $sku['stock'] - $params['quantity'];
            
            $result = self::where('id', $sku['id'])
               ->update($data);
        }

        if($option['task'] == 'add-item'){
            foreach($params['form'] as $key => $value){
                if($value['size'] != 'default' || $value['style'] != 'default' || $value['color'] != 'default' || $value['quantity'] != null){
                    $this->table = 'sku';
                    $productModel           = new ProductModel();
                    $category               = $productModel->listItems($value['style'], ['task' => 'list-items-category-name']);

                    $colorModel             = new ColorModel();
                    $color                  = $colorModel->getItem($value['color'], ['task' => 'get-name']);

                    $sizeModel              = new SizeModel();
                    $size                   = $sizeModel->getItem($value['size'], ['task' => 'get-name']);
                
                    $data                   = array_diff_key($value, array_flip($this->crudNoAccepted));
                    $data['created_by']     = 'admin';
                    $data['created']        = date('Y-m-d H:i:s');
                    $data['stock']          = $value['quantity'];
                    $data['quantity']          = $value['quantity'];
                    $data['barcode']        = 'ARTIZ-' . Str::upper($category['category_name']) . '-' . Str::upper($color['name'] . '-' . $size['name'] . '-' . $value['style']);
                    $data['color']          = $color['name'];
                    $data['size']           = $size['name'];

                    $check                  = $this->getItem($data['barcode'], ['task' => 'check-item']);
                    if($check == null){
                        self::insert($data);
                    } else {
                        $data['modified_by']    = Auth::user()->fullname;
                        $data['modified']       = date('Y-m-d H:i:s');
                        $data['stock']          = $value['quantity'] + $check['stock'];
                        $data['quantity']       = $value['quantity'] + $check['quantity'];
                        self::where('barcode', $data['barcode'])
                            ->update($data);
                    }

                    

                    

                    $this->table = 'product';
                    $quantity = $productModel->getItem($value['style'], ['task' => 'get-item-quantity']);
                    $product['quantity'] = $quantity['quantity'] + $value['quantity'];
                    self::where('style', $value['style'])
                    ->update($product);
                }
            }
            
        }

        if($option['task'] == 'edit-item'){
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
            $result = self::where('id', $params['id'])
                        ->delete();
        }
        return $result;
    }

    public function dashboard($params = null, $option = null){
        $result = null;

        // Bar Chart - Sold
        if($option['task'] == 'list-items-sold'){
            $this->table        = 'sku as s';
            $query   = self::select(DB::raw("SUM(s.quantity - s.stock) as sum, p.name as product_name, p.picture1 as product_picture"))
                        ->leftJoin('product as p', 's.style', '=', 'p.style')
                        ->groupBy(DB::raw("s.style, product_name, product_picture"))
                        ->orderBy('sum', 'desc');

            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(10);
            }
            $result = $query->get()->toArray();
        }

        if($option['task'] == 'sum-items-sold'){
            $result = self::select(DB::raw("SUM(quantity - stock) as sum"))
                            ->get()->first();
        }

        if($option['task'] == 'list-items-inventory-sold'){
            $this->table        = 'sku as s';
            $query = self::select(DB::raw("SUM(s.quantity - s.stock) as sold, SUM(s.stock) as inventory, p.name as product_name"))
                            ->leftJoin('product as p', 's.style', '=', 'p.style')
                            ->groupBy(DB::raw("s.style, product_name"));

            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(10);
            }
            $result = $query->get()->toArray();
        }

        

        return $result;
    }
}