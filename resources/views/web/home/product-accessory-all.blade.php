@if(count($product_accessory) > 0)
    <div class="accessory">
        <div class="title-block">
            <h2>PHỤ KIỆN</h2>
            <div class="list-cat">
                <a href="{{url('danh-muc/phu-kien')}}" class="item-cat"><span>Xem tất cả <span
                            style="font-weight: 800">{{count($product_accessory)}}</span> sản phẩm</span></a>
            </div>
        </div>
        <div class="list-categories">
            @foreach($category_product as $value)
                @if($value->type == 6)
                <a href="{{url('danh-muc/phu-kien/'.$value->name)}}" class="b-item-cat">
                    <img data-src="{{$value->image}}" class="img-responsive lazy">
                    <div>
                        <p class="name-cat">{{$value->name}}</p>
                        <p class="link-cat">Xem tất cả <i class="fa fa-angle-right"></i></p>
                    </div>
                </a>
                @endif
            @endforeach
        </div>
    </div>
@endif
