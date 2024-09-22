<div class="content_detail_order">
    <p class="title_order">THÔNG TIN ĐƠN HÀNG <span style="color: #0a58ca">{{$order->order_code}}</span></p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <div class="circle-order boder-circle"><i
                    class="fa-sharp fa-solid fa-receipt color_icon text_icon"></i></div>
            <div class="text-title">Đơn Hàng Đã Đặt</div>
        </div>
        @if($order->status !=4)
            <div class="line-order {{$order->status == 1 || $order->status == 2 || $order->status == 3 ? 'line-order-active' : ''}}"></div>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="circle-order {{$order->status == 1 || $order->status == 2 || $order->status == 3 ? 'boder-circle' : ''}}"><i
                        class="fa-solid fa-money-check-dollar {{$order->status == 1 || $order->status == 2 || $order->status == 3 ? 'color_icon' : 'base-color'}} text_icon"></i>
                </div>
                <div class="text-title">Đã Xác Nhận Đơn Hàng</div>
            </div>
            <div class="line-order {{$order->status == 2 || $order->status == 3 ? 'line-order-active' : ''}}"></div>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="circle-order {{$order->status == 2 || $order->status == 3 ? 'boder-circle' : ''}}"><i class="fa-solid fa-truck {{$order->status == 2 || $order->status == 3 ? 'color_icon' : 'base-color'}} text_icon"></i></div>
                <div class="text-title">Đơn Hàng Đang Giao</div>
            </div>
            <div class="line-order {{$order->status == 3 ? 'line-order-active' : ''}}"></div>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="circle-order {{$order->status == 3 ? 'boder-circle' : ''}}"><i class="fa-solid fa-inbox {{$order->status == 3 ? 'color_icon' : 'base-color'}} text_icon"></i></div>
                <div class="text-title">Đơn Hàng Giao Thành Công</div>
            </div>
        @else
            <div class="line-order line-order-active w-100"></div>
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="circle-order boder-circle"><i
                        class="fa-solid fa-circle-exclamation color_icon text_icon"></i>
                </div>
                <div class="text-title">Đơn Hàng Đã Hủy</div>
            </div>
        @endif
    </div>
    <div class="line-row"></div>
    <div>
        <p class="title-address-order">Thông tin người đặt hàng</p>
        <div class="box-people">
            <div class="content-address-order mr-2"><span
                    class="title_people">Họ tên người nhận:</span><span>{{$order->name}}</span></div>
            <div class="content-address-order2"><span class="title_people">Số điện thoại:</span>
                <span>{{$order->phone}}</span></div>
            <div class="content-address-order content_infor_mobile"><span class="title_people">Địa chỉ :</span>
                <span>{{$order->full_address}}</span></div>
            <div class="content-address-order2 content_infor_desktop"><span class="title_people">Email:</span> <span>{{$order->email}}</span>
            </div>
            <div class="content-address-order2 content_infor_mobile"><span class="title_people">Email:</span> <span>{{$order->email}}</span>
            </div>
            <div class="content-address-order content_infor_mobile"><span class="title_people">Phương thức thanh toán:</span><span>@if($order->type_payment == 1)
                        Nhận hàng thanh toán @else Thanh toán qua VNPAY @endif</span></div>
            <div class="content-address-order content_infor_desktop"><span class="title_people">Địa chỉ :</span>
                <span>{{$order->full_address}}</span></div>
            <div class="content-address-order2 content_infor_desktop"><span class="title_people">Trạng thái:</span> <span>{{$order->status_name}}</span></div>
            <div class="content-address-order2 content_infor_mobile"><span class="title_people">Trạng thái:</span> <span>{{$order->status_name}}</span></div>
            <div class="content-address-order2"><span class="title_people">Ghi chú:</span> <span>{{$order->note}}</span>
            </div>
            <div class="content-address-order content_infor_desktop"><span class="title_people">Phương thức thanh toán:</span><span>@if($order->type_payment == 1)
                        Nhận hàng thanh toán @else Thanh toán qua VNPAY @endif</span></div>
        </div>

    </div>

    <p class="title-address-order mt-3 mb-0">Thông tin sản phẩm</p>
    @foreach($order_item as $item)
        <div class="d-flex justify-content-between align-items-end pb-2 pt-2" style="border-bottom: 1px solid #cccccc">
            <div class="d-flex align-items-center panel-product-order first-product">
                <div class="image-product">
                    <img src="{{$item->product_image->image}}" alt="" class="image-product-order">
                </div>
                <div class="info_product ml-4">
                    <div class="title-product-order">{{$item->product_name->name}}</div>
                    <div class="product-color">
                        <span>Màu {{$item->product_attribute->name}}</span>
                    </div>
                    <div class="title-product-order">Số lượng: {{$item->quantity}}</div>
                </div>
            </div>
            <div class="check_price_detail">
                <p><span class="text-price title-total-money">{{number_format($item->promotional_price)}}đ</span> <span
                        class="title-total-money" style="color: red">{{number_format($item->total_money)}}đ</span></p>
            </div>
        </div>
    @endforeach
    <div class="mt-3 d-flex flex-column align-items-end">
        <div class="content-money-order d-flex align-items-center justify-content-between"><span
                style="font-weight: 700">Tổng tiền hàng:</span>
            <p style="width: 165px;margin-bottom: 0;text-align: right">{{number_format($order->total_money_product)}}đ</p></div>
        <div class="content-money-order d-flex align-items-center justify-content-between"><span
                style="font-weight: 700">Phí vận chuyển:</span>
            <p style="width: 165px;margin-bottom: 0;text-align: right">{{number_format($order->fee_shipping)}}đ</p>
        </div>
        <div class="content-money-order d-flex align-items-center justify-content-between"><span
                style="font-weight: 700">Thành tiền:</span>
            <p style="width: 165px;margin-bottom: 0;text-align: right;color: red">{{number_format($order->total_money_order)}}đ</p></div>
    </div>

</div>
