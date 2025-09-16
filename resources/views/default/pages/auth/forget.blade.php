

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center text-center">
                <div class="col-12 col-lg-5">
                    <div class="checkout_details_area mt-50 clearfix">
                        
                        <form action="{{ route($controllerName . '/post-forget-password') }}" method="post" id="formLogin" name="formLogin">
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
                            @if (session('artiz_notify_success'))
                                <h3>Yêu cầu được gửi</h3>
                                <small>Vui lòng kiểm tra email cập nhật mật khẩu mới.</small></br>
                                <small>Nếu bạn chưa nhận được email nào, hãy gửi lại để nhận.</small>
                            @else
                                <div class="login-title">
                                    <h2>Bạn quên mật khẩu?</h2>
                                    <small>Vui lòng nhập email của bạn để lấy lại mật khẩu.</small>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="">
                                    <small class="text-danger" id="error-email"></small>
                                </div>
                                <div class="col-12 mb-3">
                                    <input type="hidden" name="task" value="login">
                                    <button type="submit" class="btn artiz-btn w-100">Gửi yêu cầu</button>
                                </div>
                                <div class="col-12 mb-3">
                                    <a style="text-decoration: underline" href="{{ route('auth/login') }}">Quay lại đăng nhập</a>
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

        var errorEmail      = document.getElementById("error-email");
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
    });
</script>
@endsection