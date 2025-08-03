@extends('Super.layout')

@section('styles')
    <style>
        body,
        .container {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
        }

        .order-header {
            color: #fff;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .card {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
            margin-bottom: 2rem;
            border: none;
        }

        .card-header {
            background: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            display: flex;
            gap: 0.5rem;
        }

        .card-body {
            color: #fff;
        }

        .section-divider {
            border: none;
            border-top: 2px solid rgba(255, 255, 255, 0.08);
            margin: 2rem 0 2rem 0;
        }

        .image-upload-square {
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            width: 120px;
            height: 120px;
            border-radius: 15px;
            background: #222b3a;
            border: 2px solid #334155;
            margin: 0 auto;
        }

        .image-upload-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 15px;
        }

        .image-upload-square:hover {
            box-shadow: 0 0 0 3px #64748b;
        }

        .order-label {
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
        }

        .order-value {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .order-status {
            padding: 0.3rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            background: #334155;
            color: #38bdf8;
            display: inline-block;
        }

        .no-delegate {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.08);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            font-size: 1.1rem;
        }

        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
            margin: 1rem 0;
            position: relative;
            background: #1a2234;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .map-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.2) 0%, rgba(30, 41, 59, 0.2) 100%);
            pointer-events: none;
            z-index: 1;
        }

        #orderMap {
            height: 400px;
            width: 100%;
            border-radius: 15px;
            z-index: 0;
        }

        .back-btn {
            background: linear-gradient(135deg, #334155 0%, #0F172A 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 2rem;
            font-weight: 500;
            margin-bottom: 2rem;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.10);
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #0F172A 0%, #334155 100%);
            color: #38bdf8;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .order-header {
                font-size: 1.3rem;
            }

            .card-header {
                font-size: 1rem;
            }

            .image-upload-square {
                width: 80px;
                height: 80px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection

@section('main')
    <div class="container text-end">
        <h1 class="mb-4 section-title"><i class="fa fa-file-alt"></i> تفاصيل الطلب #{{ $order->id }}</h1>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header section-title">
                        <h5 class="mb-0">{{ __('admin.order_details') }} <i class="fa fa-shop"></i></h5>
                    </div>
                    <hr>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-4">{{ $order->created_at->format('Y-m-d g:i A') }}</div>
                                <div class="col-8">{{ __('admin.order_creation_date') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">{{ $order->order_num }}</div>
                                <div class="col-8">{{ __('admin.order_num') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">{{ __('order.' . $order->status->name)}}</div>
                                <div class="col-8">{{ __('admin.order_status') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4" dir="rtl"> {{ $order->price }} {{ __('admin.rs') }}</div>
                                <div class="col-8">{{ __('admin.products_price') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4" dir="rtl">{{  $order->delivery_price}} {{ __('admin.rs') }}</div>
                                <div class="col-8">{{ __('admin.delivery_price') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4" dir="rtl">{{ $order->total_price}} {{ __('admin.rs') }}</div>
                                <div class="col-8">{{ __('admin.total_price') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">{{ __('order.' . $order->pay_type->name) }}</div>
                                <div class="col-8">{{ __('admin.pay_type') }}</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4">{{ __('order.' . $order->pay_status->name) }}</div>
                                <div class="col-8">{{ __('admin.pay_status') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <span
                class="badge badge-status badge-status-{{ $order->status->value === 0 ? 'preparing' : ($order->status->value === 1 ? 'completed' : ($order->status->value === 2 ? 'cancelled' : 'other')) }}">
                {{ __('order.' . $order->status->name) }}
            </span>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header section-title"><i class="fa fa-user"></i> {{ __('admin.user_details') }}</div>
                    <div class="card-body">
                        @if ($order->user)
                            <div class="d-flex align-items-center mb-3">
                                <div class="image-upload-square me-3">
                                    @if($order->user->image)
                                        <img src="{{ $order->user->image }}" alt="User Image" />
                                    @else
                                        <span>{{ __('admin.no_image') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="info-value">{{ $order->user->first_name }} {{ $order->user->last_name }}</div>
                                    <div class="info-label"><i class="fa fa-phone"></i> {{ $order->user->phone }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <h4>{{ __('admin.unknown_or_deleted') }}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header section-title"><i class="fa fa-user"></i> {{ __('admin.delegate_details') }}
                    </div>
                    <div class="card-body">
                        @if ($order->delegate)
                            <div class="d-flex align-items-center mb-3">
                                <div class="image-upload-square me-3">
                                    @if($order->delegate->image)
                                        <img src="{{ $order->delegate->image }}" alt="Delegate Image" />
                                    @else
                                        <span>{{ __('admin.no_image') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="info-value">{{ $order->delegate->name }}
                                        @if(method_exists($order->delegate, 'trashed') && $order->delegate->trashed())
                                            <span class="badge bg-danger product-badge">{{ __('admin.delegate_deleted') }}</span>
                                        @endif
                                    </div>
                                    <div class="info-label"><i class="fa fa-map-marker-alt"></i> {{ $order->delegate->area }}</div>
                                    <div class="info-label"><i class="fa fa-phone"></i> {{ $order->delegate->phone }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <h4>{{ __('admin.no_delegate') }}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="section-divider"></div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header section-title"><i class="fa fa-shop"></i> {{ __('admin.store_details') }}</div>
                    <div class="card-body">
                        @if ($order->store)
                            <div class="d-flex align-items-center mb-3">
                                <div class="image-upload-square me-3">
                                    <img src="{{ $order->store->image }}" alt="Store Image" />
                                </div>
                                <div>
                                    <div class="info-value">{{ $order->store->name }}</div>
                                    <div class="info-label">{{ __('admin.store_rating') }}: {{ $order->store->rating }}</div>
                                    <div class="info-label">{{ __('admin.store_area') }}: {{ $order->store->area }}</div>
                                    <div class="info-label">{{ __('admin.store_category') }}:
                                        {{ $order->store->category->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @else
                            <div class="text-center p-4">
                                <h4>{{ __('admin.unknown_or_deleted') }}</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header section-title"><i class="fa fa-map"></i> {{ __('admin.delivery_location') }}
                    </div>
                    <div class="card-body">
                        <div id="orderMap" style="height: 200px; width: 100%; border-radius: 12px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-divider"></div>
        <div class="card">
            <div class="card-header section-title"><i class="fa fa-seedling"></i> {{ __('admin.products_details') }}</div>
            <div class="card-body">
                @if($order->items && count($order->items))
                    <div class="row g-3">
                        @foreach ($order->items as $item)
                            <div class="col-md-6 col-lg-4">
                                <div class="card mb-3 p-2 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="image-upload-square me-2">
                                            @if(isset($item->product) && $item->product->image)
                                                <img src="{{ $item->product->image }}" alt="Product Image" />
                                            @else
                                                <span>{{ __('admin.no_image') }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="info-value">{{ $item->product->name ?? __('admin.unknown_or_deleted') }}
                                                @if($item->is_product_deleted)
                                                    <span class="badge bg-danger product-badge">{{ __('admin.product_deleted') }}</span>
                                                @endif
                                            </div>
                                            <div class="info-label">{{ __('admin.product_quantity') }}: {{ $item->quantity }}</div>
                                        </div>
                                    </div>
                                    <div class="mb-1 info-label">{{ __('admin.product_price') }}: <span class="info-value">{{ $item->product_price }} {{ __('admin.rs') }}</span></div>
                                    <div class="mb-1 info-label">{{ __('admin.total_price') }}: <span class="info-value">{{ $item->total_price }} {{ __('admin.rs') }}</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center p-4">
                        <h4>{{ __('admin.no_order_items') }}</h4>
                    </div>
                @endif
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