@extends('web.layout.master')
@section('title','Hebi Store')

@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/product/product.css">
@stop

@section('content')
    <div class="headerCategory">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{url('/')}}">
                    <span class="name">Trang chủ</span>
                </a>
                <div class="breadcrumbs_sepa"></div>
                <a href="{{url('danh-muc/'.$status)}}">
                    <span class="name">
                        @if($product_infor->type_product == 1) Điện thoại @elseif($product_infor->type_product == 2) Máy
                        tính bảng @elseif($product_infor->type_product == 3)
                            Laptop @elseif($product_infor->type_product == 4) Đồng hồ thông minh
                        @elseif($product_infor->type_product == 5) Nhà thông
                        minh @elseif($product_infor->type_product == 6) Phụ kiện @else Âm thanh @endif</span>
                </a>
                <div class="breadcrumbs_sepa"></div>
                <a href="{{url('danh-muc/'.$status.'/'.$name_category->name)}}">
                    <span class="name">{{$name_category->name}}</span>
                </a>
                <div class="breadcrumbs_sepa"></div>
                <a href="{{url('danh-muc/'.$status.'/'.$name_category->name.'/'.$category->slug)}}">
                    <span class="name">{{$product_infor->name_category}}</span>
                </a>
                <div class="breadcrumbs_sepa"></div>
                <a>
                    <span class="name">{{$product->name}}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="bg-white">
        <div class="container">
            <div class="_rowtop">
                <h1 class="">{{$product->name}}</h1>
                @if($product->star)
                    <div class="product-rate">
                        <div class="star-rating" style="--rating:{{$product->star}}"></div>
                    </div>
                @endif
            </div>
            <section class="row details-top">
                <aside class="_picture col-sm-4" id="picture" width="390" height="460">
                    <div class="slide-image row-item " style="overflow: hidden;">
                        <div class="slider-image slider-all"
                             style="border: 1px solid #666;border-radius: 12px;overflow: hidden;height: 290px">
                            @foreach($image_product as $item)
                                <div class="d-flex justify-content-center align-items-center">
                                    <img class="img-phone-detail"
                                         src="{{$item->image}}"
                                         alt="">
                                </div>
                            @endforeach
                        </div>
                        <div class="detail-slider slider-one mt-3">
                            @foreach($image_product as $item)
                                <img class="img-responsive img-phone-child"
                                     src="{{$item->image}}"
                                     alt="">
                            @endforeach
                        </div>
                    </div>
                    @if($product_infor->salient_features)
                        <div class="warranty">
                            <h4>Chính sách Bảo hành</h4>
                            <div class="content_salient_features">{!! $product_infor->salient_features !!}</div>
                        </div>
                    @endif
                </aside>
                <aside class="_extra col-sm-4">
                    <div class="details_top1">
                        <div class="details_top">
                            <p class="name_mobile visible-xs">Bạn đang xem {{$product->name}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="top_prd ">
                                    <span class="_price"></span>
                                    <span class="price_old"></span>
                                </p>
                                @if($product->time_end)
                                    <p class="coun_down text-center" style="color: #B00020">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M7.9987 6.33333V9L9.66536 10M7.9987 3.33333C4.86908 3.33333 2.33203 5.87038 2.33203 9C2.33203 12.1296 4.86908 14.6667 7.9987 14.6667C11.1283 14.6667 13.6654 12.1296 13.6654 9C13.6654 5.87038 11.1283 3.33333 7.9987 3.33333ZM7.9987 3.33333V1.33333M6.66536 1.33333H9.33203M13.5514 3.72802L12.5514 2.72802L13.0514 3.22802M2.44604 3.72802L3.44604 2.72802L2.94604 3.22802"
                                                stroke="#B00020" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="time_coundown" id="time_end"
                                              data-end="{{date('l, F d Y h:i:s', strtotime($product->time_end))}}">
                                                    <span class="day"></span>
                                                    <span class="hours"></span>
                                                    <span class="minutes"></span>
                                                    <span class="seconds"></span></span>
                                    </p>
                                @endif
                            </div>

                            <div class="edit-price">
                                <div class="list_same">
                                    @foreach($list_product as $item)
                                        <a href="{{url('san-pham/'.$item->slug)}}"
                                           class="item_same @if($item->id == $product->id) active @endif">
                                            <span class="nick_name">{{$item->own_parameter}}</span>
                                            <span class="price_same" style="color: #DA0000;font-weight: 600">{{number_format($item->promotional_price)}}đ</span>
                                        </a>
                                    @endforeach
                                </div>
                                <p><b>Chọn màu để xem giá</b></p>
                                <div class="products_type">
                                    @foreach($product_attribute as $index => $item)
                                        <div data_price="{{number_format($item->price)}}"
                                             data_promotional_price="{{number_format($item->price_sale)}}"
                                             data_product_id="{{$item->id}}"
                                             data_quantity = "{{$item->quantity}}"
                                             class="item_price products_type_item products_type_click  @if($index == 0) active @endif  ">
                                            <p class="w-100" style="margin-left: 0px!important;">
                                                <span class="text-center w-100"
                                                      style="font-weight: 600">{{$item->name}}</span>
                                                <span class="text-center w-100" style="color: #DA0000;font-weight: 600">{{number_format($item->price_sale)}}đ</span>
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if($product_infor->special_offer)
                                <div class="accessories">
                                    <h4>Ưu đãi đặc biệt</h4>
                                    <div>{!! $product_infor->special_offer !!}</div>
                                </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="button-cart" class="justify-content-between align-items-center">
                        <div style="width: calc(100% - 75px);">
                            <a id="buy-now" href="#" class="btn-buy btn mt10">
                                Mua ngay
                                <span>Giao tận nơi hoặc nhận tại cửa hàng</span>
                            </a>
                        </div>
                        <button class="btn-add-cart">
                            <img data-src="{{asset('assets/images/add-to-cart.png')}}" class="lazy" alt="">
                            <span>Thêm vào giỏ</span>
                        </button>
                    </div>
                    <div id="text_contact">Sản phẩm tạm thời hết hàng</div>
                    <div class="call_shop" style="margin-top:20px;">
                        <i class="fa-solid fa-square-phone" style="color: #0a53be;font-size: 17px"></i>
                        <a href="tel:0978129116">0978129116</a>
                        <span>Thời gian làm việc (08h15 - 22h00)</span>
                    </div>
                </aside>
                @if($product_infor->promotion_policy)
                    <aside class="buycall col-sm-4">
                        <div class="standard_product" id="accessories">
                            <h4 class="c-h4">
                                <img data-src="" alt="" class="img-responsive lazy">
                                Chính sách khuyến mãi
                            </h4>
                            <div class="c-standard_product">{!! $product_infor->promotion_policy !!}</div>
                        </div>
                    </aside>
                @endif
            </section>
        </div>
    </div>
    <div class="container">
        @if(count($product_related) > 0)
            <div class="box-sales contentdetail">
                <p class="title_box mb-1">Sản phẩm liên quan</p>
                <div class="product_sale sale-hot">
                    @foreach($product_related as $value)
                        <div class="item-product product_sale_hot">
                            <div class="item-child">
                                <a href="{{url('san-pham/'.$value->product->slug)}}">
                                    <div class="product-img">
                                        <img class="img-responsive img-prd lazy"
                                             data-src="{{$value->infor->image}}"
                                             alt="ảnh sản phẩm">
                                        <div class="box-absolute">
                                            <div class="discount-box">
                                                Giảm {{round( 100 - ($value->promotional_price / $value->price * 100))}}
                                                %
                                            </div>
                                        </div>
                                        @if($value->type_sale == 1)
                                            <div class="count_down_fl">
                                                <p class="coun_down text-center">
                                                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M6.4987 5.14581V7.31248L7.85286 8.12498M6.4987 2.70831C3.95589 2.70831 1.89453 4.76967 1.89453 7.31248C1.89453 9.85529 3.95589 11.9166 6.4987 11.9166C9.04151 11.9166 11.1029 9.85529 11.1029 7.31248C11.1029 4.76967 9.04151 2.70831 6.4987 2.70831ZM6.4987 2.70831V1.08331M5.41536 1.08331H7.58203M11.0102 3.029L10.1977 2.2165L10.604 2.62275M1.98717 3.029L2.79967 2.2165L2.39342 2.62275"
                                                            stroke="white" stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                    <span class="time_coundown" id="time_end"
                                                          data-end="{{date('l, F d Y h:i:s', strtotime($value->time_end))}}">
                                                    <span class="day"></span>
                                                    <span class="hours"></span>
                                                    <span class="minutes"></span>
                                                    <span class="seconds"></span></span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <a href="{{url('san-pham/'.$value->product->slug)}}"
                                   class="product-name">{{$value->product->name}}</a>
                                <div class="product-tech">
                                    @foreach($value->type_product as $item)
                                        <a href="{{url('san-pham/'.$item->slug)}}"
                                           class="{{$value->product->own_parameter == $item->own_parameter?'active':''}}">{{$item->own_parameter}}</a>
                                    @endforeach
                                </div>
                                <div class="product-tech">
                                    <span>{{$value->infor->parameter_one}}</span>
                                    <span>{{$value->infor->parameter_two}}</span>
                                    <span>{{$value->infor->parameter_three}}</span>
                                    <span>{{$value->infor->parameter_four}}</span>
                                </div>
                                <div class="product-price">
                                    <span class="price">{{number_format($value->promotional_price)}}₫</span>
                                    <del class="price-old">{{number_format($value->price)}}₫</del>
                                </div>
                                <div class="product-status">
                                    <span>Mới 100%</span>
                                    @if($value->star)
                                        <div class="product-rate">
                                            <div class="star-rating" style="--rating:{{$value->star}}"></div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <section class="contentdetail row flex-wrap-reverse">
            <div class="col-sm-8 detail_botom">
                <div class="box-detail">
                    <div class="title_box">
                        <span>Thông tin sản phẩm</span>
                    </div>
                    <div class="boxdesc show-more" id="boxdesc">{!! $product_infor->product_information !!}</div>
                    <a class="details_click clickmore">Xem thêm</a>
                </div>
                <div class="box-detail">
                    <div class="title_box" style="padding-top: 8px">
                        <span>Đánh giá {{$product->name}}</span>
                    </div>
                    <div class="row align-items-center box_content">
                        <div class="col-md-3 content_feedback_1">
                            <p class="number_start">{{$product->star??0}}/5</p>
                            <div class="product-rate">
                                <div class="star-rating" style="--rating: {{$product->star??0}};font-size: 16px"></div>
                            </div>
                            @if(count($star) > 0)
                                <p style="font-size: 14px;color: #999999;margin-bottom: 0px">(Có {{count($star)}} đánh
                                    giá)</p>
                            @else
                                <p style="font-size: 14px;color: #999999;margin-bottom: 0px">(Chưa có đánh giá)</p>
                            @endif
                        </div>
                        <div class="col-md-6 content_feedback_2">
                            <div class="rating">
                                <div class="start_line">
                                    <div class="star-rating" style="--rating: 5;"></div>
                                    <div class="progess">
                                        <div class="line_progess">
                                            <div class="progress-bar" style="width: {{$percent_5??0}}%"></div>
                                        </div>
                                    </div>
                                    <p class="point_sao">{{$percent_5??0}}%</p>
                                </div>
                                <div class="start_line">
                                    <div class="star-rating" style="--rating: 4;"></div>
                                    <div class="progess">
                                        <div class="line_progess">
                                            <div class="progress-bar" style="width: {{$percent_4??0}}%"></div>
                                        </div>
                                    </div>
                                    <p class="point_sao">{{$percent_4??0}}%</p>
                                </div>
                                <div class="start_line">
                                    <div class="star-rating" style="--rating: 3;"></div>
                                    <div class="progess">
                                        <div class="line_progess">
                                            <div class="progress-bar" style="width: {{$percent_3??0}}%"></div>
                                        </div>
                                    </div>
                                    <p class="point_sao">{{$percent_3??0}}%</p>
                                </div>
                                <div class="start_line">
                                    <div class="star-rating" style="--rating: 2;"></div>
                                    <div class="progess">
                                        <div class="line_progess">
                                            <div class="progress-bar" style="width: {{$percent_2??0}}%"></div>
                                        </div>
                                    </div>
                                    <p class="point_sao">{{$percent_2??0}}%</p>
                                </div>
                                <div class="start_line">
                                    <div class="star-rating" style="--rating: 1;"></div>
                                    <div class="progess">
                                        <div class="line_progess">
                                            <div class="progress-bar" style="width: {{$percent_1??0}}%"></div>
                                        </div>
                                    </div>
                                    <p class="point_sao">{{$percent_1??0}}%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 content_feedback_3">
                            <button class="btn_review" data-bs-toggle="collapse" data-bs-target="#collapseFeedback"
                                    aria-expanded="false" aria-controls="collapseExample">
                                Viết đánh giá
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="collapseFeedback">
                        <div style="border-bottom: 1px solid #e5e5e5">
                            <div class="rating-container d-flex align-items-center mt-3 mb-3 w-100 flex-wrap">
                                <p class="title_start" style="font-weight: 600">Đánh giá của bạn về sản phẩm</p>
                                <div class="d-flex">
                                    <div class="rating-item">
                                        <input type="radio" id="rating1" class="start" name="rating" value="1" required>
                                        <label for="rating1"></label>
                                    </div>
                                    <div class="rating-item">
                                        <input type="radio" id="rating2" class="start" name="rating" value="2" required>
                                        <label for="rating2"></label>
                                    </div>
                                    <div class="rating-item">
                                        <input type="radio" id="rating3" class="start" name="rating" value="3" required>
                                        <label for="rating3"></label>
                                    </div>
                                    <div class="rating-item">
                                        <input type="radio" id="rating4" class="start" name="rating" value="4" required>
                                        <label for="rating4"></label>
                                    </div>
                                    <div class="rating-item">
                                        <input type="radio" id="rating5" class="start" name="rating" value="5" required>
                                        <label for="rating5"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                <input type="hidden" name="type" id="type" value="{{$product_infor->type_product}}">
                                <div class="col-sm-6">
                                    <textarea name="content" id="full_rate" class="form-control" required></textarea>
                                </div>
                                <div class="col-sm-6 row" style="padding-right: 0px!important;">
                                    <div class="col-sm-6">
                                        <input type="text" name="name" class="form-control input_text" required
                                               placeholder="Họ và tên">
                                        <input type="text" name="phone" class="form-control input_text" required
                                               placeholder="Số điện thoại">
                                    </div>
                                    <div class="col-sm-6" style="padding-right: 0px!important;">
                                        <input type="text" name="email" class="form-control input_text" required
                                               placeholder="Email">
                                        <button type="submit" class="btn_send">GỬI ĐÁNH GIÁ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div id="postContainer">
                            @foreach($comment as $value)
                                <div class="mb-4 post">
                                    <div class="d-flex justify-content-between align-items-center"
                                         style="font-weight: 600">
                                        <p>{{$value->name}}</p>
                                        <p>{{date('d/m/Y', strtotime($value->created_at))}}</p>
                                    </div>
                                    <div class="boxReview-comment-item-review p-2 py-2">
                                        <div class="d-flex align-items-center">
                                            <span>Đánh giá: </span>
                                            <span class="px-2">
                                        <div class="star-rating" style="--rating:{{$value->star}}"></div>
                                    </span>
                                        </div>
                                        <div>
                                            <span>Nhận xét: </span>
                                            <span>{{$value->content}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <div class="load-more" id="loadMore">Xem thêm</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 left_bottom" id="thongso">
                <div class="_characteristic box-detail">
                    <div class="title_box">
                        <span>Thông số kỹ thuật </span>
                    </div>
                    <div style="max-height: 648px;overflow: hidden">{!! $product->specifications !!}</div>
                    <button id="load_more_charactestic" class="w-100" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                        <span>Xem cấu hình chi tiết</span>
                    </button>
                </div>

                @if(count($new) > 0)
                    <div id="new_related" class="new_related_mb box-detail">
                        <div class="title_box d-flex">
                            <span style="padding-left: 10px">Tin tức mới</span>
                        </div>
                        <div class="relate_content ">
                            @foreach($new as $value)
                                <a class="l_item" href="{{url('chi-tiet-tin-tuc/'.$value->slug)}}">
                                    <img class="img-responsive lazy" width="120" height="68"
                                         data-src="{{$value->image}}">
                                    <span>{{$value->title}}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
    <!-- Modal cấu hình -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body body_characteristic">
                    <p class="title_characteristic">Thông số kỹ thuật chi tiết Điện thoại Apple iPhone 13 - 128GB
                        VN/A</p>
                    <div>{!! $product->specifications !!}</div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script_page')
    <script src="{{asset('dist/product/product.js')}}"></script>
@stop
