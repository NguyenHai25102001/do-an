<?php

return [
    'admin' => [
        [
            'name' => 'dashboard',
            'title' => 'Tổng quan',
            'icon' => 'bi bi-grid',
            'route' => 'admin.dashboard',
            'submenu' => [],
            'number' => 1
        ],
        [
            'name' => 'order',
            'title' => 'Quản lý đơn hàng',
            'icon' => 'bi bi-grid',
            'route' => 'admin.order.index',
            'parameters' => ['status' => 'all'],
            'submenu' => [],
            'number' => 2
        ],
        [
            'name' => 'banner',
            'title' => 'Banner hình ảnh',
            'icon' => 'bi bi-grid',
            'route' => 'admin.banner.index',
            'submenu' => [],
            'number' => 3
        ],
        [
            'name' => 'import_export',
            'title' => 'Quản lý xuất nhập hàng',
            'icon' => 'bi bi-grid',
            'route' => null,
            'submenu' => [
                [
                    'title' => 'Nhập hàng',
                    'route' => 'admin.import-export-product.import',
                    'name' => 'import'
                ],
                [
                    'title' => 'Xuất hàng',
                    'route' => 'admin.import-export-product.export',
                    'name' => 'export'
                ],
                [
                    'title' => 'Xuất nhập tồn',
                    'route' => 'admin.import-export-product.index',
                    'name' => 'import_export'
                ]
            ],
            'number' => 4
        ],
        [
            'name' => 'products',
            'title' => 'Quản lý sản phẩm',
            'icon' =>'bi bi-menu-button-wide',
            'route' => null,
            'submenu' => [
                [
                    'title' => 'Danh mục sản phẩm',
                    'route' => 'admin.category.index',
                    'name' => 'category'
                ],
                [
                    'title' => 'Danh sách sản phẩm',
                    'route' => 'admin.products.index',
                    'name' => 'index'
                ],
                [
                    'title' => 'Danh sách flash sale',
                    'route' => 'admin.flash-sale.index',
                    'name' => 'flash_sale'
                ],
            ],
            'number' => 5
        ],
        [
            'name' => 'review',
            'title' => 'Danh sách đánh giá',
            'icon' => 'bi bi-grid',
            'route' => 'admin.products.reviews',
            'parameters' => ['status' => '1'],
            'submenu' => [],
            'number' => 6
        ],
        [
            'name' => 'news',
            'title' => 'Quản lý tin tức',
            'icon' => 'bi bi-grid',
            'route' => 'admin.news.index',
            'submenu' => [],
            'number' => 7
        ],
        [
            'name' => 'introduce',
            'title' => 'Quản lý footer',
            'icon' => 'bi bi-grid',
            'route' => 'admin.introduce.index',
            'submenu' => [],
            'number' => 8
        ],
        [
            'name' => 'role',
            'title' => 'Phân quyền',
            'icon' => 'bi bi-grid',
            'route' => 'admin.role.index',
            'submenu' => [],
            'number' => 9
        ],
    ]
];
