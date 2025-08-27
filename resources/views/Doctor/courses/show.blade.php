@extends('Doctor.layout')

@section('styles')
<style>
    .course-show-container {
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
    
    .course-details-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .course-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .course-image {
        width: 200px;
        height: 150px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
    }
    
    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .course-info {
        flex: 1;
    }
    
    .course-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .course-subject {
        color: #94a3b8;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }
    
    .course-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .course-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
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
    
    .course-rating {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .rating-stars {
        color: #f59e0b;
        font-size: 1rem;
    }
    
    .rating-text {
        color: #94a3b8;
        font-size: 0.95rem;
    }
    
    .course-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.1);
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
    
    .course-description {
        color: #94a3b8;
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .course-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn {
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
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    
    
    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .units-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .section-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: #38bdf8;
    }
    
    
    
    .units-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .unit-card {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .unit-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .unit-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .unit-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }
    
    .unit-lessons-count {
        background: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .unit-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
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
    
    .btn-delete-unit {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-unit:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    .empty-units {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    
    .empty-units i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #6b7280;
    }
    
    .empty-units h3 {
        color: #fff;
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }
    
    .empty-units p {
        margin-bottom: 2rem;
        font-size: 1rem;
    }
    
    @media (max-width: 768px) {
        .course-header {
            flex-direction: column;
            text-align: center;
        }
        
        .course-image {
            width: 150px;
            height: 120px;
        }
        
        .course-title {
            font-size: 1.5rem;
        }
        
        .course-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .units-grid {
            grid-template-columns: 1fr;
        }
        
        .section-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
                 .page-title {
             font-size: 2rem;
         }
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
<div class="course-show-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تفاصيل الدورة</h1>
        <p class="page-subtitle">عرض معلومات الدورة والوحدات</p>
    </div>

    <!-- Course Details Card -->
    <div class="course-details-card">
        <div class="course-header">
            <div class="course-image">
                @if($course->image)
                    <img src="{{ asset($course->image) }}" alt="{{ $course->title }}">
                @else
                    <i class="fas fa-graduation-cap"></i>
                @endif
            </div>
            
            <div class="course-info">
                <h2 class="course-title">{{ $course->title }}</h2>
                                        <p class="course-subject">{{ $course->subject->display_name }}</p>
                
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
                
                <div class="course-rating">
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $course->rating ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <span class="rating-text">{{ number_format($course->rating, 1) }} ({{ $course->ratings_count }} تقييم)</span>
                </div>
            </div>
        </div>
        
        <!-- Course Statistics -->
        <div class="course-stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $course->units->count() }}</div>
                <div class="stat-label">الوحدات</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $course->lessons->count() }}</div>
                <div class="stat-label">الدروس</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $course->subscriptions()->count() }}</div>
                <div class="stat-label">المشتركين</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $course->created_at->format('M Y') }}</div>
                <div class="stat-label">تاريخ الإنشاء</div>
            </div>
        </div>
        
        @if($course->description)
            <div class="course-description">
                <h4 style="color: #fff; margin-bottom: 1rem;">وصف الدورة:</h4>
                {{ $course->description }}
            </div>
        @endif
        
                 <div class="course-actions">
             <a href="{{ route('doctor.courses.edit', $course->id) }}" class="btn btn-edit">
                 <i class="fas fa-edit"></i>
                 تعديل الدورة
             </a>
             <a href="{{ route('doctor.courses.index') }}" class="btn btn-back">
                 <i class="fas fa-arrow-right"></i>
                 العودة للدورات
             </a>
         </div>
    </div>

    <!-- Units Section -->
    <div class="units-section">
                 <div class="section-header">
             <h3 class="section-title">
                 <i class="fas fa-layer-group"></i>
                 وحدات الدورة
             </h3>
             <button type="button" 
                     class="btn-add-unit" 
                     onclick="openCreateModal()">
                 <i class="fas fa-plus"></i>
                 إضافة وحدة جديدة
             </button>
         </div>
        
        @if($course->units->count() > 0)
            <div class="units-grid">
                @foreach($course->units as $unit)
                    <div class="unit-card">
                        <div class="unit-header">
                            <h4 class="unit-title">{{ $unit->title }}</h4>
                            <span class="unit-lessons-count">{{ $unit->lessons->count() }} درس</span>
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
                                        class="btn-unit btn-delete-unit" 
                                        title="حذف الوحدة">
                                    <i class="fas fa-trash"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-units">
                <i class="fas fa-layer-group"></i>
                <h3>لا توجد وحدات</h3>
                <p>لم يتم إنشاء أي وحدات لهذه الدورة بعد</p>
            </div>
        @endif
    </div>
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
