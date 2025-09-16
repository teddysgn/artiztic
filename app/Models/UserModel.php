<?php
 
namespace App\Models;
use App\Models\UserModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
 
class UserModel extends AdminModel
{
    public function __construct(){
        $this->table = 'user';
        $this->folderUpload = 'user';
        $this->fieldSearchAccepted = [
            'id',
            'username',
            'fullname',
            'email',
        ];

        $this->crudNoAccepted = [
            'id'
    ,       '_token',
            'hidden_avatar',
            'save',
            'task',
            'option',
            'current_password',
            'password_confirmation',
            'new_password_confirmation',
            'new_password',
            'year',
            'month',
            'day',
        ];
    }

    public function listItems($params = null, $option = null){
        $result = null;
        if($option['task'] == 'list-items'){
            $query = self::select('id', 'fullname','username', 'email', 'phone', 'address', 'avatar', 'level', 'status', 'last_activity', 'created', 'created_by', 'modified', 'modified_by');
            
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

            $result = $query->orderBy('last_activity', 'desc')
                            ->paginate($params['pagination']['totalItemsPerPage']);
        }

        return $result;
    }

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'get-item'){
            $result = self::select('id', 'fullname', 'username', 'password', 'email', 'avatar', 'level', 'status', 'birthday', 'phone', 'address')
                        ->where('id', '=', $params['id'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'get-name'){
            $result = self::select('id', 'fullname')
                        ->where('id', '=', $params['id'])
                        ->first();
        }

        if($option['task'] == 'auth-login'){
            $result = self::select('id', 'username', 'email', 'level', 'avatar', 'fullname', 'password')
                        ->where('status', '=', 'active')
                        ->where('email', '=',  $params['email'])
                        ->first();
            if($result) $result = $result->toArray();
        }

        if($option['task'] == 'check-password'){
            $result = self::select('id', 'fullname')
                        ->where('password', '=', bcrypt($params['password']))
                        ->where('email', '=', ($params['email']))
                        ->first();
        }

        if($option['task'] == 'default-get-email'){
            $result = self::select('id', 'fullname', 'token', 'email')
                        ->where('email', '=', ($params['email']))
                        ->first();
        }

        if($option['task'] == 'default-get-item'){
            $result = self::select('id', 'fullname', 'token', 'email')
                        ->where('id', '=', ($params['id']))
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

    public function saveItem($params = null, $option = null){
        $result = null;

        if($option['task'] == 'change-status'){
            $status = $params['currentStatus'] == 'active' ? 'inactive' : 'active';
            self::where('id', $params['id'])->update(['status' => $status]);
        }

        if($option['task'] == 'change-level'){
            self::where('id', $params['id'])->update(['level' => $params['currentLevel']]);
        }

        if($option['task'] == 'change-password'){
            $password = bcrypt($params['password']);
            self::where('id', $params['id'])->update(['password' => $password]);
        }

        if($option['task'] == 'update-last-activity'){
            $this->timestamps = false;
            self::where('id', $params['id'])->update(['last_activity' => now()]);
        }

        if($option['task'] == 'add-item'){
            $params['password']     = bcrypt($params['password']);
            $params['token']        = strtoupper(Str::random(10));
            $params['birthday']     = $params['year'] . '-' . $params['month'] . '-' . $params['day'];
            
            $params['username']     = isset($params['username']) ? $params['username'] : $params['email'];
            $params['status']       = isset($params['status']) ? $params['status'] : 'active';
            $params['level']        = isset($params['level']) ? $params['level'] : 'member';
            

            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['created_by']    = Auth::user()->fullname;
            $data['created'] = date('Y-m-d H:i:s');
            self::insert($data);
            return DB::getPdo()->lastInsertId();
        }

        if($option['task'] == 'edit-item'){
            $item = self::getItem($params, ['task' => 'get-name']);
            
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = Auth::user()->fullname;
            $data['modified'] = date('Y-m-d H:i:s');

            $result = self::where('id', $params['id'])
               ->update($data);
            return $params['id'];
        }

        if($option['task'] == 'default-edit-item'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['modified_by']    = Auth::user()->fullname;
            $data['modified'] = date('Y-m-d H:i:s');
            
            $data['birthday'] = $params['year'] . '-' . $params['month'] . '-' . $params['day'];

            $result = self::where('id', $params['id'])
               ->update($data);
            return $params['id'];
        }

        if($option['task'] == 'default-edit-password'){
            $data = array_diff_key($params, array_flip($this->crudNoAccepted));
            $data['token']        = strtoupper(Str::random(10));
            $data['modified'] = date('Y-m-d H:i:s');
            $data['password'] = bcrypt($params['new_password']);
            

            $result = self::where('id', $params['id'])
               ->update($data);
            return $params['id'];
        }

        if($option['task'] == 'default-update-token'){
            $data['token']        = strtoupper(Str::random(10));
            
            $result = self::where('id', $params['id'])
               ->update($data);
            return $params['id'];
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
        if($option['task'] == 'count-items-all'){
            $result = self::select(DB::raw("COUNT(id) as count"))
                            ->get()->first();
        }

        

        if($option['task'] == 'list-items-activity'){
            $query = self::select('id', 'fullname', 'email', 'last_activity');
            if(isset($params['view_by']) && $params['view_by'] != 'default'){
                $query->limit($params['view_by']);
            } else {
                $query->limit(5);
            }

            $result = $query->orderBy('last_activity', 'desc')
                            ->get()->toArray();
        }
        
       
        
        return $result;
    }
}