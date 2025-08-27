@extends('Doctor.layout')

@section('styles')
<style>
    .profile-container {
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
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        animation: slideIn 0.3s ease-out;
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-left: 4px solid #10b981;
    }
    
    /* Profile Card */
    .profile-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .profile-avatar .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .profile-info h3 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }
    
    .profile-info p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .profile-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-active {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .status-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .partner-badge {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    /* Form Styles */
    .form-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
    
    .form-text {
        color: #64748b;
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }
    
    .text-danger {
        color: #ef4444 !important;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
    
    /* File Upload */
    .file-upload-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-upload-input {
        position: absolute;
        left: -9999px;
    }
    
    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.05);
        border: 2px dashed rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 1.5rem;
        color: #94a3b8;
        cursor: pointer;
        transition: all 0.3s ease;
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
    
    .current-image {
        margin-top: 1rem;
        text-align: center;
    }
    
    .current-image img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(56, 189, 248, 0.3);
    }
    
    /* Buttons */
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
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    /* Password Section */
    .password-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .password-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .password-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .page-title {
            font-size: 2rem;
        }
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
</style>
@endsection

@section('main')
<div class="profile-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">الملف الشخصي</h1>
        <p class="page-subtitle">تحديث بياناتك الشخصية وإعدادات الحساب</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Information Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                @if($user->image)
                    <img src="{{ asset($user->image) }}" alt="{{ $user->name }}">
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="profile-info">
                <h3>{{ $user->name }}</h3>
                <p>{{ $user->email }}</p>
                <div class="profile-status">
                    <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                    @if($user->is_partner)
                        <span class="partner-badge">شريك</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profile Update Form -->
        <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    المعلومات الشخصية
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               placeholder="أدخل اسمك الكامل">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               placeholder="أدخل بريدك الإلكتروني">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-phone"></i>
                    معلومات التواصل
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="text" 
                               class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $user->phone) }}" 
                               placeholder="أدخل رقم هاتفك">
                        <div class="form-text">مثال: +201234567890</div>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="specialization" class="form-label">التخصص</label>
                        <input type="text" 
                               class="form-control @error('specialization') is-invalid @enderror" 
                               id="specialization" 
                               name="specialization" 
                               value="{{ old('specialization', $user->specialization) }}" 
                               placeholder="أدخل تخصصك">
                        @error('specialization')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    المعلومات الأكاديمية
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="university_id" class="form-label">الجامعة</label>
                        <select class="form-select @error('university_id') is-invalid @enderror" 
                                id="university_id" 
                                name="university_id">
                            <option value="">اختر الجامعة</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}" 
                                        {{ old('university_id', $user->university_id) == $university->id ? 'selected' : '' }}>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('university_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Bio Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    السيرة الذاتية
                </h3>
                
                <div class="form-group">
                    <label for="bio" class="form-label">نبذة عنك</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                              id="bio" 
                              name="bio" 
                              rows="4" 
                              placeholder="اكتب نبذة مختصرة عنك وتجربتك الأكاديمية">{{ old('bio', $user->bio) }}</textarea>
                    <div class="form-text">أقصى 1000 حرف</div>
                    @error('bio')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Profile Image Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-camera"></i>
                    صورة الملف الشخصي
                </h3>
                
                <div class="form-group">
                    <div class="file-upload-container">
                        <input type="file" 
                               class="file-upload-input @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/png,image/jpg,image/jpeg">
                        <label for="image" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div>
                                <div>انقر لاختيار صورة أو اسحب الصورة هنا</div>
                                <small>PNG, JPG, JPEG - أقصى 5MB</small>
                            </div>
                        </label>
                    </div>
                    
                    @if($user->image)
                        <div class="current-image">
                            <p class="form-text">الصورة الحالية:</p>
                            <img src="{{ asset($user->image) }}" alt="الصورة الحالية">
                        </div>
                    @endif
                    
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('doctor.dashboard') }}" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>

    <!-- Password Change Section -->
    <div class="password-section">
        <h3 class="section-title">
            <i class="fas fa-lock"></i>
            تغيير كلمة المرور
        </h3>
        
        <form action="{{ route('doctor.profile.password') }}" method="POST">
            @csrf
            
            <div class="password-grid">
                <div class="form-group">
                    <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                    <input type="password" 
                           class="form-control @error('current_password') is-invalid @enderror" 
                           id="current_password" 
                           name="current_password" 
                           placeholder="أدخل كلمة المرور الحالية">
                    @error('current_password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="أدخل كلمة المرور الجديدة">
                    <div class="form-text">أقل من 8 أحرف</div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="أعد إدخال كلمة المرور الجديدة">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-key"></i>
                    تغيير كلمة المرور
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview
    const fileInput = document.getElementById('image');
    const fileLabel = document.querySelector('.file-upload-label');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update label text
                    fileLabel.innerHTML = `
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <div>تم اختيار: ${file.name}</div>
                            <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                        </div>
                    `;
                    fileLabel.style.borderColor = '#10b981';
                    fileLabel.style.color = '#10b981';
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Form validation enhancement
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
                submitBtn.disabled = true;
            }
        });
    });
});
</script>
@endsection