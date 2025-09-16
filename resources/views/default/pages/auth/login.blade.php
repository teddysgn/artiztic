

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>ĐĂNG NHẬP</h2>
                        </div>
                        <form action="{{ route($controllerName . '/postLogin') }}" method="post" id="formLogin" name="formLogin">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                        
                                </div>
                            @endif
                            @if (session('artiz_notify_danger'))
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <small>{{ session('artiz_notify_danger') }}</small>
                            </div>
                            @endif
                            @if (session('artiz_notify_success'))
                            <div class="alert alert-success">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <small>{{ session('artiz_notify_success') }}</small>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="">
                                    <small class="text-danger" id="error-email"></small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" value="">
                                    <small class="text-danger" id="error-password"></small>
                                </div>
                                <div class="col-12 mb-3">
                                    <a href="{{ route('auth/forget-password') }}">Quên mật khẩu?</a>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="hidden" name="task" value="login">
                                    <button type="submit" class="btn artiz-btn w-100">ĐĂNG NHẬP</button>
                                </div>
                                <div class="col-12">
                                    <hr style="width: 100%; height: 0.1px">
                                </div>
                                <div class="col-12">
                                    <p class="text-center">Bạn chưa có tài khoản?</p>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <a href="{{ route('auth/register') }}" class="btn artiz-btn-black w-100">ĐĂNG KÝ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        const form = document.getElementById('formLogin');
        let email       = document.forms["formLogin"]["email"];
        let password    = document.forms["formLogin"]["password"];

        var errorEmail      = document.getElementById("error-email");
        var errorPassword   = document.getElementById("error-password");
        form.addEventListener('submit', function handler (e) {
            let messages    = [];

            errorEmail.textContent      = '';
            if (email.value == "") {
                messages.push('Error');
                errorEmail.textContent  = 'Đây là trường bắt buộc';
            } else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
                messages.push('Error');
                errorEmail.textContent  = 'Vui lòng nhập email hợp lệ';
            }

            errorPassword.textContent   = '';
            if (password.value == "") {
                messages.push('Error');
                errorPassword.textContent  = 'Đây là trường bắt buộc';
            }

            if(messages.length > 0){
                e.preventDefault();
            } else {
                form.removeEventListener('submit', handler);
            }
        });

        $('#email').keyup(function(){
            errorEmail.textContent      = '';
            if (email.value == "") {
                errorEmail.textContent  = 'Đây là trường bắt buộc';
            }
            if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))) {
                errorEmail.textContent  = 'Vui lòng nhập email hợp lệ';
            }
        });

        $('#password').keyup(function(){
            errorPassword.textContent   = '';
            if (password.value == "") {
                errorPassword.textContent  = 'Đây là trường bắt buộc';
            }
        });
    });
</script>
@endsection