

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>TÀI KHOẢN VÀ ĐƠN HÀNG</h2>
                            <p><a href="{{ route('customer-service') }}">Dịch vụ khách hàng</a> &#8725; <a href="{{ route('customer-service/frequently-asked-questions') }}">FAQs</a> &#8725; <a class="text-primary" href="{{ route('customer-service/frequently-asked-questions/information') }}">Tài khoản và Đơn hàng</a></p>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Làm thế nào để tạo tài khoản?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Bạn có thể <a href="{{ route('auth/register') }}"><u>đây</u></a> và chọn tùy chọn “<u>Tạo tài khoản</u>” để bắt đầu.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Làm thế nào để thay đổi thông tin tài khoản của tôi?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Nếu bạn muốn thay đổi bất kỳ thông tin nào trong tài khoản Artiz của mình, bao gồm tên, ngày sinh, số điện thoại hoặc mật khẩu, hãy đăng nhập vào tài khoản của bạn <a href="{{ route('auth/login') }}"><u>tại đây</u></a> và đi tới “<u>Tài khoản</u>”.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Thông tin của tôi có được đảm bảo khi đăng ký tài khoản tại Artiz?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Vì sự uy tín của Artiz và quyền lợi của khách hàng, Artiz cam kết giữ bí mật toàn bộ thông tin của khách hàng khi sử dụng dịch vụ. Mọi thông tin chi tiết, bạn có thể tham khảo tại <a href="{{ route('customer-service/information-collection') }}"><u>Chính sách bảo mật</u></a>.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Tôi không thể đăng nhập vào tài khoản của mình, tôi phải làm gì?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Điều này có thể là do lỗi đánh máy trong địa chỉ email hoặc mật khẩu khi bạn tạo tài khoản ban đầu. Mật khẩu phân biệt chữ hoa chữ thường, vì vậy hãy đảm bảo bạn đã nhập đúng mật khẩu. </small></li>
                                                            <li><small>Một trường hợp khác có thể là do tài khoản của bạn đã bị vô hiệu hóa khi Artiz cảm thấy bạn vô tình hay cố ý vi phạm vào các <a href="{{ route('customer-service/term-of-use') }}"><u>Điều khoản sử dụng của Artiz.</u></a></small></li>
                                                            <li><small>Nếu bạn quên mật khẩu, vui lòng chọn “<u>Quên mật khẩu</u>” và Artiz sẽ gửi cho bạn form để cài lại mật khẩu qua email. Nếu bạn cần hỗ trợ thêm, vui lòng liên hệ với Artiz.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Tôi có nên đăng ký tài khoản để trở thành thành viên của Artiz?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz khuyến khích bạn nên có tài khoản mua hàng tại website vì:</small></li>
                                                            <div class="container-fluid">
                                                                <div class="container-fluid">
                                                                    <ul>
                                                                        <li><small>Bạn sẽ nhận được thông báo khi những sản phẩm mứi ra mắt.</small></li>
                                                                        <li><small>Artiz sẽ có thông tin của bạn để có thể gửi bạn những mã khuyến mãi trong những dịp đặc biệt.</small></li>
                                                                        <li><small>Bạn có thể tích điểm và có cơ hội đạt được mức hạng thành viên và được chiết khấu khi đặt hàng.</small></li>
                                                                        <li><small>Lưu trữ được những sản phẩm ưa thích.</small></li>
                                                                        <li><small>Theo dõi đơn hàng hoặc có những thay đổi về đơn hàng như: Hủy đơn hàng, Đổi hàng,...</small></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu tôi không có tài khoản nhưng vẫn muốn mua hàng của Artiz thì sao?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Theo <a href="{{ route('customer-service/term-of-use') }}"><u>Điều khoàn sử dụng</u></a>, một số dịch vụ bạn cần phải đăng nhập tài khoản thì mới có thể sử dụng được.</small></li>
                                                            <li><small>Nếu bạn không muốn tạo tài khoản nhưng vẫn muốn mua hàng, bạn có thể nhắn tin trực tiếp với bộ phận CSKH để được lên đơn trực tiếp.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Đơn hàng của tôi chỉ được giao một số mặt hàng, tôi phải làm gì?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz có thể đã gửi đơn hàng của bạn theo các gói riêng biệt. Bạn sẽ nhận được xác nhận giao hàng riêng cho mỗi gói hàng được gửi. Vui lòng kiểm tra email của bạn để xem bạn có các mặt hàng được gửi riêng lẻ không.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Artiz có đang áp dụng chiết khấu cho thành viên không?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Hiện tại Artiz đang có hạng thành viên vầ mỗi hạng sẽ có mức chiết khấu khác nhau:</small></li>
                                                            <div class="container-fluid">
                                                                <div class="container-fluid">
                                                                    <ul>
                                                                        <li><small>Opaz:    Tổng giá trị mua > 0đ, Được chiết khấu 0%.</small></li>
                                                                        <li><small>Topaz:   Tổng giá trị mua &ge; 10.000.000đ, được chiết khấu 5%.</small></li>
                                                                        <li><small>Ruby:    Tổng giá trị mua &ge; 30.000.000đ, được chiết khấu 10%.</small></li>
                                                                        <li><small>Diamond: Tổng giá trị mua &ge; 50.000.000đ, được chiết khấu 15%.</small></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Chi phí vận chuyển và các khoản trừ như mã giảm giá hay sản phẩm sale có được tính vào thành viên?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Không. Tổng giá trị mua sẽ được tình bằng số tiền cuối cùng mà bạn đã bỏ ra để thanh toán cho sản phẩm.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    .checkout_details_area li {
        list-style: disc !important;
    }

    .checkout_details_area p {
        margin-bottom: 0;
        color: black;
    }
</style>
@endsection