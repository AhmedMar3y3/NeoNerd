@extends('Super.layout')

@section('styles')
    <style>
        body,
        .container {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
        }

        .orders-card {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
            border: none;
            margin-bottom: 2rem;
        }

        .orders-header {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .orders-table {
            color: #fff;
            background: transparent;
        }

        .orders-table th {
            background: #1E293B;
            color: #94a3b8;
            font-weight: 600;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
            padding: 1rem;
        }

        .orders-table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem;
            vertical-align: middle;
        }

        .orders-table tbody tr {
            transition: background 0.2s;
        }

        .orders-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.07);
        }

        .badge-status {
            font-size: 1rem;
            padding: 0.5em 1.2em;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-status-preparing {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e42 100%);
            color: #fff;
        }

        .badge-status-completed {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: #fff;
        }

        .badge-status-cancelled {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
        }

        .badge-status-other {
            background: linear-gradient(135deg, #64748b 0%, #334155 100%);
            color: #fff;
        }

        .btn-action {
            border-radius: 10px;
            font-size: 1.1rem;
            padding: 0.5em 1.2em;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
            border: none;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: #fff;
            transform: translateY(-2px);
        }

        .image-upload-square {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: #222b3a;
            border: 2px solid #334155;
            overflow: hidden;
            margin: 0 auto;
        }

        .image-upload-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .search-bar {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            color: #fff;
            padding: 0.7rem 1.2rem;
            margin-left: 1rem;
            width: 220px;
        }

        .search-bar:focus {
            background: rgba(255, 255, 255, 0.13);
            border-color: #3b82f6;
            color: #fff;
        }

        .status-filter {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            color: #fff;
            padding: 0.7rem 1.2rem;
            width: 180px;
        }

        .status-filter:focus {
            background: rgba(255, 255, 255, 0.13);
            border-color: #3b82f6;
            color: #fff;
        }

        .pagination .btn {
            border-radius: 10px;
            font-weight: 500;
            margin: 0 0.2rem;
        }

        @media (max-width: 768px) {
            .orders-header {
                font-size: 1.2rem;
            }

            .orders-table th,
            .orders-table td {
                font-size: 0.95rem;
                padding: 0.5rem;
            }

            .search-bar,
            .status-filter {
                width: 100%;
                margin: 0 0 1rem 0;
            }
        }
    </style>
@endsection

@section('main')
    <div class="container text-end">
        <div class="orders-header mb-4"><i class="fa fa-shopping-cart"></i> قائمة الطلبات</div>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <form method="GET" action="" class="d-flex flex-wrap gap-2">
                <input type="text" name="order" class="search-bar" placeholder="بحث برقم الطلب..."
                    value="{{ isset($orderNum) ? $orderNum : request('order') }}">
                <select name="status" class="status-filter">
                    <option value="">كل الحالات</option>
                    @foreach (\App\Enums\OrderStatus::cases() as $enumStatus)
                        <option value="{{ $enumStatus->value }}" {{ (isset($status) && $status !== '' && $status == $enumStatus->value) ? 'selected' : '' }}>
                            {{ __('order.' . $enumStatus->name) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary"><i class="fa fa-filter me-1"></i> تصفية</button>
            </form>
        </div>
        <div class="orders-card">
            <div class="table-responsive">
                <table class="table orders-table align-middle">
                    <thead>
                        <tr>
                            <th>الإجراءات</th>
                            <th>الحالة</th>
                            <th>المندوب</th>
                            <th>طريقة الدفع</th>
                            <th>السعر</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <a href="{{ route('super.orders.show', $order) }}" class="btn btn-action"
                                        title="عرض التفاصيل">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-status badge-status-{{ $order->status->value === 0 ? 'preparing' : ($order->status->value === 1 ? 'completed' : ($order->status->value === 2 ? 'cancelled' : 'other')) }}">
                                        {{ __('order.' . $order->status->name) }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->delegate)
                                            {{ $order->delegate->name }}
                                    @else
                                        <span class="text-muted">لم يتم التعيين</span>
                                    @endif
                                </td>
                                <td>{{ __('order.' . $order->pay_type->name) }}</td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-4 pagination">
            @if($orders->onFirstPage())
                <span class="btn btn-secondary btn-rounded disabled">السابق</span>
            @else
                <a href="{{ $orders->previousPageUrl() }}{{ request()->getQueryString() ? '&'.http_build_query(request()->except('page')) : '' }}" class="btn btn-primary btn-rounded">السابق</a>
            @endif
            @if($orders->hasMorePages())
                <a href="{{ $orders->nextPageUrl() }}{{ request()->getQueryString() ? '&'.http_build_query(request()->except('page')) : '' }}" class="btn btn-primary btn-rounded">التالي</a>
            @else
                <span class="btn btn-secondary btn-rounded disabled">التالي</span>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush