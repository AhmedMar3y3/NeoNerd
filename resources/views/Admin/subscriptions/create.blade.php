@extends('Admin.layout')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
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
    
    .alert-info {
        background: rgba(6, 182, 212, 0.1);
        color: #06b6d4;
        border-left: 4px solid #06b6d4;
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
    
    /* Select2 Custom Styling */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container--default .select2-selection--single {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 8px !important;
        height: 42px !important;
        padding: 0 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff !important;
        line-height: 40px !important;
        padding-left: 12px !important;
        padding-right: 20px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: rgba(148, 163, 184, 0.7) !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        right: 8px !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #94a3b8 transparent transparent transparent !important;
    }
    
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent #94a3b8 transparent !important;
    }
    
    .select2-dropdown {
        background: #1E293B !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25) !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        border-radius: 6px !important;
        color: #fff !important;
        padding: 8px 12px !important;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #38bdf8 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25) !important;
        outline: none !important;
    }
    
    .select2-container--default .select2-results__option {
        background: transparent !important;
        color: #e2e8f0 !important;
        padding: 8px 12px !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: rgba(56, 189, 248, 0.2) !important;
        color: #38bdf8 !important;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background: rgba(56, 189, 248, 0.3) !important;
        color: #38bdf8 !important;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: rgba(56, 189, 248, 0.2) !important;
        color: #38bdf8 !important;
    }
    
    .select2-container--default .select2-results__option .select2-results__option {
        padding-left: 20px !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-primary, .btn-light {
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
            <i class="fa fa-plus"></i>
            إضافة اشتراك جديد
        </h1>
        <p class="page-subtitle">إنشاء اشتراك جديد للمستخدم في دورة أو كتاب</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <h2 class="form-title">بيانات الاشتراك</h2>
        <p class="form-description">أدخل بيانات الاشتراك الجديد</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.subscriptions.store') }}">
            @csrf
            
            <!-- User Selection -->
            <div class="form-group">
                <label for="user_id" class="form-label">المستخدم <span class="text-danger">*</span></label>
                <select name="user_id" id="user_id" class="form-control select2-searchable @error('user_id') is-invalid @enderror" required>
                    <option value="">اختر المستخدم</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                                data-phone="{{ $user->phone }}" 
                                data-email="{{ $user->email }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }} - {{ $user->phone }} - {{ $user->email }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted" style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem;">
                    <i class="fa fa-search"></i> يمكنك البحث بالاسم أو رقم الهاتف أو البريد الإلكتروني
                </small>
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
                        <option value="{{ $type->value }}" {{ old('subscription_type') == $type->value ? 'selected' : '' }}>
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
            <div class="form-group" id="course_selection" style="display: none;">
                <label for="course_id" class="form-label">الدورة <span class="text-danger">*</span></label>
                <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                    <option value="">اختر الدورة</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }} - {{ $course->doctor->name ?? 'غير محدد' }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Book Selection (Dynamic) -->
            <div class="form-group" id="book_selection" style="display: none;">
                <label for="book_id" class="form-label">الكتاب <span class="text-danger">*</span></label>
                <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror">
                    <option value="">اختر الكتاب</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
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
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        تفعيل الاشتراك فوراً
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa fa-save"></i>
                    حفظ الاشتراك
                </button>
                <a href="{{ route('admin.subscriptions.index') }}" class="btn-light">
                    <i class="fa fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>

    <!-- Information Card -->
    <div class="info-card">
        <h3 class="info-title">معلومات مهمة</h3>
        <div class="info-grid">
            <div class="alert alert-info">
                <h6><i class="fa fa-info-circle"></i> ملاحظات مهمة:</h6>
                <ul>
                    <li>يمكن للمستخدم الاشتراك في عدة دورات وكتب في نفس الوقت</li>
                    <li>لا يمكن إنشاء اشتراك مكرر لنفس المحتوى لنفس المستخدم</li>
                    <li>تأكد من أن المحتوى المختار نشط ومتاح للاشتراك</li>
                    <li>الاشتراكات الجديدة لا تؤثر على الاشتراكات الموجودة</li>
                </ul>
            </div>
            <div class="alert alert-warning">
                <h6><i class="fa fa-exclamation-triangle"></i> تحذيرات:</h6>
                <ul>
                    <li>تأكد من عدم وجود اشتراك نشط آخر للمستخدم في نفس المحتوى</li>
                    <li>تأكد من صحة بيانات المستخدم قبل إنشاء الاشتراك</li>
                    <li>يمكن تعديل أو إلغاء الاشتراك لاحقاً من لوحة التحكم</li>
                    <li>لا يتم إلغاء تفعيل الاشتراكات الأخرى تلقائياً</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for user dropdown with search functionality
    $('#user_id').select2({
        placeholder: 'ابحث عن المستخدم بالاسم أو رقم الهاتف أو البريد الإلكتروني (مثال: 01234567890)',
        allowClear: true,
        dir: 'rtl',
        language: {
            noResults: function() {
                return "لا توجد نتائج";
            },
            searching: function() {
                return "جاري البحث...";
            },
            inputTooShort: function() {
                return "أدخل حرف واحد على الأقل للبحث";
            }
        },
        matcher: function(params, data) {
            // If there are no search terms, return all data
            if ($.trim(params.term) === '') {
                return data;
            }
            
            // Skip if this is an optgroup
            if (typeof data.text === 'undefined') {
                return null;
            }
            
            // Get the search term and convert to lowercase
            var searchTerm = params.term.toLowerCase().trim();
            
            // Get the option text and convert to lowercase
            var optionText = data.text.toLowerCase();
            
            // Get phone and email from data attributes
            var phone = $(data.element).data('phone') || '';
            var email = $(data.element).data('email') || '';
            
            // Clean phone number for better matching (remove spaces, dashes, parentheses)
            var cleanPhone = phone.replace(/[\s\-\(\)\+]/g, '').toLowerCase();
            var cleanSearchTerm = searchTerm.replace(/[\s\-\(\)\+]/g, '');
            
            // Check if search term matches name
            if (optionText.indexOf(searchTerm) > -1) {
                return data;
            }
            
            // Check if search term matches phone (exact match or partial match)
            if (phone.toLowerCase().indexOf(searchTerm) > -1 || 
                cleanPhone.indexOf(cleanSearchTerm) > -1) {
                return data;
            }
            
            // Check if search term matches email
            if (email.toLowerCase().indexOf(searchTerm) > -1) {
                return data;
            }
            
            // Return null if no match
            return null;
        },
        templateResult: function(data) {
            if (data.loading) {
                return data.text;
            }
            
            // Get phone and email from data attributes
            var phone = $(data.element).data('phone') || '';
            var email = $(data.element).data('email') || '';
            
            // Create custom template with phone and email
            var $result = $(
                '<div class="user-option">' +
                    '<div class="user-name">' + data.text + '</div>' +
                    '<div class="user-details">' +
                        '<span class="user-phone"><i class="fa fa-phone"></i> ' + phone + '</span>' +
                        '<span class="user-email"><i class="fa fa-envelope"></i> ' + email + '</span>' +
                    '</div>' +
                '</div>'
            );
            
            return $result;
        },
        templateSelection: function(data) {
            return data.text;
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });
    
    // Add custom CSS for the template
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .user-option {
                padding: 8px 0;
            }
            .user-name {
                font-weight: 600;
                color: #fff;
                margin-bottom: 4px;
            }
            .user-details {
                display: flex;
                gap: 15px;
                font-size: 0.85rem;
            }
            .user-phone, .user-email {
                color: #94a3b8;
                display: flex;
                align-items: center;
                gap: 4px;
            }
            .user-phone i, .user-email i {
                color: #38bdf8;
                font-size: 0.8rem;
            }
        `)
        .appendTo('head');

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

.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    color: white;
}

.btn-gradient-primary:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    color: white;
}
</style>
@endsection
