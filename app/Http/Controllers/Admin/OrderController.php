<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ShippingUnitController;
use App\Models\DistrictGHNModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\ProductAttributesModel;
use App\Models\ProductInformationModel;
use App\Models\ProductsModel;
use App\Models\ProvinceGHNModel;
use App\Models\User;
use App\Models\WardGHNModel;
use Illuminate\Http\Request;

class OrderController extends ShippingUnitController
{
    /**
     * Danh sách order theo trang thái
     */
    public function getDataOrder(Request $request, $status)
    {
        try {
            if (User::checkUserRole(2)) {
                $titlePage = 'Quản lý đơn hàng';
                $page_menu = 'order';
                $page_sub = 'order';
                $listData = OrderModel::query();
                if ($status !== 'all') {
                    $listData = $listData->where('status', $status);
                }
                $key_search = $request->get('search');
                if (isset($key_search)) {
                    $listData = $listData->where(function ($listData) use ($key_search) {
                        return $listData->where('name', 'like', '%' . $key_search . '%')->orWhere('phone', 'like', '%' . $key_search . '%')
                            ->orWhere('order_code', 'LIKE', '%' . $key_search . '%');
                    });
                }
                $listData = $listData->orderBy('updated_at', 'desc')->paginate(10);
                foreach ($listData as $item) {
                    $item->status_name = $this->checkStatusOrder($item);
                }
                $order_all = OrderModel::count();
                $order_pending = OrderModel::where('status', 0)->count();
                $order_confirm = OrderModel::where('status', 1)->count();
                $order_delivery = OrderModel::where('status', 2)->count();
                $order_complete = OrderModel::where('status', 3)->count();
                $order_cancel = OrderModel::where('status', 4)->count();
                $order_refuse = OrderModel::where('status', 5)->count();
                $order_refund = OrderModel::where('status', 6)->count();
                return view('admin.order.index', compact('titlePage', 'page_menu', 'listData', 'page_sub', 'order_pending', 'order_confirm',
                    'order_delivery', 'order_complete', 'order_cancel', 'status', 'order_refuse', 'order_refund', 'order_all'));
            } else {
                return view('admin.error');
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * chi tiet đơn hàng
     */
    public function orderDetail($order_id)
    {
        try {
            if (User::checkUserRole(2)) {
                $titlePage = 'Chi tiết đơn hàng';
                $page_menu = 'order';
                $page_sub = 'order';
                $listData = OrderModel::find($order_id);
                if ($listData) {
                    $province = ProvinceGHNModel::all();
                    if (isset($listData->province_id)) {
                        $district = DistrictGHNModel::where('ProvinceID', $listData->province_id)->get();
                    } else {
                        $district = [];
                    }
                    if (isset($listData->district_id)) {
                        $ward = WardGHNModel::where('DistrictID', $listData->district_id)->get();
                    } else {
                        $ward = [];
                    }
                    $order_item = OrderItemModel::where('order_id', $order_id)->get();
                    foreach ($order_item as $item) {
                        $product_attributes = ProductAttributesModel::find($item->product_attributes_id);
                        $item->product_name = ProductsModel::find($product_attributes->product_id);
                        $item->product_image = ProductInformationModel::find($item->product_name->product_infor_id);
                        $item->product_attribute = $product_attributes;
                    }
                    $listData['status_name'] = $this->checkStatusOrder($listData);
                    $listData['order_item'] = $order_item;
                    return view('admin.order.detail', compact('titlePage', 'page_menu', 'listData', 'page_sub', 'province', 'district', 'ward'));
                } else {
                    return back()->withErrors(['error' => 'Đơn hàng không tồn tại']);
                }
            } else {
                return view('admin.error');
            }
        } catch (\Exception $exception) {
            return back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Xét trạng thái đơn hàng
     *
     */
    public function statusOrder($order_id, $status_id)
    {
        try {
            if (User::checkUserRole(2)) {
                $order = OrderModel::find($order_id);
                if ($order) {
                    $order->status = $status_id;
                    if ($status_id == 4) {
                        if ($order->transport_name == 'GHN') {
                            $this->cancelOrdersGHN($order->order_code_transport);
                        }
                    }
                    if ($status_id == 1) {
                        if ($order->transport_name == 'GHN') {
                            $order_ghn = $this->createOrdersGHN($order);
                            if ($order_ghn->code == 200) {
                                $order->order_code_transport = $order_ghn->data->order_code;
                            } else {
                                return back()->with('error', $order_ghn->message);
                            }
                        }
                    }
                    $order->save();
                    if ($status_id == 4 || $status_id == 5 || $status_id == 6) {
                        $this->updateQuantityProductWhenCancel($order);
                    }
                    return \redirect()->route('admin.order.index', [$status_id])->with(['success' => 'Xét trạng thái đơn hàng thành công']);
                } else {
                    return view('admin.error');
                }
            }
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

    /**
     * kiểm tra trạng thái đơn hàng
     */
    public function checkStatusOrder($item)
    {

        if ($item->status == 0) {
            $val_status = 'Chờ xác nhận';
        } elseif ($item->status == 1) {
            $val_status = 'Đã xác nhận';
        } elseif ($item->status == 2) {
            $val_status = 'Đang vận chuyển';
        } elseif ($item->status == 3) {
            $val_status = 'Đã hoàn thành';
        } elseif ($item->status == 4) {
            $val_status = 'Đã hủy';
        } elseif ($item->status == 5) {
            $val_status = 'Từ chối nhận';
        } else {
            $val_status = 'Hoàn trả hàng';
        }

        return $val_status;
    }

    /**
     * cập nhật số lượng sản phẩm khi huỷ đơn hàng
     *
     **/
    public function updateQuantityProductWhenCancel($order)
    {
        $order_item = OrderItemModel::where('order_id', $order->id)->get();
        foreach ($order_item as $value) {
            $product = ProductAttributesModel::find($value->product_attributes_id);
            if (isset($product)) {
                $product->quantity = $product->quantity + $value->quantity;
                $product->save();
            }
        }
        return true;
    }
}
