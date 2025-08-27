@extends('Doctor.layout')

@section('styles')
<style>
    .content-subscriptions-container {
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
    
    /* Course Info Card */
    .course-info-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 2rem;
    }
    
    .course-image {
        width: 120px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .course-details h3 {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
    }
    
    .course-details p {
        color: #94a3b8;
        font-size: 1rem;
        margin: 0 0 0.25rem 0;
    }
    
    .course-stats {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #e2e8f0;
        font-size: 0.9rem;
    }
    
    /* Subscriptions Table */
    .subscriptions-table {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden;
    }
    
    .table {
        width: 100%;
        margin-bottom: 0;
        color: #e2e8f0;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th {
        background: rgba(255,255,255,0.05);
        color: #f8fafc;
        font-weight: 600;
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        text-align: right;
        font-size: 0.9rem;
    }
    
    .table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.02);
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .user-details {
        display: flex;
        flex-direction: column;
    }
    
    .user-name {
        color: #fff;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .user-email {
        color: #94a3b8;
        font-size: 0.8rem;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
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
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        color: #fff;
    }
    
    .btn-warning-sm {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-success-sm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-danger-sm {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    /* Back Button */
    .back-button {
        margin-bottom: 2rem;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        color: #fff;
        margin-bottom: 0.5rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .course-info-card {
            flex-direction: column;
            text-align: center;
        }
        
        .course-stats {
            justify-content: center;
        }
        
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="content-subscriptions-container" dir="rtl">
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('doctor.subscriptions.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-graduation-cap"></i>
            اشتراكات الدورة
        </h1>
        <p class="page-subtitle">عرض جميع اشتراكات هذه الدورة</p>
    </div>

    <!-- Course Info Card -->
    <div class="course-info-card">
        <img src="{{ $course->image ? Storage::disk('public')->url($course->image) : asset('defaults/course.webp') }}" 
             alt="Course Image" class="course-image">
        <div class="course-details">
            <h3>{{ $course->title }}</h3>
            <p>{{ $course->subject->display_name }}</p>
            <p>{{ $course->description }}</p>
            <div class="course-stats">
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <span>{{ $course->subscriptions->count() }} مشترك</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-play-circle"></i>
                    <span>{{ $course->units->count() }} وحدة</span>
                </div>
                <div class="stat-item">
                    <i class="fas fa-video"></i>
                    <span>{{ $course->lessons->count() }} درس</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="subscriptions-table">
        @if($course->subscriptions->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>المستخدم</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course->subscriptions as $subscription)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <img src="{{ $subscription->user->image ?? asset('defaults/profile.webp') }}" 
                                             alt="User Avatar" class="user-avatar">
                                        <div class="user-details">
                                            <div class="user-name">{{ $subscription->user->first_name }} {{ $subscription->user->last_name }}</div>
                                            <div class="user-email">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $subscription->is_active ? 'status-active' : 'status-inactive' }}">
                                        <i class="fas fa-{{ $subscription->is_active ? 'check' : 'times' }}"></i>
                                        {{ $subscription->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $subscription->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('doctor.subscriptions.show', $subscription->id) }}" 
                                           class="btn-sm btn-info" title="عرض">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('doctor.subscriptions.edit', $subscription->id) }}" 
                                           class="btn-sm btn-warning-sm" title="تعديل">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('doctor.subscriptions.toggle-status', $subscription->id) }}" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-{{ $subscription->is_active ? 'warning-sm' : 'success-sm' }}" 
                                                    title="{{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                                <i class="fa fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('doctor.subscriptions.destroy', $subscription->id) }}" 
                                              class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-sm btn-danger-sm" title="حذف">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-ticket"></i>
                <h3>لا توجد اشتراكات</h3>
                <p>لا يوجد أي مشتركين في هذه الدورة</p>
            </div>
        @endif
    </div>
</div>
@endsection
