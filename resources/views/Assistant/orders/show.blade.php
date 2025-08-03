@extends('Admin.layout')

@section('styles')
    <style>
        hr {
            margin: 0;
        }

        .image-upload-square {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 250px;
            height: 250px;
            border-radius: 15px;
        }

        .image-upload-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .image-upload-square:hover {
            background-color: #9fa0a0;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #38bdf8;
            box-shadow: 0 2px 8px rgba(56,189,248,0.15);
        }
        .section-title {
            font-weight: 700;
            color: #38bdf8;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .order-badge {
            font-size: 1rem;
            padding: 0.4em 1em;
            border-radius: 8px;
            font-weight: 600;
        }
        .order-status-pending { background: #fffbe6; color: #ffc107; }
        .order-status-preparing { background: #e0f7fa; color: #38bdf8; }
        .order-status-shipping { background: #e6fff7; color: #10b981; }
        .order-status-delivered { background: #e6ffe6; color: #22c55e; }
        .order-status-cancelled { background: #ffe6e6; color: #ef4444; }
        .info-label { color: #64748b; font-weight: 500; }
        .info-value { font-weight: 600; color: #0f172a; }
        .card-section { background: #f8fafc; border-radius: 16px; box-shadow: 0 2px 8px rgba(15,23,42,0.06); margin-bottom: 2rem; }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #e0e7ef;
        }
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <h1 class="mb-4 section-title"><i class="fa fa-receipt"></i> تفاصيل الطلب <span class="badge bg-primary">#{{ $order->id }}</span></h1>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card card-section">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-info-circle"></i> بيانات الطلب</span>
                    </div>
                        <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-6 info-label">تاريخ الإنشاء</div>
                            <div class="col-6 info-value">{{ $order->created_at->format('Y-m-d g:i A') }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">رقم الطلب</div>
                            <div class="col-6 info-value">{{ $order->order_num }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">حالة الطلب</div>
                            <div class="col-6">
                                <span class="order-badge order-status-{{ strtolower($order->status->name) }}">
                                    <i class="fa fa-circle me-1"></i> {{ __('order.' . $order->status->name) }}
                                </span>
                            </div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">سعر المنتجات</div>
                            <div class="col-6 info-value">{{ $order->price }} {{ __('admin.rs') }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">سعر التوصيل</div>
                            <div class="col-6 info-value">{{ $order->delivery_price }} {{ __('admin.rs') }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">الإجمالي</div>
                            <div class="col-6 info-value">{{ $order->total_price }} {{ __('admin.rs') }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">طريقة الدفع</div>
                            <div class="col-6 info-value"><i class="fa fa-credit-card"></i> {{ __('order.' . $order->pay_type->name) }}</div>
                            </div>
                        <div class="row mb-2">
                            <div class="col-6 info-label">حالة الدفع</div>
                            <div class="col-6 info-value"><span class="badge bg-info text-dark"><i class="fa fa-check-circle"></i> {{ __('order.' . $order->pay_status->name) }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card card-section">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-map"></i> موقع التوصيل</span>
                    </div>
                    <div class="card-body">
                        <div id="orderMap" style="height: 300px; width: 100%; border-radius: 12px; overflow: hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card card-section">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-seedling"></i> تفاصيل المنتجات</span>
                    </div>
                        <div class="card-body">
                        <div class="row g-3">
                            @foreach ($order->items as $item)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ isset($item->product) && $item->product->image ? $item->product->image : '' }}" class="product-img me-3" alt="صورة المنتج">
                                            <div>
                                                <div class="fw-bold">{{ $item->product->name ?? __('admin.unknown_or_deleted') }}
                                                        @if(method_exists($item, 'is_product_deleted') ? $item->is_product_deleted : (isset($item->product) && method_exists($item->product, 'trashed') && $item->product->trashed()))
                                                        <span class="badge bg-danger ms-2">{{ __('admin.product_deleted') }}</span>
                                                        @endif
                                                </div>
                                                <div class="small text-muted">{{ __('admin.product_name') }}</div>
                                            </div>
                                        </div>
                                        <div class="mb-2"><span class="info-label">سعر المنتج:</span> <span class="info-value">{{ $item->product_price }} {{ __('admin.rs') }}</span></div>
                                        <div class="mb-2"><span class="info-label">الكمية:</span> <span class="info-value">{{ $item->quantity }}</span></div>
                                        <div class="mb-2"><span class="info-label">الكمية المجانية:</span> <span class="info-value">{{ $item->free_quantity ?? 0 }}</span></div>
                                        <div class="mb-2"><span class="info-label">الإجمالي:</span> <span class="info-value">{{ $item->total_price }} {{ __('admin.rs') }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-section text-center">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-shop"></i> بيانات المتجر</span>
                    </div>
                        <div class="card-body">
                        <img src="{{ $order->store->image }}" class="profile-img mb-3" alt="صورة المتجر">
                        <div class="fw-bold mb-1">{{ $order->store->name }}</div>
                        <div class="mb-1"><span class="info-label">التقييم:</span> <span class="badge bg-success">{{ $order->store->rating }}</span></div>
                        <div class="mb-1"><span class="info-label">المنطقة:</span> <span class="info-value">{{ $order->store->area }}</span></div>
                        <div class="mb-1"><span class="info-label">التصنيف:</span> <span class="info-value">{{ $order->store->category->name ?? 'N/A' }}</span></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-section text-center">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-user"></i> بيانات العميل</span>
                    </div>
                            <div class="card-body">
                        <img src="{{ $order->user && $order->user->image ? $order->user->image : 'https://ui-avatars.com/api/?name=' . urlencode($order->user->first_name . ' ' . $order->user->last_name) . '&background=38bdf8&color=fff' }}" class="profile-img mb-3" alt="صورة العميل">
                        <div class="fw-bold mb-1">{{ $order->user->first_name ?? '' }} {{ $order->user->last_name ?? '' }}</div>
                        <div class="mb-1"><span class="info-label">رقم الجوال:</span> <span class="info-value">{{ $order->user->phone ?? '-' }}</span></div>
                                </div>
                            </div>
                        </div>
            <div class="col-md-4 mb-4">
                <div class="card card-section text-center">
                    <div class="card-header bg-white border-0">
                        <span class="section-title"><i class="fa fa-motorcycle"></i> بيانات المندوب</span>
                    </div>
                    <div class="card-body">
                     @if ($order->delegate)
                            <img src="{{ $order->delegate->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($order->delegate->name) . '&background=10b981&color=fff' }}" class="profile-img mb-3" alt="صورة المندوب">
                            <div class="fw-bold mb-1">{{ $order->delegate->name }}
                                                    @if(method_exists($order->delegate, 'trashed') && $order->delegate->trashed())
                                    <span class="badge bg-danger ms-2">{{ __('admin.delegate_deleted') }}</span>
                                                    @endif
                                                </div>
                            <div class="mb-1"><span class="info-label">رقم الجوال:</span> <span class="info-value">{{ $order->delegate->phone }}</span></div>
                                @else
                                    <div class="text-center p-4">
                                <h4 style="color: #64748b">{{ __('admin.no_delegate') }}</h4>
                                    </div>
                                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Initialize map
        var map = L.map('orderMap').setView([{{ $order->lat }}, {{ $order->lng }}], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Add marker
        L.marker([{{ $order->lat }}, {{ $order->lng }}])
            .addTo(map)
            .bindPopup('{{ $order->map_desc }}')
            .openPopup();
    </script>
@endsection