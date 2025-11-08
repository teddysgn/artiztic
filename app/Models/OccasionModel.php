<?php
 
namespace App\Models;
use App\Models\OccasionModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class OccasionModel extends AdminModel
{
    public function __construct(){
        $this->table = 'occasion';
        $this->folderUpload = 'occasion';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'name', 'status', 'created', 'created_by', 'modified', 'modified_by', 'picture_profile');
            
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

        if($option['task'] == 'list-items-in-selectbox'){
            $result = self::select('id', 'name')
                        ->where('status', '=', 'active')
                        ->orderBy('ordering', 'desc')
                        ->pluck('name', 'id')
                        ->toArray();
        }

        if($option['task'] == 'default-list-items'){
            $result = self::select('id', 'name', 'status', 'picture_profile')
                            ->where('status', '=', 'active')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'name', 'status', 'ordering', 'picture_profile')
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
                $result = self::select('id', 'name')
                ->where('id', '=', $params['occasion_id'])
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

        if ($option['task'] == 'add-item') {
            if (!empty($params['picture_profile'])) {
                $folderPath = $this->folderUpload . '/' . $params['name'];
                $disk = Storage::disk('artiz_storage');
        
                // 🧩 Tạo thư mục nếu chưa có, với quyền ghi đầy đủ
                if (!$disk->exists($folderPath)) {
                    $fullPath = $disk->path($folderPath);
                    @mkdir($fullPath, 0775, true);
                    @chmod($fullPath, 0775);
                }
        
                // 🖼️ Lưu file hình
                $pictureProfile = $params['picture_profile'];
                $params['picture_profile'] = Str::random(10) . '.' . $pictureProfile->clientExtension();
                $pictureProfile->storeAs($folderPath, $params['picture_profile'], 'artiz_storage');
            }
        
            // 💾 Lưu dữ liệu vào DB
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by'] = 'admin';
            $data['created'] = date('Y-m-d H:i:s');
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