@extends('Admin.layout')

@section('styles')
<style>
    .edit-container {
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
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: block;
        font-size: 0.95rem;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 10px;
        color: #fff;
        padding: 0.875rem 1rem;
        width: 100%;
        font-size: 1rem;
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
    
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .form-check-input {
        width: 18px;
        height: 18px;
        accent-color: #38bdf8;
    }
    
    .form-check-label {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    .password-note {
        background: rgba(56, 189, 248, 0.1);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        color: #38bdf8;
        font-size: 0.9rem;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .btn-cancel {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .invalid-feedback i {
        color: #ef4444;
    }
    
    .is-invalid {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.25) !important;
    }
</style>
@endsection

@section('main')
<div class="edit-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تعديل بيانات الطبيب</h1>
        <p class="page-subtitle">تعديل معلومات الطبيب: {{ $doctor->name }}</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">اسم الطبيب *</label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $doctor->name) }}" 
                       placeholder="أدخل اسم الطبيب"
                       required>
                @error('name')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني *</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $doctor->email) }}" 
                       placeholder="أدخل البريد الإلكتروني"
                       required>
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       placeholder="اتركها فارغة إذا لم ترد تغيير كلمة المرور">
                @error('password')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="password-note">
                    <i class="fas fa-info-circle me-2"></i>
                    اترك حقل كلمة المرور فارغاً إذا لم ترد تغييرها. إذا أدخلت كلمة مرور جديدة، سيتم تحديثها.
                </div>
            </div>

            <div class="form-check" style="gap: 1rem;">
                <input type="checkbox" 
                       class="form-check-input @error('is_partner') is-invalid @enderror" 
                       id="is_partner" 
                       name="is_partner" 
                       value="1" 
                       {{ old('is_partner', $doctor->is_partner) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_partner" style="margin-right: 0.5rem;">
                    طبيب شريك
                </label>
                @error('is_partner')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save me-2"></i>
                    حفظ التغييرات
                </button>
                <a href="{{ route('admin.doctors.index') }}" class="btn-cancel">
                    <i class="fas fa-times me-2"></i>
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
