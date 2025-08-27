@extends('Assistant.layout')

@section('styles')
<style>
    .subscriptions-container {
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
    
    .user-info-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.1);
    }
    
    .user-details h3 {
        color: #fff;
        margin: 0 0 0.5rem 0;
        font-size: 1.5rem;
    }
    
    .user-details p {
        color: #94a3b8;
        margin: 0;
        font-size: 1rem;
    }
    
    .table-container {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        overflow: hidden;
    }
    
    .table-responsive {
        overflow-x: auto;
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
    
    .subscription-type {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .content-info h6 {
        color: #f8fafc;
        margin: 0;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .content-info small {
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
    
    .back-btn {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }
    
    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .custom-pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .page-link {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 45px;
        text-align: center;
        display: block;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .page-link:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: #10b981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.05);
        color: #64748b;
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .user-info-card {
            flex-direction: column;
            text-align: center;
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
<div class="subscriptions-container" dir="rtl">
    <!-- Back Button -->
    <a href="{{ route('assistant.subscriptions.index') }}" class="back-btn">
        <i class="fas fa-arrow-right"></i>
        العودة للقائمة
    </a>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa fa-user"></i>
            اشتراكات المستخدم
        </h1>
        <p class="page-subtitle">جميع اشتراكات {{ $user->first_name }} {{ $user->last_name }}</p>
    </div>

    <!-- User Info Card -->
    <div class="user-info-card">
        <img src="{{ $user->image ?? asset('defaults/profile.webp') }}" 
             alt="User Avatar" class="user-avatar">
        <div class="user-details">
            <h3>{{ $user->first_name }} {{ $user->last_name }}</h3>
            <p>{{ $user->email }}</p>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>نوع الاشتراك</th>
                        <th>المحتوى</th>
                        <th>الحالة</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td>
                                <span class="subscription-type">
                                    <i class="fas fa-graduation-cap"></i>
                                    دورة
                                </span>
                            </td>
                            <td>
                                <div class="content-info">
                                    <h6>{{ $subscription->course->title }}</h6>
                                    <small>{{ $subscription->course->subject->name }}</small>
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
                                    <a href="{{ route('assistant.subscriptions.show', $subscription->id) }}" 
                                       class="btn-sm btn-info" title="عرض">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('assistant.subscriptions.edit', $subscription->id) }}" 
                                       class="btn-sm btn-warning-sm" title="تعديل">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('assistant.subscriptions.toggle-status', $subscription->id) }}" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-sm btn-{{ $subscription->is_active ? 'warning-sm' : 'success-sm' }}" 
                                                title="{{ $subscription->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                            <i class="fa fa-{{ $subscription->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('assistant.subscriptions.destroy', $subscription->id) }}" 
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
    </div>

    <!-- Pagination -->
    @if($subscriptions->hasPages())
    <div class="pagination-container">
        <ul class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($subscriptions->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $subscriptions->previousPageUrl() }}" rel="prev">السابق</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($subscriptions->getUrlRange(1, $subscriptions->lastPage()) as $page => $url)
                @if ($page == $subscriptions->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($subscriptions->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $subscriptions->nextPageUrl() }}" rel="next">التالي</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">التالي</span>
                </li>
            @endif
        </ul>
    </div>
    @endif
</div>
@endsection
