

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>DỊCH VỤ GIAO HÀNG CỦA ARTIZ</h2>
                            <p><a href="{{ route('customer-service') }}">Dịch vụ khách hàng</a> &#8725; <a href="{{ route('customer-service/frequently-asked-questions') }}">FAQs</a> &#8725; <a class="text-primary" href="{{ route('customer-service/frequently-asked-questions/shipping') }}">Dịch vụ giao hàng của Artiz</a></p>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Bao lâu từ lúc đặt hàng thì tôi có thể nhận được hàng?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Nếu ở <span class="text-primary">nội thành Sài Gòn</span>, khách hàng sẽ nhận được hàng trong vòng <span class="text-primary">1 - 2 ngày làm việc</span>.</small></li>
                                                            <li><small>Nếu ở <span class="text-primary">ngoại thành</span>, khách hàng sẽ nhận được hàng trong vòng <span class="text-primary">2 - 3 ngày làm việc</span>.</small></li>
                                                            <li><small>Nếu ở <span class="text-primary">các tỉnh khác</span>, khách hàng sẽ nhận được hàng trong vòng <span class="text-primary">3 - 5 ngày làm việc</span>.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Làm thế nào để tôi có thể theo dõi đơn hàng của mình?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Khách hàng có thể truy cập vào <a href="{{ route('user/history') }}"><u>Lịch sử đơn hàng</u></a> và chọn "<u>Xem chi tiết</u>" để có thể theo dõi tình trạng đơn hàng.</small></li>
                                                            <li><small>Hoặc có thể liên hệ trực tiếp với nhân viên hỗ trợ và cung cấp mã đơn hàng được gửi qua email của bạn khi đặt hàng thàng công để bộ phận chăm sóc khách hàng sẽ phản hồi trong thời gian sớm nhất.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Tôi có thể hủy hoặc thay đổi đơn hàng trước khi đơn hàng được giao không?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Bạn có thể hủy đơn hàng của mình trong khi nó vẫn đang chờ xử lý trên hệ thống của Artiz.</small></li>
                                                            <li><small>Bạn có thể tìm hiểu xem đơn hàng của mình có đủ điều kiện để hủy hay không bằng cách nhập thông tin của bạn <a href="{{ route('user/tracking') }}"><u>tại đây</u></a> . Từ đó, chọn đơn hàng bạn muốn hủy và chọn "<u>Hủy đơn hàng</u>" ở góc trên bên phải của thông tin chi tiết đơn hàng. Nếu bạn cần mã đơn hàng của mình, bạn có thể tìm thấy mã này trong email xác nhận.</small></li>
                                                            <li><small>Khi đơn hàng của bạn bắt đầu được xử lý, đơn hàng đó không đủ điều kiện để hủy hoặc điều chỉnh. Xem <a href="{{ route('customer-service/exchanges') }}"><u>tại đây</u></a> để biết thêm <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi hàng</u></a> của Artiz.</small></li>
                                                            <li><small>Nếu bạn cần thực hiện bất kỳ thay đổi nào đối với đơn hàng của mình như điều chỉnh kích thước hoặc thay đổi địa chỉ giao hàng, Artiz khuyên bạn nên hủy và đặt đơn hàng mới miễn là đơn hàng vẫn đủ điều kiện.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu đơn hàng của tôi bị thất lạc hoặc bị đánh cắp thì sao?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Đơn hàng của bạn sẽ được Artiz bàn giao cho đơn vị vận chuyển.</small></li>
                                                            <li><small>Trường hợp không nhận được hàng, bạn vui lòng liên hệ trực tiếp với bộ phận chăm sóc khách hàng của Artiz để nhận được sự hướng dẫn sớm nhất.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu đơn hàng của tôi bị từ chối/không thể giao/giao hàng không thàng công thì sao?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz sẽ ghi nhận đơn hàng và sẽ hoàn tiền lại cho bạn nếu kiện hàng được đưa về kho của Artiz.</small></li>
                                                            <li><small>Trường hợp bạn từ chối nhận hàng, bạn sẽ phải chịu mọi chi phí giao hàng. Số tiền này sẽ được trừ vào khoản hoàn lại của bạn.</small></li>
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