@if(count($flash_sale) > 0)
    <div class="box-sale">
        <a href="" class="d-flex justify-content-center">
            <img data-src="{{$banner_hot_sale->image}}" class="img-big-sale lazy" alt="">
        </a>
        <div class="box-sales">
            <div class="product_sale sale-hot">
                @foreach($flash_sale as $value)
                    <div class="item-product flash_sale product_sale_hot">
                        <div class="item-child">
                            <a href="{{url('san-pham/'.$value->product->slug)}}">
                                <div class="product-img">
                                    <img class="img-responsive img-prd lazy"
                                         data-src="{{$value->infor->image}}" alt="">
                                    <div class="box-absolute">
                                        <div class="discount-box">
                                            Giảm {{round( 100 - ($value->price_sale / $value->price * 100))}}%
                                        </div>
                                    </div>
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
                                <span class="price">{{number_format($value->price_sale)}}₫</span>
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
    </div>
@endif
