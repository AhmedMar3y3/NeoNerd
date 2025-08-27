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
    
    .details-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .detail-section {
        margin-bottom: 2rem;
    }
    
    .detail-section:last-child {
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
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .detail-item {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
    }
    
    .detail-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .detail-value {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
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
    
    .subscription-type {
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
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .user-details h5 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
    }
    
    .user-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .course-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .course-image {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .course-details h5 {
        color: #fff;
        margin: 0 0 0.25rem 0;
        font-size: 1.1rem;
    }
    
    .course-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 0.9rem;
    }
    
    .actions-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255,255,255,0.1);
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
    
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
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
            <i class="fa fa-eye"></i>
            تفاصيل الاشتراك
        </h1>
        <p class="page-subtitle">عرض تفاصيل الاشتراك</p>
    </div>

    <!-- Details Card -->
    <div class="details-card">
        <!-- User Information -->
        <div class="detail-section">
            <h3 class="section-title">
                <i class="fas fa-user"></i>
                معلومات المستخدم
            </h3>
            
            <div class="detail-item">
                <div class="user-info">
                    <img src="{{ $subscription->user->image ?? asset('defaults/profile.webp') }}" 
                         alt="User Avatar" class="user-avatar">
                    <div class="user-details">
                        <h5>{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</h5>
                        <p>{{ $subscription->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Subscription Information -->
        <div class="detail-section">
            <h3 class="section-title">
                <i class="fas fa-ticket"></i>
                معلومات الاشتراك
            </h3>
            
            <div class="detail-grid">
                <div class="detail-item">
                    <div class="detail-label">نوع الاشتراك</div>
                    <div class="detail-value">
                        <span class="subscription-type">
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
        </div>
        
        <!-- Course Information -->
        <div class="detail-section">
            <h3 class="section-title">
                <i class="fas fa-graduation-cap"></i>
                معلومات الدورة
            </h3>
            
            <div class="detail-item">
                <div class="course-info">
                    <img src="{{ $subscription->course->image ? asset($subscription->course->image) : asset('defaults/course.webp') }}" 
                         alt="Course Image" class="course-image">
                    <div class="course-details">
                        <h5>{{ $subscription->course->title }}</h5>
                        <p>{{ $subscription->course->subject->name }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="actions-section">
            <h3 class="section-title">
                <i class="fas fa-cogs"></i>
                الإجراءات
            </h3>
            
            <div class="actions-grid">
                <a href="{{ route('assistant.subscriptions.edit', $subscription->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    تعديل
                </a>
                
                <form method="POST" action="{{ route('assistant.subscriptions.toggle-status', $subscription->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-{{ $subscription->is_active ? 'warning' : 'success' }}">
                        <i class="fas fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                        {{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('assistant.subscriptions.destroy', $subscription->id) }}" 
                      class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                        حذف
                    </button>
                </form>
                
                <a href="{{ route('assistant.subscriptions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
