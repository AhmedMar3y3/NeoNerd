@extends('Admin.layout')

@section('styles')
<style>
    .colleges-container {
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
    
    .university-info {
        background: rgba(56,189,248,0.1);
        border: 1px solid rgba(56,189,248,0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .university-name {
        color: #38bdf8;
        font-weight: 600;
        font-size: 1.2rem;
        margin: 0;
    }
    
    .back-btn {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .back-btn:hover {
        background: rgba(255,255,255,0.15);
        border-color: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
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
    
    .colleges-table {
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
    
    .college-name {
        font-weight: 600;
        color: #fff;
        font-size: 1.1rem;
    }
    
    .college-type {
        background: rgba(139,92,246,0.1);
        color: #8b5cf6;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .stats-badge {
        background: rgba(56,189,248,0.1);
        color: #38bdf8;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        margin: 0.25rem;
        display: inline-block;
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
    
    .form-control, .form-select {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 8px;
        color: #fff;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255,255,255,0.08);
        border-color: #38bdf8;
        box-shadow: 0 0 0 0.2rem rgba(56,189,248,0.25);
        color: #fff;
    }
    
    .form-control::placeholder {
        color: #64748b;
    }
    
    .form-select option {
        background: #1E293B;
        color: #fff;
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
    
    /* Pagination */
    .pagination {
        justify-content: center;
        margin-top: 2rem;
        gap: 0.5rem;
    }
    
    .pagination .page-item .page-link {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: #94a3b8;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 45px;
        text-align: center;
    }
    
    .pagination .page-item .page-link:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
        color: #fff;
        text-decoration: none;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-color: #10b981;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02);
        border-color: rgba(255,255,255,0.05);
        color: #64748b;
        cursor: not-allowed;
    }
    
    /* Fix duplicate pagination styles */
    .page-link {
        background: rgba(255,255,255,0.05) !important;
        border: 1px solid rgba(255,255,255,0.1) !important;
        color: #94a3b8 !important;
        border-radius: 8px !important;
        padding: 0.75rem 1rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        min-width: 45px !important;
        text-align: center !important;
    }
    
    .page-link:hover {
        background: rgba(255,255,255,0.1) !important;
        border-color: rgba(255,255,255,0.2) !important;
        color: #fff !important;
        text-decoration: none !important;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        border-color: #10b981 !important;
        color: white !important;
    }
    
    .page-item.disabled .page-link {
        background: rgba(255,255,255,0.02) !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #64748b !important;
        cursor: not-allowed !important;
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
<div class="colleges-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="page-title">كليات {{ $university->name }}</h1>
                <p class="page-subtitle">إدارة الكليات والمرتبطة بالجامعة</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.universities.index') }}" class="back-btn me-3">
                    <i class="fa fa-arrow-right"></i>
                    العودة للجامعات
                </a>
                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#createCollegeModal">
                    <i class="fa fa-plus"></i>
                    إضافة كلية جديدة
                </button>
            </div>
        </div>
    </div>

    <!-- University Info -->
    <div class="university-info">
        <h5 class="university-name">{{ $university->name }}</h5>
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

    <!-- Colleges Table -->
    <div class="colleges-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الكلية</th>
                        <th>نوع الكلية</th>
                        <th>عدد المراحل</th>
                        <th>عدد الطلاب</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="collegesTableBody">
                    @forelse($colleges as $college)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="college-name">{{ $college->name }}</span>
                        </td>
                        <td>
                            @if($college->collegeType)
                                <span class="college-type">{{ $college->collegeType->name }}</span>
                            @else
                                <span class="text-muted">غير محدد</span>
                            @endif
                        </td>
                        <td>
                            <span class="stats-badge">{{ $college->grades_count }} مرحلة</span>
                        </td>
                        <td>
                            <span class="stats-badge">{{ $college->users_count }} طالب</span>
                        </td>
                        <td>{{ $college->created_at->format('Y/m/d') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.universities.colleges.grades.index', [$university, $college]) }}" class="btn-view" title="عرض المراحل">
                                    <i class="fa fa-eye"></i>
                                    المراحل
                                </a>
                                                        <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editCollegeModal{{ $college->id }}">
                            <i class="fa fa-edit"></i>
                            تعديل
                        </button>
                                <button type="button" class="btn-delete" onclick="deleteCollege({{ $college->id }})">
                                    <i class="fa fa-trash"></i>
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fa fa-graduation-cap"></i>
                                <h4>لا توجد كليات</h4>
                                <p>ابدأ بإضافة أول كلية إلى {{ $university->name }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($colleges->hasPages())
    <div class="d-flex justify-content-center">
        {{ $colleges->links() }}
    </div>
    @endif
</div>

<!-- Create College Modal -->
<div class="modal fade" id="createCollegeModal" tabindex="-1" aria-labelledby="createCollegeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.universities.colleges.store', $university) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createCollegeModalLabel">إضافة كلية جديدة</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createCollegeName" class="form-label">اسم الكلية</label>
                        <input type="text" class="form-control" id="createCollegeName" name="name" placeholder="أدخل اسم الكلية" required>
                    </div>
                    <div class="mb-3">
                        <label for="createCollegeType" class="form-label">نوع الكلية</label>
                        <select class="form-select" id="createCollegeType" name="college_type_id">
                            <option value="">اختر نوع الكلية</option>
                            @foreach(\App\Models\CollegeType::active()->get() as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إضافة الكلية</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit College Modals -->
@foreach($colleges as $college)
<div class="modal fade" id="editCollegeModal{{ $college->id }}" tabindex="-1" aria-labelledby="editCollegeModalLabel{{ $college->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.universities.colleges.update', [$university, $college->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCollegeModalLabel{{ $college->id }}">تعديل الكلية</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editCollegeName{{ $college->id }}" class="form-label">اسم الكلية</label>
                        <input type="text" class="form-control" id="editCollegeName{{ $college->id }}" name="name" value="{{ $college->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCollegeType{{ $college->id }}" class="form-label">نوع الكلية</label>
                        <select class="form-select" id="editCollegeType{{ $college->id }}" name="college_type_id">
                            <option value="">اختر نوع الكلية</option>
                            @foreach(\App\Models\CollegeType::active()->get() as $type)
                                <option value="{{ $type->id }}" {{ $college->college_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
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
// Delete College
function deleteCollege(id) {
    if (confirm('هل أنت متأكد من حذف هذه الكلية؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.universities.colleges.destroy', [$university, '']) }}/${id}`;
        
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
