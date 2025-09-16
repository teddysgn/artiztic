<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $table = 'user';
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $id = $this->id;
        $task = $this->task;

        $conditionAvatar    = '';
        $conditionUsername  = '';
        $conditionFullname  = '';
        $conditionEmail     = '';
        $conditionPassword  = '';
        $conditionStatus    = '';
        $conditionLevel     = '';

        switch($task){
            case 'add':
                $conditionAvatar    = 'bail|required|image';
                $conditionUsername  = "bail|required|between:5,100|unique:$this->table,username";
                $conditionFullname  = "bail|required|min:5";
                $conditionEmail     = "bail|required|email:rfc,dns|unique:$this->table,email|indisposable";
                $conditionPassword  = "bail|required|between:5,100|confirmed";
                $conditionStatus    = 'bail|in:active,inactive';
                $conditionLevel     = 'bail|in:member,admin';
                break;
            case 'edit-info':
                $conditionAvatar    = 'bail|image';
                $conditionUsername  = "bail|required|between:5,10|unique:$this->table,username,$id";
                $conditionFullname  = "bail|required|min:5";
                $conditionEmail     = "bail|required|email:rfc,dns|unique:$this->table,email,$id|indisposable";
                $conditionStatus    = 'bail|in:active,inactive';
                $conditionLevel     = 'bail|in:member,admin';
                break;
            case 'edit-password':
                $conditionPassword  = "bail|required|between:5,100|confirmed";
                break;
            case 'update':
                $conditionEmail     = "bail|required|email:rfc,dns|unique:$this->table,email,$id|indisposable";
                break;
        }

        return [
            'username'      => $conditionUsername,
            'email'         => $conditionEmail,
            'password'      => $conditionPassword,
            'status'        => $conditionStatus,
            'level'         => $conditionLevel,
            'avatar'        => $conditionAvatar,
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.indisposable' => 'Disposable email addresses are not allowed.',
            
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            
        ];
    }
}
