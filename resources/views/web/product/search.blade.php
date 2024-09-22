@extends('web.layout.master')
@section('title','Hebi Store')
{{--meta--}}
@section('meta')
    <meta name="description" content=""/>
    <meta name="keywords" content="Hebi Mobile">
@stop
@section('style_page')
    <link rel="stylesheet" href="dist/category/category.css">
@stop
{{--content of page--}}
@section('content')
    <div class="headerCategory">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{url('/')}}"><span class="name">Trang chủ</span></a>
                <div class="breadcrumbs_sepa"></div>
                <span class="name">Kết quả tìm kiếm cho: '{{$keyword}}'</span>
            </div>
        </div>
    </div>
    <div class="container">
        <p class="cat_title">Sắp xếp theo:</p>
        <div class="box_ft">
            <form action="{{route('search')}}" method="get">
            <div class="list_check">
                <input type="hidden" name="keyword" value="{{request()->get('keyword')}}">
                <button class="sort_price" name="sort_price" value="1">
                    <i class="fa-solid fa-arrow-up-wide-short" style="font-size: 16px"></i>
                    Giá Cao - Thấp </button>
                <button class="sort_price" name="sort_price" value="2">
                    <i class="fa-solid fa-arrow-down-wide-short" style="font-size: 16px"></i>
                    Giá Thấp - Cao </button>
            </div>
            </form>
        </div>
    </div>
    <div class="container content-cate-mobile">
        <div class="box list-items">
            @if(count($product) > 0)
            <div class="productList">
                @foreach($product as $value)
                    <div class="item-product product_sale_hot col-lg-13 col-lg-14 col-md-15 col-16">
                        <div class="item-child">
                            <a href="{{url('san-pham/'.$value->slug)}}">
                                <div class="product-img">
                                    <img class="img-responsive img-prd lazy"
                                         data-src="{{$value->infor->image}}"
                                         alt="ảnh sản phẩm">
                                    <div class="box-absolute">
                                        <div class="discount-box">Giảm {{round( 100 - ($value->promotional_price / $value->price * 100))}}%</div>
                                    </div>
                                    @if($value->type_sale == 1)
                                        <div class="count_down_fl">
                                            <p class="coun_down text-center">
                                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.4987 5.14581V7.31248L7.85286 8.12498M6.4987 2.70831C3.95589 2.70831 1.89453 4.76967 1.89453 7.31248C1.89453 9.85529 3.95589 11.9166 6.4987 11.9166C9.04151 11.9166 11.1029 9.85529 11.1029 7.31248C11.1029 4.76967 9.04151 2.70831 6.4987 2.70831ZM6.4987 2.70831V1.08331M5.41536 1.08331H7.58203M11.0102 3.029L10.1977 2.2165L10.604 2.62275M1.98717 3.029L2.79967 2.2165L2.39342 2.62275"
                                                        stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
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
                            <a href="{{url('san-pham/'.$value->slug)}}" class="product-name">{{$value->name}}</a>
                            <div class="product-tech">
                                @foreach($value->type_product as $item)
                                    <a href="{{url('san-pham/'.$item->slug)}}"
                                       class="{{$value->own_parameter == $item->own_parameter?'active':''}}">{{$item->own_parameter}}</a>
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
            <div class="d-flex justify-content-center">
                {{ $product->appends(request()->all())->links('web.partials.paginate') }}
            </div>
            @else
            <p class="text_search">Không tìm thấy kết quả bạn cần tìm</p>
                @endif
        </div>
    </div>
@stop
@section('script_page')

@stop
