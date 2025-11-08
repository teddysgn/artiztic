<?php
 
namespace App\Models;
use App\Models\NewsModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
class NewsModel extends AdminModel
{
    public function __construct(){
        $this->table = 'news';
        $this->folderUpload = 'news';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'title', 'status', 'source', 'link', 'date', 'created', 'created_by', 'modified', 'modified_by', 'picture');
            
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
            $result = self::select('id', 'title', 'status', 'source', 'link', 'date', 'picture', 'description')
                            ->where('status', 'active')
                            ->orderBy('id', 'desc')
                            ->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'title', 'link', 'date', 'status', 'picture', 'source', 'description')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-title'){
            $result = self::select('id', 'title')
                        ->where('id', '=', $params['id'])
                        ->first();
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

    public function saveItem($params = null, $option = null)
    {
        $result = null;
    
        // 🌀 1. Đổi trạng thái
        if ($option['task'] == 'change-status') {
            $status = $params['currentStatus'] == 'active' ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }
    
        // 🆕 2. Thêm mới item
        if ($option['task'] == 'add-item') {
            if (!empty($params['picture'])) {
                $folderPath = $this->folderUpload;
                $disk = Storage::disk('artiz_storage');
    
                // 🧩 Tạo thư mục nếu chưa tồn tại, cấp quyền ghi
                if (!$disk->exists($folderPath)) {
                    $fullPath = $disk->path($folderPath);
                    @mkdir($fullPath, 0775, true);
                    @chmod($fullPath, 0775);
                }
    
                // 🖼️ Lưu file hình
                $pictureFile = $params['picture'];
                $params['picture'] = Str::random(10) . '.' . $pictureFile->clientExtension();
                $pictureFile->storeAs($folderPath, $params['picture'], 'artiz_storage');
            }
    
            // 💾 Ghi dữ liệu DB
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by'] = Auth::user()->fullname ?? 'admin';
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
        }
    
        // ✏️ 3. Sửa item
        if ($option['task'] == 'edit-item') {
            if (!empty($params['picture'])) {
                $params['picture'] = $this->deletePictureAndChangeNameDirectory(
                    $params['picture'],
                    $params['hidden_picture']
                );
            }
    
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by'] = Auth::user()->fullname ?? 'admin';
            $data['modified'] = date('Y-m-d H:i:s');
    
            self::where('id', $params['id'])->update($data);
        }
    
        return $result;
    }


    public function deleteItem($params = null, $option = null){
        $result = null;
        if($option['task'] = 'delete-item'){
            Storage::disk('artiz_storage')->deleteDirectory($this->folderUpload);
            $result = self::where('id', $params['id'])
                        ->delete();
        }
        return $result;
    }
}