<?php

namespace App\Http\Controllers\admin;

use App\Exports\ExportDelivery;
use App\Exports\ExportImport;
use App\Exports\ExportReceipt;
use App\Http\Controllers\Controller;
use App\Models\ImportExxportProductModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportProductController extends Controller
{
    public function importExport(Request $request)
    {
        if (User::checkUserRole(4)) {
            if (isset($request->date_form) && isset($request->date_to)) {
                $listData = ImportExxportProductModel::whereDate('created_at', '>=', $request->get('date_form'))
                    ->whereDate('created_at', '<=', $request->get('date_to'))
                    ->selectRaw('product_attributes_id, MAX(created_at) as max_created_at')
                    ->groupBy('product_attributes_id')
                    ->orderBy('max_created_at', 'asc')
                    ->paginate(50);
            } else {
                $listData = ImportExxportProductModel::selectRaw('product_attributes_id, MAX(created_at) as max_created_at')
                    ->groupBy('product_attributes_id')
                    ->orderBy('max_created_at', 'asc')
                    ->paginate(50);
            }

            foreach ($listData as $item) {
                $attribute = ProductAttributesModel::find($item->product_attributes_id);
                $product = ProductsModel::find($attribute->product_id);
                $item->attribute_name = $attribute->name;
                $item->product_name = $product->name;
                $item->survive_sl = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->first()->survive_sl;
                $item->survive_tt = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->first()->survive_tt;
                $item->import_sl = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->sum('import_sl');
                $item->import_tt = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->sum('import_tt');
                $item->export_sl = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->sum('export_sl');
                $item->export_tt = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->sum('export_tt');
                $item->ending_sl = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->orderBy('id', 'desc')->first()->ending_sl;
                $item->ending_tt = ImportExxportProductModel::where('product_attributes_id', $item->product_attributes_id)->orderBy('id', 'desc')->first()->ending_tt;
            }
            $titlePage = 'Admin | Xuất Nhập Tồn';
            $page_menu = 'import_export';
            $page_sub = 'import_export';

            if ($request->excel == 2) {
                return Excel::download(new ExportImport($listData), 'ThongKePhieuXuatNhapHang.xlsx');
            } else {
                return view('admin.import_export_product.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
            }
        }else{
            return view('admin.error');
        }
    }

    public function indexImport(Request $request)
    {
        if (User::checkUserRole(4)) {
            if (isset($request->date_form) && isset($request->date_to)) {
                $listData = ImportExxportProductModel::where('type', 1)->whereDate('created_at', '>=', $request->get('date_form'))->whereDate('created_at', '<=', $request->get('date_to'))
                    ->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $listData = ImportExxportProductModel::where('type', 1)->orderBy('created_at', 'desc')->paginate(20);
            }
            foreach ($listData as $item) {
                $attribute = ProductAttributesModel::find($item->product_attributes_id);
                $product = ProductsModel::find($attribute->product_id);
                $item->attribute_name = $attribute->name;
                $item->product_name = $product->name;
                $item->product_img = ProductInformationModel::find($product->product_infor_id)->image;
            }
            $titlePage = 'Admin | Nhập Hàng';
            $page_menu = 'import_export';
            $page_sub = 'import';
            if ($request->excel == 2) {
                return Excel::download(new ExportReceipt($listData), 'ThongKePhieuNhapHang.xlsx');
            } else {
                return view('admin.import_export_product.import.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
            }
        }else{
            return view('admin.error');
        }
    }

    public function createImport()
    {
        if (User::checkUserRole(4)) {
            $titlePage = 'Admin | Nhập Hàng';
            $page_menu = 'import_export';
            $page_sub = 'import';
            return view('admin.import_export_product.import.create', compact('titlePage', 'page_menu', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function storeImport(Request $request)
    {
        $value = $request->get('data');
        foreach ($value as $k => $item) {
            $product = ProductAttributesModel::find($item['product_attributes_id']);
            $quantity = str_replace(",", "", $item['quantity']);
            $price = str_replace(",", "", $item['price']);
            $intoMoney = (int)$quantity * (int)$price;
            if ((int)$quantity > 0) {
                $import = ImportExxportProductModel::where('product_attributes_id', $item['product_attributes_id'])->orderBy('id', 'desc')->first();
                $total_money = $import->ending_tt ?? 0;
                $list_data = ImportExxportProductModel::create([
                    'product_attributes_id' => $item['product_attributes_id'],
                    'quantity' => (int)$quantity,
                    'price' => (int)$price,
                    'Survive_sl' => $import->ending_sl ?? 0,
                    'Survive_tt' => $total_money,
                    'import_sl' => (int)$quantity,
                    'import_tt' => $intoMoney,
                    'export_sl' => 0,
                    'export_tt' => 0,
                    'ending_sl' => $product->quantity + (int)$quantity,
                    'ending_tt' => $intoMoney + $total_money,
                    'type' => 1,
                ]);
                $list_data->save();
                $product->quantity = $product->quantity + (int)$quantity;
                $product->save();
            }
        }
        return redirect()->route('admin.import-export-product.import')->with(['success' => 'Nhập sản phẩm thành công']);
    }

    public function indexExport(Request $request)
    {
        if (User::checkUserRole(4)) {
            if (isset($request->date_form) && isset($request->date_to)) {
                $listData = ImportExxportProductModel::where('type', 2)->whereDate('created_at', '>=', $request->get('date_form'))->whereDate('created_at', '<=', $request->get('date_to'))
                    ->orderBy('created_at', 'desc')->paginate(20);
            } else {
                $listData = ImportExxportProductModel::where('type', 2)->orderBy('created_at', 'desc')->paginate(20);
            }
            foreach ($listData as $item) {
                $attribute = ProductAttributesModel::find($item->product_attributes_id);
                $product = ProductsModel::find($attribute->product_id);
                $item->attribute_name = $attribute->name;
                $item->product_name = $product->name;
                $item->product_img = ProductInformationModel::find($product->product_infor_id)->image;
            }
            $titlePage = 'Admin | Xuất Hàng';
            $page_menu = 'import_export';
            $page_sub = 'export';
            if ($request->excel == 2) {
                return Excel::download(new ExportDelivery($listData), 'ThongKePhieuXuatHang.xlsx');
            } else {
                return view('admin.import_export_product.export.index', compact('titlePage', 'page_menu', 'page_sub', 'listData'));
            }
        }else{
            return view('admin.error');
        }
    }

    public function createExport()
    {
        if (User::checkUserRole(4)) {
            $titlePage = 'Admin | Xuất Hàng';
            $page_menu = 'import_export';
            $page_sub = 'export';
            return view('admin.import_export_product.export.create', compact('titlePage', 'page_menu', 'page_sub'));
        }else{
            return view('admin.error');
        }
    }

    public function storeExport(Request $request)
    {
        $value = $request->get('data');
        foreach ($value as $k => $item) {
            $product = ProductAttributesModel::find($item['product_attributes_id']);
            $quantity = str_replace(",", "", $item['quantity']);
            $price = str_replace(",", "", $item['price']);
            $intoMoney = (int)$quantity * (int)$price;
            if ((int)$quantity > 0) {
                $import = ImportExxportProductModel::where('product_attributes_id', $item['product_attributes_id'])->orderBy('id', 'desc')->first();
                $total_money = $import->ending_tt ?? 0;
                $list_data = ImportExxportProductModel::create([
                    'product_attributes_id' => $item['product_attributes_id'],
                    'quantity' => (int)$quantity,
                    'price' => (int)$price,
                    'Survive_sl' => $import->ending_sl ?? 0,
                    'Survive_tt' => $total_money,
                    'import_sl' => 0,
                    'import_tt' => 0,
                    'export_sl' => (int)$quantity,
                    'export_tt' => $intoMoney,
                    'ending_sl' => $product->quantity - (int)$quantity,
                    'ending_tt' => $total_money - $intoMoney,
                    'type' => 2,
                ]);
                $list_data->save();
                $product->quantity = $product->quantity - (int)$quantity;
                $product->save();
            }
        }
        return redirect()->route('admin.import-export-product.export')->with(['success' => 'Xuất sản phẩm thành công']);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function productSearch(Request $request)
    {
        try {
            $key_search = $request->get('query');
            $products = ProductsModel::Where('name', 'LIKE', '%' . $key_search . '%')->limit(10)->pluck('id');
            $listData = ProductAttributesModel::whereIn('product_id', $products)->get();
            foreach ($listData as $item) {
                $item_product = ProductsModel::find($item->product_id);
                $item->product = $item_product;
                $item->infor = ProductInformationModel::find($item_product->product_infor_id);
            }
            $view = view('admin.import_export_product.item-product', compact('listData'))->render();
            return response()->json(['table_data' => $view]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Thêm sản phẩm
     * */
    public function itemProduct(Request $request)
    {
        try {
            $listData = ProductAttributesModel::whereIn('id', $request->data)->get();
            foreach ($listData as $item) {
                $item_product = ProductsModel::find($item->product_id);
                $item->product = $item_product;
                $item->infor = ProductInformationModel::find($item_product->product_infor_id);
            }
            $view = view('admin.import_export_product.product', compact('listData'))->render();
            return response()->json(['table_data' => $view]);
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * Xóa sản phẩm
     * */
    public function itemDeleteProduct(Request $request)
    {
        try {
            if (isset($request->data)) {
                $listData = ProductAttributesModel::whereIn('id', $request->data)->get();
                foreach ($listData as $item) {
                    $item_product = ProductsModel::find($item->product_id);
                    $item->product = $item_product;
                    $item->infor = ProductInformationModel::find($item_product->product_infor_id);
                }
                $view = view('admin.import_export_product.product', compact('listData'))->render();
                return response()->json(['status' => true, 'table_data' => $view]);
            } else {
                return response()->json(['status' => false]);
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

}
