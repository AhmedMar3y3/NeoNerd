@extends('Doctor.layout')

@section('styles')
<style>
    .assistants-container {
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
    
    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .stat-number {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
        margin: 0;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-total .stat-icon { color: #3b82f6; }
    .stat-active .stat-icon { color: #10b981; }
    .stat-recent .stat-icon { color: #8b5cf6; }
    
    /* Assistants Grid */
    .assistants-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .assistant-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
    }
    
    .assistant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.4);
    }
    
    .assistant-avatar {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .assistant-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .assistant-avatar .placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .assistant-badges {
        position: absolute;
        top: 1rem;
        right: 1rem;
        display: flex;
        gap: 0.5rem;
    }
    
    .assistant-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-active {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .assistant-content {
        padding: 1.5rem;
    }
    
    .assistant-name {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    
    .assistant-email {
        color: #94a3b8;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .assistant-date {
        color: #64748b;
        font-size: 0.8rem;
        margin-bottom: 1.5rem;
    }
    
    .assistant-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-toggle {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
    }
    
    .btn-toggle.inactive {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Add Assistant Button */
    .add-assistant-section {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .btn-add-assistant {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .btn-add-assistant:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        color: #6b7280;
    }
    
    .empty-state h3 {
        color: #fff;
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
    }
    
    .empty-state p {
        margin-bottom: 2rem;
        font-size: 1rem;
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .assistants-grid {
            grid-template-columns: 1fr;
        }
        
        .assistant-actions {
            flex-direction: column;
        }
        
        .page-title {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('main')
<div class="assistants-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">إدارة المساعدين</h1>
        <p class="page-subtitle">إدارة مساعديك ومراقبة نشاطهم</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <i class="fas fa-users stat-icon"></i>
            <div class="stat-number">{{ $statistics['total'] }}</div>
            <div class="stat-label">إجمالي المساعدين</div>
        </div>
        <div class="stat-card stat-active">
            <i class="fas fa-check-circle stat-icon"></i>
            <div class="stat-number">{{ $statistics['active'] }}</div>
            <div class="stat-label">المساعدين النشطين</div>
        </div>
        <div class="stat-card stat-recent">
            <i class="fas fa-clock stat-icon"></i>
            <div class="stat-number">{{ $statistics['recent'] }}</div>
            <div class="stat-label">المساعدين الجدد</div>
        </div>
    </div>

    <!-- Add Assistant Button -->
    <div class="add-assistant-section">
        <a href="{{ route('doctor.assistants.create') }}" class="btn-add-assistant">
            <i class="fas fa-plus"></i>
            إضافة مساعد جديد
        </a>
    </div>

    <!-- Assistants Grid -->
    @if($assistants->count() > 0)
        <div class="assistants-grid">
            @foreach($assistants as $assistant)
            <div class="assistant-card">
                <div class="assistant-avatar">
                    <div class="placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="assistant-badges">
                        <span class="assistant-badge {{ $assistant->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $assistant->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </div>
                </div>
                <div class="assistant-content">
                    <h3 class="assistant-name">{{ $assistant->name }}</h3>
                    <p class="assistant-email">{{ $assistant->email }}</p>
                    <p class="assistant-date">تم الإنشاء: {{ $assistant->created_at->format('Y-m-d') }}</p>
                    <div class="assistant-actions">
                        <form action="{{ route('doctor.assistants.toggle-status', $assistant->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-action btn-toggle {{ !$assistant->is_active ? 'inactive' : '' }}" title="{{ $assistant->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                <i class="fas {{ $assistant->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                {{ $assistant->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                            </button>
                        </form>
                        <a href="{{ route('doctor.assistants.edit', $assistant->id) }}" class="btn-action btn-edit">
                            <i class="fas fa-edit"></i>
                            تعديل
                        </a>
                        <form action="{{ route('doctor.assistants.destroy', $assistant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المساعد؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($assistants->hasPages())
        <div class="pagination-container">
            <ul class="custom-pagination">
                {{-- Previous Page Link --}}
                @if ($assistants->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">السابق</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $assistants->previousPageUrl() }}" rel="prev">السابق</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($assistants->getUrlRange(1, $assistants->lastPage()) as $page => $url)
                    @if ($page == $assistants->currentPage())
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
                @if ($assistants->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $assistants->nextPageUrl() }}" rel="next">التالي</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">التالي</span>
                    </li>
                @endif
            </ul>
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <h3>لا توجد مساعدين</h3>
            <p>ابدأ بإضافة مساعد جديد لإدارة دوراتك</p>
        </div>
    @endif
</div>
@endsection
