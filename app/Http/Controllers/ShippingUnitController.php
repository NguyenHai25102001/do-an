<?php

namespace App\Http\Controllers;

use App\Models\DistrictGhnModel;
use App\Models\OrderItemModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductsModel;
use App\Models\ProvinceGhnModel;
use App\Models\WardGhnModel;
use Illuminate\Http\Request;

class ShippingUnitController extends Controller
{
    /**
     * Tạo đơn hàng giao hàng nhanh
     */
    public function createOrdersGHN($order)
    {
        try {
            $province = ProvinceGhnModel::where('ProvinceID', $order->province_id)->first();
            $district = DistrictGhnModel::where('DistrictID', $order->district_id)->first();
            $ward = WardGhnModel::where('WardCode', $order->ward_id)->first();

            $shop_province = ProvinceGhnModel::where('ProvinceID', '201')->first();
            $shop_district = DistrictGhnModel::where('DistrictID', '1493')->first();
            $shop_ward = WardGhnModel::where('WardCode', '1A0709')->first();
            $products = [];
            $order_item = OrderItemModel::where('order_id', $order->id)->get();
            $_value = $order->total_money_order;

            $__products_name = '';
            $__quantity = 0;
            $__products_price = 0;
            $__products_weight = 0;
            foreach ($order_item as $k => $item) {
                $product_attribute = ProductAttributesModel::find($item->product_attributes_id);
                $product = ProductsModel::find($product_attribute->product_id);
                $products[$k]['name'] = $product->name;
                $products[$k]['quantity'] = $item->quantity;
                $products[$k]['price'] = $item->promotional_price;
                $__products_name .= ', ' . $product->name;
                $__quantity += $item->quantity;
                $__products_price += $item->promotional_price;
                $__products_weight += $item->quantity * 100;
            }
            $services = $this->serviceGHN($shop_district->DistrictID, $district->DistrictID);

            $__post = '{
                    "payment_type_id": 1,
                    "note": "không cho xem hàng",
                    "required_note": "KHONGCHOXEMHANG",
                    "from_name":"Hebi Store",
                    "from_phone":"0978129116",
                    "from_address":"Nhà số 1",
                    "from_ward_name":"' . $shop_ward->WardName . '",
                    "from_district_name":"' . $shop_district->DistrictName . '",
                    "from_province_name":"' . $shop_province->ProvinceName . '",
                    "client_order_code": "' . $order->order_code . '",
                    "to_name": "' . $order->name . '",
                    "to_phone": "' . $order->phone . '",
                    "to_address": "' . $order->full_address . '",
                    "to_ward_name": "' . $ward->WardName . '",
                    "to_district_name": "' . $district->DistrictName . '",
                    "to_province_name": "' . $province->ProvinceName . '",
                    "cod_amount": ' . $_value . ',
                    "content": "' . $__products_name . '",
                    "weight": ' . $__products_weight . ',
                    "length": 5,
                    "width": 5,
                    "height": 5,
                    "insurance_value": ' . $__products_price . ',
                    "service_id": ' . $services . ',
                    "service_type_id":2,
                    "items":' . json_encode($products) . '
                }';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => $__post,
                CURLOPT_HTTPHEADER => array(
                    'token: cdb73e69-2ea8-11ee-96dc-de6f804954c9',
                    'Content-Type: application/json',
                    'shopid: 4404387'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return json_decode($response);
        } catch (\Exception $exception) {

            dd($exception);
        }
    }

    /**
     * Huỷ đơn hàng giao hàng nhanh
     */
    public function cancelOrdersGHN($order_transport_code)
    {
        try {
            $__post = '{"order_codes":["' . $order_transport_code . '"]}';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/switch-status/cancel',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $__post,
                CURLOPT_HTTPHEADER => array(
                    'token: cdb73e69-2ea8-11ee-96dc-de6f804954c9',
                    'Content-Type: application/json',
                    'shopid: 4404387'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return json_decode($response);
        } catch (\Exception $exception) {

        }
    }

    /**
     * Tính phí vận chuyển giao hàng nhanh
     */
    public function feeShippingGHN($_address_shipping, $total_money_product)
    {
        try {
            $district = DistrictGhnModel::where('DistrictID', '1493')->first();
            $district_customer = DistrictGhnModel::where('DistrictID', $_address_shipping['district_id_ghn'])->first();
            $ward_customer = WardGhnModel::where('WardCode', $_address_shipping['ward_id_ghn'])->first();
            $__weight = 1 * 100;
            $__value = $total_money_product;
            $__service = $this->serviceGHN($district->DistrictID, $district_customer->DistrictID);

            $data = '{
                    "from_district_id":' . $district->DistrictID . ',
                    "service_id":' . $__service . ',
                    "service_type_id":null,
                    "to_district_id":' . $district_customer->DistrictID . ',
                    "to_ward_code":"' . $ward_customer->WardCode . '",
                    "height":0,
                    "length":0,
                    "weight":' . $__weight . ',
                    "width":0,
                    "insurance_value":' . $__value . ',
                    "coupon": null
                    }';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/fee',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'ShopId: 4404387',
                    'token: cdb73e69-2ea8-11ee-96dc-de6f804954c9'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response);

            if ($response->code == 200) {
                return $response->data->total;
            } else {
                return 0;
            }

        } catch (\Exception $exception) {

        }
    }

    /**
     * Tính giá cho tất cả các dịch vụ phù hợp
     */
    protected function serviceGHN($district, $district_customer)
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://online-gateway.ghn.vn/shiip/public-api/v2/shipping-order/available-services',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "shop_id":4404387,
                    "from_district": ' . $district . ',
                    "to_district": ' . $district_customer . '
                }',
                CURLOPT_HTTPHEADER => array(
                    'token: cdb73e69-2ea8-11ee-96dc-de6f804954c9',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $response = json_decode($response);
            if ($response->code) {
                return $response->data[0]->service_id;
            } else {
                return 53320;
            }
        } catch (\Exception $exception) {

        }
    }
}
