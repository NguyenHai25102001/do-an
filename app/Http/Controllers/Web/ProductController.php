<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\NewsModel;
use App\Models\CategoryModel;
use App\Models\FlashSaleModel;
use App\Models\ImageVariantModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductRelatedModel;
use App\Models\ProductReviewsModel;
use App\Models\ProductsModel;
use App\Models\ProductValue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function category($status)
    {
        $checkCate = $this->checkStatus($status);
        $cate = CategoryModel::where('display', 1)->where('type', $checkCate['type'])->where('parent_id', 0)->get();
        $product_infor = ProductInformationModel::where('type_product', $checkCate['type'])->pluck('id');
        $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->orderBy('product_attributes.promotional_price', 'desc')
            ->select('products.*')
            ->whereIn('product_infor_id', $product_infor)
            ->paginate(20);
        $this->dataProduct($product);
        $name = null;
        $slug = null;
        $name_cate = $checkCate['name_cate'];
        $type_product = $checkCate['type'];
        return view('web.category.index', array_merge(compact('cate', 'name_cate', 'status', 'name', 'product', 'type_product',
            'slug'), $this->criteria($checkCate, $product_infor)));
    }

    public function productCate($status, $name)
    {
        $checkCate = $this->checkStatus($status);
        $id_cate = CategoryModel::where('name', $name)->where('display', 1)->where('type', $checkCate['type'])->first();
        $cate = CategoryModel::where('display', 1)->where('type', $checkCate['type'])->where('parent_id', $id_cate->id)->get();
        $parent_id = CategoryModel::where('display', 1)->where('type', $checkCate['type'])->where('parent_id', $id_cate->id)->pluck('id');
        $product_infor = ProductInformationModel::where('type_product', $checkCate['type'])->whereIn('category_id', $parent_id)->pluck('id');
        $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->orderBy('product_attributes.promotional_price', 'desc')
            ->select('products.*')
            ->whereIn('product_infor_id', $product_infor)
            ->paginate(20);
        $this->dataProduct($product);
        $name_cate = $checkCate['name_cate'];
        $type_product = $checkCate['type'];
        $slug = null;
        return view('web.category.index', array_merge(compact('cate', 'name_cate', 'status', 'name', 'type_product',
            'product', 'slug'), $this->criteria($checkCate, $product_infor)));
    }

    public function productCateDetail($status, $name, $slug)
    {
        $checkCate = $this->checkStatus($status);
        $id_cate = CategoryModel::where('name', $name)->where('display', 1)->where('type', $checkCate['type'])->first();
        $cate = CategoryModel::where('display', 1)->where('type', $checkCate['type'])->where('parent_id', $id_cate->id)->get();
        $parent_id = CategoryModel::where('display', 1)->where('type', $checkCate['type'])->where('slug', $slug)->first();
        $product_infor = ProductInformationModel::where('type_product', $checkCate['type'])->where('category_id', $parent_id->id)->pluck('id');
        $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->orderBy('product_attributes.promotional_price', 'desc')
            ->select('products.*')
            ->whereIn('product_infor_id', $product_infor)
            ->paginate(20);
        $this->dataProduct($product);
        $name_cate = $checkCate['name_cate'];
        $type_product = $checkCate['type'];
        return view('web.category.index', array_merge(compact('cate', 'name_cate', 'status', 'name', 'type_product',
            'product', 'slug'), $this->criteria($checkCate, $product_infor)));
    }

    public function detailProduct(Request $request,$slug)
    {
        $product = ProductsModel::where('slug', $slug)->first();
        if (empty($product)) {
            return back()->with(['error' => 'Sản phẩm không tồn tại']);
        }
        $sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id', $product->id)->first();
        if ($sale) {
            $product->time_end = $sale->time_end;
        }
        $star = $this->starReview($product);
        $star_five = ProductReviewsModel::where('product_id', $product->id)->where('star', 5)->where('status',1)->count();
        $star_four = ProductReviewsModel::where('product_id', $product->id)->where('star', 4)->where('status',1)->count();
        $star_three = ProductReviewsModel::where('product_id', $product->id)->where('star', 3)->where('status',1)->count();
        $star_two = ProductReviewsModel::where('product_id', $product->id)->where('star', 2)->where('status',1)->count();
        $star_one = ProductReviewsModel::where('product_id', $product->id)->where('star', 1)->where('status',1)->count();
        $percent_5 = round(($star_five??0 / count($star)) * 100,0);
        $percent_4 = round(($star_four??0 / count($star)) * 100,0);
        $percent_3 = round(($star_three??0 / count($star)) * 100,0);
        $percent_2 = round(($star_two??0 / count($star)) * 100,0);
        $percent_1 = round(($star_one??0 / count($star)) * 100,0);
        $comment = ProductReviewsModel::where('product_id', $product->id)->where('status',1)->orderBy('created_at','desc')->paginate(5);
        $image_product = ImageVariantModel::where('product_infor_id', $product->product_infor_id)->get();
        $product_infor = ProductInformationModel::where('id', $product->product_infor_id)->first();
        $status = $this->statusCategory($product_infor);
        $list_product = ProductsModel::where('product_infor_id', $product_infor->id)->get();
        foreach ($list_product as $item) {
            $this->flashSale($item);
        }
        $product_attribute = ProductAttributesModel::where('product_id', $product->id)->get();
        foreach ($product_attribute as $value) {
            $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id', $value->product_id)->first();
            if ($flash_sale) {
                $value->price_sale = $flash_sale->price_sale;
            } else {
                $value->price_sale = ProductAttributesModel::where('product_id', $value->product_id)->first()->promotional_price;
            }
        }
        $product_related = ProductRelatedModel::where('product_infor_id', $product->product_infor_id)->get();
        foreach ($product_related as $item) {
            $item->product = ProductsModel::find($item->product_id);
            $item->infor = ProductInformationModel::find($item->product->product_infor_id);
            $item->type_product = ProductsModel::where('product_infor_id', $item->product->product_infor_id)->get();
            $item->price = ProductAttributesModel::where('product_id', $item->product->id)->first()->price;
            $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id', $item->product_id)->first();
            if ($flash_sale) {
                $item->promotional_price = $flash_sale->price_sale;
                $item->time_end = $flash_sale->time_end;
                $item->type_sale = 1;
            } else {
                $item->promotional_price = ProductAttributesModel::where('product_id', $item->product->id)->first()->promotional_price;
                $item->type_sale = 0;
            }
        }
        $category = CategoryModel::find($product_infor->category_id);
        $name_category = CategoryModel::find($category->parent_id);
        $new = NewsModel::where('display', 1)->where('is_featured', 1)->orderBy('index', 'desc')->limit(3)->get();
        $w_title = 'Chi tiết sản phẩm';
        return view('web.product.detail-product', compact('w_title', 'product', 'product_attribute', 'product_infor',
            'image_product', 'list_product', 'name_category', 'category', 'product_related', 'new', 'status', 'star','percent_5',
        'percent_4','percent_3','percent_2','percent_1','comment'));
    }

    public function filter(Request $request)
    {
        try {
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 200000000);
            if ($request->sort == 1) {
                $sort = ['product_attributes.promotional_price', 'asc'];
            } else if ($request->sort == 2) {
                $sort = ['product_attributes.promotional_price', 'desc'];
            } else {
                $sort = ['product_attributes.created_at', 'desc'];
            }
            $product_infor = ProductInformationModel::query();
            $product_infor = $this->filterProduct($product_infor, $request);
            $product_infor = $product_infor->where('type_product', $request->type_product)->where('display', 1)->pluck('id');
            if ($request->parameter_five) {
                $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                    ->orderBy($sort[0], $sort[1])
                    ->select('products.*')
                    ->whereIn('product_infor_id', $product_infor)->where('own_parameter', $request->parameter_five)
                    ->whereBetween('product_attributes.promotional_price', [$minPrice, $maxPrice])
                    ->paginate(20);
            } else {
                $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
                    ->orderBy($sort[0], $sort[1])
                    ->select('products.*')
                    ->whereIn('product_infor_id', $product_infor)
                    ->whereBetween('product_attributes.promotional_price', [$minPrice, $maxPrice])
                    ->paginate(20);
            }

            foreach ($product as $item) {
                $item->infor = ProductInformationModel::find($item->product_infor_id);
                $item->type_product = ProductsModel::where('product_infor_id', $item->product_infor_id)->get();
                $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->price;
                $this->flashSale($item);
                $this->starReview($item);
            }
            $view = view('web.category.items-product', compact('product'))->render();
            return response()->json(['status' => true, 'prop' => $view]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        if ($request->sort_price == 1) {
            $sort = ['product_attributes.promotional_price', 'asc'];
        } else if ($request->sort_price == 2) {
            $sort = ['product_attributes.promotional_price', 'desc'];
        } else {
            $sort = ['product_attributes.created_at', 'desc'];
        }
        $product = ProductsModel::join('product_attributes', 'products.id', '=', 'product_attributes.product_id')
            ->orderBy($sort[0], $sort[1])
            ->select('products.*')
            ->where('products.name', 'like', '%' . $keyword . '%')
            ->paginate(20);
        foreach ($product as $item) {
            $item->infor = ProductInformationModel::find($item->product_infor_id);
            $item->type_product = ProductsModel::where('product_infor_id', $item->product_infor_id)->get();
            $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->price;
            $this->flashSale($item);
            $this->starReview($item);
        }
        return view('web.product.search', compact('product', 'keyword'));
    }

    public function statusCategory($product_infor)
    {
        try {
            if ($product_infor->type_product == 1) {
                $status = 'dien-thoai';
            } elseif ($product_infor->type_product == 2) {
                $status = 'may-tinh-bang';
            } elseif ($product_infor->type_product == 3) {
                $status = 'laptop';
            } elseif ($product_infor->type_product == 4) {
                $status = 'dong-ho-thong-minh';
            } elseif ($product_infor->type_product == 5) {
                $status = 'nha-thong-minh';
            } elseif ($product_infor->type_product == 6) {
                $status = 'phu-kien';
            } else {
                $status = 'am-thanh';
            }
            return $status;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function storeReview(Request $request)
    {
        $rule = [
            'star' => 'required',
            'content' => 'required',
            'name' => 'required',
            'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ];
        $messenger = [
            'star.required' => 'Vui lòng chọn đánh giá trước khi gửi',
            'content.required' => 'Vui lòng nhập nội dung đánh giá trước khi gửi',
            'name.required' => 'Vui lòng nhập họ và tên trước khi gửi',
            'phone.required' => 'Vui lòng nhập số điện thoại trước khi gửi',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'phone.not_regex' => 'Số điện thoại không hợp lệ',
            'phone.min' => 'Số điện thoại không hợp lệ',
            'phone.max' => 'Số điện thoại không hợp lệ',
            'email.required' => 'Vui lòng nhập địa chỉ email trước khi gửi',
            'email.regex' => 'Địa chỉ email không hợp lệ',
        ];
        $validator = Validator::make($request->all(), $rule, $messenger);
        if ($validator->fails()){
            return response()->json(['status' => false, 'msg' => $validator->errors()->first()], 201);
        }

        $review = new ProductReviewsModel([
            'product_id' => $request->get('product_id'),
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'content' => $request->get('content'),
            'star' => $request->get('star'),
            'type' => $request->get('type'),
            'status' => 0
        ]);
        $review->save();
        $dataReturn = [
            'status' => true,
            'msg' => 'Cảm ơn bạn đã gửi đánh giá.'
        ];
        return response()->json($dataReturn, Response::HTTP_OK);
    }

    public function getReviewProduct(Request $request)
    {
        $perPage = 5;
        $offset = ($request->get("page") - 1) * $perPage;
        $posts = ProductReviewsModel::where('product_id', $request->get("product_id"))->where('status',1)->orderBy('created_at','desc')
            ->skip($offset)
            ->take($perPage)
            ->get();

        return response()->json($posts);
    }

}
