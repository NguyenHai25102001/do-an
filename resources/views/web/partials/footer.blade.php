@php
    $contact_infor = \App\Models\IntroduceModel::where('display',1)->where('type',0)->get();
    $policy = \App\Models\IntroduceModel::where('display',1)->where('type',1)->get();
    $other_infor = \App\Models\IntroduceModel::where('display',1)->where('type',2)->get();
    $category_product = \App\Models\CategoryModel::where('display',1)->where('parent_id',0)->orderBy('location','asc')->get();
    $category = \App\Models\CategoryModel::where('display',1)->orderBy('location','asc')->get();
@endphp
<div class="fab-wrapper">
    <input id="fabCheckbox" type="checkbox" class="fab-checkbox"/>
    <label class="fap" for="fabCheckbox">
        <span class="fab-dots fab-dots-1"></span>
        <span class="fab-dots fab-dots-2"></span>
        <span class="fab-dots fab-dots-3"></span>
    </label>
    <div class="fab-wheel">
        <a class="fab-action fab-action-1" style="background: red">
            <i class="fa-brands fa-youtube" style="font-size: 25px"></i>
        </a>
        <a class="fab-action fab-action-2">
            <i class="fa-brands fa-tiktok" style="font-size: 25px"></i>
        </a>
        <a class="fab-action fab-action-3" style="background: #ffa000">
            <img data-src="{{asset('assets/images/icon-zalo.png')}}" class="lazy" alt="" style="width: 35px;">
        </a>
        <a class="fab-action fab-action-4" style="background: #0058ff">
            <i class="fa-brands fa-facebook" style="font-size: 29px"></i>
        </a>
    </div>
