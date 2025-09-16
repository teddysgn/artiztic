<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    private $table = 'user';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $task = $this->task;
       
        $conditionEmail     = "";
        $conditionFullname  = "";
        $conditionPassword  = "";

        switch($task){
            case 'login':
                $conditionEmail     = "bail|required|email";
                $conditionPassword  = "bail|required|between:8,100";
                break;
            case 'register':
                $conditionEmail     = "bail|required|email:rfc,dns|unique:$this->table,email";
                $conditionFullname  = "bail|required|min:5";
                $conditionPassword  = "bail|required|between:8,100|confirmed";
                break;
        }
       
        return [
            'email'         => $conditionEmail,
            'fullname'      => $conditionFullname,
            'password'      => $conditionPassword,
            
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => 'Đây là trường bắt buộc',
            'email.unique'          => 'Email đã tồn tại',
            'password.required'     => 'Đây là trường bắt buộc',
            'password.confirmed'    => 'Nhập lại mật khẩu không khớp',
            'password.between'      => 'Mật khẩu phải có ít nhất 8 ký tự và 1 ký tự in hoa',
            'fullname.required'     => 'Đây là trường bắt buộc',
            
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            
        ];
    }
}
