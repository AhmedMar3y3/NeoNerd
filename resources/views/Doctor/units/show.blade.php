@extends('Doctor.layout')

@section('styles')
<style>
    .unit-show-container {
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
    
    .breadcrumb-info {
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
    
    .breadcrumb-info i {
        font-size: 1.2rem;
    }
    
    .unit-details-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .unit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .unit-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .unit-badges {
        display: flex;
        gap: 0.75rem;
    }
    
    .unit-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .badge-lessons {
        background: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    
    
    
    .unit-stats-grid {
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
    
    .unit-actions {
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
    
    .lessons-section {
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
    
    
    
    .lessons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
    }
    
    .lesson-card {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .lesson-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        border-color: rgba(56, 189, 248, 0.3);
    }
    
    .lesson-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .lesson-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
        flex: 1;
    }
    
    .lesson-badges {
        display: flex;
        gap: 0.5rem;
    }
    
    .lesson-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
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
    
    
    
    .lesson-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .lesson-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .lesson-detail i {
        color: #38bdf8;
        font-size: 0.8rem;
    }
    
    .lesson-actions {
        display: flex;
        gap: 0.75rem;
    }
    
    .btn-lesson {
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
    
    .btn-view-lesson {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
    }
    
    .btn-edit-lesson {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-delete-lesson {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-lesson:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    .empty-lessons {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    
    .empty-lessons i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #6b7280;
    }
    
    .empty-lessons h3 {
        color: #fff;
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }
    
    .empty-lessons p {
        margin-bottom: 2rem;
        font-size: 1rem;
    }
    
    @media (max-width: 768px) {
        .unit-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .unit-title {
            font-size: 1.5rem;
        }
        
        .unit-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .lessons-grid {
            grid-template-columns: 1fr;
        }
        
        .lesson-details {
            grid-template-columns: 1fr;
        }
        
        .lesson-actions {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
                 .unit-actions {
             flex-direction: column;
         }
     }
     
     .btn-add-lesson {
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
     
     .btn-add-lesson:hover {
         transform: translateY(-2px);
         box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
         color: #fff;
         text-decoration: none;
     }
</style>
@endsection

@section('main')
<div class="unit-show-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تفاصيل الوحدة</h1>
        <p class="page-subtitle">عرض معلومات الوحدة والدروس</p>
        <div class="breadcrumb-info">
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $course->title }} - {{ $unit->title }}</span>
        </div>
    </div>

    <!-- Unit Details Card -->
    <div class="unit-details-card">
        <div class="unit-header">
            <h2 class="unit-title">{{ $unit->title }}</h2>
                         <div class="unit-badges">
                 <span class="unit-badge badge-lessons">{{ $unit->lessons->count() }} درس</span>
             </div>
        </div>
        
                 <!-- Unit Statistics -->
         <div class="unit-stats-grid">
             <div class="stat-item">
                 <div class="stat-number">{{ $unit->lessons->count() }}</div>
                 <div class="stat-label">إجمالي الدروس</div>
             </div>
             <div class="stat-item">
                 <div class="stat-number">{{ $unit->lessons->where('is_free', true)->count() }}</div>
                 <div class="stat-label">الدروس المجانية</div>
             </div>
             <div class="stat-item">
                 <div class="stat-number">{{ $unit->created_at->format('M Y') }}</div>
                 <div class="stat-label">تاريخ الإنشاء</div>
             </div>
         </div>
        
                 <div class="unit-actions">
             <button type="button" 
                     class="btn btn-edit" 
                     onclick="openEditModal({{ $unit->id }}, '{{ $unit->title }}')">
                 <i class="fas fa-edit"></i>
                 تعديل الوحدة
             </button>
             <a href="{{ route('doctor.courses.units.index', $course->id) }}" class="btn btn-back">
                 <i class="fas fa-arrow-right"></i>
                 العودة للوحدات
             </a>
         </div>
    </div>

    <!-- Lessons Section -->
    <div class="lessons-section">
                 <div class="section-header">
             <h3 class="section-title">
                 <i class="fas fa-book"></i>
                 دروس الوحدة
             </h3>
             <a href="{{ route('doctor.courses.units.lessons.create', [$course->id, $unit->id]) }}" class="btn-add-lesson">
                 <i class="fas fa-plus"></i>
                 إضافة درس جديد
             </a>
         </div>
        
        @if($unit->lessons->count() > 0)
            <div class="lessons-grid">
                @foreach($unit->lessons as $lesson)
                    <div class="lesson-card">
                        <div class="lesson-header">
                            <h4 class="lesson-title">{{ $lesson->title }}</h4>
                            <div class="lesson-badges">
                                @if($lesson->is_free)
                                    <span class="lesson-badge badge-free">مجاني</span>
                                @else
                                    <span class="lesson-badge badge-paid">مدفوع</span>
                                @endif
                                
                            </div>
                        </div>
                        
                                                 <div class="lesson-details">
                             <div class="lesson-detail">
                                 <i class="fas fa-video"></i>
                                 <span>فيديو متاح</span>
                             </div>
                             @if($lesson->file)
                                 <div class="lesson-detail">
                                     <i class="fas fa-file"></i>
                                     <span>ملف مرفق</span>
                                 </div>
                             @endif
                             <div class="lesson-detail">
                                 <i class="fas fa-calendar"></i>
                                 <span>{{ $lesson->created_at->format('M Y') }}</span>
                             </div>
                         </div>
                        
                        <div class="lesson-actions">
                            <a href="{{ route('doctor.courses.units.lessons.show', [$course->id, $unit->id, $lesson->id]) }}" 
                               class="btn-lesson btn-view-lesson" 
                               title="عرض الدرس">
                                <i class="fas fa-eye"></i>
                                عرض
                            </a>
                            <a href="{{ route('doctor.courses.units.lessons.edit', [$course->id, $unit->id, $lesson->id]) }}" 
                               class="btn-lesson btn-edit-lesson" 
                               title="تعديل الدرس">
                                <i class="fas fa-edit"></i>
                                تعديل
                            </a>
                            <form action="{{ route('doctor.courses.units.lessons.destroy', [$course->id, $unit->id, $lesson->id]) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn-lesson btn-delete-lesson" 
                                        title="حذف الدرس">
                                    <i class="fas fa-trash"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-lessons">
                <i class="fas fa-book"></i>
                <h3>لا توجد دروس</h3>
                <p>لم يتم إنشاء أي دروس لهذه الوحدة بعد. ابدأ بإنشاء أول درس لإضافة المحتوى التعليمي.</p>

            </div>
        @endif
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

<style>
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

<script>
// Modal functions
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

function resetEditForm() {
    document.getElementById('edit_title').classList.remove('error');
    document.getElementById('edit_title_error').style.display = 'none';
    document.getElementById('editSubmitBtn').disabled = false;
    document.getElementById('editSubmitBtn').innerHTML = '<i class="fas fa-save"></i> حفظ التغييرات';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const editModal = document.getElementById('editUnitModal');
    
    if (event.target === editModal) {
        closeEditModal();
    }
}

// Form submission
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

function showEditError(fieldId, message) {
    document.getElementById(fieldId).classList.add('error');
    const errorDiv = document.getElementById(fieldId + '_error');
    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';
}

// Character count for input
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
