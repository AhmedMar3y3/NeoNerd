@extends('Doctor.layout')

@section('styles')
<style>
    .subscription-form-container {
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
    
    /* Form Card */
    .form-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .form-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .form-description {
        color: #94a3b8;
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-left: 4px solid #ef4444;
    }
    
    /* Form Groups */
    .form-group {
        margin-bottom: 1.5rem;
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
    
    .form-select option {
        background: #1E293B;
        color: #fff;
    }
    
    .form-text {
        color: #94a3b8;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .form-check-input {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 4px;
        width: 1.2rem;
        height: 1.2rem;
    }
    
    .form-check-input:checked {
        background: #38bdf8;
        border-color: #38bdf8;
    }
    
    .form-check-label {
        color: #94a3b8;
        font-size: 0.9rem;
        cursor: pointer;
    }
    
    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
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
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Error Messages */
    .error-message {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    
    .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25);
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
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('main')
<div class="subscription-form-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-plus"></i>
            إضافة اشتراك جديد
        </h1>
        <p class="page-subtitle">إنشاء اشتراك جديد للمستخدم في إحدى دوراتك</p>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fa fa-exclamation-triangle"></i>
            <strong>خطأ!</strong> يرجى تصحيح الأخطاء التالية:
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <h3 class="form-title">معلومات الاشتراك</h3>
        <p class="form-description">املأ المعلومات التالية لإنشاء اشتراك جديد</p>
        
        <form method="POST" action="{{ route('doctor.subscriptions.store') }}">
            @csrf
            
            <div class="form-grid">
                <!-- User Selection -->
                <div class="form-group">
                    <label for="user_id" class="form-label">
                        <i class="fas fa-user"></i>
                        المستخدم
                    </label>
                    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">اختر المستخدم</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->phone }}) - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subscription Type -->
                <div class="form-group">
                    <label for="subscription_type" class="form-label">
                        <i class="fas fa-tag"></i>
                        نوع الاشتراك
                    </label>
                    <select name="subscription_type" id="subscription_type" class="form-select @error('subscription_type') is-invalid @enderror" required>
                        <option value="">اختر نوع الاشتراك</option>
                        @foreach($subscriptionTypes as $type)
                            <option value="{{ $type->value }}" {{ old('subscription_type') == $type->value ? 'selected' : '' }}>
                                {{ $type->value === 'course' ? 'دورة' : 'كتاب' }}
                            </option>
                        @endforeach
                    </select>
                    @error('subscription_type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Course Selection -->
                <div class="form-group" id="course-selection">
                    <label for="course_id" class="form-label">
                        <i class="fas fa-graduation-cap"></i>
                        الدورة
                    </label>
                    <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror">
                        <option value="">اختر الدورة</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }} - {{ $course->subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="form-text">اختر الدورة التي تريد إنشاء الاشتراك فيها</div>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-toggle-on"></i>
                        حالة الاشتراك
                    </label>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">تفعيل الاشتراك فوراً</label>
                    </div>
                    <div class="form-text">اترك هذا الخيار مفعلاً لتفعيل الاشتراك مباشرة</div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    إنشاء الاشتراك
                </button>
                <a href="{{ route('doctor.subscriptions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    العودة للقائمة
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subscriptionTypeSelect = document.getElementById('subscription_type');
    const courseSelection = document.getElementById('course-selection');
    
    // Show/hide course selection based on subscription type
    subscriptionTypeSelect.addEventListener('change', function() {
        if (this.value === 'course') {
            courseSelection.style.display = 'block';
            document.getElementById('course_id').required = true;
        } else {
            courseSelection.style.display = 'none';
            document.getElementById('course_id').required = false;
        }
    });
    
    // Initialize on page load
    if (subscriptionTypeSelect.value === 'course') {
        courseSelection.style.display = 'block';
        document.getElementById('course_id').required = true;
    } else {
        courseSelection.style.display = 'none';
        document.getElementById('course_id').required = false;
    }
});
</script>
@endsection
