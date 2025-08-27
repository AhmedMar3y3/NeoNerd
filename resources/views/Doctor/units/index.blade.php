@extends('Doctor.layout')

@section('styles')
<style>
    .units-container {
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
    
    .course-info {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin: 1rem 0;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        color: #fff;
        font-weight: 500;
    }
    
    .course-info i {
        font-size: 1.2rem;
    }
    
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
        text-align: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-icon.total {
        color: #38bdf8;
    }
    
    .stat-icon.lessons {
        color: #10b981;
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
    }
    
    .filter-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .filter-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .filter-title i {
        color: #38bdf8;
    }
    
    .btn-add-unit {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .btn-add-unit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .filter-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        align-items: end;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
    }
    
    .form-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-input {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
    }
    
    .form-input::placeholder {
        color: #64748b;
    }
    
    .form-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .form-select:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
    }
    
    .form-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .filter-actions {
        display: flex;
        gap: 1rem;
        align-items: end;
    }
    
    .btn-filter {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-reset {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .btn-reset:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }
    
    .units-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .unit-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .unit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .unit-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .unit-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
        flex: 1;
    }
    
    .unit-badge {
        background: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    
    .unit-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .unit-stat {
        text-align: center;
        padding: 0.75rem;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .unit-stat-number {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .unit-stat-label {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .unit-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .btn-unit {
        padding: 0.6rem 1rem;
        border: none;
        border-radius: 6px;
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
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-unit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 2rem;
        color: #6b7280;
    }
    
    .empty-state h3 {
        color: #fff;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }
    
    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1.1rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .page-link {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
        border-color: #38bdf8;
        text-decoration: none;
    }
    
    .page-link.active {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
        border-color: #38bdf8;
    }
    
    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        margin: 5% auto;
        padding: 0;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .modal-header {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
        padding: 1.5rem 2rem;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .modal-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0;
    }
    
    .close {
        color: #fff;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
    }
    
    .close:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }
    
    .modal-body {
        padding: 2rem;
    }
    
    .modal-form-group {
        margin-bottom: 1.5rem;
    }
    
    .modal-label {
        color: #94a3b8;
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .modal-label.required::after {
        content: ' *';
        color: #ef4444;
    }
    
    .modal-input {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }
    
    .modal-input:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        background: rgba(255,255,255,0.08);
    }
    
    .modal-input::placeholder {
        color: #64748b;
    }
    
    .modal-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .modal-error {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .modal-error i {
        font-size: 0.8rem;
    }
    
    .modal-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }
    
    .modal-btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 100px;
        justify-content: center;
    }
    
    .modal-btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .modal-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .modal-btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .modal-btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    }
    
    .modal-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    @media (max-width: 768px) {
        .filter-form {
            grid-template-columns: 1fr;
        }
        
        .filter-actions {
            flex-direction: column;
        }
        
        .units-grid {
            grid-template-columns: 1fr;
        }
        
        .unit-stats {
            grid-template-columns: 1fr;
        }
        
        .unit-actions {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .modal-content {
            width: 95%;
            margin: 10% auto;
        }
        
        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 1rem;
        }
        
        .modal-footer {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="units-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">وحدات الدورة</h1>
        <p class="page-subtitle">إدارة وحدات الدورة التعليمية</p>
        <div class="course-info">
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $course->title }}</span>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_units'] }}</div>
            <div class="stat-label">إجمالي الوحدات</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon lessons">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_lessons'] }}</div>
            <div class="stat-label">إجمالي الدروس</div>
        </div>

    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <h3 class="filter-title">
                <i class="fas fa-filter"></i>
                تصفية وبحث الوحدات
            </h3>
            <button type="button" class="btn-add-unit" onclick="openCreateModal()">
                <i class="fas fa-plus"></i>
                إضافة وحدة جديدة
            </button>
        </div>
        
        <form method="GET" action="{{ route('doctor.courses.units.index', $course->id) }}" class="filter-form">
            <div class="form-group">
                <label class="form-label">البحث في العنوان</label>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-input" 
                       placeholder="ابحث في عنوان الوحدة...">
            </div>
            
            <div class="form-group">
                <label class="form-label">ترتيب حسب</label>
                <select name="sort" class="form-select">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاريخ الإنشاء</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>العنوان</option>
                    <option value="lessons_count" {{ request('sort') == 'lessons_count' ? 'selected' : '' }}>عدد الدروس</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">الاتجاه</label>
                <select name="order" class="form-select">
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                </select>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i>
                    تطبيق الفلتر
                </button>
                <a href="{{ route('doctor.courses.units.index', $course->id) }}" class="btn-reset">
                    <i class="fas fa-times"></i>
                    إعادة تعيين
                </a>
            </div>
        </form>
    </div>

    <!-- Units Grid -->
    @if($units->count() > 0)
        <div class="units-grid">
            @foreach($units as $unit)
                <div class="unit-card">
                    <div class="unit-header">
                        <h4 class="unit-title">{{ $unit->title }}</h4>
                        <span class="unit-badge">{{ $unit->lessons->count() }} درس</span>
                    </div>
                    
                                         <div class="unit-stats">
                         <div class="unit-stat">
                             <div class="unit-stat-number">{{ $unit->lessons->count() }}</div>
                             <div class="unit-stat-label">الدروس</div>
                         </div>
                     </div>
                    
                    <div class="unit-actions">
                        <a href="{{ route('doctor.courses.units.show', [$course->id, $unit->id]) }}" 
                           class="btn-unit btn-view" 
                           title="عرض الوحدة">
                            <i class="fas fa-eye"></i>
                            عرض
                        </a>
                        <button type="button" 
                                class="btn-unit btn-edit" 
                                onclick="openEditModal({{ $unit->id }}, '{{ $unit->title }}')"
                                title="تعديل الوحدة">
                            <i class="fas fa-edit"></i>
                            تعديل
                        </button>
                        <form action="{{ route('doctor.courses.units.destroy', [$course->id, $unit->id]) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذه الوحدة؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn-unit btn-delete" 
                                    title="حذف الوحدة">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($units->hasPages())
            <div class="pagination-container">
                <div class="pagination">
                    @if($units->onFirstPage())
                        <span class="page-link disabled">السابق</span>
                    @else
                        <a href="{{ $units->previousPageUrl() }}" class="page-link">السابق</a>
                    @endif
                    
                    @foreach($units->getUrlRange(1, $units->lastPage()) as $page => $url)
                        <a href="{{ $url }}" 
                           class="page-link {{ $page == $units->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    
                    @if($units->hasMorePages())
                        <a href="{{ $units->nextPageUrl() }}" class="page-link">التالي</a>
                    @else
                        <span class="page-link disabled">التالي</span>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-layer-group"></i>
            <h3>لا توجد وحدات</h3>
            <p>لم يتم إنشاء أي وحدات لهذه الدورة بعد. ابدأ بإنشاء أول وحدة لإضافة المحتوى التعليمي.</p>
        </div>
    @endif
</div>

<!-- Create Unit Modal -->
<div id="createUnitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-plus-circle"></i>
                إضافة وحدة جديدة
            </h3>
            <span class="close" onclick="closeCreateModal()">&times;</span>
        </div>
        <form id="createUnitForm" action="{{ route('doctor.courses.units.store', $course->id) }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="modal-form-group">
                    <label for="create_title" class="modal-label required">عنوان الوحدة</label>
                    <input type="text" 
                           id="create_title" 
                           name="title" 
                           class="modal-input" 
                           placeholder="أدخل عنوان الوحدة..."
                           maxlength="255"
                           required>
                    <div id="create_title_error" class="modal-error" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeCreateModal()">
                    <i class="fas fa-times"></i>
                    إلغاء
                </button>
                <button type="submit" class="modal-btn modal-btn-primary" id="createSubmitBtn">
                    <i class="fas fa-save"></i>
                    حفظ الوحدة
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Unit Modal -->
<div id="editUnitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-edit"></i>
                تعديل الوحدة
            </h3>
            <span class="close" onclick="closeEditModal()">&times;</span>
        </div>
        <form id="editUnitForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-form-group">
                    <label for="edit_title" class="modal-label required">عنوان الوحدة</label>
                    <input type="text" 
                           id="edit_title" 
                           name="title" 
                           class="modal-input" 
                           placeholder="أدخل عنوان الوحدة..."
                           maxlength="255"
                           required>
                    <div id="edit_title_error" class="modal-error" style="display: none;">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-secondary" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                    إلغاء
                </button>
                <button type="submit" class="modal-btn modal-btn-primary" id="editSubmitBtn">
                    <i class="fas fa-save"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functions
function openCreateModal() {
    document.getElementById('createUnitModal').style.display = 'block';
    document.getElementById('create_title').focus();
    resetCreateForm();
}

function closeCreateModal() {
    document.getElementById('createUnitModal').style.display = 'none';
    resetCreateForm();
}

function openEditModal(unitId, unitTitle) {
    document.getElementById('editUnitModal').style.display = 'block';
    document.getElementById('edit_title').value = unitTitle;
    document.getElementById('editUnitForm').action = `{{ route('doctor.courses.units.update', [$course->id, ':unitId']) }}`.replace(':unitId', unitId);
    document.getElementById('edit_title').focus();
    resetEditForm();
}

function closeEditModal() {
    document.getElementById('editUnitModal').style.display = 'none';
    resetEditForm();
}

function resetCreateForm() {
    document.getElementById('create_title').value = '';
    document.getElementById('create_title').classList.remove('error');
    document.getElementById('create_title_error').style.display = 'none';
    document.getElementById('createSubmitBtn').disabled = false;
    document.getElementById('createSubmitBtn').innerHTML = '<i class="fas fa-save"></i> حفظ الوحدة';
}

function resetEditForm() {
    document.getElementById('edit_title').classList.remove('error');
    document.getElementById('edit_title_error').style.display = 'none';
    document.getElementById('editSubmitBtn').disabled = false;
    document.getElementById('editSubmitBtn').innerHTML = '<i class="fas fa-save"></i> حفظ التغييرات';
}

// Close modals when clicking outside
window.onclick = function(event) {
    const createModal = document.getElementById('createUnitModal');
    const editModal = document.getElementById('editUnitModal');
    
    if (event.target === createModal) {
        closeCreateModal();
    }
    if (event.target === editModal) {
        closeEditModal();
    }
}

// Form submissions
document.getElementById('createUnitForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const title = document.getElementById('create_title').value.trim();
    const submitBtn = document.getElementById('createSubmitBtn');
    
    // Reset errors
    document.getElementById('create_title').classList.remove('error');
    document.getElementById('create_title_error').style.display = 'none';
    
    // Validate
    if (!title) {
        showCreateError('create_title', 'عنوان الوحدة مطلوب');
        return;
    }
    
    if (title.length < 3) {
        showCreateError('create_title', 'عنوان الوحدة يجب أن يكون 3 أحرف على الأقل');
        return;
    }
    
    // Submit
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
    
    this.submit();
});

document.getElementById('editUnitForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const title = document.getElementById('edit_title').value.trim();
    const submitBtn = document.getElementById('editSubmitBtn');
    
    // Reset errors
    document.getElementById('edit_title').classList.remove('error');
    document.getElementById('edit_title_error').style.display = 'none';
    
    // Validate
    if (!title) {
        showEditError('edit_title', 'عنوان الوحدة مطلوب');
        return;
    }
    
    if (title.length < 3) {
        showEditError('edit_title', 'عنوان الوحدة يجب أن يكون 3 أحرف على الأقل');
        return;
    }
    
    // Submit
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
    
    this.submit();
});

function showCreateError(fieldId, message) {
    document.getElementById(fieldId).classList.add('error');
    const errorDiv = document.getElementById(fieldId + '_error');
    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';
}

function showEditError(fieldId, message) {
    document.getElementById(fieldId).classList.add('error');
    const errorDiv = document.getElementById(fieldId + '_error');
    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';
}

// Character count for inputs
document.getElementById('create_title').addEventListener('input', function() {
    const length = this.value.length;
    if (length >= 240) {
        this.style.borderColor = '#ef4444';
    } else if (length >= 200) {
        this.style.borderColor = '#f59e0b';
    } else {
        this.style.borderColor = 'rgba(255,255,255,0.1)';
    }
});

document.getElementById('edit_title').addEventListener('input', function() {
    const length = this.value.length;
    if (length >= 240) {
        this.style.borderColor = '#ef4444';
    } else if (length >= 200) {
        this.style.borderColor = '#f59e0b';
    } else {
        this.style.borderColor = 'rgba(255,255,255,0.1)';
    }
});
</script>
@endsection
