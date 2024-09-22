<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CartModel;
use App\Models\FlashSaleModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function getCart(Request $request)
    {
        try {
            $carts = CartModel::where('user_token', $request->get('token'))->get();
            foreach ($carts as $k => $item) {
                $product_attribute = ProductAttributesModel::find($item->product_attributes_id);
                if (empty($product_attribute)) {
                    $carts[$k]->delete();
                }
                $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())
                    ->where('product_id',$product_attribute->product_id)->first();
                if ($flash_sale){
                    $item->total_money = $flash_sale->price_sale * $item->quantity;
                }else{
                    $item->total_money = $product_attribute->promotional_price * $item->quantity;
                }
                $item->save();
                $product = ProductsModel::find($product_attribute->product_id);
                $product_infor = ProductInformationModel::find($product->product_infor_id);
                $carts[$k]['product_attribute'] = $product_attribute;
                $carts[$k]['product'] = $product;
                $carts[$k]['product_infor'] = $product_infor;
            }
            $dataReturn = [
                'status' => true,
                'msg' => 'Lấy danh sách sản phẩm trong giỏ hàng thành công.',
                'data' => $carts,
            ];
            return response()->json($dataReturn, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function addProduct(Request $request)
    {
        try {
            $product_attribute = ProductAttributesModel::find($request->get('product_attributes_id'));
            $cart = CartModel::where('user_token', $request->get('token'))->where('product_attributes_id', $request->get('product_attributes_id'))->first();
            $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id',$product_attribute->product_id)->first();
            if (isset($cart)) {
                $quantity = $cart->quantity + 1;
                if ($quantity > 3) {
                    return $dataReturn = [
                        'status' => false,
                        'msg' => 'Số lượng sản phẩm đã đạt đến mức tối đa.',
                    ];
                }
                if ($flash_sale){
                    $total_price = $quantity * $flash_sale->price_sale;
                }else{
                    $total_price = $quantity * $product_attribute->promotional_price;
                }
                $cart->total_money = $total_price;
                $cart->quantity = $quantity;
                $cart->save();
            } else {
                $quantity = 1;
                if ($quantity > $product_attribute->quantity) {
                    $quantity = $product_attribute->quantity;
                }
                if ($flash_sale){
                    $total_price = $quantity * $flash_sale->price_sale;
                }else{
                    $total_price = $quantity * $product_attribute->promotional_price;
                }
                $cart = new CartModel([
                    'user_token' => $request->get('token'),
                    'product_attributes_id' => $product_attribute->id,
                    'quantity' => $quantity,
                    'total_money' => $total_price,
                ]);
                $cart->save();
            }
            $count_cart = CartModel::where('user_token', $request->get('token'))->count();
            $dataReturn = [
                'status' => true,
                'msg' => 'Thêm sản phẩm vào giỏ hàng thành công.',
                'count_cart' => $count_cart
            ];
            return response()->json($dataReturn, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function changeQuantity(Request $request)
    {
        try {
            $cart = CartModel::find($request->get('cart_id'));
            if (empty($cart)) {
                $dataReturn = [
                    'status' => false,
                    'msg' => 'Không tìm thấy sản phẩm'
                ];
                return response()->json($dataReturn, Response::HTTP_OK);
            }
            $type = $request->get('type');
            $product_attribute = ProductAttributesModel::find($cart->product_attributes_id);
            $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id',$product_attribute->product_id)->first();
            switch ($type) {
                case 1:
                    $quantity = $cart->quantity + 1;
                    if ($quantity > 3) {
                        $dataReturn = [
                            'status' => false,
                            'msg' => 'Vượt quá số lượng cho phép mua'
                        ];
                        return response()->json($dataReturn, Response::HTTP_OK);
                    }
                    break;
                case 2:
                    $quantity = $cart->quantity - 1;
                    if ($quantity < 1) {
                        $quantity = 1;
                    }
                    break;
            }
            if ($flash_sale){
                $total_price = $quantity * $flash_sale->price_sale;
            }else{
                $total_price = $quantity * $product_attribute->promotional_price;
            }
            $money_base = $quantity * $product_attribute->price;
            $cart->total_money = $total_price;
            $cart->quantity = $quantity;
            $cart->save();
            $sum_price = CartModel::where('user_token', $request->get('token'))->sum('total_money');
            $dataReturn = [
                'status' => true,
                'msg' => 'Thêm sản phẩm thành công',
                'quantity'=> $quantity,
                'total_money' => $total_price,
                'sum_price'=>$sum_price,
                'money_base'=>$money_base
            ];
            return response()->json($dataReturn, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function delete(Request $request)
    {
        try {
            $cart = CartModel::find($request->get('cart_id'));
            $cart->delete();
            $sum_price = CartModel::where('user_token', $request->get('token'))->sum('total_money');
            $dataReturn = [
                'status' => true,
                'msg' => 'Bạn đã xóa sản phẩm thành công',
                'sum_price' => $sum_price
            ];
            return response()->json($dataReturn, Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
