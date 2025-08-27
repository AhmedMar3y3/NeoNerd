@extends('Doctor.layout')

@section('styles')
<style>
    .lesson-create-container {
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
    
    .lesson-form-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .section-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: #38bdf8;
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
    
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .form-error {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-error i {
        font-size: 0.8rem;
    }
    
    .form-textarea {
        width: 100%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
        resize: vertical;
        min-height: 120px;
    }
    
    .form-textarea:focus {
        outline: none;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        background: rgba(255,255,255,0.08);
    }
    
    .form-textarea::placeholder {
        color: #64748b;
    }
    
    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .form-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #38bdf8;
        cursor: pointer;
    }
    
    .form-checkbox label {
        color: #94a3b8;
        font-size: 0.95rem;
        cursor: pointer;
        user-select: none;
    }
    
    .duration-input {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .duration-input input {
        width: 80px;
        text-align: center;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .duration-separator {
        color: #94a3b8;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .duration-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
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
        min-width: 120px;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .character-count {
        color: #64748b;
        font-size: 0.8rem;
        margin-top: 0.5rem;
        text-align: left;
    }
    
    .character-count.warning {
        color: #f59e0b;
    }
    
    .character-count.danger {
        color: #ef4444;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .lesson-form-card {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .duration-input {
            flex-direction: column;
            align-items: stretch;
        }
        
        .duration-input input {
            width: 100%;
        }
    }
</style>
@endsection

@section('main')
<div class="lesson-create-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إضافة درس جديد</h1>
        <p class="page-subtitle">إنشاء درس جديد في الوحدة</p>
        <div class="breadcrumb-info">
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $course->title }} - {{ $unit->title }}</span>
        </div>
    </div>

    <!-- Lesson Form Card -->
    <div class="lesson-form-card">
        <form action="{{ route('doctor.courses.units.lessons.store', [$course->id, $unit->id]) }}" method="POST">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="form-group">
                    <label for="title" class="form-label required">عنوان الدرس</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           class="form-input @error('title') error @enderror" 
                           placeholder="أدخل عنوان الدرس..."
                           value="{{ old('title') }}"
                           maxlength="255"
                           required>
                    @error('title')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="character-count" id="titleCount">0/255</div>
                </div>
            </div>
            
            <!-- Video Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-video"></i>
                    معلومات الفيديو
                </h3>
                
                <div class="form-group">
                    <label for="video_url" class="form-label required">رابط الفيديو</label>
                    <input type="url" 
                           id="video_url" 
                           name="video_url" 
                           class="form-input @error('video_url') error @enderror" 
                           placeholder="https://www.youtube.com/watch?v=..."
                           value="{{ old('video_url') }}"
                           maxlength="500"
                           required>
                    @error('video_url')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="character-count" id="videoUrlCount">0/500</div>
                </div>
                
                <div class="form-group">
                    <label for="duration" class="form-label required">مدة الدرس</label>
                    <div class="duration-input">
                        <input type="number" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               class="form-input @error('duration') error @enderror" 
                               placeholder="00"
                               min="0"
                               max="99"
                               value="{{ old('duration_minutes', 0) }}"
                               required>
                        <span class="duration-separator">:</span>
                        <input type="number" 
                               id="duration_seconds" 
                               name="duration_seconds" 
                               class="form-input @error('duration') error @enderror" 
                               placeholder="00"
                               min="0"
                               max="59"
                               value="{{ old('duration_seconds', 0) }}"
                               required>
                        <span class="duration-label">دقيقة:ثانية</span>
                    </div>
                    <input type="hidden" id="duration" name="duration" value="{{ old('duration', '00:00') }}">
                    @error('duration')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            
            <!-- Settings Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    الإعدادات
                </h3>
                
                                 <div class="form-checkbox">
                     <input type="hidden" name="is_free" value="0">
                     <input type="checkbox" 
                            id="is_free" 
                            name="is_free" 
                            value="1"
                            {{ old('is_free', true) ? 'checked' : '' }}>
                     <label for="is_free">درس مجاني</label>
                 </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('doctor.courses.units.show', [$course->id, $unit->id]) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    حفظ الدرس
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Character count for title
document.getElementById('title').addEventListener('input', function() {
    const length = this.value.length;
    const countElement = document.getElementById('titleCount');
    countElement.textContent = `${length}/255`;
    
    if (length >= 240) {
        countElement.className = 'character-count danger';
    } else if (length >= 200) {
        countElement.className = 'character-count warning';
    } else {
        countElement.className = 'character-count';
    }
});

// Character count for video URL
document.getElementById('video_url').addEventListener('input', function() {
    const length = this.value.length;
    const countElement = document.getElementById('videoUrlCount');
    countElement.textContent = `${length}/500`;
    
    if (length >= 450) {
        countElement.className = 'character-count danger';
    } else if (length >= 400) {
        countElement.className = 'character-count warning';
    } else {
        countElement.className = 'character-count';
    }
});

// Duration formatting
function updateDuration() {
    const minutes = document.getElementById('duration_minutes').value.padStart(2, '0');
    const seconds = document.getElementById('duration_seconds').value.padStart(2, '0');
    document.getElementById('duration').value = `${minutes}:${seconds}`;
}

document.getElementById('duration_minutes').addEventListener('input', updateDuration);
document.getElementById('duration_seconds').addEventListener('input', updateDuration);

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const videoUrl = document.getElementById('video_url').value.trim();
    const minutes = document.getElementById('duration_minutes').value;
    const seconds = document.getElementById('duration_seconds').value;
    const submitBtn = document.getElementById('submitBtn');
    
    // Reset errors
    document.querySelectorAll('.form-input').forEach(input => {
        input.classList.remove('error');
    });
    document.querySelectorAll('.form-error').forEach(error => {
        error.style.display = 'none';
    });
    
    let hasErrors = false;
    
    // Validate title
    if (!title) {
        showError('title', 'عنوان الدرس مطلوب');
        hasErrors = true;
    } else if (title.length < 3) {
        showError('title', 'عنوان الدرس يجب أن يكون 3 أحرف على الأقل');
        hasErrors = true;
    }
    
    // Validate video URL
    if (!videoUrl) {
        showError('video_url', 'رابط الفيديو مطلوب');
        hasErrors = true;
    } else if (!isValidUrl(videoUrl)) {
        showError('video_url', 'رابط الفيديو يجب أن يكون رابط صحيح');
        hasErrors = true;
    }
    
    // Validate duration
    if (!minutes || !seconds) {
        showError('duration_minutes', 'مدة الدرس مطلوبة');
        hasErrors = true;
    } else if (parseInt(minutes) < 0 || parseInt(minutes) > 99) {
        showError('duration_minutes', 'الدقائق يجب أن تكون بين 0 و 99');
        hasErrors = true;
    } else if (parseInt(seconds) < 0 || parseInt(seconds) > 59) {
        showError('duration_seconds', 'الثواني يجب أن تكون بين 0 و 59');
        hasErrors = true;
    }
    
    if (hasErrors) {
        e.preventDefault();
        return;
    }
    
    // Submit
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
});

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    field.classList.add('error');
    
    // Create or update error message
    let errorDiv = field.parentNode.querySelector('.form-error');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'form-error';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i><span></span>';
        field.parentNode.appendChild(errorDiv);
    }
    
    errorDiv.querySelector('span').textContent = message;
    errorDiv.style.display = 'flex';
}

function isValidUrl(string) {
    try {
        new URL(string);
        return true;
    } catch (_) {
        return false;
    }
}

// Initialize character counts
document.getElementById('title').dispatchEvent(new Event('input'));
document.getElementById('video_url').dispatchEvent(new Event('input'));
</script>
@endsection
