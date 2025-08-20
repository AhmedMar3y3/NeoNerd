@extends('Admin.layout')

@section('styles')
<style>
    .course-details-container {
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
    
    /* Course Info Card */
    .course-info-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .course-header {
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .course-image {
        width: 120px;
        height: 120px;
        border-radius: 15px;
        object-fit: cover;
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 3rem;
    }
    
    .course-basic-info h2 {
        color: #fff;
        margin: 0 0 0.5rem 0;
        font-size: 2rem;
        font-weight: 700;
    }
    
    .course-basic-info p {
        color: #94a3b8;
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
        line-height: 1.6;
    }
    
    .course-stats {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .stat-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        text-align: center;
        min-width: 100px;
    }
    
    .stat-number {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 0.8rem;
        margin: 0;
    }
    
    /* Course Details Grid */
    .course-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .detail-card {
        background: rgba(255,255,255,0.05);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .detail-title {
        color: #38bdf8;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .detail-content {
        color: #fff;
        font-size: 1rem;
        line-height: 1.6;
    }
    
    .detail-content p {
        margin: 0 0 0.5rem 0;
    }
    
    .detail-content p:last-child {
        margin-bottom: 0;
    }
    
    /* Status Badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        min-width: 80px;
        display: inline-block;
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
    
    .price-badge {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    .free-badge {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    /* Rating Stars */
    .rating-stars {
        color: #fbbf24;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .rating-text {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    /* Units and Lessons Section */
    .units-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .section-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .units-list {
        display: grid;
        gap: 1rem;
    }
    
    .unit-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .unit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .unit-title {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    
    .lessons-count {
        background: rgba(56, 189, 248, 0.2);
        color: #38bdf8;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .lessons-list {
        display: grid;
        gap: 0.75rem;
    }
    
    .lesson-item {
        background: rgba(255,255,255,0.03);
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .lesson-info h5 {
        color: #fff;
        font-size: 1rem;
        font-weight: 500;
        margin: 0 0 0.25rem 0;
    }
    
    .lesson-details {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .lesson-detail {
        color: #94a3b8;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .lesson-free-badge {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        padding: 0.2rem 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
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
        .course-header {
            flex-direction: column;
            text-align: center;
        }
        
        .course-stats {
            justify-content: center;
        }
        
        .course-details-grid {
            grid-template-columns: 1fr;
        }
        
        .unit-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .lesson-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="course-details-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تفاصيل الدورة</h1>
        <p class="page-subtitle">{{ $course->title }}</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Course Info Card -->
    <div class="course-info-card">
        <div class="course-header">
            <div class="course-image">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;">
                @else
                    {{ strtoupper(substr($course->title, 0, 1)) }}
                @endif
            </div>
            <div class="course-basic-info">
                <h2>{{ $course->title }}</h2>
                <p>{{ $course->description }}</p>
                <div class="course-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $course->units->count() }}</div>
                        <div class="stat-label">الوحدات</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $course->lessons->count() }}</div>
                        <div class="stat-label">الدروس</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $course->rating }}</div>
                        <div class="stat-label">التقييم</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $course->ratings_count }}</div>
                        <div class="stat-label">التقييمات</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Details Grid -->
        <div class="course-details-grid">
            <div class="detail-card">
                <h3 class="detail-title">
                    <i class="fas fa-info-circle"></i>
                    المعلومات الأساسية
                </h3>
                <div class="detail-content">
                    <p><strong>العنوان:</strong> {{ $course->title }}</p>
                    <p><strong>الوصف:</strong> {{ $course->description ?? 'غير محدد' }}</p>
                    <p><strong>الحالة:</strong> 
                        <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $course->is_active ? 'نشط' : 'غير نشط' }}
                        </span>
                    </p>
                    <p><strong>تاريخ الإنشاء:</strong> {{ $course->created_at->format('Y/m/d H:i') }}</p>
                    <p><strong>آخر تحديث:</strong> {{ $course->updated_at->format('Y/m/d H:i') }}</p>
                </div>
            </div>

            <div class="detail-card">
                <h3 class="detail-title">
                    <i class="fas fa-user-md"></i>
                    معلومات الطبيب
                </h3>
                <div class="detail-content">
                    <p><strong>اسم الطبيب:</strong> {{ $course->doctor->name ?? 'غير محدد' }}</p>
                    <p><strong>البريد الإلكتروني:</strong> {{ $course->doctor->email ?? 'غير محدد' }}</p>
                    <p><strong>التخصص:</strong> {{ $course->doctor->specialization ?? 'غير محدد' }}</p>
                    <p><strong>الهاتف:</strong> {{ $course->doctor->phone ?? 'غير محدد' }}</p>
                </div>
            </div>

            <div class="detail-card">
                <h3 class="detail-title">
                    <i class="fas fa-book"></i>
                    معلومات المادة
                </h3>
                <div class="detail-content">
                    <p><strong>اسم المادة:</strong> {{ $course->subject->name ?? 'غير محدد' }}</p>
                    <p><strong>نوع المادة:</strong> {{ $course->subject->type ?? 'غير محدد' }}</p>
                    <p><strong>المستوى:</strong> {{ $course->subject->level ?? 'غير محدد' }}</p>
                </div>
            </div>

            <div class="detail-card">
                <h3 class="detail-title">
                    <i class="fas fa-credit-card"></i>
                    معلومات السعر والتقييم
                </h3>
                <div class="detail-content">
                    <p><strong>السعر:</strong> 
                        @if($course->is_free)
                            <span class="free-badge">مجاني</span>
                        @else
                            <span class="price-badge">{{ $course->price }} جنيه</span>
                        @endif
                    </p>
                    <p><strong>التقييم:</strong></p>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= $course->rating ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <p class="rating-text">({{ $course->ratings_count }} تقييم)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Units and Lessons Section -->
    <div class="units-section">
        <h3 class="section-title">
            <i class="fas fa-layer-group"></i>
            الوحدات والدروس
        </h3>

        @if($course->units->count() > 0)
            <div class="units-list">
                @foreach($course->units as $unit)
                    <div class="unit-item">
                        <div class="unit-header">
                            <h4 class="unit-title">{{ $unit->title }}</h4>
                            <span class="lessons-count">{{ $unit->lessons->count() }} درس</span>
                        </div>
                        
                        @if($unit->lessons->count() > 0)
                            <div class="lessons-list">
                                @foreach($unit->lessons as $lesson)
                                    <div class="lesson-item">
                                        <div class="lesson-info">
                                            <h5>{{ $lesson->title }}</h5>
                                            <div class="lesson-details">
                                                @if($lesson->duration)
                                                    <span class="lesson-detail">
                                                        <i class="fas fa-clock"></i>
                                                        {{ $lesson->duration }}
                                                    </span>
                                                @endif
                                                @if($lesson->video_url)
                                                    <span class="lesson-detail">
                                                        <i class="fas fa-video"></i>
                                                        فيديو
                                                    </span>
                                                @endif
                                                @if($lesson->has_file)
                                                    <span class="lesson-detail">
                                                        <i class="fas fa-file"></i>
                                                        ملف مرفق
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($lesson->is_free)
                                            <span class="lesson-free-badge">مجاني</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p style="color: #94a3b8; margin: 0;">لا توجد دروس في هذه الوحدة</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #94a3b8; text-align: center; margin: 0;">لا توجد وحدات في هذه الدورة</p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <form action="{{ route('admin.courses.toggle-status', $course->id) }}" 
              method="POST" 
              style="display: inline;">
            @csrf
            <button type="submit" 
                    class="btn-action btn-toggle">
                <i class="fas {{ $course->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                {{ $course->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
            </button>
        </form>
        
        <form action="{{ route('admin.courses.destroy', $course->id) }}" 
              method="POST" 
              style="display: inline;"
              onsubmit="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="btn-action btn-delete">
                <i class="fas fa-trash"></i>
                حذف الدورة
            </button>
        </form>
        
        <a href="{{ route('admin.courses.index') }}" class="btn-action btn-back">
            <i class="fas fa-arrow-right"></i>
            العودة للقائمة
        </a>
    </div>
</div>
@endsection
