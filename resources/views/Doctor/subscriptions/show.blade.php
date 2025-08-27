@extends('Doctor.layout')

@section('styles')
<style>
    .subscription-details-container {
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
    
    /* Details Card */
    .details-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .details-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .details-title i {
        color: #38bdf8;
    }
    
    /* Details Grid */
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
    
    .detail-section-title {
        color: #38bdf8;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .detail-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    
    .detail-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .detail-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .detail-value {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
    }
    
    /* User Avatar */
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.1);
        margin-bottom: 1rem;
    }
    
    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
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
    
    /* Subscription Type Badge */
    .subscription-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    /* Course Info */
    .course-info {
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        padding: 1rem;
        border: 1px solid rgba(255,255,255,0.05);
    }
    
    .course-title {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .course-subject {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    /* Actions */
    .actions-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .actions-title {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .actions-title i {
        color: #38bdf8;
    }
    
    .actions-grid {
        display: flex;
        gap: 1rem;
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
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
        }
    }
</style>
@endsection

@section('main')
<div class="subscription-details-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-eye"></i>
            تفاصيل الاشتراك
        </h1>
        <p class="page-subtitle">عرض تفاصيل الاشتراك</p>
    </div>

    <!-- Details Card -->
    <div class="details-card">
        <h3 class="details-title">
            <i class="fas fa-info-circle"></i>
            معلومات الاشتراك
        </h3>
        
        <div class="details-grid">
            <!-- User Information -->
            <div class="detail-section">
                <h4 class="detail-section-title">
                    <i class="fas fa-user"></i>
                    معلومات المستخدم
                </h4>
                
                <div class="detail-item">
                    <img src="{{ $subscription->user->image ?? asset('defaults/profile.webp') }}" 
                         alt="User Avatar" class="user-avatar">
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">الاسم</div>
                    <div class="detail-value">{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">البريد الإلكتروني</div>
                    <div class="detail-value">{{ $subscription->user->email }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">رقم الهاتف</div>
                    <div class="detail-value">{{ $subscription->user->phone ?? 'غير محدد' }}</div>
                </div>
            </div>

            <!-- Subscription Information -->
            <div class="detail-section">
                <h4 class="detail-section-title">
                    <i class="fas fa-ticket"></i>
                    معلومات الاشتراك
                </h4>
                
                <div class="detail-item">
                    <div class="detail-label">رقم الاشتراك</div>
                    <div class="detail-value">#{{ $subscription->id }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">نوع الاشتراك</div>
                    <div class="detail-value">
                        <span class="subscription-type-badge">
                            <i class="fas fa-graduation-cap"></i>
                            دورة
                        </span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">الحالة</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $subscription->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas fa-{{ $subscription->is_active ? 'check' : 'times' }}"></i>
                            {{ $subscription->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">تاريخ الإنشاء</div>
                    <div class="detail-value">{{ $subscription->created_at->format('Y-m-d H:i') }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">آخر تحديث</div>
                    <div class="detail-value">{{ $subscription->updated_at->format('Y-m-d H:i') }}</div>
                </div>
            </div>

            <!-- Course Information -->
            <div class="detail-section">
                <h4 class="detail-section-title">
                    <i class="fas fa-graduation-cap"></i>
                    معلومات الدورة
                </h4>
                
                <div class="course-info">
                    <div class="course-title">{{ $subscription->course->title }}</div>
                    <div class="course-subject">{{ $subscription->course->subject->name }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">وصف الدورة</div>
                    <div class="detail-value">{{ $subscription->course->description ?? 'لا يوجد وصف' }}</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">سعر الدورة</div>
                    <div class="detail-value">{{ $subscription->course->price ?? 0 }} جنيه</div>
                </div>
                
                <div class="detail-item">
                    <div class="detail-label">حالة الدورة</div>
                    <div class="detail-value">
                        <span class="status-badge {{ $subscription->course->is_active ? 'status-active' : 'status-inactive' }}">
                            <i class="fas fa-{{ $subscription->course->is_active ? 'check' : 'times' }}"></i>
                            {{ $subscription->course->is_active ? 'نشطة' : 'غير نشطة' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Section -->
    <div class="actions-section">
        <h3 class="actions-title">
            <i class="fas fa-cogs"></i>
            الإجراءات
        </h3>
        
        <div class="actions-grid">
            <a href="{{ route('doctor.subscriptions.edit', $subscription->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>
                تعديل الاشتراك
            </a>
            
            <form method="POST" action="{{ route('doctor.subscriptions.toggle-status', $subscription->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-{{ $subscription->is_active ? 'warning' : 'primary' }}">
                    <i class="fas fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                    {{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                </button>
            </form>
            
            <form method="POST" action="{{ route('doctor.subscriptions.destroy', $subscription->id) }}" 
                  class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                    حذف الاشتراك
                </button>
            </form>
            
            <a href="{{ route('doctor.subscriptions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i>
                العودة للقائمة
            </a>
        </div>
    </div>
</div>
@endsection
