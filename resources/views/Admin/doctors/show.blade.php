@extends('Admin.layout')

@section('styles')
<style>
    .show-container {
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
    
    .profile-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 2rem;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        flex-wrap: wrap;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 3rem;
        box-shadow: 0 8px 32px rgba(56, 189, 248, 0.3);
    }
    
    .profile-info h2 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }
    
    .profile-email {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0 0 1rem 0;
    }
    
    .profile-status {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        text-align: center;
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
    }
    
    .profile-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    
    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .detail-section {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .section-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title i {
        color: #38bdf8;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .detail-value {
        color: #fff;
        font-size: 0.9rem;
        font-weight: 500;
        text-align: left;
    }
    
    .detail-value.null {
        color: #6b7280;
        font-style: italic;
    }
    
    .bio-section {
        grid-column: 1 / -1;
    }
    
    .bio-content {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        padding: 1.5rem;
        color: #fff;
        line-height: 1.6;
        min-height: 100px;
    }
    
    .bio-content.null {
        color: #6b7280;
        font-style: italic;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-actions {
            justify-content: center;
        }
        
        .details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('main')
<div class="show-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تفاصيل الطبيب</h1>
        <p class="page-subtitle">عرض معلومات الطبيب بالتفصيل</p>
    </div>

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($doctor->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ $doctor->name }}</h2>
                <p class="profile-email">{{ $doctor->email }}</p>
                <div class="profile-status">
                    <span class="status-badge {{ $doctor->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $doctor->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                    @if($doctor->is_partner)
                        <span class="status-badge partner-badge">طبيب شريك</span>
                    @endif
                </div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                <form action="{{ route('admin.doctors.toggle-status', $doctor->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-action btn-toggle">
                        <i class="fas {{ $doctor->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                        {{ $doctor->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                    </button>
                </form>
                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطبيب؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete">
                        <i class="fas fa-trash"></i>
                        حذف
                    </button>
                </form>
                <a href="{{ route('admin.doctors.index') }}" class="btn-action btn-back">
                    <i class="fas fa-arrow-right"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="details-grid">
            <!-- Basic Information -->
            <div class="detail-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    المعلومات الأساسية
                </h3>
                <div class="detail-item">
                    <span class="detail-label">الاسم</span>
                    <span class="detail-value">{{ $doctor->name }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">البريد الإلكتروني</span>
                    <span class="detail-value">{{ $doctor->email }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">رقم الهاتف</span>
                    <span class="detail-value {{ $doctor->phone ? '' : 'null' }}">
                        {{ $doctor->phone ?? 'غير محدد' }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">التخصص</span>
                    <span class="detail-value {{ $doctor->specialization ? '' : 'null' }}">
                        {{ $doctor->specialization ?? 'غير محدد' }}
                    </span>
                </div>
            </div>

            <!-- Account Information -->
            <div class="detail-section">
                <h3 class="section-title">
                    <i class="fas fa-shield-alt"></i>
                    معلومات الحساب
                </h3>
                <div class="detail-item">
                    <span class="detail-label">حالة الحساب</span>
                    <span class="detail-value">
                        <span class="status-badge {{ $doctor->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $doctor->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">نوع الحساب</span>
                    <span class="detail-value">
                        @if($doctor->is_partner)
                            <span class="status-badge partner-badge">طبيب شريك</span>
                        @else
                            طبيب عادي
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">تاريخ الإنشاء</span>
                    <span class="detail-value">{{ $doctor->created_at->format('Y/m/d H:i') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">آخر تحديث</span>
                    <span class="detail-value">{{ $doctor->updated_at->format('Y/m/d H:i') }}</span>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="detail-section">
                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    المعلومات الأكاديمية
                </h3>
                <div class="detail-item">
                    <span class="detail-label">الكلية</span>
                    <span class="detail-value {{ $doctor->college ? '' : 'null' }}">
                        {{ $doctor->college->name ?? 'غير محدد' }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">الجامعة</span>
                    <span class="detail-value {{ $doctor->college && $doctor->college->university ? '' : 'null' }}">
                        {{ $doctor->college->university->name ?? 'غير محدد' }}
                    </span>
                </div>
            </div>

            <!-- Bio Section -->
            <div class="detail-section bio-section">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    السيرة الذاتية
                </h3>
                <div class="bio-content {{ $doctor->bio ? '' : 'null' }}">
                    @if($doctor->bio)
                        {{ $doctor->bio }}
                    @else
                        <i class="fas fa-info-circle me-2"></i>
                        لم يتم إضافة سيرة ذاتية بعد
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
