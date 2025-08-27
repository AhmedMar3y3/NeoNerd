@extends('Doctor.layout')

@section('styles')
<style>
    .unit-create-container {
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
    
    .form-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .form-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .form-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .form-title i {
        color: #38bdf8;
    }
    
    .form-subtitle {
        color: #94a3b8;
        font-size: 1rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: #10b981;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .form-label.required::after {
        content: ' *';
        color: #ef4444;
    }
    
    .form-input {
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
    
    .form-input:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        background: rgba(255,255,255,0.08);
    }
    
    .form-input::placeholder {
        color: #64748b;
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .form-input.success {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .error-message {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .error-message i {
        font-size: 0.8rem;
    }
    
    .success-message {
        color: #10b981;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .success-message i {
        font-size: 0.8rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 140px;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(107, 114, 128, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .form-info {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        color: #94a3b8;
        font-size: 0.9rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    
    .form-info i {
        color: #38bdf8;
        font-size: 1.1rem;
        margin-top: 0.1rem;
    }
    
    .character-count {
        color: #64748b;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        text-align: left;
    }
    
    .character-count.near-limit {
        color: #f59e0b;
    }
    
    .character-count.at-limit {
        color: #ef4444;
    }
    
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
        
        .page-title {
            font-size: 2rem;
        }
        
        .form-container {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('main')
<div class="unit-create-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إضافة وحدة جديدة</h1>
        <p class="page-subtitle">إنشاء وحدة تعليمية جديدة للدورة</p>
        <div class="course-info">
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $course->title }}</span>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas fa-plus-circle"></i>
                معلومات الوحدة
            </h2>
            <p class="form-subtitle">أدخل تفاصيل الوحدة الجديدة</p>
        </div>

        <form action="{{ route('doctor.courses.units.store', $course->id) }}" method="POST" id="unitForm">
            @csrf
            
            <div class="form-info">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>نصيحة:</strong> اختر عنواناً واضحاً ووصفاً مختصراً للوحدة لمساعدة الطلاب على فهم المحتوى.
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-edit"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="form-group">
                    <label for="title" class="form-label required">عنوان الوحدة</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           class="form-input @error('title') error @enderror" 
                           placeholder="أدخل عنوان الوحدة..."
                           maxlength="255"
                           required>
                    @error('title')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="character-count" id="titleCount">
                        <span id="titleCurrent">0</span> / 255 حرف
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    حفظ الوحدة
                </button>
                <a href="{{ route('doctor.courses.units.index', $course->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const titleCount = document.getElementById('titleCount');
    const titleCurrent = document.getElementById('titleCurrent');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('unitForm');

    // Character count for title
    function updateTitleCount() {
        const length = titleInput.value.length;
        titleCurrent.textContent = length;
        
        if (length >= 240) {
            titleCount.className = 'character-count at-limit';
        } else if (length >= 200) {
            titleCount.className = 'character-count near-limit';
        } else {
            titleCount.className = 'character-count';
        }
    }

    titleInput.addEventListener('input', updateTitleCount);
    updateTitleCount();

    // Form validation
    function validateForm() {
        const title = titleInput.value.trim();
        let isValid = true;

        // Reset error states
        titleInput.classList.remove('error', 'success');

        // Validate title
        if (!title) {
            titleInput.classList.add('error');
            isValid = false;
        } else if (title.length < 3) {
            titleInput.classList.add('error');
            isValid = false;
        } else {
            titleInput.classList.add('success');
        }

        return isValid;
    }

    // Real-time validation
    titleInput.addEventListener('blur', validateForm);

    // Form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            submitBtn.disabled = true;
            setTimeout(() => {
                submitBtn.disabled = false;
            }, 2000);
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
        }
    });

    // Auto-save draft (optional feature)
    let autoSaveTimeout;
    titleInput.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function() {
            // Here you could implement auto-save functionality
            console.log('Auto-saving draft...');
        }, 2000);
    });
});
</script>
@endsection
