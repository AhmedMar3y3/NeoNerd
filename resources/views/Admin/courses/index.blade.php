@extends('Admin.layout')

@section('styles')
<style>
    .courses-container {
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
    .stat-free .stat-icon { color: #f59e0b; }
    .stat-paid .stat-icon { color: #8b5cf6; }
    .stat-units .stat-icon { color: #06b6d4; }
    .stat-lessons .stat-icon { color: #84cc16; }
    
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
    
    /* Course Info */
    .course-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .course-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    .course-details h6 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }
    
    .course-details p {
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
    
    .price-badge {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    .free-badge {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    /* Rating Stars */
    .rating-stars {
        color: #fbbf24;
        font-size: 0.9rem;
    }
    
    .rating-text {
        color: #94a3b8;
        font-size: 0.8rem;
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
        
        .course-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('main')
<div class="courses-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إدارة الدورات</h1>
        <p class="page-subtitle">عرض وإدارة الدورات التعليمية</p>
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
            <i class="fas fa-graduation-cap stat-icon"></i>
            <div class="stat-number">{{ $statistics['total'] }}</div>
            <div class="stat-label">إجمالي الدورات</div>
        </div>
        <div class="stat-card stat-active">
            <i class="fas fa-check-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['active'] }}</div>
            <div class="stat-label">الدورات النشطة</div>
        </div>
        <div class="stat-card stat-inactive">
            <i class="fas fa-times-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['inactive'] }}</div>
            <div class="stat-label">الدورات غير النشطة</div>
        </div>
        <div class="stat-card stat-free">
            <i class="fas fa-gift stat-icon"></i>
            <div class="stat-number">{{ $statistics['free'] }}</div>
            <div class="stat-label">الدورات المجانية</div>
        </div>
        <div class="stat-card stat-paid">
            <i class="fas fa-credit-card stat-icon"></i>
            <div class="stat-number">{{ $statistics['paid'] }}</div>
            <div class="stat-label">الدورات المدفوعة</div>
        </div>
        <div class="stat-card stat-units">
            <i class="fas fa-layer-group stat-icon"></i>
            <div class="stat-number">{{ $statistics['total_units'] }}</div>
            <div class="stat-label">إجمالي الوحدات</div>
        </div>
        <div class="stat-card stat-lessons">
            <i class="fas fa-play-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['total_lessons'] }}</div>
            <div class="stat-label">إجمالي الدروس</div>
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
        
        <form method="GET" action="{{ route('admin.courses.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">البحث</label>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="البحث في عنوان الدورة أو الوصف...">
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
                    <label class="form-label">نوع السعر</label>
                    <select class="form-control" name="price_type">
                        <option value="">جميع الدورات</option>
                        <option value="free" {{ request('price_type') === 'free' ? 'selected' : '' }}>مجاني</option>
                        <option value="paid" {{ request('price_type') === 'paid' ? 'selected' : '' }}>مدفوع</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">الطبيب</label>
                    <select class="form-control" name="doctor_id">
                        <option value="">جميع الأطباء</option>
                        @foreach($filterOptions['doctors'] as $doctor)
                            <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">المادة</label>
                    <select class="form-control" name="subject_id">
                        <option value="">جميع المواد</option>
                        @foreach($filterOptions['subjects'] as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">التقييم الأدنى</label>
                    <select class="form-control" name="rating">
                        <option value="">جميع التقييمات</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة فأكثر</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم فأكثر</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم فأكثر</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم فأكثر</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 نجوم</option>
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
                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>العنوان</option>
                        <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>التقييم</option>
                        <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>السعر</option>
                        <option value="is_active" {{ request('sort_by') === 'is_active' ? 'selected' : '' }}>الحالة</option>
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
                <a href="{{ route('admin.courses.index') }}" class="btn-clear">
                    <i class="fas fa-times me-2"></i>
                    مسح الفلاتر
                </a>
            </div>
        </form>
    </div>

    <!-- Courses Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">قائمة الدورات</h3>
        </div>

        @if($courses->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>الدورة</th>
                            <th>الطبيب</th>
                            <th>المادة</th>
                            <th>السعر</th>
                            <th>التقييم</th>
                            <th>الدروس</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <div class="course-info">
                                        <div class="course-image">
                                            @if($course->image)
                                                <img src="{{ $course->image }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                                            @else
                                                {{ strtoupper(substr($course->title, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div class="course-details">
                                            <h6>{{ $course->title }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $course->doctor->name ?? 'غير محدد' }}</td>
                                <td>{{ $course->subject->name ?? 'غير محدد' }}</td>
                                <td>
                                    @if($course->is_free)
                                        <span class="free-badge">مجاني</span>
                                    @else
                                        <span class="price-badge">{{ $course->price }} جنيه</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $course->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="rating-text">({{ $course->ratings_count }})</span>
                                </td>
                                <td>{{ $course->lessons_count ?? 0 }}</td>
                                <td>
                                    <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $course->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.courses.show', $course->id) }}" 
                                           class="btn-action btn-view" 
                                           title="عرض التفاصيل">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.courses.toggle-status', $course->id) }}" 
                                              method="POST" 
                                              style="display: inline;">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn-action btn-toggle" 
                                                    title="{{ $course->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                                <i class="fas {{ $course->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.courses.destroy', $course->id) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
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
            @if($courses->hasPages())
            <div class="pagination-container">
                <ul class="custom-pagination">
                    {{-- Previous Page Link --}}
                    @if ($courses->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">السابق</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $courses->previousPageUrl() }}" rel="prev">السابق</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                        @if ($page == $courses->currentPage())
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
                    @if ($courses->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $courses->nextPageUrl() }}" rel="next">التالي</a>
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
                <i class="fas fa-graduation-cap"></i>
                <h4>لا توجد دورات</h4>
                <p>لم يتم العثور على دورات مطابقة للفلاتر المحددة</p>
            </div>
        @endif
    </div>
</div>
@endsection
