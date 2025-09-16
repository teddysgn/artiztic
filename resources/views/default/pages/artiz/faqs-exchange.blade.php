

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>ĐÔI HÀNG & TRẢ HÀNG</h2>
                            <p><a href="{{ route('customer-service') }}">Dịch vụ khách hàng</a> &#8725; <a href="{{ route('customer-service/frequently-asked-questions') }}">FAQs</a> &#8725; <a class="text-primary" href="{{ route('customer-service/frequently-asked-questions/exchange') }}">Đổi hàng & Trả hàng</a></p>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Chính sách đổi & trả của Artiz là gì?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Bạn có thể tham khảo <a href="{{ route('customer-service/exchanges') }}"><u>tại đây</u></a></small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Làm thế nào để tôi trả hàng?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz không chi trả chi phí vận chuyển đổi hàng cho các đơn vị vận chuyển</small></li>
                                                            <li><small>Trước khi đóng gói đơn hàng, bạn nên liên hệ với bộ phận CSKH hoặc tham khảo <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi & trả hàng hóa</u></a></small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Các bước để trả hàng là gì?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Hiện tại Artiz không hỗ trợ dịch vụ đổi hàng dưới mọi hình thức.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nguyên nhân nào khiến việc đổi hàng của tôi bị từ chối?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Các sản phẩm được trả lại có vết bẩn rõ ràng đã qua sử dụng, trang điểm, lông động vật, gàu, chất khử mùi, nước hoa hoặc các sản phẩm tương tự.</small></li>
                                                            <li><small>Các sản phẩm được trả lại không còn nguyên nhãn, mác.</small></li>
                                                            <li><small>Các sản hàng được bán theo bộ không được trả lại theo bộ.</small></li>
                                                            <li><small>Bạn có thể tham khảo thêm các nguyên nhân khác trong <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi & trả hàng hóa</u></a>.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Tôi có phải chịu chi phí vận chuyển trả lại không?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Có. Artiz không chi trả chi phí vận chuyển đổi hàng cho các đơn hàng. Xem tại <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi & trả hàng hóa</u></a>. để biết cách trả lại.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu tôi trả lại sản phẩm không phải của Artiz thì sao?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz không chịu trách nhiệm đối với các sản phẩm không phải của Artiz được trả lại kho của Artiz. </small></li>
                                                            <li><small>Nếu Artiz có thể tìm thấy các mặt hàng bị trả lại do nhầm lẫn, Artiz có thể liên hệ để cho bạn biết những gì đã được trả lại và yêu cầu bạn chi trả chi phí vận chuyển để trả lại các mặt hàng cho bạn. 
                                                                Không phải lúc nào cũng có thể tìm thấy các mặt hàng đã trả lại và Artiz không thể đảm bảo rằng các mặt hàng sẽ được tìm thấy để trả lại cho bạn. </small></li>
                                                            <li><small>Artiz khuyên bạn nên đóng gói cẩn thận khi trả lại hàng và đảm bảo các sản phẩm bạn định trả lại cho Artiz là đúng. 
                                                                Vì gói hàng vẫn là trách nhiệm của bạn cho đến khi nó được trả lại cho Artiz, Artiz cũng khuyên bạn nên giữ lại bằng chứng về việc đổi hàng/hàng hư hỏng trong trường hợp bạn cần liên hệ với Artiz về việc trả lại hàng.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu đơn hàng của tôi bị từ chối/không thể giao/giao hàng không thành công thì sao?</span></small></p>
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
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Nếu tôi muốn đổi hàng sang sản phẩm khác thì có được không?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Được. Tuy nhiên theo <a href="{{ route('customer-service/exchanges') }}"><u>Chính sách đổi & trả hàng hóa</u></a>, Artiz chỉ cấp nhận bạn đổi sang sản phẩm có giá trị ngang giá hoặc cáo hơn sản phẩm bạn muốn đổi (Ngoại trừ những sản phẩm giảm giá).</small></li>
                                                            <li><small>Phần chênh lệch giữa các sản phẩm bạn muốn đổi sẽ được chi trả cho đơn vị vận chuyển khi bạn nhận được hàng ở kỳ tới.</small></li>
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