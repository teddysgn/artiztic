<?php
 
namespace App\Models;
use App\Models\DetailModel as MainModel;
 
use App\Models\AdminModel;
use App\Models\ColorModel as ColorModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class DetailModel extends AdminModel
{
    public function __construct(){
        $this->table        = 'detail';
        $this->folderUpload = 'detail';
    }

    public function listItems($params = null, $option = null){
        $this->table        = 'product as p';
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('p.id', 'p.picture1', 'p.created', 'p.created_by', 'p.modified', 'p.modified_by', );

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

       
        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $this->table        = 'detail as p';
            $result = self::select('p.id', 'p.picture1', 'p.picture2', 'p.picture3', 'p.picture4', 'p.picture5', 'p.picture6', 'p.style', 'p.color', 'c.name as color_name')
                        ->leftJoin('color as c', 'p.color', '=', 'c.id')
                        ->where('p.id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-name'){
            $result = self::select('id', 'name')
                        ->where('id', '=', $params['id'])
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

        if($option['task'] == 'default-get-item-by-color'){
            $result = self::select('id', 'picture1', 'picture2', 'picture3', 'picture4', 'picture5', 'picture6')
                        ->where('color', '=', $params['color_id'])
                        ->where('style', '=', $params['style'])
                        ->first();
        }

        if($option['task'] == 'get-style-and-color'){
            $result = self::select('id', 'style', 'color')
                        ->where('id', '=', $params['id'])
                        ->first();
        }

        if($option['task'] == 'get-item-exist-color-in-style'){
            $this->table        = 'product';
            $result = self::select('id', 'style', 'color')
                        ->where('style', '=', $params['style'])
                        ->where('color', 'LIKE', "%{$params['color']}%")
                        ->first();
        }
        return $result;
    }

    public function saveItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'add-item'){
            $colorModel         = new ColorModel();
            $color              = $colorModel->getItem($params['color'], ['task' => 'get-name']);

            $picture1 = $params['picture1'];
            $params['picture1'] = Str::random(10) . '.' .  $picture1->clientExtension();
            $picture1->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture1'], 'artiz_storage');

            if(!empty($params['picture2'])){
                $picture2 = $params['picture2'];
                $params['picture2'] = Str::random(10) . '.' .  $picture2->clientExtension();
                $picture2->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture2'], 'artiz_storage');
            }
            

            if(!empty($params['picture3'])){
                $picture3 = $params['picture3'];
                $params['picture3'] = Str::random(10) . '.' .  $picture3->clientExtension();
                $picture3->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture3'], 'artiz_storage');
            }
            

            if(!empty($params['picture4'])){
                $picture4 = $params['picture4'];
                $params['picture4'] = Str::random(10) . '.' .  $picture4->clientExtension();
                $picture4->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture4'], 'artiz_storage');
            }
            

            if(!empty($params['picture5'])){
                $picture5 = $params['picture5'];
                $params['picture5'] = Str::random(10) . '.' .  $picture5->clientExtension();
                $picture5->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture5'], 'artiz_storage');
            }
            

            if(!empty($params['picture6'])){
                $picture6 = $params['picture6'];
                $params['picture6'] = Str::random(10) . '.' .  $picture6->clientExtension();
                $picture6->storeAs($this->folderUpload . '/' . $params['style'] . '/' . $color['name'], $params['picture6'], 'artiz_storage');
            }
            

            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by']    = 'admin';
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
            return DB::getPdo()->lastInsertId();
        }

        if($option['task'] == 'edit-item'){
            $colorModel         = new ColorModel();
            $color              = $colorModel->getItem($params['color'], ['task' => 'get-name']);

            $item = self::getItem($params, ['task' => 'get-style-and-color']);
            $colorOld = $colorModel->getItem($item['color'], ['task' => 'get-name']);

            if(!empty($params['picture1'])){
                $params['picture1'] = $this->deletePictureAndChangeNameDirectory($params['picture1'], $params['hidden_picture1'], $params['style'] . '/' . $color['name']);
            }

            if(!empty($params['picture2'])){
                $params['picture2'] = $this->deletePictureAndChangeNameDirectory($params['picture2'], $params['hidden_picture2'], $params['style'] . '/' . $color['name']);
            }

            if(!empty($params['picture3'])){
                $params['picture3'] = $this->deletePictureAndChangeNameDirectory($params['picture3'], $params['hidden_picture3'], $params['style'] . '/' . $color['name']);
            }

            if(!empty($params['picture4'])){
                $params['picture4'] = $this->deletePictureAndChangeNameDirectory($params['picture4'], $params['hidden_picture4'], $params['style'] . '/' . $color['name']);
            }
            
            if(!empty($params['picture5'])){
                $params['picture5'] = $this->deletePictureAndChangeNameDirectory($params['picture5'], $params['hidden_picture5'], $params['style'] . '/' . $color['name']);
            }

            if(!empty($params['picture6'])){
                $params['picture6'] = $this->deletePictureAndChangeNameDirectory($params['picture6'], $params['hidden_picture6'], $params['style'] . '/' . $color['name']);
            }
            
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = 'admin';
            $data['modified']       = date('Y-m-d H:i:s');

            Storage::disk('artiz_storage')->move($this->folderUpload . '/' . $item['style'] . '/' . $colorOld['name'], $this->folderUpload . '/' . $params['style'] . '/' . $color['name']);

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
}