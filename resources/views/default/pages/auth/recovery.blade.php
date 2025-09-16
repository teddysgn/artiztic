

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-12 col-lg-5">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>Lấy lại mật khẩu</h2>
                            <small>Vui lòng cài mật khẩu mới vào form bên dưới.</small>
                        </div>
                        <form action="" method="post" id="formRecovery" name="formRecovery">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p class="mb-0">{{ $error }}</p>
                                        @endforeach
                                        
                                </div>
                            @endif
                            @if (session('artiz_notify_error'))
                            <div class="alert alert-danger">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <small>{{ session('artiz_notify_error') }}</small>
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu" value="" >
                                    <small class="text-danger" id="error-password">
                                        @if ($errors->has('password'))
                                            {!! $errors->first('password') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Nhập lại mật khẩu" value="" >
                                    <small class="text-danger" id="error-confirm">
                                        @if ($errors->has('password'))
                                            {!! $errors->first('password') !!}
                                        @endif
                                    </small>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <input type="hidden" name="task" value="login">
                                    <button type="submit" class="btn artiz-btn w-100">Cập nhật</button>
                                </div>
                                <div class="col-12 mb-3">
                                    <a style="text-decoration: underline" href="{{ route('auth/forget-password') }}">Quay lại đăng nhập</a>
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
        const form = document.getElementById('formRecovery');
        let password    = document.forms["formRecovery"]["password"];
        let confirm     = document.forms["formRecovery"]["password_confirmation"];

        var errorPassword   = document.getElementById("error-password");
        var errorConfirmm   = document.getElementById("error-confirm");

        form.addEventListener('submit', function handler (e) {
            let messages    = [];
           
            // password
            $("#error-password").addClass('text-danger');
            errorPassword.textContent   = '';
            if (password.value == "") {
                messages.push('Error');
                errorPassword.textContent  = 'Đây là trường bắt buộc';
            } else if (password.value.length < 8) {
                messages.push('Error');
                errorPassword.textContent  = 'Mật khẩu phải có ít nhất 8 ký tự';
            } else if (password.value == password.value.toLowerCase()) {
                messages.push('Error');
                errorPassword.textContent  = 'Mật khẩu phải chứa ít nhất 1 ký tự in hoa';
            }

            // confirm
            errorConfirmm.textContent   = '';
            if (password.value != confirm.value) {
                messages.push('Error');
                errorConfirmm.textContent  = 'Nhập lại mật khẩu không khớp';
            }

            // fullname
            errorFullname.textContent   = '';
            if (fullname.value == '') {
                messages.push('Error');
                errorFullname.textContent  = 'Đây là trường bắt buộc';
            }
            
            if(messages.length > 0){
                e.preventDefault();
            } else {
                form.removeEventListener('submit', handler);
            }
        });

        $('#password').keyup(function(){
            let password    = document.forms["formRecovery"]["password"].value;
            
            $("#error-password").addClass('text-danger');
            document.getElementById("error-password").textContent   = '';
            if (password == "") {
                document.getElementById("error-password").textContent  = 'Đây là trường bắt buộc';
            } else if (password.length < 8) {
                document.getElementById("error-password").textContent  = 'Mật khẩu phải có ít nhất 8 ký tự';
            } else if (password == password.toLowerCase()) {
                document.getElementById("error-password").textContent  = 'Mật khẩu phải chứa ít nhất 1 ký tự in hoa';
            }
        });

        $('#password_confirmation').keyup(function(){
            let password    = document.forms["formRecovery"]["password"].value;
            let confirm     = document.forms["formRecovery"]["password_confirmation"].value;
            document.getElementById("error-confirm").textContent   = '';
            if (password != confirm) {
                document.getElementById("error-confirm").textContent  = 'Nhập lại mật khẩu không khớp';
            }
        });
    });
</script>
@endsection