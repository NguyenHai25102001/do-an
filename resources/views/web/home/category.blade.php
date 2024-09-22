<div class="home-top">
    <div class="position-absolute mobile-posi" style="position: unset!important;">
        <div id='cssmenu_content' class="position-relative menu ">
            <ul class='menu-product list-unstyled '>
                <li class='level_0 first-item' style="padding-top: 6px">
                    <a href='{{url('danh-muc/dien-thoai')}}' class='lv_0'>
                                <span><img src="{{asset('assets/images/dienthoai.svg')}}"
                                           width='20px' height='20px'>Điện thoại</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 1)
                                <li class='level_1 first-item'><a
                                        href='{{url('danh-muc/dien-thoai/'.$value->name)}}'>{{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 first-item'><a
                                                        href='{{url('danh-muc/dien-thoai/'.$value->name.'/'.$item->slug)}}'>
                                                        {{$item->name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class='level_0'><a href='{{url('danh-muc/may-tinh-bang')}}' class='lv_0'> <span><img
                                src="{{asset('assets/images/icon_ipad.png')}}"
                                width='20px' height='20px'>Máy tính bảng</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 2)
                                <li class='level_1'><a href='{{url('danh-muc/may-tinh-bang/'.$value->name)}}'>
                                        {{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 last-item '><a
                                                        href='{{url('danh-muc/may-tinh-bang/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class='level_0'><a
                        href='{{url('danh-muc/laptop')}}' class='lv_0'> <span><img
                                src="{{asset('assets/images/laptop.svg')}}"
                                width='20px' height='20px'>Laptop</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 3)
                                <li class='level_1 '><a href='{{url('danh-muc/laptop/'.$value->name)}}'>
                                        {{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 last-item '><a
                                                        href='{{url('danh-muc/laptop/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class='level_0'><a href='{{url('danh-muc/dong-ho-thong-minh')}}' class='lv_0'>
                        <span><img src='{{asset('assets/images/dong-ho-thong-minh.svg')}}' width='20px' height='20px'>Đồng hồ thông minh</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 4)
                                <li class='level_1 '><a
                                        href='{{url('danh-muc/dong-ho-thong-minh/'.$value->name)}}'>{{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 '><a
                                                        href='{{url('danh-muc/dong-ho-thong-minh/'.$value->name.'/'.$item->slug)}}'>
                                                        {{$item->name}}</a>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class='level_0'><a
                        href='{{url('danh-muc/nha-thong-minh')}}' class='lv_0'> <span><img
                                src={{asset('assets/images/nhathongminh.svg')}}
                                    width='20px' height='20px'>Nhà thông minh</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 5)
                                <li class='level_1'><a
                                        href='{{url('danh-muc/nha-thong-minh/'.$value->name)}}'>{{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 '><a
                                                        href='{{url('danh-muc/nha-thong-minh/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class='level_0'><a href='{{url('danh-muc/phu-kien')}}'
                                       class='lv_0'> <span><img
                                src={{asset('assets/images/accessory.svg')}}
                                    width='20px' height='20px'>Phụ kiện</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 6)
                                <li class='level_1 '><a
                                        href='{{url('danh-muc/phu-kien/'.$value->name)}}'>{{$value->name}}</a>
                                    <ul class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 '><a
                                                        href='{{url('danh-muc/phu-kien/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class='level_0'><a
                        href='{{url('danh-muc/am-thanh')}}' class='lv_0'> <span><img
                                src={{asset('assets/images/am-thanh.svg')}} width='20px'
                                height='20px'>Âm thanh</span><i
                            class='fa fa-angle-right'></i></a>
                    <ul class='wrapper_children_level0'>
                        @foreach($category_product as $value)
                            @if($value->type == 7)
                                <li class='level_1 '><a
                                        href='{{url('danh-muc/am-thanh/'.$value->name)}}'>{{$value->name}}</a>
                                    <ul id='c_132' class='wrapper_children wrapper_children_level1'>
                                        @foreach($category as $item)
                                            @if($item->parent_id == $value->id)
                                                <li class='level_2 '><a
                                                        href='{{url('danh-muc/am-thanh/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>

                <li class='level_0'>
                    <a href='{{url('tin-tuc/trang-chu')}}' class='lv_0'>
                                <span><img src="{{asset('assets/images/tintuc.svg')}}" width='20px'
                                           height='20px'>Tin tức</span><i class='fa fa-angle-right'></i></a>
                </li>
                <li class='level_0'>
                    <a href='{{url('tra-cuu-don-hang')}}' class='lv_0'> <span>
                            <i class="fa-solid fa-truck-fast" ></i>Tra cứu đơn hàng</span><i
                            class='fa fa-angle-right'></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="home-slider-banner">
        <div class="row-3">
            <div class="col-md-row col-left">
                <div class="slider-image slider-for">
                    @foreach($banner_top as $item)
                        <div class="item-image image_banner_home">
                            <a href="{{$item->link}}">
                                <img alt="{{$item->title}}" width="714px" height="301px"
                                     src="{{$item->image}}"
                                     class="img-responsive img-banner-responsive">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="detail-slider slider-nav">
                    @foreach($banner_top as $item)
                        <div class="item-caption">
                            <div>
                                <p class="title">{{$item->title}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-row col-right">
                <div class='banners banners-home banners-default block_inner block_banner'>
                    @foreach($banner_top_right as $item)
                        <a href="{{$item->link}}" title='{{$item->title}}' id="banner_item_27">
                            <img class="img-old img-responsive me-4" alt="{{$item->title}}"
                                 src="{{$item->image}}">
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
<a href="{{$banner_two->link}}">
    <img src="{{$banner_two->image}}" alt="" class="banner-home-top2">
</a>
