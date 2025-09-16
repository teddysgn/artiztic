<?php
 
namespace App\Models;
use App\Models\OutfitModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class OutfitModel extends AdminModel
{
    public function __construct(){
        $this->table        = 'outfit';
        $this->folderUpload = 'outfit';
        $this->crudNoAccepted = [
            'id'
    ,        '_token',
            'name1',
            'name2',
            'name3',
            'name4',
            'name5',
            'name6',
            'save',
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6', 'created', 'created_by', 'modified', 'modified_by');

            $result = $query->orderBy('id', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if($option['task'] == 'default-list-items'){
            $query = self::select('id', 'item1', 'item2', 'item3', 'item4', 'item5', 'item6');

            $result = $query->orderBy('id', 'desc')
                            ->where('item1', '=', $params['id'])
                            ->orWhere('item2', '=', $params['id'])
                            ->orWhere('item3', '=', $params['id'])
                            ->orWhere('item4', '=', $params['id'])
                            ->orWhere('item5', '=', $params['id'])
                            ->orWhere('item6', '=', $params['id'])
                            ->get()->toArray();
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'item1','item2', 'item3', 'item4', 'item5', 'item6')
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
            $data['created_by']    = 'admin';
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
        }

        if($option['task'] == 'edit-item'){
            if($params['name1'] == '') $params['item1'] = null;
            if($params['name2'] == '') $params['item2'] = null;
            if($params['name3'] == '') $params['item3'] = null;
            if($params['name4'] == '') $params['item4'] = null;
            if($params['name5'] == '') $params['item5'] = null;
            if($params['name6'] == '') $params['item6'] = null;
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
}