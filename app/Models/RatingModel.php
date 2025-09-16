<?php
 
namespace App\Models;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class RatingModel extends AdminModel
{
    public function __construct(){
        $this->table = 'rating';
        $this->folderUpload = 'rating';
        $this->fieldSearchAccepted = [
            'r.review',
            'r.id',
            'p.name',
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $this->table        = 'rating as r';
            $query = self::select('r.id', 'r.review', 'r.rating', 'r.status', 'r.created', 'r.modified', 'p.name as product_name', 'u.fullname as user_fullname', 'p.picture1 as product_picture', 'p.name as product_name')
                                    ->leftJoin('user as u', 'r.user_id', '=', 'u.id')
                                    ->leftJoin('product as p', 'r.product_id', '=', 'p.id');
            
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

        if($option['task'] == 'default-list-items'){
            $this->table        = 'rating as r';
            $result = self::select('r.id', 'r.review', 'r.rating', 'r.created', 'u.fullname as user_fullname')
                            ->leftJoin('user as u', 'r.user_id', '=', 'u.id')
                            ->where('r.status', '=', 'active')
                            ->where('r.product_id', '=', $params['product_id'])
                            ->orderBy('r.rating', 'desc')
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
                $result = self::select('id')
                ->where('product_id', '=', $params['product_id'])
                ->where('user_id', '=', Auth::user()->id)
                ->first();
                if($result) $result = $result->toArray();
        }

        
        return $result;
    }

    public function countItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'count-status'){
            $this->table        = 'rating as r';
            $query = self::groupBy('r.status')
                        ->select(DB::raw('COUNT(`r`.`id`) AS `count`, `r`.`status`'))
                        ->leftJoin('product as p', 'r.product_id', '=', 'p.id');
                            

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

        if($option['task'] == 'count-rating'){
            $query = self::where('product_id', '=', $params['product_id'])
                        ->where('status', '=', 'active')
                        ->select(DB::raw('COUNT(`rating`) AS `count`'));
                        
            $result = $query->get()->first();
        }
        return $result;
    }

    public function sumItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'sum-rating'){
            $query = self::where('product_id', '=', $params['product_id'])
                            ->where('status', '=', 'active')
                            ->select(DB::raw('SUM(`rating`) AS `sum`'));
            $result = $query->get()->first();
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
            $data['user_id'] = Auth::user()->id;
            $data['status'] = 'inactive';
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
        }

        if($option['task'] == 'edit-item'){
            $item = self::getItem($params, ['task' => 'get-name']);

            if(!empty($params['picture_profile'])){
                $params['picture_profile'] = $this->deletePictureAndChangeNameDirectory($params['picture_profile'], $params['hidden_picture_profile'], $item['name']);
            }
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['user_id'] = Auth::user()->id;
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

        // Summary
        if($option['task'] == 'list-items-rating-highest'){
            $this->table        = 'rating as r';
            $query   = self::select(DB::raw("SUM(r.rating) / COUNT(r.product_id) as rating, COUNT(r.product_id) as count, p.name as product_name, p.picture1 as product_picture"))
                        ->leftJoin('product as p', 'r.product_id', '=', 'p.id')
                        ->groupBy(DB::raw("r.product_id, product_name, product_picture"))
                        ->orderBy('rating', 'desc');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(10);
            }
            $result = $query->get()->toArray();
        }

        if($option['task'] == 'list-items-rating-lowest'){
            $this->table        = 'rating as r';
            $query   = self::select(DB::raw("SUM(r.rating) / COUNT(r.product_id) as rating, COUNT(r.product_id) as count, p.name as product_name, p.picture1 as product_picture"))
                        ->leftJoin('product as p', 'r.product_id', '=', 'p.id')
                        ->groupBy(DB::raw("r.product_id, product_name, product_picture"))
                        ->orderBy('rating', 'asc');
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