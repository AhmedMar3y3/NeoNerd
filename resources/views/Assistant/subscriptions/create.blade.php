@extends('Assistant.layout')

@section('styles')
<style>
    .subscription-container {
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
    }
    
    .form-section:last-child {
        margin-bottom: 0;
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
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
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
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .form-check-input {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 4px;
        width: 18px;
        height: 18px;
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
    
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .btn {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
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
    
    .error-message {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    .course-selection {
        display: none;
    }
    
    .course-selection.show {
        display: block;
    }
    
    /* Search Results Dropdown */
    .form-group {
        position: relative;
    }
    
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
    
    .search-result-item:hover,
    .search-result-item.selected {
        background: rgba(56, 189, 248, 0.15);
        transform: translateX(-3px);
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
    
    .result-user-phone {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .result-user-phone i {
        color: #38bdf8;
        font-size: 0.8rem;
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
    
    .selected-user-phone {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .selected-user-phone i {
        color: #38bdf8;
        font-size: 0.8rem;
    }
    
    /* Custom Scrollbar */
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
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="subscription-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-plus"></i>
            إضافة اشتراك جديد
        </h1>
        <p class="page-subtitle">إضافة اشتراك جديد للمستخدمين في دورات الدكتور</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form method="POST" action="{{ route('assistant.subscriptions.store') }}">
            @csrf
            
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    المعلومات الأساسية
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">ابحث عن المستخدم</label>
                        <input type="text" 
                               id="user_search" 
                               class="form-control @error('user_id') is-invalid @enderror" 
                               placeholder="ابدأ بالكتابة للبحث بالاسم أو رقم الهاتف..." 
                               autocomplete="off"
                               value="{{ old('user_search') }}">
                        <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
                        <div id="user_search_results" class="search-results-dropdown"></div>
                        @error('user_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">نوع الاشتراك</label>
                        <select name="subscription_type" class="form-select @error('subscription_type') is-invalid @enderror" required>
                            <option value="">اختر نوع الاشتراك</option>
                            @foreach($subscriptionTypes as $type)
                                <option value="{{ $type['value'] }}" {{ old('subscription_type') == $type['value'] ? 'selected' : '' }}>
                                    {{ $type['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Course Selection -->
            <div class="form-section course-selection" id="course-selection">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    اختيار الدورة
                </h3>
                
                <div class="form-group">
                    <label class="form-label">الدورة</label>
                    <select name="course_id" class="form-select @error('course_id') is-invalid @enderror">
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
                </div>
            </div>
            
            <!-- Status -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-toggle-on"></i>
                    حالة الاشتراك
                </h3>
                
                <div class="form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input @error('is_active') is-invalid @enderror" 
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        تفعيل الاشتراك فوراً
                    </label>
                </div>
                @error('is_active')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('assistant.subscriptions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    حفظ الاشتراك
                </button>
            </div>
        </form>
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
    
    // Search functionality
    function performSearch(query) {
        if (query.length < 1) {
            searchResultsDiv.classList.remove('show');
            return;
        }
        
        const searchTerm = query.toLowerCase().trim();
        const results = [];
        
        users.forEach(user => {
            const fullName = `${user.first_name} ${user.last_name}`.toLowerCase();
            const phone = user.phone ? user.phone.toLowerCase().replace(/[\s\-\(\)\+]/g, '') : '';
            const cleanSearchTerm = searchTerm.replace(/[\s\-\(\)\+]/g, '');
            
            let score = 0;
            let matched = false;
            
            if (fullName.includes(searchTerm)) {
                score += 10;
                matched = true;
            }
            
            if (phone.includes(cleanSearchTerm)) {
                score += 5;
                matched = true;
            }
            
            if (matched) {
                results.push({ user, score });
            }
        });
        
        results.sort((a, b) => b.score - a.score);
        displaySearchResults(results);
    }
    
    function displaySearchResults(results) {
        if (results.length === 0) {
            searchResultsDiv.innerHTML = '<div style="padding: 2rem; text-align: center; color: #94a3b8;">لا توجد نتائج</div>';
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
        
        document.querySelectorAll('.search-result-item').forEach(item => {
            item.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const userName = this.querySelector('.result-user-name').textContent;
                const userPhone = this.querySelector('.result-user-phone').textContent.replace('📱', '').trim();
                
                userIdInput.value = userId;
                userSearchInput.value = userName;
                showSelectedUser(userName, userPhone);
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
        const existingDisplay = document.querySelector('.selected-user-display');
        if (existingDisplay) {
            existingDisplay.remove();
        }
        
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
        }, 300);
    });
    
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
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.form-group')) {
            searchResultsDiv.classList.remove('show');
        }
    });
    
    // Subscription type functionality
    const subscriptionTypeSelect = document.querySelector('select[name="subscription_type"]');
    const courseSelection = document.getElementById('course-selection');
    
    function toggleCourseSelection() {
        const selectedType = subscriptionTypeSelect.value;
        if (selectedType === 'course') {
            courseSelection.classList.add('show');
        } else {
            courseSelection.classList.remove('show');
        }
    }
    
    subscriptionTypeSelect.addEventListener('change', toggleCourseSelection);
    toggleCourseSelection();
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!userIdInput.value) {
            e.preventDefault();
            alert('الرجاء اختيار مستخدم');
            userSearchInput.focus();
            return false;
        }
    });
});
</script>
@endsection
