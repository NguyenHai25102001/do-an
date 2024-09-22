<?php

namespace App\Http\Controllers\Web;

use App\Events\OrderNoticeEvent;
use App\Http\Controllers\ShippingUnitController;
use App\Models\CartModel;
use App\Models\DistrictGhnModel;
use App\Models\FlashSaleModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductsModel;
use App\Models\ProvinceGHNModel;
use App\Models\WardGhnModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PayController extends ShippingUnitController
{
    public function pay(){
        return view('web.pay.index');
    }

    public function getPay(Request $request)
    {
        try {
            $data_cart = CartModel::where('user_token', $request->user_token)->get();
            if (count($data_cart)>0){
                foreach ($data_cart as $item){
                    $item->product_attribute = ProductAttributesModel::find($item->product_attributes_id);
                    $item->product = ProductsModel::find($item->product_attribute->product_id);
                    $item->product_infor = ProductInformationModel::find($item->product->product_infor_id);
                    $flash_sale = FlashSaleModel::where('time_start', '<=', Carbon::now())->where('time_end', '>=', Carbon::now())->where('product_id',$item->product->id)->first();
                    if ($flash_sale){
                        $item->product_attribute->promotional_price = $flash_sale->price_sale;
                    }
                }
                $data_province = ProvinceGhnModel::orderBy('id', 'desc')->get();
                $sum_price = CartModel::where('user_token', $request->user_token)->sum('total_money');
                $dataReturn = [
                    'status' => true,
                    'msg' => 'Lấy danh sách sản phẩm trong giỏ hàng thành công.',
                    'data' => $data_cart,
                    'sum_price' => $sum_price,
                    'data_province' => $data_province,
                ];
            }else{
                $dataReturn = [
                    'status' => false,
                    'msg' => 'Chưa có sản phẩm trong giỏ hàng. Vui lòng thêm sản phẩm vào giỏ hàng!',
                ];
            }

            return response()->json($dataReturn, Response::HTTP_OK);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function createOrderUser(Request $request)
    {
        try {
            $rule = [
                'name' => 'required',
                'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:10|max:10',
                'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            ];
            $messenger = [
                'name.required' => 'Vui lòng thêm họ tên',
                'phone.required' => 'Vui lòng thêm số điện thoại',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'phone.not_regex' => 'Số điện thoại không hợp lệ',
                'phone.min' => 'Số điện thoại không hợp lệ',
                'phone.max' => 'Số điện thoại không hợp lệ',
                'email.required' => 'Vui lòng thêm email',
                'email.regex' => 'Email không hợp lệ',
            ];
            $validator = Validator::make($request->all(), $rule, $messenger);
            if ($validator->fails()){
                return back()->with(['error' => $validator->errors()->first()]);
            }
            $carts = CartModel::where('user_token',$request->get('user_token'))->get();
            $province = ProvinceGhnModel::where('ProvinceID', $request->get('province_id'))->first();
            $district = DistrictGhnModel::where('DistrictID', $request->get('district_id'))->first();
            $ward = WardGhnModel::where('WardCode', $request->get('ward_id'))->first();
            $total_money = $carts->sum('total_money');
            if ($total_money >= 5000000){
                $fee_ship = 0;
            }else{
                $fee_ship = $request->get('fee_ship');
            }
            $order = new OrderModel();
            $order['order_code'] = 'HS'.rand(0, 99999).$order->id;
            $order['name'] = $request->get('name');
            $order['phone'] = $request->get('phone');
            $order['email'] = $request->get('email');
            $order['vocative'] = $request->get('vocative');
            $order['delivery_address'] = $request->get('delivery_address');
            $order['province_id'] = $request->get('province_id');
            $order['district_id'] = $request->get('district_id');
            $order['ward_id'] = $request->get('ward_id');
            $order['address_detail'] = $request->get('address_detail');
            $order['full_address'] = $request->get('address_detail').','. $ward->WardName . ',' . $district->DistrictName . ',' . $province->ProvinceName;
            $order['note'] = $request->get('note');
            $order['issue_invoice'] = $request->get('issue_invoice');
            $order['name_cty'] = $request->get('name_cty');
            $order['address_cty'] = $request->get('address_cty');
            $order['tax_code'] = $request->get('tax_code');
            $order['fee_shipping'] = $fee_ship;
            $order['total_money_product'] = $total_money;
            $order['total_money_order'] = $total_money + $fee_ship;
            $order['status'] = 0;
            if ($request->get('fee_ship') == 0){
                $order['transport_name'] = 'Store';
            }else{
                $order['transport_name'] = 'GHN';
            }
            $order->save();
            foreach ($carts as $k => $item){
                $this->saveOrderItem($order, $item);
            }
            if ($request->type_payment == 1) {
                $order['type_payment'] = 1;
                $order->save();
                CartModel::where('user_token',$request->get('user_token'))->delete();
                event(new OrderNoticeEvent('Có đơn hàng mới. Mau đến kiểm tra'));
                return redirect()->route('home')->with(['success' => 'Tạo đơn hàng thành công. Mã đơn hàng của bạn là: '.$order->order_code.'']);
            }elseif ($request->type_payment == 2){
                $this->checkoutByVnPay($total_money,$order,$request->get('user_token'));
            }
        } catch (\Exception $exception) {
            dd($exception);
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

    public function feeShip(Request $request)
    {
        try {
            $province = ProvinceGhnModel::where('ProvinceID', $request->province_id)->first();
            $district = DistrictGhnModel::where('DistrictID', $request->district_id)->first();
            $ward = WardGhnModel::where('WardCode', $request->ward_id)->first();
            $_address_shipping = [
                'province_id_ghn' => $request->province_id,
                'district_id_ghn' => $request->district_id,
                'ward_id_ghn' => $request->ward_id,
                'address_detail' => $request->address_detail,
                'full_address' => $request->address_detail . ', ' . $ward->WardName . ', ' . $district->DistrictName . ', ' . $province->ProvinceName
            ];
            $total_money_product = (int)$request->total_all;
            $fee_ship = $this->feeShippingGHN($_address_shipping, $total_money_product);

            $data['status'] = true;
            $data['address'] = $_address_shipping['full_address'];
            $data['ship'] = $fee_ship;
            $data['total_product'] = $total_money_product;
            $data['msg'] = 'Tính phí ship thành công';
            return $data;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function checkoutByVnPay ($total,$order,$user_token)
    {
        session_start();
        $_SESSION['user_token'] = $user_token;
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('thanh-toan/thanh-cong');
        $vnp_TmnCode = "7HKVF2P8";
        $vnp_HashSecret = "QZHVDKNDFLLQBQIZRWSCUEBNDWEOOODQ";

        $vnp_TxnRef = $order->order_code;
        $vnp_OrderInfo = 'Khách hàng '.$order->name.' - '.$order->phone.' đã mua hàng';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function successOrderVnPay ()
    {
        session_start();
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $vnp_HashSecret = 'QZHVDKNDFLLQBQIZRWSCUEBNDWEOOODQ';
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $order = OrderModel::where('order_code',$_GET['vnp_TxnRef'])->first();
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $order->type_payment = 2;
                $order->save();
                CartModel::where('user_token',$_SESSION['user_token'])->delete();
                event(new OrderNoticeEvent('Có đơn hàng mới. Mau đến kiểm tra'));
                $msg = ['success' => 'Thanh toán thành công. Cảm ơn bạn đã lựa chọn HebiStore. Mã đơn hàng của bạn là: '.$order->order_code.''];
            }
            else {
                $order_item = OrderItemModel::where('order_id',$order->id)->get();
                foreach ($order_item as $item){
                    $item->delete();
                }
                $order->delete();
                $msg = ['error' => 'Thanh toán thất bại.Vui lòng thanh toán lại'];
            }
        } else {
            $order_item = OrderItemModel::where('order_id',$order->id)->get();
            foreach ($order_item as $item){
                $item->delete();
            }
            $order->delete();
            $msg = ['error' => 'Thanh toán thất bại.Vui lòng thanh toán lại'];
        }
        return redirect()->route('home')->with($msg);
    }

    /**
     * Lưu order item
     */
    public function saveOrderItem($order, $item){
        try {
            $product_attributes = ProductAttributesModel::find($item->product_attributes_id);
            $order_item = new OrderItemModel();
            $order_item['order_id'] = $order->id;
            $order_item['product_attributes_id'] = $item->product_attributes_id;
            $order_item['price'] = $product_attributes->price;
            $order_item['promotional_price'] = $product_attributes->promotional_price;
            $order_item['quantity'] = $item->quantity;
            $order_item['total_money'] = $item->total_money;
            $order_item->save();

            return true;
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

}
