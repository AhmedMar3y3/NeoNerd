@extends('Assistant.layout')

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
    
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem;
        width: 100%;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
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
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
    }
    
    /* Actions Section */
    .actions-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .add-subscription-section {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .btn-add-subscription {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .btn-add-subscription:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .bulk-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .bulk-select-all {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .form-check-input {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 4px;
    }
    
    .form-check-input:checked {
        background: #38bdf8;
        border-color: #38bdf8;
    }
    
    .btn-bulk-action {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.85rem;
    }
    
    .btn-bulk-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
    
    .btn-bulk-action.danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .btn-bulk-action.danger:hover {
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    /* Table Styles */
    .table-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden;
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
        color: #e2e8f0;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th {
        background: rgba(255,255,255,0.05);
        color: #f8fafc;
        font-weight: 600;
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        text-align: right;
        font-size: 0.9rem;
    }
    
    .table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.02);
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .user-info h6 {
        color: #f8fafc;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
    }
    
    .user-info small {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .subscription-type {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .type-course {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .content-info h6 {
        color: #f8fafc;
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .content-info small {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-active {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .status-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: #fff;
    }
    
    .btn-warning-sm {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-success-sm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-danger-sm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .custom-pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .page-link {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 45px;
        text-align: center;
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .page-link:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: #10b981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.05);
        color: #64748b;
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
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
<div class="subscriptions-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-ticket"></i>
            إدارة الاشتراكات
        </h1>
        <p class="page-subtitle">إدارة اشتراكات المستخدمين في دورات الدكتور</p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                تصفية الاشتراكات
            </h3>
        </div>
        
        <form method="GET" action="{{ route('assistant.subscriptions.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">البحث</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="البحث في اسم المستخدم أو البريد الإلكتروني"
                           value="{{ request('search') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">نوع الاشتراك</label>
                    <select name="subscription_type" class="form-select">
                        <option value="">جميع الأنواع</option>
                        @foreach($filterOptions['subscription_types'] as $type)
                            <option value="{{ $type['value'] }}" {{ request('subscription_type') == $type['value'] ? 'selected' : '' }}>
                                {{ $type['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">المستخدم</label>
                    <select name="user_id" class="form-select">
                        <option value="">جميع المستخدمين</option>
                        @foreach($filterOptions['users'] as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الدورة</label>
                    <select name="course_id" class="form-select">
                        <option value="">جميع الدورات</option>
                        @foreach($filterOptions['courses'] as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
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
                    <label class="form-label">الاشتراكات الحديثة</label>
                    <select name="recent" class="form-select">
                        <option value="">جميع الاشتراكات</option>
                        <option value="7" {{ request('recent') == '7' ? 'selected' : '' }}>آخر 7 أيام</option>
                        <option value="30" {{ request('recent') == '30' ? 'selected' : '' }}>آخر 30 يوم</option>
                        <option value="90" {{ request('recent') == '90' ? 'selected' : '' }}>آخر 90 يوم</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i>
                    تطبيق الفلتر
                </button>
                <a href="{{ route('assistant.subscriptions.index') }}" class="btn-clear">
                    <i class="fas fa-times"></i>
                    مسح الفلتر
                </a>
            </div>
        </form>
    </div>

    <!-- Actions Section -->
    <div class="actions-container">
        <div class="add-subscription-section">
            <a href="{{ route('assistant.subscriptions.create') }}" class="btn-add-subscription">
                <i class="fas fa-plus"></i>
                إضافة اشتراك جديد
            </a>
        </div>
        
        <div class="bulk-actions">
            <div style="display: flex; gap: 1rem; align-items: center;">
                <div class="bulk-select-all">
                    <input type="checkbox" id="select-all-header" class="form-check-input">
                    <label for="select-all-header">تحديد الكل</label>
                </div>
                
                <select id="bulk-action-select" class="form-select" style="width: auto; min-width: 150px;">
                    <option value="">اختر الإجراء</option>
                    <option value="activate">تفعيل</option>
                    <option value="deactivate">إلغاء التفعيل</option>
                    <option value="delete">حذف</option>
                </select>
                
                <button type="button" id="bulk-action-submit" class="btn-bulk-action">
                    تطبيق
                </button>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all-table" class="form-check-input">
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
                                <span class="subscription-type type-course">
                                    <i class="fas fa-graduation-cap"></i>
                                    دورة
                                </span>
                            </td>
                            <td>
                                <div class="content-info">
                                    <h6>{{ $subscription->course->title }}</h6>
                                    <small>{{ $subscription->course->subject->name }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $subscription->is_active ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-{{ $subscription->is_active ? 'check' : 'times' }}"></i>
                                    {{ $subscription->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>
                                {{ $subscription->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('assistant.subscriptions.show', $subscription->id) }}" 
                                       class="btn-sm btn-info" title="عرض">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('assistant.subscriptions.edit', $subscription->id) }}" 
                                       class="btn-sm btn-warning-sm" title="تعديل">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('assistant.subscriptions.toggle-status', $subscription->id) }}" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-{{ $subscription->is_active ? 'warning-sm' : 'success-sm' }}" 
                                                title="{{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                            <i class="fa fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('assistant.subscriptions.destroy', $subscription->id) }}" 
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
    </div>
    
    <!-- Bulk Action Form -->
    <form id="bulk-action-form" method="POST" action="{{ route('assistant.subscriptions.bulk-action') }}" style="display: none;">
    </form>

    <!-- Pagination -->
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all functionality
    const selectAllHeaderCheckbox = document.getElementById('select-all-header');
    const selectAllTableCheckbox = document.getElementById('select-all-table');
    const subscriptionCheckboxes = document.querySelectorAll('.subscription-checkbox');
    
    // Function to update select all checkboxes
    function updateSelectAllCheckboxes() {
        const allChecked = Array.from(subscriptionCheckboxes).every(cb => cb.checked);
        const anyChecked = Array.from(subscriptionCheckboxes).some(cb => cb.checked);
        
        selectAllHeaderCheckbox.checked = allChecked;
        selectAllHeaderCheckbox.indeterminate = anyChecked && !allChecked;
        
        selectAllTableCheckbox.checked = allChecked;
        selectAllTableCheckbox.indeterminate = anyChecked && !allChecked;
    }
    
    // Header select all checkbox
    selectAllHeaderCheckbox.addEventListener('change', function() {
        subscriptionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectAllCheckboxes();
    });
    
    // Table select all checkbox
    selectAllTableCheckbox.addEventListener('change', function() {
        subscriptionCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectAllCheckboxes();
    });
    
    // Individual subscription checkboxes
    subscriptionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckboxes();
        });
    });
    
    // Bulk action form submission
    const bulkActionSubmit = document.getElementById('bulk-action-submit');
    const bulkActionSelect = document.getElementById('bulk-action-select');
    const bulkActionForm = document.getElementById('bulk-action-form');
    
    bulkActionSubmit.addEventListener('click', function() {
        const selectedCheckboxes = document.querySelectorAll('.subscription-checkbox:checked');
        const actionValue = bulkActionSelect.value;
        
        console.log('Selected checkboxes:', selectedCheckboxes.length);
        console.log('Action value:', actionValue);
        
        if (selectedCheckboxes.length === 0) {
            alert('يرجى تحديد اشتراك واحد على الأقل');
            return;
        }
        
        if (!actionValue) {
            alert('يرجى اختيار الإجراء المطلوب');
            return;
        }
        
        if (confirm('هل أنت متأكد من تنفيذ هذا الإجراء؟')) {
            const subscriptionIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
            
            // Create a proper form with array inputs
            const form = document.getElementById('bulk-action-form');
            form.innerHTML = ''; // Clear existing inputs
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfInput);
            
            // Add action
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = actionValue;
            form.appendChild(actionInput);
            
            // Add subscription IDs as array
            subscriptionIds.forEach(id => {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'subscription_ids[]';
                idInput.value = id;
                form.appendChild(idInput);
            });
            
            console.log('Form data:', {
                action: actionValue,
                subscription_ids: subscriptionIds
            });
            
            form.submit();
        }
    });
});
</script>
@endsection
