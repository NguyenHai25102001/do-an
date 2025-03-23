<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\DistrictGhnModel;
use App\Models\FlashSaleModel;
use App\Models\ImageVariantModel;
use App\Models\ProductAttribute;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductRelatedModel;
use App\Models\ProductReviewsModel;
use App\Models\ProductsModel;
use App\Models\ProductValue;
use App\Models\WardGhnModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * ADD Images product
     **/
    public function add_img_product($request, $product_infor_id)
    {
        try {
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                foreach ($file as $value) {
                    $image_name = 'upload/product/img/' . Str::random(40);
                    $ext = strtolower($value->getClientOriginalExtension());
                    $image_full_name = $image_name . '.' . $ext;
                    $path = 'upload/product/img';
                    $value->move($path, $image_full_name);
                    $image_invest = new ImageVariantModel([
                        'product_infor_id' => $product_infor_id,
                        'image' => $image_full_name,
                    ]);
                    $image_invest->save();
                }
                return true;
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

   public function add_and_update_attribute_product($data_attribute, $product_infor, $related)
{
    foreach ($data_attribute as $value) {
        $is_featured_products = 1;
        if (isset($value['featured_products']) && $value['featured_products'] == 'on') {
            $is_featured_products = 1;
        }
        if (isset($value['attribute_id'])) {
            $product = ProductsModel::find($value['attribute_id']);
            $product->product_infor_id = $product_infor->id;
            $product->name = $value['name'];
            $product->slug = Str::slug($value['name']);
            $product->own_parameter = $value['own_parameter'];
            $product->specifications = $value['specifications'];
            $product->is_featured_products = $is_featured_products;
            $product->save();
        } else {
            $product = new ProductsModel([
                'product_infor_id' => $product_infor->id,
                'name' => $value['name'],
                'slug' => Str::slug($value['name']),
                'own_parameter' => $value['own_parameter'],
                'specifications' => $value['specifications'],
                'is_featured_products' => $is_featured_products,
            ]);
            $product->save();
        }
        if (isset($value['data']) && count($value['data'])) {
            foreach ($value['data'] as $item) {
                if (isset($item['value_id'])) {
                    $product_attribute = ProductAttributesModel::find($item['value_id']);
                    $product_attribute->name = $item['color'];
                    $product_attribute->price = isset($item['price']) ? str_replace(",", "", $item['price']) : 0;
                    $product_attribute->promotional_price = isset($item['promotion_price']) ? str_replace(",", "", $item['promotion_price']) : 0;
                    $product_attribute->save();
                } else {
                    $product_attribute = new ProductAttributesModel([
                        'product_id' => $product->id,
                        'name' => $item['color'],
                        'price' => isset($item['price']) ? str_replace(",", "", $item['price']) : 0,
                        'promotional_price' => isset($item['promotion_price']) ? str_replace(",", "", $item['promotion_price']) : 0,
                    ]);
                    $product_attribute->save();
                }
            }
        }
    }
    if (isset($related)) {
        foreach ($related as $item) {
            $prouct_related = new ProductRelatedModel([
                'product_id' => $item['product_id'],
                'product_infor_id' => $product_infor->id,
            ]);
            $prouct_related->save();
        }
    }
    return true;
}
    /**
     * item san phẩm
     **/
    public function item_product($type)
    {
        try {
            $product_infor = ProductInformationModel::where('type_product', $type)->pluck('id');
            $product = ProductsModel::whereIn('product_infor_id', $product_infor)->where('is_featured_products', 1)->limit(10)->get();
            foreach ($product as $value) {
                $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id',$value->id)->first();
                $value->infor = ProductInformationModel::find($value->product_infor_id);
                $value->type_product = ProductsModel::where('product_infor_id', $value->product_infor_id)->get();
                $value->price = ProductAttributesModel::where('product_id', $value->id)->first()->price;
                if ($flash_sale){
                    $value->promotional_price = $flash_sale->price_sale;
                    $value->time_end = $flash_sale->time_end;
                    $value->type_sale = 1;
                }else{
                    $value->promotional_price = ProductAttributesModel::where('product_id', $value->id)->first()->promotional_price;
                    $value->type_sale = 0;
                }
                $this->starReview($value);
            }
            return $product;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * check danh mục
     **/
    public function checkStatus($status)
    {
        if ($status == 'dien-thoai') {
            $type = 1;
            $name_cate = "Điện thoại";
        }elseif ($status == 'may-tinh-bang'){
            $type = 2;
            $name_cate = "Máy tính bảng";
        }elseif ($status == 'laptop'){
            $type = 3;
            $name_cate = "Laptop";
        }elseif ($status == 'dong-ho-thong-minh'){
            $type = 4;
            $name_cate = "Đồng hồ thông minh";
        }elseif ($status == 'nha-thong-minh'){
            $type = 5;
            $name_cate = "Nhà thông minh";
        }elseif ($status == 'phu-kien'){
            $type = 6;
            $name_cate = "Phụ kiện";
        }elseif ($status == 'am-thanh'){
            $type = 7;
            $name_cate = "Âm thanh";
        }
        return ['type'=>$type, 'name_cate'=>$name_cate];
    }

    /**
     * Bộ lọc
     **/
    public function filterProduct ($data,$request)
    {
        try{
            if ($request->slug_cate){
                $category = CategoryModel::where('slug',$request->slug_cate)->first();
                $data = $data->where('category_id', $category->id);
            }
            if ($request->name_cate){
                $category = CategoryModel::where('name',$request->name_cate)->first();
                $parent_id = CategoryModel::where('parent_id', $category->id)->pluck('id');
                $data = $data->whereIn('category_id', $parent_id);
            }
            if (isset($request->parameter_one)){
                $data = $data->where('parameter_one', $request->parameter_one);
            }
            if (isset($request->parameter_two)){
                $data = $data->where('parameter_two', $request->parameter_two);
            }
            if (isset($request->parameter_three)){
                $data = $data->where('parameter_three', $request->parameter_three);
            }
            if (isset($request->parameter_four)){
                $data = $data->where('parameter_four', $request->parameter_four);
            }
            return $data;
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * list data sản phẩm
     **/
    public function dataProduct($product)
    {
        foreach ($product as $item) {
            $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id', $item->id)->first();
            $item->infor = ProductInformationModel::find($item->product_infor_id);
            $item->type_product = ProductsModel::where('product_infor_id', $item->product_infor_id)->get();
            $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->price;
            if ($flash_sale) {
                $item->promotional_price = $flash_sale->price_sale;
                $item->time_end = $flash_sale->time_end;
                $item->type_sale = 1;
            } else {
                $item->promotional_price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
                $item->type_sale = 0;
            }
            $this->starReview($item);
        }
        return $product;
    }

    /**
     * danh sách tiêu chí
     **/
    public function criteria($checkCate,$product_infor)
    {
        $parameter_one = ProductInformationModel::select('parameter_one')->where('type_product', $checkCate['type'])->distinct()->get();
        $parameter_two = ProductInformationModel::select('parameter_two')->where('type_product', $checkCate['type'])->distinct()->get();
        $parameter_three = ProductInformationModel::select('parameter_three')->where('type_product', $checkCate['type'])->distinct()->get();
        $parameter_four = ProductInformationModel::select('parameter_four')->where('type_product', $checkCate['type'])->distinct()->get();
        $parameter_five = ProductsModel::select('own_parameter')->whereIn('product_infor_id', $product_infor)->distinct()->get();
        $name_filter =$this->nameFilter($checkCate);
        return compact('parameter_one', 'parameter_five', 'parameter_two', 'parameter_three', 'parameter_four','name_filter');
    }

    /**
     * lấy name bộ lọc
     **/
    public function nameFilter($checkCate)
    {
        if ($checkCate['type'] == 1){
            $name_filter_one = 'Ram';
            $name_filter_two = 'Kích thước màn hình';
            $name_filter_three = 'Nhu cầu sử dụng';
            $name_filter_four = 'Chíp xử lí';
            $name_filter_five = 'Bộ nhớ trong';
        }elseif ($checkCate['type'] == 2){
            $name_filter_one = 'Ram';
            $name_filter_two = 'Kích thước màn hình';
            $name_filter_three = 'Nhu cầu sử dụng';
            $name_filter_four = 'Chíp xử lí';
            $name_filter_five = 'Bộ nhớ trong';
        }elseif ($checkCate['type'] == 3){
            $name_filter_one = 'Ram';
            $name_filter_two = 'Kích thước màn hình';
            $name_filter_three = 'CPU';
            $name_filter_four = 'Card đồ họa';
            $name_filter_five = 'Bộ nhớ trong';
        }elseif ($checkCate['type'] == 4){
            $name_filter_one = 'Chất liệu viền';
            $name_filter_two = 'Kích cỡ mặt đồng hồ';
            $name_filter_three = 'Thời lượng pin';
            $name_filter_four = 'Thiết kế';
            $name_filter_five = 'Thông số 5';
        }elseif ($checkCate['type'] == 5){
            $name_filter_one = 'Thông số 1';
            $name_filter_two = 'Thông số 2';
            $name_filter_three = 'Thông số 3';
            $name_filter_four = 'Thông số 4';
            $name_filter_five = 'Thông số 5';
        }elseif ($checkCate['type'] == 6){
            $name_filter_one = 'Thông số 1';
            $name_filter_two = 'Thông số 2';
            $name_filter_three = 'Thông số 3';
            $name_filter_four = 'Thông số 4';
            $name_filter_five = 'Thông số 5';
        }else{
            $name_filter_one = 'Thông số 1';
            $name_filter_two = 'Thông số 2';
            $name_filter_three = 'Thông số 3';
            $name_filter_four = 'Thông số 4';
            $name_filter_five = 'Thông số 5';
        }
        return [$name_filter_one,$name_filter_two,$name_filter_three,$name_filter_four,$name_filter_five];
    }

    /**
     * sản phẩm plash sale
     **/
    public function flashSale($item)
    {
        $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id', $item->id)->first();
        if ($flash_sale) {
            $item->promotional_price = $flash_sale->price_sale;
            $item->time_end = $flash_sale->time_end;
            $item->type_sale = 1;
        } else {
            $item->promotional_price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
            $item->type_sale = 0;
        }
        return true;
    }

    /**
     * số sao đánh giá theo sản phẩm
     **/
    public function starReview($product)
    {
        $star = ProductReviewsModel::where('product_id', $product->id)->where('status',1)->orderBy('created_at','desc')->get();
        if (!$star->isEmpty()) {
            $total_score =  ProductReviewsModel::where('product_id', $product->id)->where('status',1)->sum('star');
            $total_votes = count($star);
            $product->star = round($total_score/$total_votes, 1);
        }
        return $star;
    }

    /**
     * Lấy danh sách quận huyện theo tỉnh
     */
    public function getDistrict($province_id){
        try {
            $districts = DistrictGhnModel::where('ProvinceId', $province_id)->get();

            $html = 'Tất cả';
            foreach ($districts as $value){
                $html .= '<option value="'.$value->DistrictID.'">'.$value->DistrictName.'</option>';
            }
            $data['html'] = $html;
            $data['status'] = true;
            return $data;
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Lấy danh sách Phường/Xã theo quận huyện
     */
    public function getWard($district_id){
        try {
            $districts = WardGhnModel::where('DistrictID', $district_id)->get();

            $html = 'Tất cả';
            foreach ($districts as $value){
                $html .= '<option value="'.$value->WardCode.'">'.$value->WardName.'</option>';
            }
            $data['html'] = $html;
            $data['status'] = true;
            return $data;
        }catch (\Exception $exception){
            dd($exception);
        }
    }
}
