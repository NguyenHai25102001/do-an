@php
    $category_product = \App\Models\CategoryModel::where('display',1)->where('parent_id',0)->orderBy('location','asc')->get();
    $category = \App\Models\CategoryModel::where('display',1)->orderBy('location','asc')->get();
@endphp
<div class="bor_navigation">
    <div class="navigation ">
        <div class="container">
            <div class="visible-xs visible-sm dpl bar_mobile">
                <div class="header_menu text-center">
                    <div class="logo">
                        <a href="{{url('/')}}" title="Hebi Mobile">
                            <img src="{{asset('assets/images/logo.png')}}"
                                 alt="Hebi Mobile" class="img-responsive"/>
                        </a>
                    </div>
                    <div class="search-mobiles">
                        <div id="search-mobile" class="search">
                            <form action="{{route('search')}}" name="search_form" id="search_form" method="get">
                                <div id="search_form_mobile">
                                    <input type="text" value="{{request()->get('keyword')}}" placeholder="Tìm kiếm sản phẩm" name="keyword"
                                           class="navigation__search__input" id="navigation__search__input"/>
                                    <button type="submit" class="searchbt" id='searchbt' ><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex">
                        <a class="icon-phone-xb mobile-phone" href="tel::0978129116">
                            <img src="{{asset('assets/images/phone-call.svg')}}" alt=""
                                 class="img-responsive img-icon"
                                 width="24px" height="24px">
                        </a>
                        <span class="icon-phone-xb" data-bs-toggle="offcanvas"
                              data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <img src="{{asset('assets/images/shopping-bag.svg')}}" alt=""
                                 class="img-responsive img-icon"
                                 width="24px" height="24px">
                        </span>
                    </div>
                </div>
            </div>

            <div class="row align-items-center bar_desktop">
                <div class="col-md-7 col-row-left">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-4 col-row-left-one">
                            <div class="logo-menu">
                                <div class="logo">
                                    <a href="{{url('/')}}" title="Hebi Mobile">
                                        <img
                                            src="{{asset('assets/images/logo.png')}}"
                                            alt="Hebi Mobile" class="img-responsive" width="50px" height="48px"/>
                                    </a>
                                </div>
                                <div class="menu_show align-items-center tab-click" style="cursor: pointer">
                                    <img src="https://onewaymobile.vn/images/menu.svg" alt="Hebi Mobile"
                                         class="image-show-menu visible-md-block visible-lg-block" width="16px"
                                         height="16px">
                                    <span class="catpro">Danh mục</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-row-left-two">
                            <div class="search_1">
                                <div id="search" class="search ">
                                    <div id="collapseExample" class="collapse_search">
                                        <form action="{{route('search')}}" name="search_form" id="search_form" method="get">
                                            <input type="text" value="{{request()->get('keyword')}}"
                                                   placeholder="Tìm kiếm sản phẩm"
                                                   name="keyword" class="keyword" id="autocomplete"/>
                                            <button type="submit" class="submit_form_search">
                                                <i class="fas fa-search" style="font-weight: 900"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-row-right">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative">
                                <div class="d-flex align-items-center justify-content-end">
                                        <span class="icon-phone-xb">
                                            <img src="{{asset('assets/images/phone-call.svg')}}" alt=""
                                                 class="img-responsive" width="24px" height="24px">
                                        </span>
                                    <a href="tel::0978129116" class="link-to-hotline">
                                        <div class="hotline-head">
                                            <p class="title-hotline">Tổng đài</p>
                                            <b>0978129116</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative">
                                <div class="d-flex align-items-center justify-content-end">
                                        <span class="icon-phone-xb">
                                        <img src="https://onewaymobile.vn/images/map-pin.svg" alt=""
                                             class="img-responsive" width="24px" height="24px">
                                        </span>

                                    <a href="https://onewaymobile.vn/he-thong-cua-hang" class="link-to-hotline">
                                        <div class="hotline-head">
                                            <p class="title-hotline">Chỉ đường đến</p>
                                            <b>Showroom</b>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative" data-bs-toggle="offcanvas"
                                 data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <div class="d-flex align-items-center justify-content-end">
                                        <span class="icon-phone-xb">
                                            <img src="{{asset('assets/images/shopping-bag.svg')}}" alt=""
                                                 class="img-responsive" width="24px" height="24px">
                                        </span>
                                    <span class="link-to-hotline">
                                        <div class="hotline-head">
                                            <p class="title-hotline">Giỏ hàng</p>
                                            <b>Sản phẩm <span class="number_cart">0</span></b>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-show-click">
                <div class="menu-click for-click">
                    <div class="position-absolute">
                        <div id='cssmenu_content' class="position-relative menu ">
                            <ul class='menu-product list-unstyled '>
                                <li class='level_0 first-item' style="padding-top: 6px">
                                    <a href='{{url('danh-muc/dien-thoai')}}' class='lv_0'>
                                        <span><img src="{{asset('assets/images/dienthoai.svg')}}" width='20px' height='20px'>Điện thoại</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_168' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 1)
                                        <li class='level_1 first-item child_168'><a
                                                href='{{url('danh-muc/dien-thoai/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_6' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 first-item child_6'>
                                                    <a href='{{url('danh-muc/dien-thoai/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='level_0' id='pr_7'>
                                    <a href='{{url('danh-muc/may-tinh-bang')}}' class='lv_0'> <span>
                                            <img src="{{asset('assets/images/icon_ipad.png')}}" width='20px' height='20px'>Máy tính bảng</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_7' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 2)
                                        <li class='level_1 child_7'>
                                            <a href='{{url('danh-muc/may-tinh-bang/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_143' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 last-item child_143'>
                                                    <a href='{{url('danh-muc/may-tinh-bang/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='level_0' id='pr_7'>
                                    <a href='{{url('danh-muc/laptop')}}' class='lv_0'> <span>
                                            <img src="{{asset('assets/images/laptop.svg')}}" width='20px' height='20px'>Laptop</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_7' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 3)
                                        <li class='level_1 child_7'>
                                            <a href='{{url('danh-muc/laptop/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_143' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 last-item child_143'><a
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
                                <li class='level_0' id='pr_169'>
                                    <a href='{{url('danh-muc/dong-ho-thong-minh')}}' class='lv_0'>
                                        <span>
                                            <img src='{{asset('assets/images/dong-ho-thong-minh.svg')}}' width='20px' height='20px'>Đồng hồ thông minh</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_169' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 4)
                                        <li class='  level_1 child_169'>
                                            <a href='{{url('danh-muc/dong-ho-thong-minh/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_160' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='  level_2 child_160'>
                                                    <a href='{{url('danh-muc/dong-ho-thong-minh/'.$value->name.'/'.$item->slug)}}'>
                                                        {{$item->name}}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                            @endif
                                        @endforeach
                                            </ul>
                                        </li>
                                <li class='level_0' id='pr_150'><a
                                        href='{{url('danh-muc/nha-thong-minh')}}' class='lv_0'> <span>
                                            <img src='{{asset('assets/images/nhathongminh.svg')}}' width='20px' height='20px'>Nhà thông minh</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_150' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 5)
                                        <li class='level_1 child_150'><a
                                                href='{{url('danh-muc/nha-thong-minh/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_152' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 child_152'><a
                                                        href='{{url('danh-muc/nha-thong-minh/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='level_0' id='pr_11'>
                                    <a href='{{url('danh-muc/phu-kien')}}' class='lv_0'><span>
                                            <img src='{{asset('assets/images/accessory.svg')}}' width='20px' height='20px'>Phụ kiện</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_11' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 6)
                                        <li class='level_1 child_11'><a
                                                href='{{url('danh-muc/phu-kien/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_135' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 child_135'><a
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
                                <li class='level_0' id='pr_258'><a
                                        href='{{url('danh-muc/am-thanh')}}' class='lv_0'><span>
                                            <img src='{{asset('assets/images/am-thanh.svg')}}' width='20px' height='20px'>Âm thanh</span><i
                                            class='fa fa-angle-right'></i></a>
                                    <ul id='c_258' class='wrapper_children_level0'>
                                        @foreach($category_product as $value)
                                            @if($value->type == 7)
                                        <li class='level_1 child_258'><a
                                                href='{{url('danh-muc/am-thanh/'.$value->name)}}'>{{$value->name}}</a>
                                            <ul id='c_132' class='wrapper_children wrapper_children_level1'>
                                                @foreach($category as $item)
                                                    @if($item->parent_id == $value->id)
                                                <li class='level_2 child_132'>
                                                    <a href='{{url('danh-muc/am-thanh/'.$value->name.'/'.$item->slug)}}'>{{$item->name}}</a>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class='level_0' id='pr_89'>
                                    <a href='{{url('tin-tuc/trang-chu')}}' class='lv_0'> <span>
                                            <img src='{{asset('assets/images/tintuc.svg')}}'  width='20px' height='20px'>Tin tức</span><i
                                            class='fa fa-angle-right'></i></a>
                                <li class='level_0' style="padding-bottom: 7px"><a
                                        href='{{url('tra-cuu-don-hang')}}'
                                        class='lv_0'> <span><img
                                                src=https://onewaymobile.vn/images/menus/tragop_1663659805.svg alt=Trả
                                                góp width='20px' height='20px'>Tra cứu đơn hàng</span><i
                                            class='fa fa-angle-right'></i></a>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header header_cart" >
        <h5 class="offcanvas-title text-center w-100 text-white" id="offcanvasRightLabel" style="padding-left: 20px">Giỏi hàng</h5>
        <button type="button" class="btn-close-cart" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="offcanvas-body list_carts">

    </div>
</div>
