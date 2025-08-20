@extends('Admin.layout')

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
    
    .alert-info {
        background: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
        border-left: 4px solid #06b6d4;
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
    
    .form-control.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25);
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    /* Checkbox */
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border-radius: 4px;
        border: 2px solid rgba(255,255,255,0.2);
        background: rgba(255,255,255,0.05);
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-color: #3b82f6;
    }
    
    .form-check-label {
        color: #e2e8f0;
        font-weight: 500;
        cursor: pointer;
    }
    
    /* Buttons */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: #fff;
    }
    
    .btn-light {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        color: #fff;
    }
    
    /* Current Info Card */
    .current-info-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .current-info-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .current-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-item strong {
        color: #94a3b8;
        font-weight: 500;
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }
    
    .info-item span, .info-item div {
        color: #e2e8f0;
        font-weight: 500;
    }
    
    /* Badges */
    .badge {
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .badge-primary {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .badge-info {
        background: rgba(6, 182, 212, 0.2);
        color: #06b6d4;
        border: 1px solid rgba(6, 182, 212, 0.3);
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    /* Information Cards */
    .info-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .info-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border-left: 4px solid #f59e0b;
    }
    
    .alert h6 {
        color: inherit;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }
    
    .alert li {
        margin-bottom: 0.5rem;
    }
    
    /* Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .info-grid, .current-info-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-warning, .btn-light {
            justify-content: center;
        }
    }
</style>
@endsection

@section('main')
<div class="subscription-form-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-edit"></i>
            تعديل الاشتراك
        </h1>
        <p class="page-subtitle">تعديل بيانات الاشتراك المحدد</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <h2 class="form-title">تعديل بيانات الاشتراك</h2>
        <p class="form-description">قم بتعديل بيانات الاشتراك حسب الحاجة</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.subscriptions.update', $subscription->id) }}">
            @csrf
            @method('PUT')
            
            <!-- User Selection -->
            <div class="form-group">
                <label for="user_id" class="form-label">المستخدم <span class="text-danger">*</span></label>
                <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                    <option value="">اختر المستخدم</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $subscription->user_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Subscription Type -->
            <div class="form-group">
                <label for="subscription_type" class="form-label">نوع الاشتراك <span class="text-danger">*</span></label>
                <select name="subscription_type" id="subscription_type" class="form-control @error('subscription_type') is-invalid @enderror" required>
                    <option value="">اختر نوع الاشتراك</option>
                    @foreach($subscriptionTypes as $type)
                        <option value="{{ $type->value }}" {{ old('subscription_type', $subscription->subscription_type) == $type->value ? 'selected' : '' }}>
                            @if($type->value === 'course')
                                <i class="fa fa-graduation-cap"></i> دورة
                            @else
                                <i class="fa fa-book"></i> كتاب
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('subscription_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Course Selection (Dynamic) -->
            <div class="form-group" id="course_selection" style="display: {{ $subscription->subscription_type === 'course' ? 'block' : 'none' }};">
                <label for="course_id" class="form-label">الدورة <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                    <option value="">اختر الدورة</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $subscription->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->title }} - {{ $course->doctor->name ?? 'غير محدد' }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Book Selection (Dynamic) -->
            <div class="form-group" id="book_selection" style="display: {{ $subscription->subscription_type === 'book' ? 'block' : 'none' }};">
                <label for="book_id" class="form-label">الكتاب <span class="text-danger">*</span></label>
                <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror">
                    <option value="">اختر الكتاب</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id', $subscription->book_id) == $book->id ? 'selected' : '' }}>
                            {{ $book->title }} - {{ $book->author ?? 'غير محدد' }}
                        </option>
                    @endforeach
                </select>
                @error('book_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $subscription->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        تفعيل الاشتراك
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-warning">
                    <i class="fa fa-save"></i>
                    حفظ التعديلات
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn-light">
                    <i class="fa fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>

    <!-- Current Subscription Info -->
    <div class="current-info-card">
        <h3 class="current-info-title">معلومات الاشتراك الحالي</h3>
        <div class="current-info-grid">
            <div class="info-item">
                <strong>المستخدم:</strong>
                <div>{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</div>
            </div>
            <div class="info-item">
                <strong>البريد الإلكتروني:</strong>
                <div>{{ $subscription->user->email }}</div>
            </div>
            <div class="info-item">
                <strong>نوع الاشتراك:</strong>
                <div>
                    @if($subscription->subscription_type === 'course')
                        <span class="badge badge-primary">
                            <i class="fa fa-graduation-cap"></i>
                            دورة
                        </span>
                    @else
                        <span class="badge badge-info">
                            <i class="fa fa-book"></i>
                            كتاب
                        </span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <strong>المحتوى:</strong>
                <div>
                    @if($subscription->subscription_type === 'course' && $subscription->course)
                        {{ $subscription->course->title }}
                    @elseif($subscription->subscription_type === 'book' && $subscription->book)
                        {{ $subscription->book->title }}
                    @else
                        غير متوفر
                    @endif
                </div>
            </div>
            <div class="info-item">
                <strong>الحالة:</strong>
                <div>
                    @if($subscription->is_active)
                        <span class="badge badge-success">
                            <i class="fa fa-check"></i>
                            نشط
                        </span>
                    @else
                        <span class="badge badge-danger">
                            <i class="fa fa-times"></i>
                            غير نشط
                        </span>
                    @endif
                </div>
            </div>
            <div class="info-item">
                <strong>تاريخ الإنشاء:</strong>
                <div>{{ $subscription->created_at->format('Y-m-d H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Information Card -->
    <div class="info-card">
        <h3 class="info-title">معلومات مهمة</h3>
        <div class="info-grid">
            <div class="alert alert-info">
                <h6><i class="fa fa-info-circle"></i> ملاحظات مهمة:</h6>
                <ul>
                    <li>يمكن تغيير نوع الاشتراك من دورة إلى كتاب أو العكس</li>
                    <li>يمكن للمستخدم الاشتراك في عدة دورات وكتب في نفس الوقت</li>
                    <li>لا يمكن إنشاء اشتراك مكرر لنفس المحتوى لنفس المستخدم</li>
                    <li>يمكن تغيير المستخدم المرتبط بالاشتراك</li>
                </ul>
            </div>
            <div class="alert alert-warning">
                <h6><i class="fa fa-exclamation-triangle"></i> تحذيرات:</h6>
                <ul>
                    <li>تأكد من عدم وجود اشتراك نشط آخر للمستخدم في نفس المحتوى</li>
                    <li>تغيير نوع الاشتراك قد يؤثر على صلاحيات المستخدم</li>
                    <li>يمكن إلغاء التفعيل مؤقتاً بدلاً من الحذف</li>
                    <li>الاشتراكات الأخرى للمستخدم لن تتأثر بالتعديل</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subscriptionTypeSelect = document.getElementById('subscription_type');
    const courseSelection = document.getElementById('course_selection');
    const bookSelection = document.getElementById('book_selection');
    const courseSelect = document.getElementById('course_id');
    const bookSelect = document.getElementById('book_id');

    function toggleContentSelection() {
        const selectedType = subscriptionTypeSelect.value;
        
        // Hide both selections initially
        courseSelection.style.display = 'none';
        bookSelection.style.display = 'none';
        
        // Reset values
        courseSelect.value = '';
        bookSelect.value = '';
        
        // Show appropriate selection based on type
        if (selectedType === 'course') {
            courseSelection.style.display = 'block';
        } else if (selectedType === 'book') {
            bookSelection.style.display = 'block';
        }
    }

    // Add event listener for subscription type change
    subscriptionTypeSelect.addEventListener('change', toggleContentSelection);
    
    // Initialize on page load
    toggleContentSelection();

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const subscriptionType = subscriptionTypeSelect.value;
        const courseId = courseSelect.value;
        const bookId = bookSelect.value;
        
        if (subscriptionType === 'course' && !courseId) {
            e.preventDefault();
            alert('الرجاء اختيار دورة');
            courseSelect.focus();
            return false;
        }
        
        if (subscriptionType === 'book' && !bookId) {
            e.preventDefault();
            alert('الرجاء اختيار كتاب');
            bookSelect.focus();
            return false;
        }
    });
});
</script>

<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-control, .form-select {
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    padding: 0.75rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.alert {
    border-radius: 0.5rem;
    border: none;
}

.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}

.btn {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

.btn-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800);
    border: none;
    color: #212529;
}

.btn-gradient-warning:hover {
    background: linear-gradient(45deg, #e0a800, #d39e00);
    color: #212529;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5em 0.75em;
}
</style>
@endsection
