<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\ImageVariantModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductRelatedModel;
use App\Models\ProductReviewsModel;
use App\Models\ProductsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (User::checkUserRole(5)) {
            if (isset($request->key_search)) {
                $id_product = ProductsModel::where('name', 'like', '%' . $request->get('key_search') . '%')->pluck('product_infor_id');
                $data_product = ProductInformationModel::whereIn('id', $id_product)->where('display', 1)->paginate(10);
            } else {
                $data_product = ProductInformationModel::orderBy('created_at', 'desc')->where('display', 1)->paginate(10);
            }
            if ($data_product) {
                foreach ($data_product as $value) {
                    $value->product = ProductsModel::where('product_infor_id', $value->id)->get();
                    foreach ($value->product as $item) {
                        $attribute = ProductAttributesModel::where('product_id', $item->id)->first();
                        $item->price = $attribute->price;
                        $item->promotional_price = $attribute->promotional_price;
                    }
                }
            }

            $titlePage = 'Admin | Sản Phẩm';
            $page_menu = 'products';
            $page_sub = 'index';
            $listData = $data_product;
            return view('admin.products.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
        }else{
            return view('admin.error');
        }
    }

    public function create()
    {
        if (User::checkUserRole(5)) {
            $data['titlePage'] = 'Thêm sản phẩm';
            $data['page_menu'] = 'products';
            $data['page_sub'] = 'index';
            return view('admin.products.create', $data);
        }else{
            return view('admin.error');
        }
    }

    /**
     * create product
     **/

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $category = CategoryModel::find($request->get('sub_category'));
            if (empty($category)) {
                return back()->with(['error' => 'Vui lòng chọn danh mục để tiếp tục']);
            }
            if (!$request->hasFile('file_product')) {
                return back()->with(['error' => 'Vui lòng thêm hình ảnh sản phẩm']);
            }
            $display = 0;
            if ($request->get('display') == 'on') {
                $display = 1;
            }
            $file = $request->file('file_product');
            $extension = $file->getClientOriginalExtension();
            $banner = 'upload/product/' . Str::random(40) . '.' . $extension;
            $file->move('upload/product/', $banner);
            $product_infor = new ProductInformationModel([
                'image' => $banner,
                'category_id' => isset($category) ? $category->id : null,
                'name_category' => isset($category) ? $category->name : null,
                'parameter_one' => $request->get('parameter_one'),
                'parameter_two' => $request->get('parameter_two'),
                'parameter_three' => $request->get('parameter_three'),
                'parameter_four' => $request->get('parameter_four'),
                'product_information' => $request->get('product_information'),
                'special_offer' => $request->get('special_offer'),
                'promotion_policy' => $request->get('promotion_policy'),
                'salient_features' => $request->get('salient_features'),
                'type_product' => $category->type,
                'display' => $display,
            ]);
            $product_infor->save();
            $this->add_img_product($request, $product_infor->id);
            $attribute = $request->get('variant');
            $related = $request->get('related');
            $this->add_and_update_attribute_product($attribute, $product_infor, $related);
            DB::commit();
            return \redirect()->route('admin.products.index')->with(['success' => 'Thêm sản phẩm thành công']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete($id)
    {
        if (User::checkUserRole(5)) {
            $product_infor = ProductInformationModel::find($id);
            unlink($product_infor->image);
            $data_image = ImageVariantModel::where('product_infor_id', $id)->get();
            if ($data_image) {
                foreach ($data_image as $value) {
                    unlink($value->image);
                    $value->delete();
                }
            }
            $product = ProductsModel::where('product_infor_id', $id)->get();
            foreach ($product as $item) {
                ProductAttributesModel::where('product_id', $item->id)->delete();
                $item->delete();
            }
            $product_infor->delete();

            return back()->with(['success' => 'Xóa sản phẩm thành công']);
        }else{
            return view('admin.error');
        }
    }

    public function edit($id)
    {
        if (User::checkUserRole(5)) {
            $product_infor = ProductInformationModel::find($id);
            $product = ProductsModel::where('product_infor_id', $product_infor->id)->get();
            $category_2 = CategoryModel::find($product_infor->category_id);
            $category_3 = CategoryModel::where('display', 1)->where('type', $product_infor->type_product)->where('parent_id', $category_2->parent_id)->orderBy('location', 'asc')->get();
            $related = ProductRelatedModel::where('product_infor_id', $id)->get();
            foreach ($related as $item) {
                $item->product = ProductsModel::find($item->product_id);
                $item->infor = ProductInformationModel::find($item->product->product_infor_id);
                $item->price = ProductAttributesModel::where('product_id', $item->product_id)->first()->promotional_price;
            }
            $data['product_infor'] = $product_infor;
            $data['product'] = $product;
            $data['related'] = $related;
            $data['image_variant'] = ImageVariantModel::where('product_infor_id', $id)->get();
            $data['category_2'] = $category_2;
            $data['category_3'] = $category_3;
            $data['titlePage'] = 'Admin | Sản Phẩm';
            $data['page_menu'] = 'products';
            $data['page_sub'] = 'index';
            return view('admin.products.edit', $data);
        }else{
            return view('admin.error');
        }
    }

    public function update($id, Request $request)
    {
        try {
            $product_infor = ProductInformationModel::find($id);
            $category = CategoryModel::find($request->get('sub_category'));
            if (empty($product_infor)) {
                return back()->with(['error' => 'Sản phẩm không tồn tại']);
            }
            $display = 0;
            if ($request->display == 'on') {
                $display = 1;
            }
            if (isset($request->image_product)) {
                unlink($product_infor->image);
                $product_infor->image = $request->get('image_product');
            }
            $product_infor->category_id = isset($category) ? $category->id : null;
            $product_infor->name_category = isset($category) ? $category->name : null;
            $product_infor->parameter_one = $request->get('parameter_one');
            $product_infor->parameter_two = $request->get('parameter_two');
            $product_infor->parameter_three = $request->get('parameter_three');
            $product_infor->parameter_four = $request->get('parameter_four');
            $product_infor->product_information = $request->get('product_information');
            $product_infor->special_offer = $request->get('special_offer');
            $product_infor->promotion_policy = $request->get('promotion_policy');
            $product_infor->salient_features = $request->get('salient_features');
            $product_infor->type_product = $category->type;
            $product_infor->display = $display;

            $product_infor->save();
            $this->add_img_product($request, $product_infor->id);
            $attribute = $request->get('variant');
            $related = $request->get('related');
            $this->add_and_update_attribute_product($attribute, $product_infor, $related);
            return \redirect()->route('admin.products.index')->with(['success' => 'Sửa sản phẩm thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * delete img variant
     **/
    public function deleteImg(Request $request)
    {
        try {
            $img = ImageVariantModel::find($request->get('id'));
            unlink($img->image);
            $img->delete();
            $data['status'] = true;
            return $data;
        } catch (\Exception $exception) {
            $data['status'] = false;
            $data['msg'] = $exception->getMessage();
            return $data;
        }
    }

    /**
     * Delete Product Attribute
     **/
    public function deleteName($id)
    {
        try {
            $product = ProductsModel::find($id);
            ProductAttributesModel::where('product_id', $id)->delete();
            if (isset($product->image)) {
                unlink($product->image);
            }
            $product->delete();
            return back()->with(['success' => 'Xóa tên sản phẩm thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Delete Product Value
     **/
    public function deleteColor($id)
    {
        try {
            $product_attribute = ProductAttributesModel::find($id);
            $product_attribute->delete();
            return back()->with(['success' => 'Xóa màu số thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Product create
     * add size product
     **/
    public function variantSize(Request $request)
    {
        $count = $request->get('count');
        $index = $request->get('index');
        $view = view('admin.products.variant-size', compact('count', 'index'))->render();
        return \response()->json(['html' => $view]);
    }

    /**
     * Product create
     * add color product
     **/
    public function variantColor(Request $request)
    {
        $count = $request->get('count');
        $view = view('admin.products.variant-color', compact('count'))->render();
        return \response()->json(['html' => $view, 'count' => $count]);
    }

    /**
     * Tìm kiếm sản phẩm liên quan
     */
    public function productSearch(Request $request)
    {
        try {
            $key_search = $request->get('query');
            $products = ProductsModel::Where('name', 'LIKE', '%' . $key_search . '%')->paginate(10);
            foreach ($products as $item) {
                $item->infor = ProductInformationModel::find($item->product_infor_id);
                $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
            }
            $view = view('admin.products.item-similar-product', compact('products'))->render();
            return response()->json(['table_data' => $view]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Thêm sản phẩm liên quan
     * */
    public function itemSimilar(Request $request)
    {
        try {
            $products = ProductsModel::whereIn('id', $request->data)->get();
            foreach ($products as $item) {
                $item->infor = ProductInformationModel::find($item->product_infor_id);
                $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
            }
            $view = view('admin.products.similar-product', compact('products'))->render();
            return response()->json(['table_data' => $view]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Xóa sản phẩm liên quan
     * */
    public function itemDeleteSimilar(Request $request)
    {
        try {
            if (isset($request->data)) {
                $products = ProductsModel::whereIn('id', $request->data)->get();
                foreach ($products as $item) {
                    $item->infor = ProductInformationModel::find($item->product_infor_id);
                    $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
                }
                $view = view('admin.products.similar-product', compact('products'))->render();
                return response()->json(['status' => true, 'table_data' => $view]);
            } else {
                return response()->json(['status' => false]);
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Xóa sản phẩm liên quan khi sửa
     * */
    public function itemDeleteRelated(Request $request)
    {
        try {
            $product_related = ProductRelatedModel::find($request->id);
            $product_related->delete();
            return response()->json(['status' => true]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Danh sách đánh giá sản phẩm
     */
    public function reviewProduct($type)
    {
        try {
            if (User::checkUserRole(6)) {
                $titlePage = 'Danh sách đánh giá sản phẩm';
                $page_menu = 'review';
                $page_sub = '';
                $listData = ProductReviewsModel::query();
                $listData = $listData->where('type', $type);
                $listData = $listData->orderBy('status', 'asc')->paginate(10);
                foreach ($listData as $item) {
                    $item->name_product = ProductsModel::find($item->product_id)->name;
                }

                return view('admin.products.review', compact('titlePage', 'page_menu', 'listData', 'page_sub', 'type'));
            }else{
                return view('admin.error');
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Duyệt đánh giá sản phẩm
     */
    public function browserReview($id)
    {
        if (User::checkUserRole(6)) {
            $review = ProductReviewsModel::find($id);
            $review->status = 1;
            $review->save();
            return back()->with(['success' => 'Duyệt review sản phẩm thành công']);
        }else{
            return view('admin.error');
        }
    }

    /**
     * Xóa đánh giá sản phẩm
     */
    public function deleteReview($id)
    {
        if (User::checkUserRole(6)) {
            ProductReviewsModel::where('id', $id)->delete();
            return back()->with(['success' => 'Xóa review sản phẩm thành công']);
        }else{
            return view('admin.error');
        }
    }

}
