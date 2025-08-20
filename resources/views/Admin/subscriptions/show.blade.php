@extends('Admin.layout')

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
    
    /* Detail Cards */
    .detail-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .detail-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .detail-title i {
        color: #38bdf8;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .detail-item {
        margin-bottom: 1.5rem;
    }
    
    .detail-label {
        color: #94a3b8;
        font-weight: 500;
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        color: #e2e8f0;
        font-weight: 600;
        font-size: 1.1rem;
        padding: 0.75rem;
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    /* User Profile Card */
    .user-profile-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .user-details h4 {
        color: #fff;
        font-size: 1.3rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }
    
    .user-details p {
        color: #94a3b8;
        margin: 0;
    }
    
    /* Content Card */
    .content-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .content-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .content-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
    }
    
    .content-icon.course {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }
    
    .content-icon.book {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .content-title {
        color: #fff;
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }
    
    .content-subtitle {
        color: #94a3b8;
        margin: 0;
    }
    
    .content-image {
        width: 100%;
        height: 200px;
        border-radius: 12px;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 2px solid rgba(255,255,255,0.1);
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
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: #fff;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: #fff;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        color: #fff;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: #fff;
    }
    
    .btn-light {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn-light:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        color: #fff;
    }
    
    /* Status Indicators */
    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.9rem;
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
    
    .detail-card, .user-profile-card, .content-card {
        animation: slideIn 0.3s ease-out;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            justify-content: center;
        }
        
        .user-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('main')
<div class="subscription-details-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-eye"></i>
            تفاصيل الاشتراك
        </h1>
        <p class="page-subtitle">عرض معلومات الاشتراك المحدد</p>
    </div>

    <!-- Subscription Details -->
    <div class="detail-card">
        <h2 class="detail-title">
            <i class="fa fa-info-circle"></i>
            معلومات الاشتراك الأساسية
        </h2>
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">رقم الاشتراك</span>
                <div class="detail-value">#{{ $subscription->id }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">نوع الاشتراك</span>
                <div class="detail-value">
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
            <div class="detail-item">
                <span class="detail-label">حالة الاشتراك</span>
                <div class="detail-value">
                    @if($subscription->is_active)
                        <span class="status-indicator status-active">
                            <i class="fa fa-check-circle"></i>
                            نشط
                        </span>
                    @else
                        <span class="status-indicator status-inactive">
                            <i class="fa fa-times-circle"></i>
                            غير نشط
                        </span>
                    @endif
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">تاريخ الإنشاء</span>
                <div class="detail-value">{{ $subscription->created_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">آخر تحديث</span>
                <div class="detail-value">{{ $subscription->updated_at->format('Y-m-d H:i') }}</div>
            </div>
            <div class="detail-item">
                <span class="detail-label">مدة الاشتراك</span>
                <div class="detail-value">{{ $subscription->created_at->diffForHumans() }}</div>
            </div>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="user-profile-card">
        <h2 class="detail-title">
            <i class="fa fa-user"></i>
            معلومات المستخدم
        </h2>
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr($subscription->user->first_name, 0, 1)) }}{{ strtoupper(substr($subscription->user->last_name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h4>{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</h4>
                <p>{{ $subscription->user->email }}</p>
                <p>رقم الهاتف: {{ $subscription->user->phone ?? 'غير متوفر' }}</p>
            </div>
        </div>
    </div>

    <!-- Content Information -->
    <div class="content-card">
        <h2 class="detail-title">
            <i class="fa fa-file-text"></i>
            معلومات المحتوى
        </h2>
        
        @if($subscription->subscription_type === 'course' && $subscription->course)
            <div class="content-header">
                <div class="content-icon course">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div>
                    <h3 class="content-title">{{ $subscription->course->title }}</h3>
                    <p class="content-subtitle">الدكتور: {{ $subscription->course->doctor->name ?? 'غير محدد' }}</p>
                </div>
            </div>
            
            <img src="{{ asset('defaults/subject.png') }}" alt="Course Image" class="content-image">
            
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">عنوان الدورة</span>
                    <div class="detail-value">{{ $subscription->course->title }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">الدكتور</span>
                    <div class="detail-value">{{ $subscription->course->doctor->name ?? 'غير محدد' }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">الوصف</span>
                    <div class="detail-value">{{ $subscription->course->description ?? 'غير متوفر' }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">حالة الدورة</span>
                    <div class="detail-value">
                        @if($subscription->course->is_active)
                            <span class="badge badge-success">نشطة</span>
                        @else
                            <span class="badge badge-danger">غير نشطة</span>
                        @endif
                    </div>
                </div>
            </div>
            
        @elseif($subscription->subscription_type === 'book' && $subscription->book)
            <div class="content-header">
                <div class="content-icon book">
                    <i class="fa fa-book"></i>
                </div>
                <div>
                    <h3 class="content-title">{{ $subscription->book->title }}</h3>
                    <p class="content-subtitle">الكاتب: {{ $subscription->book->author ?? 'غير محدد' }}</p>
                </div>
            </div>
            
            <img src="{{ asset('defaults/subject.png') }}" alt="Book Image" class="content-image">
            
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">عنوان الكتاب</span>
                    <div class="detail-value">{{ $subscription->book->title }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">الكاتب</span>
                    <div class="detail-value">{{ $subscription->book->author ?? 'غير محدد' }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">الوصف</span>
                    <div class="detail-value">{{ $subscription->book->description ?? 'غير متوفر' }}</div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">حالة الكتاب</span>
                    <div class="detail-value">
                        @if($subscription->book->is_active)
                            <span class="badge badge-success">متوفر</span>
                        @else
                            <span class="badge badge-danger">غير متوفر</span>
                        @endif
                    </div>
                </div>
            </div>
            
        @else
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i>
                المحتوى غير متوفر أو تم حذفه
            </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-warning">
            <i class="fa fa-edit"></i>
            تعديل الاشتراك
        </a>
        
        <form method="POST" action="{{ route('admin.subscriptions.toggle-status', $subscription->id) }}" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-toggle-on"></i>
                {{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل الاشتراك' }}
            </button>
        </form>
        
        <form method="POST" action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fa fa-trash"></i>
                حذف الاشتراك
            </button>
        </form>
        
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-light">
            <i class="fa fa-arrow-left"></i>
            رجوع للقائمة
        </a>
    </div>
</div>
@endsection
