<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSaleModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductsModel;
use App\Models\User;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        if (User::checkUserRole(5)) {
            $listData = FlashSaleModel::all();
            foreach ($listData as $item) {
                $item->product = ProductsModel::find($item->product_id);
            }
            $titlePage = 'Admin | Sản Phẩm';
            $page_menu = 'products';
            $page_sub = 'flash_sale';
            return view('admin.flash-sale.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
        }else{
            return view('admin.error');
        }
    }

    public function create()
    {
        if (User::checkUserRole(5)) {
            $data['titlePage'] = 'Thêm sản phẩm vào flash sale';
            $data['page_menu'] = 'products';
            $data['page_sub'] = 'flash_sale';
            return view('admin.flash-sale.create', $data);
        }else{
            return view('admin.error');
        }
    }

    public function store(Request $request)
    {
        try {
            $sale = $request->get('sale');
            foreach ($sale as $value){
                $price = str_replace(",", "", $value['price_sale']);
                $product = new FlashSaleModel([
                    'product_id' => $value['product_id'],
                    'price_sale' => $price,
                    'time_start' => $request->get('time_start'),
                    'time_end' => $request->get('time_end'),
                ]);
                $product->save();
            }
            return \redirect()->route('admin.flash-sale.index')->with(['success' => 'Thêm sản phẩm flash sale thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function delete($id)
    {
        if (User::checkUserRole(5)) {
            $product = FlashSaleModel::find($id);
            $product->delete();
            return back()->with(['success' => 'Xóa sản phẩm flash sale thành công']);
        }else{
            return view('admin.error');
        }
    }

    public function edit($id)
    {
        if (User::checkUserRole(5)) {
            $flash_sale = FlashSaleModel::find($id);
            $flash_sale->product = ProductsModel::find($flash_sale->product_id);
            $flash_sale->infor = ProductInformationModel::find($flash_sale->product->product_infor_id);

            $data['flash_sale'] = $flash_sale;
            $data['titlePage'] = 'Admin | Sản Phẩm';
            $data['page_menu'] = 'products';
            $data['page_sub'] = 'flash_sale';
            return view('admin.flash-sale.edit', $data);
        }else{
            return view('admin.error');
        }
    }

    public function update($id, Request $request)
    {
        try {
            $price = str_replace(",", "", $request->get('price_sale'));
            $flash_sale = FlashSaleModel::find($id);
            $flash_sale->price_sale = $price;
            $flash_sale->time_start = $request->get('time_start');
            $flash_sale->time_end = $request->get('time_end');
            $flash_sale->save();

            return \redirect()->route('admin.flash-sale.index')->with(['success' => 'Sửa sản phẩm flash sale thành công']);
        } catch (\Exception $exception) {
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Thêm sản phẩm sale
     * */
    public function itemProduct(Request $request)
    {
        try {
            $products = ProductsModel::whereIn('id', $request->data)->get();
            foreach ($products as $item) {
                $item->infor = ProductInformationModel::find($item->product_infor_id);
                $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
            }
            $view = view('admin.flash-sale.flash-sale', compact('products'))->render();
            return response()->json(['table_data' => $view]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Xóa sản phẩm sale
     * */
    public function itemDeleteProduct(Request $request)
    {
        try {
            if (isset($request->data)) {
                $products = ProductsModel::whereIn('id', $request->data)->get();
                foreach ($products as $item) {
                    $item->infor = ProductInformationModel::find($item->product_infor_id);
                    $item->price = ProductAttributesModel::where('product_id', $item->id)->first()->promotional_price;
                }
                $view = view('admin.flash-sale.flash-sale', compact('products'))->render();
                return response()->json(['status' => true, 'table_data' => $view]);
            } else {
                return response()->json(['status' => false]);
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

}
