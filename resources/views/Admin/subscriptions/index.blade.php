@extends('Admin.layout')

@section('styles')
<style>
    .subscriptions-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        text-align: center;
    }
    
    .page-title {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }
    
    .page-subtitle {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0;
    }
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-left: 4px solid #10b981;
    }
    
    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .stat-number {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-total .stat-icon { color: #3b82f6; }
    .stat-active .stat-icon { color: #10b981; }
    .stat-inactive .stat-icon { color: #ef4444; }
    .stat-courses .stat-icon { color: #f59e0b; }
    .stat-books .stat-icon { color: #8b5cf6; }
    .stat-users .stat-icon { color: #06b6d4; }
    .stat-recent .stat-icon { color: #84cc16; }
    
    /* Filters Section */
    .filters-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .filters-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .filters-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filters-title i {
        color: #38bdf8;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem;
        width: 100%;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        outline: none;
    }
    
    .form-control::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    
    .filters-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
    }
    
    .btn-clear {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-clear:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }
    
    /* Action Buttons */
    .actions-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .actions-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: #fff;
    }
    
    .bulk-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    /* Table Section */
    .table-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .table-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }
    
    .table-count {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        overflow: hidden;
        margin: 0;
    }
    
    .table thead th {
        background: rgba(255,255,255,0.05);
        color: #94a3b8;
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.05);
        transform: scale(1.01);
    }
    
    .table tbody td {
        padding: 1rem;
        color: #e2e8f0;
        border: none;
        vertical-align: middle;
    }
    
    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .user-info h6 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }
    
    .user-info small {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    /* Badges */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .badge-primary {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .badge-info {
        background: rgba(6, 182, 212, 0.2);
        color: #06b6d4;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    /* Content Info */
    .content-info h6 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }
    
    .content-info small {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
        border-radius: 6px;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: #fff;
    }
    
    .btn-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
        color: #fff;
    }
    
    .btn-warning-sm {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-warning-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }
    
    .btn-success-sm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-success-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }
    
    .btn-danger-sm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-danger-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h5 {
        color: #e2e8f0;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1rem;
    }
    
    /* Custom Pagination - Complete Override */
    .custom-pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 0.5rem !important;
        margin-top: 2rem !important;
        list-style: none !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }
    
    .custom-pagination .page-item {
        margin: 0 !important;
        padding: 0 !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    .custom-pagination .page-link {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #94a3b8 !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        min-width: 45px !important;
        text-align: center !important;
        display: block !important;
        font-size: 0.9rem !important;
        font-weight: 500 !important;
        line-height: 1 !important;
        margin: 0 !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    .custom-pagination .page-link:hover {
        background: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.2) !important;
        color: #fff !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
    }
    
    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border-color: #10b981 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
    }
    
    .custom-pagination .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
        cursor: not-allowed !important;
        opacity: 0.5 !important;
    }
    
    .custom-pagination .page-item.disabled .page-link:hover {
        transform: none !important;
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
    }
    
    .custom-pagination .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.25) !important;
        outline: none !important;
    }
    
    /* Hide default Laravel pagination */
    .pagination:not(.custom-pagination) {
        display: none !important;
    }
    
    /* Pagination container */
    .pagination-container {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin-top: 2rem !important;
    }
    
    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
        
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-container {
            flex-direction: column;
            align-items: stretch;
        }
        
        .bulk-actions {
            justify-content: center;
        }
        
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="subscriptions-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-ticket"></i>
            إدارة الاشتراكات
        </h1>
        <p class="page-subtitle">إدارة اشتراكات المستخدمين في الدورات والكتب</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <div class="stat-icon">
                <i class="fa fa-ticket"></i>
            </div>
            <div class="stat-number">{{ $statistics['total'] }}</div>
            <div class="stat-label">إجمالي الاشتراكات</div>
        </div>
        
        <div class="stat-card stat-active">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="stat-number">{{ $statistics['active'] }}</div>
            <div class="stat-label">الاشتراكات النشطة</div>
        </div>
        
        <div class="stat-card stat-inactive">
            <div class="stat-icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="stat-number">{{ $statistics['inactive'] }}</div>
            <div class="stat-label">الاشتراكات غير النشطة</div>
        </div>
        
        <div class="stat-card stat-courses">
            <div class="stat-icon">
                <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="stat-number">{{ $statistics['course_subscriptions'] }}</div>
            <div class="stat-label">اشتراكات الدورات</div>
        </div>
        
        <div class="stat-card stat-books">
            <div class="stat-icon">
                <i class="fa fa-book"></i>
            </div>
            <div class="stat-number">{{ $statistics['book_subscriptions'] }}</div>
            <div class="stat-label">اشتراكات الكتب</div>
        </div>
        
        <div class="stat-card stat-users">
            <div class="stat-icon">
                <i class="fa fa-users"></i>
            </div>
            <div class="stat-number">{{ $statistics['unique_users'] }}</div>
            <div class="stat-label">المستخدمين المشتركين</div>
        </div>
        
        <div class="stat-card stat-recent">
            <div class="stat-icon">
                <i class="fa fa-calendar-week"></i>
            </div>
            <div class="stat-number">{{ $statistics['recent_7_days'] }}</div>
            <div class="stat-label">آخر 7 أيام</div>
        </div>
        
        <div class="stat-card stat-recent">
            <div class="stat-icon">
                <i class="fa fa-calendar-month"></i>
            </div>
            <div class="stat-number">{{ $statistics['recent_30_days'] }}</div>
            <div class="stat-label">آخر 30 يوم</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="actions-section">
        <div class="actions-container">
            <a href="{{ route('admin.subscriptions.create') }}" class="btn-primary">
                <i class="fa fa-plus"></i>
                إضافة اشتراك جديد
            </a>
            
            <div class="bulk-actions">
                <button type="button" class="btn-success" onclick="bulkAction('activate')">
                    <i class="fa fa-check"></i>
                    تفعيل المحدد
                </button>
                <button type="button" class="btn-warning" onclick="bulkAction('deactivate')">
                    <i class="fa fa-ban"></i>
                    إلغاء تفعيل المحدد
                </button>
                <button type="button" class="btn-danger" onclick="bulkAction('delete')">
                    <i class="fa fa-trash"></i>
                    حذف المحدد
                </button>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fa fa-filter"></i>
                فلاتر البحث
            </h3>
        </div>
        
        <form method="GET" action="{{ route('admin.subscriptions.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">البحث</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="اسم المستخدم أو البريد الإلكتروني" 
                           value="{{ request('search') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type" class="form-control">
                        <option value="">الكل</option>
                        @foreach($filterOptions['subscription_types'] as $type)
                            <option value="{{ $type['value'] }}" {{ request('subscription_type') == $type['value'] ? 'selected' : '' }}>
                                {{ $type['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-control">
                        <option value="">الكل</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">المستخدم</label>
                    <select name="user_id" class="form-control">
                        <option value="">الكل</option>
                        @foreach($filterOptions['users'] as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الدورة</label>
                    <select name="course_id" class="form-control">
                        <option value="">الكل</option>
                        @foreach($filterOptions['courses'] as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الكتاب</label>
                    <select name="book_id" class="form-control">
                        <option value="">الكل</option>
                        @foreach($filterOptions['books'] as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">الترتيب</label>
                    <select name="sort_by" class="form-control">
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                        <option value="is_active" {{ request('sort_by') == 'is_active' ? 'selected' : '' }}>الحالة</option>
                        <option value="subscription_type" {{ request('sort_by') == 'subscription_type' ? 'selected' : '' }}>نوع الاشتراك</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الاتجاه</label>
                    <select name="sort_order" class="form-control">
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="btn-filter">
                    <i class="fa fa-search"></i>
                    بحث
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn-clear">
                    <i class="fa fa-refresh"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">قائمة الاشتراكات</h3>
            <span class="table-count">إجمالي النتائج: {{ $subscriptions->total() }}</span>
        </div>

        @if($subscriptions->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input">
                            </th>
                            <th>المستخدم</th>
                            <th>نوع الاشتراك</th>
                            <th>المحتوى</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <input type="checkbox" name="subscription_ids[]" value="{{ $subscription->id }}" class="form-check-input subscription-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $subscription->user->image ?? asset('defaults/profile.webp') }}" 
                                             alt="Avatar" class="user-avatar me-3">
                                        <div class="user-info">
                                            <h6>{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</h6>
                                            <small>{{ $subscription->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($subscription->subscription_type === 'course')
                                        <span class="badge badge-primary">
                                            <i class="fa fa-graduation-cap"></i>
                                            دورة
                                        </span>
                                    @else
                                        <span class="badge badge-info">
                                            <i class="fa fa-book"></i>
                                            كتاب
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($subscription->subscription_type === 'course' && $subscription->course)
                                        <div class="content-info">
                                            <h6>{{ $subscription->course->title }}</h6>
                                            <small>د. {{ $subscription->course->doctor->name ?? 'غير محدد' }}</small>
                                        </div>
                                    @elseif($subscription->subscription_type === 'book' && $subscription->book)
                                        <div class="content-info">
                                            <h6>{{ $subscription->book->title }}</h6>
                                            <small>{{ $subscription->book->author ?? 'غير محدد' }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">غير متوفر</span>
                                    @endif
                                </td>
                                <td>
                                    @if($subscription->is_active)
                                        <span class="badge badge-success">
                                            <i class="fa fa-check"></i>
                                            نشط
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fa fa-times"></i>
                                            غير نشط
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $subscription->created_at->format('Y-m-d') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $subscription->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.subscriptions.show', $subscription->id) }}" 
                                           class="btn-sm btn-info" title="عرض">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" 
                                           class="btn-sm btn-warning-sm" title="تعديل">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.subscriptions.toggle-status', $subscription->id) }}" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-{{ $subscription->is_active ? 'warning-sm' : 'success-sm' }}" 
                                                    title="{{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                                <i class="fa fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" 
                                              class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger-sm" title="حذف">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if($subscriptions->hasPages())
            <div class="pagination-container">
                <ul class="custom-pagination">
                    {{-- Previous Page Link --}}
                    @if ($subscriptions->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $subscriptions->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($subscriptions->getUrlRange(1, $subscriptions->lastPage()) as $page => $url)
                        @if ($page == $subscriptions->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($subscriptions->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $subscriptions->nextPageUrl() }}" rel="next">التالي</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">التالي</span>
                        </li>
                    @endif
                </ul>
            </div>
            @endif
        @else
            <div class="empty-state">
                <i class="fa fa-ticket"></i>
                <h5>لا توجد اشتراكات</h5>
                <p>لم يتم العثور على أي اشتراكات تطابق معايير البحث</p>
                <a href="{{ route('admin.subscriptions.create') }}" class="btn-primary">
                    <i class="fa fa-plus"></i>
                    إضافة اشتراك جديد
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulk-action-form" method="POST" action="{{ route('admin.subscriptions.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulk-action-type">
    <input type="hidden" name="subscription_ids" id="bulk-action-ids">
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const subscriptionCheckboxes = document.querySelectorAll('.subscription-checkbox');

    selectAllCheckbox.addEventListener('change', function() {
        subscriptionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    subscriptionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.subscription-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === subscriptionCheckboxes.length;
        });
    });
});

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.subscription-checkbox:checked');
    
    if (checkedBoxes.length === 0) {
        alert('الرجاء تحديد الاشتراكات المراد تنفيذ العملية عليها');
        return;
    }

    let confirmMessage = '';
    switch(action) {
        case 'activate':
            confirmMessage = 'هل أنت متأكد من تفعيل الاشتراكات المحددة؟';
            break;
        case 'deactivate':
            confirmMessage = 'هل أنت متأكد من إلغاء تفعيل الاشتراكات المحددة؟';
            break;
        case 'delete':
            confirmMessage = 'هل أنت متأكد من حذف الاشتراكات المحددة؟ هذا الإجراء لا يمكن التراجع عنه.';
            break;
    }

    if (confirm(confirmMessage)) {
        const subscriptionIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);
        
        document.getElementById('bulk-action-type').value = action;
        document.getElementById('bulk-action-ids').value = JSON.stringify(subscriptionIds);
        document.getElementById('bulk-action-form').submit();
    }
}
</script>
@endsection
