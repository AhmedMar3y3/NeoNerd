@extends('Doctor.layout')

@section('styles')
<style>
    .course-form-container {
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
    
    .form-card {
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
        font-size: 1.2rem;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: block;
        font-size: 0.95rem;
    }
    
    .form-label.required::after {
        content: ' *';
        color: #ef4444;
    }
    
    .form-control, .form-select, .form-textarea {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 1rem;
        width: 100%;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }
    
    .form-control:focus, .form-select:focus, .form-textarea:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
        outline: none;
    }
    
    .form-control::placeholder, .form-textarea::placeholder {
        color: rgba(148, 163, 184, 0.7);
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-select {
        cursor: pointer;
    }
    
    .form-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .custom-checkbox {
        position: relative;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        width: 20px;
        height: 20px;
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.2);
        border-radius: 4px;
        transition: all 0.3s ease;
    }
    
    .custom-checkbox input:checked ~ .checkmark {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: #10b981;
    }
    
    .checkmark:after {
        content: '';
        position: absolute;
        display: none;
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    
    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }
    
    .checkbox-label {
        color: #94a3b8;
        font-size: 0.95rem;
        cursor: pointer;
    }
    
    .file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-upload-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        background: rgba(255,255,255,0.05);
        border: 2px dashed rgba(255,255,255,0.2);
        border-radius: 10px;
        padding: 2rem;
        color: #94a3b8;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
    }
    
    .file-upload-label:hover {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        color: #38bdf8;
    }
    
    .file-upload-label i {
        font-size: 1.5rem;
    }
    
    .image-preview {
        margin-top: 1rem;
        text-align: center;
    }
    
    .image-preview img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    
    .current-image {
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .current-image img {
        max-width: 200px;
        max-height: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    
    .current-image-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-top: 0.5rem;
        display: block;
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
        padding: 0.875rem 2rem;
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
        min-width: 120px;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-secondary:hover {
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
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
    
    .help-text {
        color: #94a3b8;
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('main')
<div class="course-form-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تعديل الدورة</h1>
        <p class="page-subtitle">تحديث معلومات الدورة "{{ $course->title }}"</p>
    </div>

    <div class="form-card">
        <form action="{{ route('doctor.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" id="courseForm">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">عنوان الدورة</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               name="title" 
                               value="{{ old('title', $course->title) }}" 
                               placeholder="أدخل عنوان الدورة">
                        @error('title')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required">المادة الدراسية</label>
                        <select class="form-select @error('subject_id') is-invalid @enderror" name="subject_id">
                            <option value="">اختر المادة الدراسية</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $course->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->display_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group full-width">
                    <label class="form-label">وصف الدورة</label>
                    <textarea class="form-textarea @error('description') is-invalid @enderror" 
                              name="description" 
                              placeholder="أدخل وصف مفصل للدورة...">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="help-text">يمكنك كتابة وصف مفصل يشرح محتوى الدورة وأهدافها</div>
                </div>
            </div>

            <!-- Pricing Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-dollar-sign"></i>
                    التسعير والحالة
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">السعر</label>
                        <input type="number" 
                               class="form-control @error('price') is-invalid @enderror" 
                               name="price" 
                               value="{{ old('price', $course->price) }}" 
                               min="0"
                               placeholder="أدخل سعر الدورة">
                        @error('price')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="help-text">أدخل 0 إذا كانت الدورة مجانية</div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">حالة الدورة</label>
                        <div class="checkbox-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <span class="checkbox-label">دورة مجانية</span>
                        </div>
                        
                        <div class="checkbox-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                            </label>
                            <span class="checkbox-label">تفعيل الدورة</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-image"></i>
                    صورة الدورة
                </h3>
                
                <div class="form-group">
                    @if($course->image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="الصورة الحالية">
                            <span class="current-image-label">الصورة الحالية</span>
                        </div>
                    @endif
                    
                    <label class="form-label">صورة الدورة الجديدة</label>
                    <div class="file-upload">
                        <input type="file" 
                               class="file-upload-input @error('image') is-invalid @enderror" 
                               name="image" 
                               id="courseImage"
                               accept="image/*">
                        <label for="courseImage" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>اختر صورة جديدة للدورة أو اسحبها هنا</span>
                        </label>
                    </div>
                    @error('image')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="help-text">الصيغ المدعومة: PNG, JPG, JPEG - الحد الأقصى: 5 ميجابايت</div>
                    
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <img id="previewImage" src="" alt="معاينة الصورة">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('doctor.courses.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInput = document.getElementById('courseImage');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
    
    // Price field behavior based on free checkbox
    const freeCheckbox = document.querySelector('input[name="is_free"]');
    const priceInput = document.querySelector('input[name="price"]');
    
    freeCheckbox.addEventListener('change', function() {
        if (this.checked) {
            priceInput.value = '0';
            priceInput.disabled = true;
        } else {
            priceInput.disabled = false;
        }
    });
    
    // Initialize price field state
    if (freeCheckbox.checked) {
        priceInput.disabled = true;
    }
    
    // Form validation
    const form = document.getElementById('courseForm');
    form.addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const subjectId = document.querySelector('select[name="subject_id"]').value;
        
        if (!title) {
            e.preventDefault();
            alert('يرجى إدخال عنوان الدورة');
            return false;
        }
        
        if (!subjectId) {
            e.preventDefault();
            alert('يرجى اختيار المادة الدراسية');
            return false;
        }
    });
});
</script>
@endsection
