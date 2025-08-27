@extends('Doctor.layout')

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
    .stat-free .stat-icon { color: #8b5cf6; }
    .stat-paid .stat-icon { color: #f59e0b; }
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
    
    /* Courses Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .course-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .course-image {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .course-image .placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .course-badges {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }
    
    .course-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-free {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-paid {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .badge-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .course-content {
        padding: 1.5rem;
    }
    
    .course-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .course-subject {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .course-description {
        color: #94a3b8;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .course-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .course-stat {
        text-align: center;
    }
    
    .course-stat-number {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .course-stat-label {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .course-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .rating-stars {
        color: #f59e0b;
        font-size: 0.9rem;
    }
    
    .rating-text {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .course-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        flex: 1;
        justify-content: center;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: #fff;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Add Course Button */
    .add-course-section {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .btn-add-course {
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
    
    .btn-add-course:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        color: #6b7280;
    }
    
    .empty-state h3 {
        color: #fff;
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }
    
    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1rem;
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
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filters-grid {
            grid-template-columns: 1fr;
        }
        
        .courses-grid {
            grid-template-columns: 1fr;
        }
        
        .course-actions {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('main')
<div class="courses-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إدارة الدورات</h1>
        <p class="page-subtitle">إنشاء وإدارة دوراتك التعليمية</p>
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
            <i class="fas fa-dollar-sign stat-icon"></i>
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

    <!-- Add Course Button -->
    <div class="add-course-section">
        <a href="{{ route('doctor.courses.create') }}" class="btn-add-course">
            <i class="fas fa-plus"></i>
            إنشاء دورة جديدة
        </a>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i>
                فلاتر البحث
            </h3>
        </div>
        
        <form method="GET" action="{{ route('doctor.courses.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">البحث</label>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="البحث في عنوان أو وصف الدورة...">
                </div>
                
                <div class="form-group">
                    <label class="form-label">الحالة</label>
                    <select class="form-select" name="status">
                        <option value="">جميع الحالات</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">نوع السعر</label>
                    <select class="form-select" name="price_type">
                        <option value="">جميع الدورات</option>
                        <option value="free" {{ request('price_type') === 'free' ? 'selected' : '' }}>مجاني</option>
                        <option value="paid" {{ request('price_type') === 'paid' ? 'selected' : '' }}>مدفوع</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">المادة الدراسية</label>
                    <select class="form-select" name="subject_id">
                        <option value="">جميع المواد</option>
                        @foreach($filterOptions['subjects'] as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">التقييم</label>
                    <select class="form-select" name="rating">
                        <option value="">جميع التقييمات</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 نجوم وأكثر</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 نجوم وأكثر</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 نجوم وأكثر</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 نجمة وأكثر</option>
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
                    <select class="form-select" name="sort_by">
                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>العنوان</option>
                        <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>التقييم</option>
                        <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>السعر</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">ترتيب</label>
                    <select class="form-select" name="sort_order">
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
                <a href="{{ route('doctor.courses.index') }}" class="btn-clear">
                    <i class="fas fa-times me-2"></i>
                    مسح الفلاتر
                </a>
            </div>
        </form>
    </div>

    <!-- Courses Grid -->
    @if($courses->count() > 0)
        <div class="courses-grid">
            @foreach($courses as $course)
                <div class="course-card">
                    <div class="course-image">
                        @if($course->image)
                            <img src="{{ asset($course->image) }}" alt="{{ $course->title }}">
                        @else
                            <div class="placeholder">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        @endif
                        
                        <div class="course-badges">
                            @if($course->is_free)
                                <span class="course-badge badge-free">مجاني</span>
                            @else
                                <span class="course-badge badge-paid">{{ $course->price }} ج.م</span>
                            @endif
                            
                            @if(!$course->is_active)
                                <span class="course-badge badge-inactive">غير نشط</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="course-content">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-subject">{{ $course->subject->display_name }}</p>
                        
                        @if($course->description)
                            <p class="course-description">{{ $course->description }}</p>
                        @endif
                        
                        <div class="course-rating">
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $course->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                            <span class="rating-text">{{ number_format($course->rating, 1) }} ({{ $course->ratings_count }} تقييم)</span>
                        </div>
                        
                        <div class="course-stats">
                            <div class="course-stat">
                                <div class="course-stat-number">{{ $course->units->count() }}</div>
                                <div class="course-stat-label">وحدة</div>
                            </div>
                            <div class="course-stat">
                                <div class="course-stat-number">{{ $course->lessons->count() }}</div>
                                <div class="course-stat-label">درس</div>
                            </div>
                            <div class="course-stat">
                                <div class="course-stat-number">{{ $course->created_at->format('M Y') }}</div>
                                <div class="course-stat-label">تاريخ الإنشاء</div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <a href="{{ route('doctor.courses.show', $course->id) }}" 
                               class="btn btn-view" 
                               title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                                عرض
                            </a>
                            <a href="{{ route('doctor.courses.edit', $course->id) }}" 
                               class="btn btn-edit" 
                               title="تعديل">
                                <i class="fas fa-edit"></i>
                                تعديل
                            </a>
                            <form action="{{ route('doctor.courses.toggle-status', $course->id) }}" 
                                  method="POST" 
                                  style="display: inline;">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-toggle" 
                                        title="{{ $course->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                    <i class="fas {{ $course->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    {{ $course->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                                </button>
                            </form>
                            <form action="{{ route('doctor.courses.destroy', $course->id) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-delete" 
                                        title="حذف">
                                    <i class="fas fa-trash"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
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
            <h3>لا توجد دورات</h3>
            <p>لم يتم العثور على دورات مطابقة للفلاتر المحددة</p>
            <a href="{{ route('doctor.courses.create') }}" class="btn-add-course">
                <i class="fas fa-plus me-2"></i>
                إنشاء أول دورة
            </a>
        </div>
    @endif
</div>
@endsection
