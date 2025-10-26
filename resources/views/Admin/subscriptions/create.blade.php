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
    
    /* Search Results Dropdown */
    .search-results-dropdown {
        position: absolute;
        z-index: 1000;
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
        max-height: 400px;
        overflow-y: auto;
        display: none;
        margin-top: 5px;
        width: 100%;
    }
    
    .search-results-dropdown.show {
        display: block;
    }
    
    .search-result-item {
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .search-result-item:last-child {
        border-bottom: none;
    }
    
    .search-result-item:hover {
        background: rgba(56, 189, 248, 0.15);
        transform: translateX(-3px);
    }
    
    .search-result-item.selected {
        background: rgba(56, 189, 248, 0.25);
        border-left: 3px solid #38bdf8;
    }
    
    .result-user-name {
        color: #fff;
        font-weight: 600;
        font-size: 1rem;
    }
    
    .result-user-details {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .result-user-phone,
    .result-user-email {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .result-user-phone i,
    .result-user-email i {
        color: #38bdf8;
        font-size: 0.8rem;
    }
    
    .search-results-dropdown.empty {
        padding: 2rem;
        text-align: center;
        color: #94a3b8;
    }
    
    .search-results-dropdown.loading {
        padding: 2rem;
        text-align: center;
        color: #94a3b8;
    }
    
    .selected-user-display {
        background: rgba(56, 189, 248, 0.15);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 0.5rem;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    
    .selected-user-name {
        color: #38bdf8;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .selected-user-info {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .selected-user-phone,
    .selected-user-email {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .selected-user-phone i,
    .selected-user-email i {
        color: #38bdf8;
        font-size: 0.8rem;
    }
    
    .form-group {
        position: relative;
    }
    
    /* Custom Scrollbar for Search Results */
    .search-results-dropdown::-webkit-scrollbar {
        width: 8px;
    }
    
    .search-results-dropdown::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.05);
        border-radius: 4px;
    }
    
    .search-results-dropdown::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
    }
    
    .search-results-dropdown::-webkit-scrollbar-thumb:hover {
        background: rgba(255,255,255,0.3);
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
        
        .search-results-dropdown {
            max-height: 300px;
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
            
            <!-- User Selection with Search Box -->
            <div class="form-group">
                <label for="user_search" class="form-label">ابحث عن المستخدم <span class="text-danger">*</span></label>
                <input type="text" 
                       id="user_search" 
                       class="form-control @error('user_id') is-invalid @enderror" 
                       placeholder="ابدأ بالكتابة للبحث بالاسم أو رقم الهاتف..." 
                       autocomplete="off"
                       value="{{ old('user_search') }}">
                <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                <div id="user_search_results" class="search-results-dropdown"></div>
                <small class="form-text text-muted" style="color: #94a3b8; font-size: 0.8rem; margin-top: 0.25rem;">
                    <i class="fa fa-search"></i> ابدأ بالكتابة للبحث (الاسم أو رقم الهاتف)
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const users = @json($users);
    const userSearchInput = document.getElementById('user_search');
    const userIdInput = document.getElementById('user_id');
    const searchResultsDiv = document.getElementById('user_search_results');
    let searchTimeout;
    let selectedUserIndex = -1;
    
    // Debounced search function
    function performSearch(query) {
        if (query.length < 1) {
            searchResultsDiv.classList.remove('show');
            return;
        }
        
        const searchTerm = query.toLowerCase().trim();
        const results = [];
        
        // Search through users
        users.forEach(user => {
            const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
            const phone = user.phone ? user.phone.toLowerCase().replace(/[\s\-\(\)\+]/g, '') : '';
            const cleanSearchTerm = searchTerm.replace(/[\s\-\(\)\+]/g, '');
            
            let score = 0;
            let matched = false;
            
            // Check name match
            if (fullName.includes(searchTerm)) {
                score += 10;
                matched = true;
            }
            
            // Check phone match (exact or partial)
            if (phone.includes(cleanSearchTerm)) {
                score += 5;
                matched = true;
            }
            
            if (matched) {
                results.push({ user, score });
            }
        });
        
        // Sort by score (best matches first)
        results.sort((a, b) => b.score - a.score);
        
        // Display results
        displaySearchResults(results);
    }
    
    function displaySearchResults(results) {
        if (results.length === 0) {
            searchResultsDiv.innerHTML = '<div class="empty">لا توجد نتائج</div>';
            searchResultsDiv.classList.add('show');
            return;
        }
        
        let html = '';
        results.forEach((result, index) => {
            const user = result.user;
            html += `
                <div class="search-result-item" data-user-id="${user.id}" data-index="${index}">
                    <div class="result-user-name">${user.first_name} ${user.last_name}</div>
                    <div class="result-user-details">
                        <span class="result-user-phone">
                            <i class="fa fa-phone"></i> ${user.phone}
                        </span>
                    </div>
                </div>
            `;
        });
        
        searchResultsDiv.innerHTML = html;
        searchResultsDiv.classList.add('show');
        
        // Add click listeners to results
        document.querySelectorAll('.search-result-item').forEach(item => {
            item.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const userName = this.querySelector('.result-user-name').textContent;
                const userPhone = this.querySelector('.result-user-phone').textContent.replace('📱', '').trim();
                
                // Set the selected user
                userIdInput.value = userId;
                userSearchInput.value = userName;
                
                // Display selected user info
                showSelectedUser(userName, userPhone);
                
                // Hide search results
                searchResultsDiv.classList.remove('show');
                selectedUserIndex = -1;
            });
            
            item.addEventListener('mouseenter', function() {
                document.querySelectorAll('.search-result-item').forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }
    
    function showSelectedUser(name, phone) {
        // Remove existing selected user display
        const existingDisplay = document.querySelector('.selected-user-display');
        if (existingDisplay) {
            existingDisplay.remove();
        }
        
        // Create and show selected user display
        const display = document.createElement('div');
        display.className = 'selected-user-display';
        display.innerHTML = `
            <div class="selected-user-name">
                <i class="fa fa-check-circle"></i> المستخدم المحدد: ${name}
            </div>
            <div class="selected-user-info">
                <span class="selected-user-phone">
                    <i class="fa fa-phone"></i> ${phone}
                </span>
            </div>
        `;
        
        userSearchInput.parentNode.appendChild(display);
    }
    
    // Handle input events with debounce
    userSearchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        const query = this.value;
        const existingDisplay = document.querySelector('.selected-user-display');
        if (existingDisplay) {
            existingDisplay.remove();
            userIdInput.value = '';
        }
        
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300); // Wait 300ms after user stops typing
    });
    
    // Handle keyboard navigation
    userSearchInput.addEventListener('keydown', function(e) {
        const items = document.querySelectorAll('.search-result-item');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedUserIndex = Math.min(selectedUserIndex + 1, items.length - 1);
            updateSelectedItem(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedUserIndex = Math.max(selectedUserIndex - 1, -1);
            updateSelectedItem(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (selectedUserIndex >= 0 && items[selectedUserIndex]) {
                items[selectedUserIndex].click();
            }
        } else if (e.key === 'Escape') {
            searchResultsDiv.classList.remove('show');
        }
    });
    
    function updateSelectedItem(items) {
        items.forEach((item, index) => {
            item.classList.toggle('selected', index === selectedUserIndex);
        });
        
        if (selectedUserIndex >= 0 && items[selectedUserIndex]) {
            items[selectedUserIndex].scrollIntoView({ block: 'nearest' });
        }
    }
    
    // Close search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            searchResultsDiv.classList.remove('show');
        }
    });
    
    // Rest of the existing functionality for subscription type
    const subscriptionTypeSelect = document.getElementById('subscription_type');
    const courseSelection = document.getElementById('course_selection');
    const bookSelection = document.getElementById('book_selection');
    const courseSelect = document.getElementById('course_id');
    const bookSelect = document.getElementById('book_id');

    function toggleContentSelection() {
        const selectedType = subscriptionTypeSelect.value;
        
        courseSelection.style.display = 'none';
        bookSelection.style.display = 'none';
        
        courseSelect.value = '';
        bookSelect.value = '';
        
        if (selectedType === 'course') {
            courseSelection.style.display = 'block';
        } else if (selectedType === 'book') {
            bookSelection.style.display = 'block';
        }
    }

    subscriptionTypeSelect.addEventListener('change', toggleContentSelection);
    toggleContentSelection();

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!userIdInput.value) {
            e.preventDefault();
            alert('الرجاء اختيار مستخدم');
            userSearchInput.focus();
            return false;
        }
        
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
