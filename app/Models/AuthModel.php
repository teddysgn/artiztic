<?php
 
namespace App\Models;
use App\Models\UserModel as MainModel;
 
use App\Models\AdminModel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Foundation\Auth\User as Authenticable;
 
class AuthModel extends Authenticable
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

    public function getItem($params = null, $option = null){
        $result = null;
        if($option['task'] == 'auth-login'){
            $result = self::select('id', 'username', 'email', 'level', 'avatar', 'fullname', 'password')
                        ->where('status', '=', 'active')
                        ->where('email', '=',  $params['email'])
                        ->where('password', '=', bcrypt($params['password']))
                        ->first();
            if($result) $result = $result->toArray();
        }

        return $result;
    }

}