</div>
<footer class="footer">
    <div class="container footer-end">
        <div class="top_ft">
            <div class="item-menu">
                <span class="title_item title-menu title-menu1">Thông tin liên hệ <i
                        class="fa fa-angle-down hidden"></i></span>
                <div class="bottom-nav nav-bottom1">
                    <ul>
                        @foreach($contact_infor as $item)
                            <li class="first-item">
                                <a href="{{url('gioi-thieu/'.$item->slug)}}">{{$item->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="item-menu">
                <span class="title_item title-menu title-menu2">Chính sách <i
                        class="fa fa-angle-down hidden"></i></span>
                <div class="bottom-nav nav-bottom2">
                    <ul>
                        @foreach($policy as $item)
                            <li class="first-item">
                                <a href="{{url('gioi-thieu/'.$item->slug)}}">{{$item->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="item-menu">
                <span class="title_item title-menu title-menu3">Thông tin khác <i
                        class="fa fa-angle-down hidden"></i></span>
                <div class="bottom-nav nav-bottom3">
                    <ul>
                        @foreach($other_infor as $item)
                            <li class="first-item">
                                <a href="{{url('gioi-thieu/'.$item->slug)}}">{{$item->title}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="fanpage item-menu">
                <span class="title_item">Hỗ trợ thanh toán</span>
                <div class="bank-ft">
                    <img data-src="https://onewaymobile.vn/images/icon/bank1.png" alt=""
                         class="img-responsive img-footer-pay lazy" width="241px"
                         height="33px">
                    <img data-src="https://onewaymobile.vn/images/icon/bank2.png" alt=""
                         class="img-responsive img-footer-pay lazy" width="117px"
                         height="33px">
                </div>
                <div class="dmca-protec">
                    <a href="" target="_blank" class="img-dk-ft">
                        <img data-src=" https://onewaymobile.vn/images/config/c52a1034a68361dd3892_1666686156.jpg"
                             class="img-responsive img lazy" style="width: 133px; height: 50px">
                    </a>
                </div>
            </div>
        </div>
        <div class="copyright_">
            <div class="copyright_right" style="color: #999999">
                <span>Copyright © 2023 - Bản quyền thuộc về Hebi.</span>
            </div>
            <div class="bot_foot_right">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/ONEWAY.416CAUGIAY/"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a href="https://bit.ly/33UHrmv"><i class="fab fa-youtube"></i></a>
                    </li>
                    <li>
                        <a href="https://bit.ly/2XtNtIJ"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/"><i class="fab fa-google"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="catpro" class="danhmuc">
        <div class="category">
            <nav>
                <ul class="sub-menu">
                    <li class="menubottom " onclick="activeFooter(1)">
                        <div class="show_par icon_hover" title="Điện thoại">
                            <div class="icon_plus">
                                <img width="30" height="30"
                                     data-src="{{asset('assets/images/dienthoai.svg')}}"
                                     class="img-responsive icon-img-footer lazy"> Điện thoại
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(2)">
                        <div class="show_par icon_hover" title="Laptop">
                            <div class="icon_plus">
                                <img width="30" height="30"
                                     data-src="{{asset('assets/images/icon_ipad.png')}}"
                                     class="img-responsive icon-img-footer lazy"> Máy tính bảng
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(3)">
                        <div class="show_par icon_hover" title="Laptop">
                            <div class="icon_plus">
                                <img width="30" height="30"
                                     src="{{asset('assets/images/laptop.svg')}}"
                                     class="img-responsive icon-img-footer"> Laptop
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(4)">
                        <div class="show_par icon_hover" title="Đồng hồ thông minh">
                            <div class="icon_plus">
                                <img width="30" height="30"
                                     data-src="{{asset('assets/images/dong-ho-thong-minh.svg')}}"
                                     class="img-responsive icon-img-footer lazy"> Đồng hồ thông minh
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(5)">
                        <div class="show_par icon_hover" title="Nhà thông minh">
                            <div class="icon_plus">
                                <img width="30" height="30"
                                     data-src="{{asset('assets/images/nhathongminh.svg')}}"
                                     class="img-responsive icon-img-footer lazy"> Nhà thông minh
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(6)">
                        <div class="show_par icon_hover" title="Phụ kiện">
                            <div class="icon_plus">
                                <img width="30" height="30" data-src="{{asset('assets/images/accessory.svg')}}"
                                     class="img-responsive icon-img-footer lazy"> Phụ kiện
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(7)">
                        <div class="show_par" title="Âm thanh">
                            <div class="icon_plus">
                                <img width="30" height="30" data-src="{{asset('assets/images/am-thanh.svg')}}"
                                     class="img-responsive icon-img-footer lazy"> Âm thanh
                            </div>
                        </div>
                    </li>
                    <li class="menubottom " onclick="activeFooter(8)">
                        <div class="show_par" title="Tin tức">
                            <div class="icon_plus">
                                <a href="{{url('tin-tuc/trang-chu')}}">
                                    <img width="30" height="30"
                                         data-src="{{asset('assets/images/tintuc.svg')}}"
                                         class="img-responsive icon-img-footer lazy"> Tin tức </a></div>
                        </div>
                    </li>

                </ul>
                <div class="side-right ">
                    <div class="show_cat show_cat1 active_side">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/dien-thoai')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/dienthoai.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Điện thoại</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 1)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/dien-thoai/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/dien-thoai/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat2 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/may-tinh-bang')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/icon_ipad.png')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Máy tính bảng</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 2)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/may-tinh-bang/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/may-tinh-bang/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat3 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/laptop')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/laptop.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Laptop</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 3)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/laptop/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/laptop/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat4 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/dong-ho-thong-minh')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/dong-ho-thong-minh.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Đồng hồ thông minh</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 4)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/dong-ho-thong-minh/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/dong-ho-thong-minh/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat5 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/nha-thong-minh')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/nhathongminh.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Nhà thông minh</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 5)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/nha-thong-minh/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/nha-thong-minh/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat6 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/phu-kien')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/accessory.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Phụ kiện</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 6)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/phu-kien/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/phu-kien/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="show_cat show_cat7 ">
                        <ul class="me-float">
                            <li>
                                <div>
                                    <a href="{{url('danh-muc/am-thanh')}}"
                                       style="display:flex; line-height:20px;">
                                        <img width="20" height="20"
                                             data-src="{{asset('assets/images/am-thanh.svg')}}"
                                             class="img-responsive lazy"
                                             style="padding: 0; height: 20px; width: 20px; margin: 0 10px 0 0; object-fit: contain;"/>
                                        <span>Âm thanh</span>
                                    </a>
                                </div>
                            </li>
                            @foreach($category_product as $value)
                                @if($value->type == 7)
                                    <li>
                                        <div>
                                            <a href="{{url('danh-muc/am-thanh/'.$value->name)}}">
                                                <span>{{$value->name}}</span>
                                            </a>
                                        </div>
                                        <ul class="me-float ul-child">
                                            @foreach($category as $item)
                                                @if($item->parent_id == $value->id)
                                                    <li>
                                                        <a href="{{url('danh-muc/am-thanh/'.$value->name.'/'.$item->slug)}}"
                                                           title="iPhone 14 Series">{{$item->name}}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="hidden-lg hidden-md bottom">
        <ul>
            <li>
                <a href="{{url('/')}}">
                    <i class="fa fa-home"></i>
                    <span>Trang chủ</span>
                </a>

            </li>
            <li>
                <a alt="Hệ thống cửa hàng" href="/he-thong-cua-hang">
                    <i class="fa fa-store"></i>
                    <span>Cửa hàng</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" id="procat">
                    <i class="fa fa-list"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            <li>
                <a href="{{url('tra-cuu-don-hang')}}" id="modal_support">
                    <i class="fa-solid fa-truck-fast" style="font-size: unset;margin-right: 0" ></i>
                    <span>Tra cứu đơn</span>
                </a>
            </li>
            <li>
                <a href="{{url('news')}}">
                    <i class="fa fa-newspaper"></i>
                    <span>Tin tức</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<script>
    function activeFooter(id) {
        $('.show_cat').removeClass('active_side');
        $('.show_cat' + id).addClass('active_side')
    }
</script>

