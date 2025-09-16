<?php
 
namespace App\Models;
use App\Models\ProductModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class ProductModel extends AdminModel
{
    public function __construct(){
        $this->table        = 'product';
        $this->folderUpload = 'product';
    }

    public function listItems($params = null, $option = null){
        $this->table        = 'product as p';
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('p.id', 'p.name', 'p.status', 'p.ordering', 'p.picture1', 'p.price', 'p.type', 'p.occasion_id', 'p.color', 'p.style', 'p.discount', 'p.category_id','p.occasion_id', 'p.created', 'p.created_by', 'p.modified', 'p.modified_by', 'c.name as category_name', 'o.name as occasion_name', 'co.name as collection_name', 'co.id as collection_id')
                        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                        ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                        ->leftJoin('collection as co', 'p.collection_id', '=', 'co.id');
            
            if($params['filter']['status'] != 'all'){
                $query->where('p.status', '=', $params['filter']['status']);
            }

            if($params['filter']['occasion'] != ''){
                $query->where('p.occasion_id', '=', $params['filter']['occasion']);
            }

            if($params['filter']['collection'] != ''){
                $query->where('p.collection_id', '=', $params['filter']['collection']);
            }

            if($params['filter']['category'] != ''){
                $query->where('p.category_id', '=', $params['filter']['category']);
            }

            if($params['filter']['type'] != ''){
                $query->where('p.type', '=', $params['filter']['type']);
            }

            // Search
            if($params['search']['value'] != ''){
                if($params['search']['field'] == 'all'){
                    $query->where(function($query) use($params){
                        foreach($this->fieldSearchAccepted as $column){
                            $query->orWhere('p.' . $column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } elseif(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    $query->where('p.' . $params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            

            $result = $query->orderBy('p.id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($option['task'] == 'list-name-products'){
            $result = self::select('p.id', 'p.name')
                    ->orderBy('name', 'asc')
                    ->get()
                    ->toArray();
        }

        if($option['task'] == 'list-picture-products'){
            $result = self::select('p.id', 'p.name', 'p.picture1')
                    ->where('name', '=', $params)
                    ->get();
        }

        if($option['task'] == 'list-items-ajax'){
            if($params != ''){
                $query = self::select('p.id as product_id', 'p.name', 'p.picture1', 'c.name as category_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id');

                if($params['category_id'] != 'all' && $params['category_id'] != ''){
                    $query->where('p.category_id', '=', $params['category_id']);
                }
    
                if($params['occasion_id'] != 'all' && $params['occasion_id'] != ''){
                    $query->where('p.occasion_id', '=', $params['occasion_id']);
                }
    
                if($params['collection_id'] != 'all' && $params['collection_id'] != ''){
                    $query->where('p.collection_id', '=', $params['collection_id']);
                }
    
                if($params['color_id'] != 'all' && $params['color_id'] != ''){
                    $query->where('p.color', 'LIKE', "%{$params['color_id']}%");
                }
    
                if($params['size_id'] != 'all' && $params['size_id'] != ''){
                    $query->where('p.size', 'LIKE', "%{$params['size_id']}%");
                }
    
                if($params['price_id'] != 'all' && $params['price_id'] != ''){
                    switch($params['price_id']){
                        case 1:
                            $query->where('p.price', '<', "1000000");
                            break;
                        case 2:
                            $query->where('p.price', '>=', "1000000")
                                    ->where('p.price', '<', '3000000');
                            break;
                        case 3:
                            $query->where('p.price', '>=', "3000000")
                                    ->where('p.price', '<', '6000000');
                            break;
                        case 4:
                            $query->where('p.price', '>=', "6000000")
                                    ->where('p.price', '<', '10000000');
                            break;
                    }
                    
                }
    
                $query->where('p.name', 'LIKE', "%{$params['key']}%");
                $result = $query->orderBy('p.name', 'asc')->get()->toArray(); 
            }
        }

        if($option['task'] == 'default-list-items-new'){
            $time = date('Y-m-d', time() - 30*24*3600);
            $result = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'p.color', 'p.size', 'p.view', 'p.discount', 'c.name as category_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->where('p.status', '=', 'active')
                            ->where('p.created', '<=', date("Y-m-d"))
                            ->where('p.created', '>=', $time)
                            ->paginate($params['pagination']['totalItemsPerPage']);
            
        }

        if($option['task'] == 'default-list-products-6'){
            $result = self::select('p.id', 'p.name', 'p.picture1', 'p.price', 'category_id')
                    ->where('p.status', '=', 'active')
                    ->limit(6)
                    ->get()
                    ->toArray();
        }

        if($option['task'] == 'default-list-related-products'){
            $result = self::select('p.id', 'p.name', 'p.picture1', 'p.price', 'p.category_id', 'p.discount')
                    ->where('p.status', '=', 'active')
                    ->where('p.id', '!=', $params['id'])
                    ->where('p.category_id', '=', $params['category_id'])
                    ->take(10)
                    ->get()
                    ->toArray();
        }

        if($option['task'] == 'default-list-featured-products'){
            $result = self::select('p.id', 'p.name', 'p.picture1', 'p.price', 'p.category_id', 'p.discount')
                    ->where('p.status', '=', 'active')
                    ->where('p.id', '!=', $params['id'])
                    ->where('type', '=', 'featured')
                    ->take(10)
                    ->get()
                    ->toArray();
        }

        if($option['task'] == 'default-list-products'){
            $query = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'p.color', 'p.size', 'p.view', 'p.discount',
                            'c.name as category_name', 'o.name as occasion_name', 'co.name as collection_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                            ->leftJoin('collection as co', 'p.collection_id', '=', 'co.id');

            if($params['category_id'] != 'all' && $params['category_id'] != ''){
                $query->where('p.category_id', '=', $params['category_id']);
            }

            if($params['occasion_id'] != 'all' && $params['occasion_id'] != ''){
                $query->where('p.occasion_id', '=', $params['occasion_id']);
            }

            if($params['collection_id'] != 'all' && $params['collection_id'] != ''){
                $query->where('p.collection_id', '=', $params['collection_id']);
            }

            if($params['color_id'] != 'all' && $params['color_id'] != ''){
                $query->where('p.color', 'LIKE', "%{$params['color_id']}%");
            }

            if($params['size_id'] != 'all' && $params['size_id'] != ''){
                $query->where('p.size', 'LIKE', "%{$params['size_id']}%");
            }

            if($params['price_id'] != 'all' && $params['price_id'] != ''){
                switch($params['price_id']){
                    case 1:
                        $query->where('p.price', '<', "1000000");
                        break;
                    case 2:
                        $query->where('p.price', '>=', "1000000")
                              ->where('p.price', '<', '3000000');
                        break;
                    case 3:
                        $query->where('p.price', '>=', "3000000")
                              ->where('p.price', '<', '6000000');
                        break;
                    case 4:
                        $query->where('p.price', '>=', "6000000")
                              ->where('p.price', '<', '10000000');
                        break;
                }
                
            }

            // Search
            if($params['key'] != ''){
                $query->where('p.name', 'LIKE', "%{$params['key']}%");
            }

            $result = $query->where('p.status', '=', 'active')
                            ->orderBy('p.price', 'asc')
                            ->take($params['pagination']['totalItemsPerPage'])->get()->toArray();
        }

        if($option['task'] == 'default-list-items-sales'){
            $result = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'p.color', 'p.size', 'p.view', 'p.discount', 'c.name as category_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->where('p.status', '=', 'active')
                            ->where('discount', '>', '0')
                            ->orderBy('discount', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($option['task'] == 'default-list-products-ajax'){
            $query = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'p.color', 'p.size', 'p.view', 'p.discount',
                            'c.name as category_name', 'o.name as occasion_name', 'co.name as collection_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                            ->leftJoin('collection as co', 'p.collection_id', '=', 'co.id')
                            ->where('p.status', '=', 'active');

            if($params['category_id'] != 'all' && $params['category_id'] != ''){
                $query->where('p.category_id', '=', $params['category_id']);
            }

            if($params['occasion_id'] != 'all' && $params['occasion_id'] != ''){
                $query->where('p.occasion_id', '=', $params['occasion_id']);
            }

            if($params['collection_id'] != 'all' && $params['collection_id'] != ''){
                $query->where('p.collection_id', '=', $params['collection_id']);
            }

            if($params['color_id'] != 'all' && $params['color_id'] != ''){
                $query->where('p.color', 'LIKE', "%{$params['color_id']}%");
            }

            if($params['size_id'] != 'all' && $params['size_id'] != ''){
                $query->where('p.size', 'LIKE', "%{$params['size_id']}%");
            }

            if($params['price_id'] != 'all' && $params['price_id'] != ''){
                switch($params['price_id']){
                    case 1:
                        $query->where('p.price', '<', "1000000");
                        break;
                    case 2:
                        $query->where('p.price', '>=', "1000000")
                              ->where('p.price', '<', '3000000');
                        break;
                    case 3:
                        $query->where('p.price', '>=', "3000000")
                              ->where('p.price', '<', '6000000');
                        break;
                    case 4:
                        $query->where('p.price', '>=', "6000000")
                              ->where('p.price', '<', '10000000');
                        break;
                }
            }

            // Search
            if($params['key'] != ''){
                $query->where('p.name', 'LIKE', "%{$params['key']}%");
            }

            // Sort
            if($params['sort'] != ''){
                switch($params['sort']){
                    case 'price-down':
                        $query->orderBy('p.price', 'desc');
                        break;
                    case 'price-up':
                        $query->orderBy('p.price', 'asc');
                        break;
                    case 'newest':
                        $query->orderBy('p.created', 'desc');
                        break;
                    case 'popular':
                        $query->orderBy('p.view', 'desc');
                        break;
                }
            }

            // View
            if($params['view'] != ''){
                $query->take($params['view']);
            } else{
                $query->take($params['pagination']['totalItemsPerPage']);
            }
            
            $result = $query->get()->toArray();
        }

        if($option['task'] == 'default-load-more-products-ajax'){
            $query = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'p.color', 'p.size', 'p.view', 'p.discount',
                            'c.name as category_name', 'o.name as occasion_name', 'co.name as collection_name')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                            ->leftJoin('collection as co', 'p.collection_id', '=', 'co.id')
                            ->where('p.status', '=', 'active');

            if($params['category_id'] != 'all' && $params['category_id'] != ''){
                $query->where('p.category_id', '=', $params['category_id']);
            }

            if($params['occasion_id'] != 'all' && $params['occasion_id'] != ''){
                $query->where('p.occasion_id', '=', $params['occasion_id']);
            }

            if($params['collection_id'] != 'all' && $params['collection_id'] != ''){
                $query->where('p.collection_id', '=', $params['collection_id']);
            }

            if($params['color_id'] != 'all' && $params['color_id'] != ''){
                $query->where('p.color', 'LIKE', "%{$params['color_id']}%");
            }

            if($params['size_id'] != 'all' && $params['size_id'] != ''){
                $query->where('p.size', 'LIKE', "%{$params['size_id']}%");
            }

            if($params['price_id'] != 'all' && $params['price_id'] != ''){
                switch($params['price_id']){
                    case 1:
                        $query->where('p.price', '<', "1000000");
                        break;
                    case 2:
                        $query->where('p.price', '>=', "1000000")
                              ->where('p.price', '<', '3000000');
                        break;
                    case 3:
                        $query->where('p.price', '>=', "3000000")
                              ->where('p.price', '<', '6000000');
                        break;
                    case 4:
                        $query->where('p.price', '>=', "6000000")
                              ->where('p.price', '<', '10000000');
                        break;
                }
            }

            // Search
            if($params['key'] != ''){
                $query->where('p.name', 'LIKE', "%{$params['key']}%");
            }

            // Sort
            if($params['sort'] != ''){
                switch($params['sort']){
                    case 'price-down':
                        $query->orderBy('p.price', 'desc');
                        break;
                    case 'price-up':
                        $query->orderBy('p.price', 'asc');
                        break;
                    case 'newest':
                        $query->orderBy('p.created', 'desc');
                        break;
                    case 'popular':
                        $query->orderBy('p.view', 'desc');
                        break;
                }
            }
            
            $result = $query->take($params['limit'])->skip($params['start'])->get()->toArray();
        }

        if($option['task'] == 'default-exchange-list-items'){
            $result = self::select('id', 'name')
                            ->where('status', '=', 'active')
                            ->where('price', '>=', $params['price'])
                            ->orderBy('name')
                            ->get()
                            ->toArray();
        }

        if($option['task'] == 'list-items-in-selectbox'){
            $result = self::select('id', 'style')
                        ->where('style', '>', '0')
                        ->orderBy('style', 'asc')
                        ->pluck('style', 'id')
                        ->toArray();
        }

        if($option['task'] == 'list-items-category-name'){
            $result = self::select('c.name as category_name')
                        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                        ->where('p.style', '=', $params)
                        ->first();
        }

        if($option['task'] == 'list-pictures'){
            foreach($params as $key => $value){
                $id = $value['id'];
                
                $result[$id] = [];
                array_pop($value);
                foreach($value as $keyPicture => $valuePicture){
                    $query = self::select('picture1', 'id', 'name')
                    ->where('id', '=', $valuePicture)
                    ->get()
                    ->toArray();
                   
                    array_push($result[$id], $query);
                }
            }
        }

        if($option['task'] == 'default-list-pictures'){
           
            foreach($params['picture'] as $key => $value){
                if($key != $params['id']){
                    $result[$key] = [];
                    $query = self::select('picture1', 'id', 'name', 'price', 'discount')
                                ->where('id', '=', $key)
                                ->get()
                                ->toArray();
                   
                    array_push($result[$key], $query);
                }
                
            }
        }

        if($option['task'] == 'default-list-items-wishlist'){
            $query = self::select('p.id', 'p.name', 'p.picture1', 'p.picture2', 'p.price', 'c.name as category_name', 'p.view', 'p.discount')
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->leftJoin('favorite as f', 'p.id', '=', 'f.product_id')
                            ->where('p.status', '=', 'active')
                            ->where('f.user_id', '=', $params['user_id']);
            if(isset($params['pagination']['totalItemsPerPage']))
                $result = $query->paginate($params['pagination']['totalItemsPerPage']);
            else
                $result = $query->get()->toArray();

        }
       
        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $this->table        = 'product as p';
            $result = self::select('p.id', 'p.name', 'p.price', 'p.description', 'p.type', 'p.status', 'p.size', 'p.ordering', 'p.discount', 'p.view', 'p.quantity',
                                    'p.picture1', 'p.picture2', 'p.picture3', 'p.picture4', 'p.picture5', 'p.picture6', 
                                    'p.price', 'p.color', 'p.style', 'p.bust', 'p.waist', 'p.bust', 'p.hip', 'p.fabric', 'p.composition', 'p.care', 'p.style',
                                    'c.name as category_name', 'p.category_id', 
                                    'co.id as collection_name', 'p.collection_id', 
                                    'o.name as occasion_name', 'p.occasion_id')
                                    ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                                    ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                                    ->leftJoin('collection as co', 'p.collection_id', '=', 'co.id')
                                    ->where('p.id', '=', $params['id'])
                                    ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-name'){
            $result = self::select('id', 'name')
                        ->where('id', '=', $params['id'])
                        ->first();
        }

        if($option['task'] == 'get-name-ajax'){
            $result = self::select('id', 'name')
                        ->where('name', '=', $params['name'])
                        ->first();
        }

        if($option['task'] == 'get-style-ajax'){
            $result = self::select('id', 'name')
                        ->where('style', '=', $params['style'])
                        ->first();
        }

        if($option['task'] == 'get-item-quantity'){
            $result = self::select('id', 'quantity', 'sold')
                        ->where('style', '=', $params)
                        ->orWhere('id', '=', $params)
                        ->first();
        }

        if($option['task'] == 'get-category-name'){
            $this->table        = 'product as p';
            $result = self::select('p.id', 'c.name as category_name', 'p.style')
                        ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                        ->where('p.id', '=', $params)
                        ->first();
        }

        if($option['task'] == 'get-pictures'){
            $result = [];
            foreach($params['picture'] as $key => $value){
                $query = self::select('picture1', 'id', 'name')
                            ->where('id', '=', $value)
                            ->get()
                            ->toArray();
                array_unshift($result, $query);
            }
        }

        if($option['task'] == 'sku-check-item'){
            $result = self::select('id', 'quantity')
                    ->where('style', '=', $params['style'])
                    ->where('size', 'LIKE', "%{$params['size']}%")
                    ->where('color', 'LIKE', "%{$params['color']}%")
                    ->first();
        }

        if($option['task'] == 'default-get-item'){
            $result = self::select('id', 'name', 'price', 'discount', 'quantity', 'picture1', 'size', 'color', 'style')
                        ->where('id', '=', $params['id'])
                        ->first();
        }

        if($option['task'] == 'quick-view-get-item'){
            $this->table        = 'product as p';
            $result = self::select('p.id', 'p.name', 'p.price', 'p.description', 'p.type', 'p.status', 'p.size', 'p.ordering', 'p.quantity', 'p.view', 'p.discount',
                                    'p.picture1', 'p.picture2', 'p.picture3', 'p.picture4', 'p.picture5', 'p.picture6', 
                                    'p.price', 'p.color', 'p.style', 'p.bust', 'p.waist', 'p.bust', 'p.hip', 'p.fabric', 'p.composition', 'p.care', 'p.style')
                                   
                       
                        ->where('p.id', '=', $params)
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

            if($params['filter']['status'] != 'all'){
                $query->where('p.status', '=', $params['filter']['status']);
            }

            if($params['filter']['occasion'] != ''){
                $query->where('occasion_id', '=', $params['filter']['occasion']);
            }

            if($params['filter']['collection'] != ''){
                $query->where('collection_id', '=', $params['filter']['collection']);
            }

            if($params['filter']['category'] != ''){
                $query->where('category_id', '=', $params['filter']['category']);
            }

            if($params['filter']['type'] != ''){
                $query->where('type', '=', $params['filter']['type']);
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

        if($option['task'] == 'change-occasion'){
            self::where('id', $params['id'])->update(['occasion_id' => $params['currentOccasion']]);
        }

        if($option['task'] == 'change-collection'){
            self::where('id', $params['id'])->update(['collection_id' => $params['currentCollection']]);
        }

        if($option['task'] == 'change-category'){
            self::where('id', $params['id'])->update(['category_id' => $params['currentCategory']]);
        }

        if($option['task'] == 'change-type'){
            self::where('id', $params['id'])->update(['type' => $params['currentType']]);
        }

        if($option['task'] == 'update-view'){
            $this->timestamps = false;
            self::where('id', $params['id'])->update(['view' => $params['view'] + 1]);
        }

        if($option['task'] == 'update-quantity'){ // +
            $product = $this->getItem($params['id'], ['task' => 'get-item-quantity']);
            $data['quantity']   = $product['quantity'] + $params['quantity'];
            $data['sold']       = $product['sold'] - $params['quantity'];
            $result = self::where('id', $product['id'])
               ->update($data);
        }

        if($option['task'] == 'update-quantity-submit-cart'){ // -
            $product = $this->getItem($params['product_id'], ['task' => 'get-item-quantity']);
            $data['quantity'] = $product['quantity'] - $params['quantity'];
            $data['sold']       = $product['sold'] + $params['quantity'];
            $result = self::where('id', $product['id'])
               ->update($data);
        }


        if($option['task'] == 'add-item'){
            $params['price'] = str_replace(',', '', $params['price']);
            
            $picture1 = $params['picture1'];
            $params['picture1'] = Str::random(10) . '.' .  $picture1->clientExtension();
            $picture1->storeAs($this->folderUpload . '/' . $params['name'], $params['picture1'], 'artiz_storage');

            if(!empty($params['picture2'])){
                $picture2 = $params['picture2'];
                $params['picture2'] = Str::random(10) . '.' .  $picture2->clientExtension();
                $picture2->storeAs($this->folderUpload . '/' . $params['name'], $params['picture2'], 'artiz_storage');
            }
            

            if(!empty($params['picture3'])){
                $picture3 = $params['picture3'];
                $params['picture3'] = Str::random(10) . '.' .  $picture3->clientExtension();
                $picture3->storeAs($this->folderUpload . '/' . $params['name'], $params['picture3'], 'artiz_storage');
            }
            

            if(!empty($params['picture4'])){
                $picture4 = $params['picture4'];
                $params['picture4'] = Str::random(10) . '.' .  $picture4->clientExtension();
                $picture4->storeAs($this->folderUpload . '/' . $params['name'], $params['picture4'], 'artiz_storage');
            }
            

            if(!empty($params['picture5'])){
                $picture5 = $params['picture5'];
                $params['picture5'] = Str::random(10) . '.' .  $picture5->clientExtension();
                $picture5->storeAs($this->folderUpload . '/' . $params['name'], $params['picture5'], 'artiz_storage');
            }
            

            if(!empty($params['picture6'])){
                $picture6 = $params['picture6'];
                $params['picture6'] = Str::random(10) . '.' .  $picture6->clientExtension();
                $picture6->storeAs($this->folderUpload . '/' . $params['name'], $params['picture6'], 'artiz_storage');
            }
            

            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by']    = 'admin';
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
            return DB::getPdo()->lastInsertId();
        }

        if($option['task'] == 'edit-item'){
            $item = self::getItem($params, ['task' => 'get-name']);

            if(!empty($params['picture1'])){
                $params['picture1'] = $this->deletePictureAndChangeNameDirectory($params['picture1'], $params['hidden_picture1'], $item['name']);
            }

            if(!empty($params['picture2'])){
                $params['picture2'] = $this->deletePictureAndChangeNameDirectory($params['picture2'], $params['hidden_picture2'], $item['name']);
            }

            if(!empty($params['picture3'])){
                $params['picture3'] = $this->deletePictureAndChangeNameDirectory($params['picture3'], $params['hidden_picture3'], $item['name']);
            }

            if(!empty($params['picture4'])){
                $params['picture4'] = $this->deletePictureAndChangeNameDirectory($params['picture4'], $params['hidden_picture4'], $item['name']);
            }
            
            if(!empty($params['picture5'])){
                $params['picture5'] = $this->deletePictureAndChangeNameDirectory($params['picture5'], $params['hidden_picture5'], $item['name']);
            }

            if(!empty($params['picture6'])){
                $params['picture6'] = $this->deletePictureAndChangeNameDirectory($params['picture6'], $params['hidden_picture6'], $item['name']);
            }
            
            $params['price'] = str_replace(',', '', $params['price']);
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = 'admin';
            $data['modified'] = date('Y-m-d H:i:s');

            Storage::disk('artiz_storage')->move($this->folderUpload . '/' . $item['name'], $this->folderUpload . '/' . $params['name']);

            $result = self::where('id', $params['id'])
               ->update($data);
            return $params['id'];
        }
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
            $result = self::select(DB::raw("COUNT(id) as count"))
                            ->get()->first();
        }

        if($option['task'] == 'sum-items-inventory'){
            $result = self::select(DB::raw("SUM(quantity) as sum"))
                            ->get()->first();
        }

        if($option['task'] == 'count-items-discount'){
            $result = self::select(DB::raw("COUNT(id) as count"))
                            ->where('discount', '>', 0)
                            ->get()->first();
        }

        if($option['task'] == 'list-items-view'){
            $query = self::select('view', 'name', 'picture1')
                            ->orderBy('view', 'desc');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(5);
            }
            $result = $query->get()->toArray();
        }  

        // Search Inventory & Sold
        if($option['task'] == 'list-items-inventory-sold'){
            $this->table        = 'product as p';
            $query = self::select(DB::raw("(s.quantity - s.stock) as sold, (s.stock) as inventory, p.name, p.picture1, p.style, s.size, s.color"))
                            ->leftJoin('sku as s', 's.style', '=', 'p.style')
                            ->orderBy('s.color');
            if($params['key'] != ''){
                $query->where('p.name', 'LIKE', "%{$params['key']}%")
                      ->orWhere('p.style', 'LIKE', "%{$params['key']}%")
                      ->orWhere('p.id', 'LIKE', "%{$params['key']}%")
                      ->orWhere('s.barcode', 'LIKE', "%{$params['key']}%");
            }
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            }

            $result = $query->get()->toArray();
        }
        

        // Distribution
        if($option['task'] == 'list-items-in-category'){
            $this->table        = 'product as p';
            $query = self::select(DB::raw("COUNT(p.id) as count, c.name as distribution_name"))
                            ->leftJoin('category as c', 'p.category_id', '=', 'c.id')
                            ->groupBy('distribution_name');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            }

            $result = $query->get()->toArray();
        }
        
        if($option['task'] == 'list-items-in-occasion'){
            $this->table        = 'product as p';
            $query = self::select(DB::raw("COUNT(p.id) as count, o.name as distribution_name"))
                            ->leftJoin('occasion as o', 'p.occasion_id', '=', 'o.id')
                            ->groupBy('distribution_name');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            }

            $result = $query->get()->toArray();
        }
        
        if($option['task'] == 'list-items-in-collection'){
            $this->table        = 'product as p';
            $query = self::select(DB::raw("COUNT(p.id) as count, c.name as distribution_name"))
                            ->leftJoin('collection as c', 'p.collection_id', '=', 'c.id')
                            ->groupBy('distribution_name');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            }

            $result = $query->get()->toArray();
        }
        
        return $result;
    }
}