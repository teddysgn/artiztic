@extends('default.pages.user.main')
@section('user')
<hr style="height: 1.1px; background: transparent">
    <div class="cart-table-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="checkout_details_area clearfix">
                        <div class="cart-title">
                            <h3>Đổi mật khẩu</h3>
                        </div>
                        @if (session('artiz_notify_success'))
                        <div class="alert alert-success">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                aria-label="Close">
                                <i style="color: green" class="fa-solid fa-xmark"></i>
                            </button>
                            <small> {{ session('artiz_notify_success') }}</small>
                        </div>
                        @endif
                        <form action="{{ route($controllerName . '/postUpdate') }}" method="post" id="formUpdate"
                            name="formUpdate" class="block-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="password" class="form-control" id="current_password" name="current_password"
                                        placeholder="Mật khẩu hiện tại (*)">
                                    <small class="text-danger" id="error-password">
                                        @if ($errors->has('current_password'))
                                            {!! $errors->first('current_password') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        placeholder="Mật khẩu mới (*)">
                                    <small class="text-danger" id="error-new-password">
                                        @if ($errors->has('new_password'))
                                            {!! $errors->first('new_password') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" placeholder="Xác nhận mật khẩu (*)">
                                    <small class="text-danger" id="error-confirm">
                                        @if ($errors->has('new_password_confirmation'))
                                            {!! $errors->first('new_password_confirmation') !!}
                                        @endif
                                    </small>
                                </div>
                                <div class="col-6 mb-3">
                                    <input type="hidden" name="task" value="password">
                                    <input type="hidden" name="option" value="password">
                                    <input type="hidden" name="id" value="{{ $user['id'] }}">
                                    <button type="submit" class="btn artiz-btn btn-submit w-100" disabled>CẬP NHẬT</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            const form = document.getElementById('formUpdate');
            let password = document.forms["formUpdate"]["current_password"];
            let newPassword = document.forms["formUpdate"]["new_password"];
            let confirm = document.forms["formUpdate"]["new_password_confirmation"];

            var errorPassword = document.getElementById("error-password");
            var errorNew = document.getElementById("error-new-password");
            var errorConfirmm = document.getElementById("error-confirm");

            form.addEventListener('submit', function handler(e) {
                let messages = [];

                // new password
                $("#error-new-password").addClass('text-danger');
                errorNew.textContent = '';
                if (newPassword.value == "") {
                    messages.push('Error');
                    errorNew.textContent = 'Đây là trường bắt buộc nhập';
                } else if (newPassword.value.length < 8) {
                    messages.push('Error');
                    errorNew.textContent = 'Mật khẩu phải có ít nhất 8 ký tự';
                } else if (newPassword.value == newPassword.value.toLowerCase()) {
                    messages.push('Error');
                    errorNew.textContent = 'Mật khẩu phải có ít nhất 1 ký tự in hoa, 1 ký tự thường và 1 chữ số';
                }

                // confirm
                errorConfirmm.textContent = '';
                if (newPassword.value != confirm.value) {
                    messages.push('Error');
                    errorConfirmm.textContent = 'Xác nhận mật khẩu không khớp';
                }

                if (password.value == newPassword.value) {
                    messages.push('Error');
                    document.getElementById("error-new-password").textContent =
                        'Vui lòng nhập mật khẩu khác với mật khẩu hiện tại';
                }


                if (messages.length > 0) {
                    e.preventDefault();
                } else {
                    form.removeEventListener('submit', handler);
                }
            });


            $('#new_password').keyup(function() {
                let newPassword = document.forms["formUpdate"]["new_password"].value;
                let password = document.forms["formUpdate"]["current_password"].value;

                $("#error-new-password").addClass('text-danger');
                document.getElementById("error-new-password").textContent = '';
                if (newPassword == "") {
                    document.getElementById("error-new-password").textContent = 'Đây là trường bắt buộc nhập';
                } else if (newPassword.length < 8) {
                    document.getElementById("error-new-password").textContent =
                        'Mật khẩu phải có ít nhất 8 ký tự';
                } else if (newPassword == newPassword.toLowerCase()) {
                    document.getElementById("error-new-password").textContent =
                        'Mật khẩu phải có ít nhất 1 ký tự in hoa';
                } else if (password == newPassword) {
                    document.getElementById("error-new-password").textContent =
                        'Vui lòng nhập mật khẩu khác với mật khẩu hiện tại';
                } else {
                    $("#error-new-password").removeClass('text-danger');
                    document.getElementById("error-new-password").textContent =
                        'Mật khẩu phải có ít nhất 1 ký tự in hoa, 1 ký tự thường và 1 chữ số';
                }

                
            });

            $('#new_password_confirmation').keyup(function() {
                let newPassword = document.forms["formUpdate"]["new_password"].value;
                let confirm = document.forms["formUpdate"]["new_password_confirmation"].value;
                document.getElementById("error-confirm").textContent = '';
                if (newPassword != confirm) {
                    document.getElementById("error-confirm").textContent =
                        'Xác nhận mật khẩu không khớp';
                }

                
            });

            $('#current_password').keyup(function() {
                let password = document.forms["formUpdate"]["current_password"].value;
                document.getElementById("error-password").textContent = '';

                if (password == "") {
                    document.getElementById("error-password").textContent = 'Đây là trường bắt buộc nhập';
                } else {
                    $.ajax({
                        url: "{{ route('user/check-password') }}",
                        type: "GET",
                        data: {
                            confirm_password: password,
                        },
                        success: function(response) {
                            if (response == '') {
                                document.getElementById("error-password").textContent =
                                    'Mật khẩu hiện tại không khớp';
                            } else {
                                document.getElementById("error-password").textContent  = '';
                                $('.btn-submit').removeAttr("disabled");
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
