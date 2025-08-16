@extends('Admin.layout')

@section('styles')
<style>
    .universities-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .page-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }
    
    .page-subtitle {
        color: #94a3b8;
        font-size: 1.1rem;
        margin: 0.5rem 0 0 0;
    }
    
    .add-btn {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .universities-table {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
    }
    
    .table {
        margin: 0;
        color: #fff;
    }
    
    .table thead th {
        background: rgba(255,255,255,0.05);
        border: none;
        color: #94a3b8;
        font-weight: 600;
        padding: 1.5rem 1rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background: rgba(255,255,255,0.02);
    }
    
    .table tbody tr:last-child {
        border-bottom: none;
    }
    
    .table tbody td {
        padding: 1.5rem 1rem;
        border: none;
        vertical-align: middle;
    }
    
    .university-name {
        font-weight: 600;
        color: #fff;
        font-size: 1.1rem;
    }
    
    .colleges-count {
        background: rgba(56,189,248,0.1);
        color: #38bdf8;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        color: white;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        color: white;
        text-decoration: none;
    }
    
    /* Modal Styles */
    .modal-content {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem 2rem;
    }
    
    .modal-title {
        color: #fff;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    .modal-body {
        padding: 2rem;
    }
    
    .form-label {
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
    }
    
    .form-control::placeholder {
        color: #64748b;
    }
    
    .modal-footer {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 1.5rem 2rem;
    }
    
    .btn-secondary {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #94a3b8;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-primary:disabled {
        opacity: 0.6;
        transform: none;
    }
    
    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
    
    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
    }
    
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border-left: 4px solid #10b981;
    }
    
    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-left: 4px solid #ef4444;
    }
    
    /* Custom Pagination - Complete Override */
    .custom-pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 0.5rem !important;
        margin-top: 2rem !important;
        list-style: none !important;
        padding: 0 !important;
        flex-wrap: wrap !important;
    }
    
    .custom-pagination .page-item {
        margin: 0 !important;
        padding: 0 !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
    }
    
    .custom-pagination .page-link {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #94a3b8 !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        min-width: 45px !important;
        text-align: center !important;
        display: block !important;
        font-size: 0.9rem !important;
        font-weight: 500 !important;
        line-height: 1 !important;
        margin: 0 !important;
        box-shadow: none !important;
        outline: none !important;
    }
    
    .custom-pagination .page-link:hover {
        background: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.2) !important;
        color: #fff !important;
        text-decoration: none !important;
        transform: translateY(-1px) !important;
    }
    
    .custom-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border-color: #10b981 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
    }
    
    .custom-pagination .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
        cursor: not-allowed !important;
        opacity: 0.5 !important;
    }
    
    .custom-pagination .page-item.disabled .page-link:hover {
        transform: none !important;
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
    }
    
    .custom-pagination .page-link:focus {
        box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.25) !important;
        outline: none !important;
    }
    
    /* Hide default Laravel pagination */
    .pagination:not(.custom-pagination) {
        display: none !important;
    }
    
    /* Pagination container */
    .pagination-container {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
        margin-top: 2rem !important;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #94a3b8;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .empty-state h4 {
        color: #fff;
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('main')
<div class="universities-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">الجامعات</h1>
                <p class="page-subtitle">إدارة الجامعات والكليات المرتبطة بها</p>
            </div>
            <div class="col-md-6 text-md-end">
                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#createUniversityModal">
                    <i class="fa fa-plus"></i>
                    إضافة جامعة جديدة
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Universities Table -->
    <div class="universities-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الجامعة</th>
                        <th>عدد الكليات</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="universitiesTableBody">
                    @forelse($universities as $university)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="university-name">{{ $university->name }}</span>
                        </td>
                        <td>
                            <span class="colleges-count">{{ $university->colleges_count }} كلية</span>
                        </td>
                        <td>{{ $university->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.universities.colleges.index', $university) }}" class="btn-view" title="عرض الكليات">
                                    <i class="fa fa-eye"></i>
                                    الكليات
                                </a>
                                                        <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editUniversityModal{{ $university->id }}">
                            <i class="fa fa-edit"></i>
                            تعديل
                        </button>
                                <button type="button" class="btn-delete" onclick="deleteUniversity({{ $university->id }})">
                                    <i class="fa fa-trash"></i>
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fa fa-university"></i>
                                <h4>لا توجد جامعات</h4>
                                <p>ابدأ بإضافة أول جامعة إلى النظام</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Pagination -->
    @if($universities->hasPages())
    <div class="pagination-container">
        <ul class="custom-pagination">
            {{-- Previous Page Link --}}
            @if ($universities->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">السابق</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $universities->previousPageUrl() }}" rel="prev">السابق</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($universities->getUrlRange(1, $universities->lastPage()) as $page => $url)
                @if ($page == $universities->currentPage())
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
            @if ($universities->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $universities->nextPageUrl() }}" rel="next">التالي</a>
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

<!-- Create University Modal -->
<div class="modal fade" id="createUniversityModal" tabindex="-1" aria-labelledby="createUniversityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.universities.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUniversityModalLabel">إضافة جامعة جديدة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createUniversityName" class="form-label">اسم الجامعة</label>
                        <input type="text" class="form-control" id="createUniversityName" name="name" placeholder="أدخل اسم الجامعة" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة الجامعة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit University Modals -->
@foreach($universities as $university)
<div class="modal fade" id="editUniversityModal{{ $university->id }}" tabindex="-1" aria-labelledby="editUniversityModalLabel{{ $university->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.universities.update', $university->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUniversityModalLabel{{ $university->id }}">تعديل الجامعة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editUniversityName{{ $university->id }}" class="form-label">اسم الجامعة</label>
                        <input type="text" class="form-control" id="editUniversityName{{ $university->id }}" name="name" value="{{ $university->name }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection

@section('scripts')
<script>
// Delete University
function deleteUniversity(id) {
    if (confirm('هل أنت متأكد من حذف هذه الجامعة؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.universities.destroy', '') }}/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
