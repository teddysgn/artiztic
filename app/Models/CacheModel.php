<?php
 
namespace App\Models;
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
 
class CacheModel extends AdminModel
{
    public function __construct(){
        $this->table        = 'cache';
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $result = self::select(DB::raw("COUNT(value) as count"))
                            ->get()->first();
        }

       
        return $result;
    }
}