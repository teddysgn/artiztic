<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserModel as MainModel;
use App\Http\Requests\AuthRequest as MainRequest;
use App\Models\UserModel;
use App\Mail\SubscriptionMail;
use Mail;
use Auth;
use Cookie;
use Illuminate\Support\Facades\Redirect;
 
class AuthController extends Controller
{
    private $pathViewController = 'default.pages.auth.';
    private $controllerName     = 'auth';
    private $model;
    private $params             = [];

    public function __construct()
    {
        $this->params['pagination']['totalItemsPerPage'] = 10;
        $this->model = new MainModel();
        view()->share('controllerName', $this->controllerName);
    }

    public function login(Request $request)
    {   
        return view($this->pathViewController.'login', [
            'active'        => 'login',
            'header'        => 'Đăng nhập'
        ]);
    }

    public function register(Request $request)
    {   
        return view($this->pathViewController.'register', [
            'active'        => 'register',
            'header'        => 'Đăng ký'
        ]);
    }

    public function postLogin(MainRequest $request)
    {   
        if($request->method() == "POST"){
            $params = $request->all();
        
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password], true)){
                return redirect()->route('home');
               
            } else {
                 return redirect()->route($this->controllerName . '/login')->with('artiz_notify_danger', 'Tài khoản không tồn tại.');
            }
        }
    }

    public function postRegister(MainRequest $request)
    {   
        if($request->method() == "POST"){
            $params = $request->all();

            $userModel = new UserModel();
            $userModel->saveItem($params, ['task' => 'add-item']);

            return redirect()->route($this->controllerName . '/mail', [
                'email'        => $params['email'],
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route($this->controllerName . '/login');
    }

    public function form(Request $request)
    {
        $item = '';
        
        if($request->id != null){
            $this->params['id'] = $request->id;
            $item = $this->model->getItem($this->params, ['task' => 'get-item']);
        }
        return view($this->pathViewController.'form', ['item' => $item]);
    }

    public function mail(Request $request){
        $email = $request->email;
        Mail::to($email)->send(new SubscriptionMail);
        return redirect()->route($this->controllerName . '/login')->with('artiz_notify_success', 'Đăng ký tài khoản thành công.');
    }

    public function forgetPassword(){
        return view($this->pathViewController.'forget', [
            'active'        => 'login',
            'header'        => 'Quên mật khẩu'
        ]);
    }

    public function postForgetPassword(Request $request){
        $params = $request->all();
        $user = $this->model->getItem($params, ['task' => 'default-get-email']);
        // $this->model->saveItem($user, ['task' => 'default-update-token']);

        if($user == null){
            return redirect()->back()->with('artiz_notify_error', 'Email của bạn nhập không tồn tại.');
        } else {
            Mail::send('default.pages.mail.forget', compact('user'), function($email) use($user){
                $email->subject('ARTIZ - LẤY LẠI MẬT KHẨU');
                $email->to($user->email, $user->fullname);
            });
            return redirect()->route('auth/forget-password')->with('artiz_notify_success', 'Password Sent');
        }
    }

    public function recovery(UserModel $user, $token){

        if($user->token == $token){
            return view($this->pathViewController.'recovery', [
                'active'        => 'login',
            ]);
        } else {
            return redirect()->route('auth/login')->with('artiz_notify_danger', 'Yêu cầu của bạn đã hết hạn.');
        }
    }

    public function postRecovery(UserModel $user, $token, Request $request)
    {   
        if($request->method() == "POST"){
            $params = $request->all();
          
            $params['new_password'] = $request['password'];
            $params['id'] = $user['id'];
            $this->model->saveItem($params, ['task' => 'default-edit-password']);

            
            return redirect()->route('auth/login')->with('artiz_notify_success', 'Cập nhật thành công!!!');
        }
    }
}