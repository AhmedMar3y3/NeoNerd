@extends('Admin.layout')

@section('styles')
<style>
    .doctors-container {
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
    .stat-partners .stat-icon { color: #f59e0b; }
    .stat-complete .stat-icon { color: #8b5cf6; }
    .stat-incomplete .stat-icon { color: #6b7280; }
    
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
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
    }
    
    /* Table Styles */
    .table-container {
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
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .table-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    .table th {
        background: rgba(255,255,255,0.05);
        color: #94a3b8;
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-size: 0.9rem;
    }
    
    .table td {
        color: #fff;
        padding: 1rem;
        border: none;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.02);
    }
    
    /* Doctor Info */
    .doctor-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .doctor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 1.2rem;
    }
    
    .doctor-details h6 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }
    
    .doctor-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.85rem;
    }
    
    /* Status Badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        min-width: 80px;
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
    
    .partner-badge {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 35px;
        height: 35px;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
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
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #6b7280;
    }
    
    .empty-state h4 {
        color: #fff;
        margin-bottom: 0.5rem;
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
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .table-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .doctor-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('main')
<div class="doctors-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إدارة الأطباء</h1>
        <p class="page-subtitle">إدارة حسابات الأطباء والتحكم في صلاحياتهم</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <i class="fas fa-user-md stat-icon"></i>
            <div class="stat-number">{{ $statistics['total'] }}</div>
            <div class="stat-label">إجمالي الأطباء</div>
        </div>
        <div class="stat-card stat-active">
            <i class="fas fa-check-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['active'] }}</div>
            <div class="stat-label">الأطباء النشطين</div>
        </div>
        <div class="stat-card stat-inactive">
            <i class="fas fa-times-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['inactive'] }}</div>
            <div class="stat-label">الأطباء غير النشطين</div>
        </div>
        <div class="stat-card stat-partners">
            <i class="fas fa-handshake stat-icon"></i>
            <div class="stat-number">{{ $statistics['partners'] }}</div>
            <div class="stat-label">الأطباء الشركاء</div>
        </div>
        <div class="stat-card stat-complete">
            <i class="fas fa-user-check stat-icon"></i>
            <div class="stat-number">{{ $statistics['complete_profiles'] }}</div>
            <div class="stat-label">الملفات المكتملة</div>
        </div>
        <div class="stat-card stat-incomplete">
            <i class="fas fa-user-clock stat-icon"></i>
            <div class="stat-number">{{ $statistics['incomplete_profiles'] }}</div>
            <div class="stat-label">الملفات غير المكتملة</div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                فلاتر البحث
            </h3>
        </div>
        
        <form method="GET" action="{{ route('admin.doctors.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">البحث</label>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="البحث بالاسم، البريد الإلكتروني، الهاتف، التخصص...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">الحالة</label>
                    <select class="form-control" name="status">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">حالة الشريك</label>
                    <select class="form-control" name="partner_status">
                        <option value="">جميع الأطباء</option>
                        <option value="partner" {{ request('partner_status') === 'partner' ? 'selected' : '' }}>شركاء</option>
                        <option value="not_partner" {{ request('partner_status') === 'not_partner' ? 'selected' : '' }}>غير شركاء</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الجامعة</label>
                    <select class="form-control" name="university_id">
                        <option value="">جميع الجامعات</option>
                        @foreach($filterOptions['universities'] as $university)
                            <option value="{{ $university->id }}" {{ request('university_id') == $university->id ? 'selected' : '' }}>
                                {{ $university->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">اكتمال الملف</label>
                    <select class="form-control" name="profile_completion">
                        <option value="">جميع الملفات</option>
                        <option value="complete" {{ request('profile_completion') === 'complete' ? 'selected' : '' }}>مكتمل</option>
                        <option value="incomplete" {{ request('profile_completion') === 'incomplete' ? 'selected' : '' }}>غير مكتمل</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">من تاريخ</label>
                    <input type="date" 
                           class="form-control" 
                           name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">إلى تاريخ</label>
                    <input type="date" 
                           class="form-control" 
                           name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label">ترتيب حسب</label>
                    <select class="form-control" name="sort_by">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                        <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="email" {{ request('sort_by') === 'email' ? 'selected' : '' }}>البريد الإلكتروني</option>
                        <option value="is_active" {{ request('sort_by') === 'is_active' ? 'selected' : '' }}>الحالة</option>
                        <option value="is_partner" {{ request('sort_by') === 'is_partner' ? 'selected' : '' }}>حالة الشريك</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">ترتيب</label>
                    <select class="form-control" name="sort_order">
                        <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>تنازلي</option>
                        <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>تصاعدي</option>
                    </select>
                </div>
            </div>
            
            <div class="filters-actions">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search me-2"></i>
                    تطبيق الفلاتر
                </button>
                <a href="{{ route('admin.doctors.index') }}" class="btn-clear">
                    <i class="fas fa-times me-2"></i>
                    مسح الفلاتر
                </a>
            </div>
        </form>
    </div>

    <!-- Doctors Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">قائمة الأطباء</h3>
            <a href="{{ route('admin.doctors.create') }}" class="btn-add">
                <i class="fas fa-plus"></i>
                إضافة طبيب جديد
            </a>
        </div>

        @if($doctors->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الطبيب</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>الكلية</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                            <tr>
                                <td>
                                    <div class="doctor-info">
                                        <div class="doctor-avatar">
                                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                        </div>
                                        <div class="doctor-details">
                                            <h6>{{ $doctor->name }}</h6>
                                            <p>
                                                @if($doctor->is_partner)
                                                    <span class="partner-badge">شريك</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->phone ?? 'غير محدد' }}</td>
                                <td>{{ $doctor->university->name ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="status-badge {{ $doctor->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $doctor->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.doctors.show', $doctor->id) }}" 
                                           class="btn-action btn-view" 
                                           title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.doctors.edit', $doctor->id) }}" 
                                           class="btn-action btn-edit" 
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.doctors.toggle-status', $doctor->id) }}" 
                                              method="POST" 
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn-action btn-toggle" 
                                                    title="{{ $doctor->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                                <i class="fas {{ $doctor->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-action btn-delete" 
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
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
            @if($doctors->hasPages())
            <div class="pagination-container">
                <ul class="custom-pagination">
                    {{-- Previous Page Link --}}
                    @if ($doctors->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $doctors->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($doctors->getUrlRange(1, $doctors->lastPage()) as $page => $url)
                        @if ($page == $doctors->currentPage())
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
                    @if ($doctors->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $doctors->nextPageUrl() }}" rel="next">التالي</a>
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
                <i class="fas fa-user-md"></i>
                <h4>لا توجد أطباء</h4>
                <p>لم يتم العثور على أطباء مطابقين للفلاتر المحددة</p>
                <a href="{{ route('admin.doctors.create') }}" class="btn-add">
                    <i class="fas fa-plus me-2"></i>
                    إضافة أول طبيب
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
