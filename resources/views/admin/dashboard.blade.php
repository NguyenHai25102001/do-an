@extends('layout.admin.index')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tổng quan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"></li>
                    <li class="breadcrumb-item active">Tổng quan</li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Doanh số bán hàng</h5>
                                    <div class="form-group d-flex align-items-center">
                                        <form class="d-flex align-items-center w-50" method="get" id="dashboard"
                                              action="{{route('admin.dashboard')}}">
                                            <input type="month" id="monthPicker" name="date" class="form-control w-50" value="{{request()->get('date')}}"
                                                   max="<?= date('Y-m') ?>" onchange="submitForm()">
                                        </form>
                                    </div>
                                    <div id="areaChart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            updateChart();
                                        });

                                        function updateChart() {
                                            let monthYear = document.querySelector("#monthPicker").value;
                                            if (monthYear === "") {
                                                const currentDate = new Date();
                                                const currentMonth = currentDate.getMonth() + 1;
                                                const currentYear = currentDate.getFullYear();
                                                monthYear = currentYear + '-' + (currentMonth < 10 ? '0' : '') + currentMonth;
                                            }
                                            const firstDayOfMonth = new Date(monthYear + '-01');
                                            const lastDayOfMonth = new Date(firstDayOfMonth.getFullYear(), firstDayOfMonth.getMonth() + 1, 1);
                                            const dateRange = [];

                                            let currentDate = new Date(firstDayOfMonth);
                                            while (currentDate <= lastDayOfMonth) {
                                                dateRange.push(currentDate.toISOString().split('T')[0]);
                                                currentDate.setDate(currentDate.getDate() + 1);
                                            }
                                            const sampleData = {!! json_encode($dailySalesData) !!};
                                            const chartData = dateRange.map(date => {
                                                const sales = sampleData[date] || 0;
                                                return {
                                                    x: date,
                                                    y: sales
                                                };
                                            });

                                            const chart = new ApexCharts(document.querySelector("#areaChart"), {
                                                series: [{
                                                    name: "Doanh số",
                                                    data: chartData
                                                }],
                                                chart: {
                                                    type: 'area',
                                                    height: 350,
                                                    zoom: {
                                                        enabled: false
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                stroke: {
                                                    curve: 'smooth'
                                                },
                                                xaxis: {
                                                    type: 'date',
                                                    labels: {
                                                        datetimeUTC: false
                                                    }
                                                },
                                                yaxis: {
                                                    opposite: false,
                                                    labels: {
                                                        formatter: function (value) {
                                                            return value.toLocaleString('vi-VN', {
                                                                style: 'currency',
                                                                currency: 'VND'
                                                            });
                                                        }
                                                    }
                                                },
                                                legend: {
                                                    horizontalAlign: 'left'
                                                },
                                                tooltip: {
                                                    x: {
                                                        format: 'yyyy-MM-dd',
                                                    },
                                                    y: {
                                                        formatter: function (val) {
                                                            return val.toLocaleString('vi-VN', {
                                                                style: 'currency',
                                                                currency: 'VND'
                                                            });
                                                        }
                                                    }
                                                }
                                            });

                                            chart.render();
                                        }
                                        function submitForm() {
                                            document.getElementById("dashboard").submit();
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Loại hàng được mua nhiều nhất</h5>
                                    <input type="hidden" value="{{ json_encode($sectors) }}" id="sectors">
                                    <div id="pieChart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            var sectors = JSON.parse(document.getElementById('sectors').value);
                                            var sectorArray = [];
                                            for (var key in sectors) {
                                                if (sectors.hasOwnProperty(key)) {
                                                    sectorArray.push(sectors[key]);
                                                }
                                            }
                                            new ApexCharts(document.querySelector("#pieChart"), {
                                                series: sectorArray,
                                                chart: {
                                                    height: 350,
                                                    type: 'pie',
                                                    toolbar: {
                                                        show: true
                                                    }
                                                },
                                                labels: ['Điện thoại', 'Máy tính bảng', 'Laptop', 'Đồng hồ thông minh', 'Nhà thông minh', 'Phụ kiện', 'Âm thanh']
                                            }).render();
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Sản phẩm được mua nhiều nhất của từng loại sản phẩm</h5>
                                    <div id="donutChart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            var chartData = @json($product_top);
                                            var seriesData = chartData.map(item => item.SoLuong);
                                            var labelsData = chartData.map(item => item.TenSanPham);
                                            new ApexCharts(document.querySelector("#donutChart"), {
                                                series: seriesData,
                                                chart: {
                                                    height: 350,
                                                    type: 'donut',
                                                    toolbar: {
                                                        show: true
                                                    }
                                                },
                                                labels: labelsData,
                                            }).render();
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="pagetitle">
                            <h8 class="card-title" style="color: #f26522">Thống kê đơn hàng</h8>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Tổng số đơn hàng</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_all}}</h6>
                                            <a href="{{url('admin/order/index/all')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_all_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Đơn hàng chờ xác nhận</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_pending}}</h6>
                                            <a href="{{url('admin/order/index/0')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_pending_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Đơn hàng chờ lấy hàng</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_confirm}}</h6>
                                            <a href="{{url('admin/order/index/1')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_confirm_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Đơn hàng vận chuyển</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_delivery}}</h6>
                                            <a href="{{url('admin/order/index/2')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_delivery_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Đơn hàng hoàn thành</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_complete}}</h6>
                                            <a href="{{url('admin/order/index/3')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_complete_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Đơn hàng đã huỷ</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_cancel}}</h6>
                                            <a href="{{url('admin/order/index/4')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_cancel_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Khách từ chối nhận hàng</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_refuse}}</h6>
                                            <a href="{{url('admin/order/index/5')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_refuse_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Hoàn hàng trả tiền</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-cart"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$order_refund}}</h6>
                                            <a href="{{url('admin/order/index/6')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                            <p>{{number_format($order_refund_money)}} VND</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pagetitle">
                            <h8 class="card-title" style="color: #f26522">Khách hàng</h8>
                        </div>
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Danh sách khách hàng</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{$listCustomers}}</h6>
                                            <a href="{{url('admin/customer')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Khách hàng mua nhiều lần</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{count($customers)}}</h6>
                                            <a href="{{url('admin/customer-buy-max')}}"/><span
                                                class="text-muted small pt-2 ps-1">Xem chi tiết</span></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
