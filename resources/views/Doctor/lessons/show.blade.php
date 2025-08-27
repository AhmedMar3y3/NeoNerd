@extends('Doctor.layout')

@section('styles')
<style>
    .lesson-show-container {
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
    
    .breadcrumb-info {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin: 1rem 0;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        color: #fff;
        font-weight: 500;
    }
    
    .breadcrumb-info i {
        font-size: 1.2rem;
    }
    
    .lesson-details-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 16px rgba(0,0,0,0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .lesson-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .lesson-title {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.3;
    }
    
    .lesson-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .lesson-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .badge-free {
        background: rgba(16, 185, 129, 0.2);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .badge-paid {
        background: rgba(245, 158, 11, 0.2);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .lesson-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.1);
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
    }
    
    .lesson-info-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
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
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .info-item {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
    }
    
    .info-label {
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .info-label i {
        color: #38bdf8;
        font-size: 0.8rem;
    }
    
    .info-value {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        word-break: break-all;
    }
    
    .video-preview {
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 1.5rem;
        border: 1px solid rgba(255,255,255,0.1);
        text-align: center;
    }
    
    .video-placeholder {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        border-radius: 10px;
        padding: 3rem 2rem;
        color: #fff;
        margin-bottom: 1rem;
    }
    
    .video-placeholder i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
    }
    
    .video-placeholder h4 {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .video-placeholder p {
        color: rgba(255,255,255,0.8);
        font-size: 0.9rem;
    }
    
    .video-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .video-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .lesson-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #fff;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
    }
    
    .btn-back {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        color: #fff;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .lesson-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .lesson-title {
            font-size: 1.5rem;
        }
        
        .lesson-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .lesson-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('main')
<div class="lesson-show-container" dir="rtl">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">تفاصيل الدرس</h1>
        <p class="page-subtitle">عرض معلومات الدرس</p>
        <div class="breadcrumb-info">
            <i class="fas fa-graduation-cap"></i>
            <span>{{ $course->title }} - {{ $unit->title }} - {{ $lesson->title }}</span>
        </div>
    </div>

    <!-- Lesson Details Card -->
    <div class="lesson-details-card">
        <div class="lesson-header">
            <h2 class="lesson-title">{{ $lesson->title }}</h2>
            <div class="lesson-badges">
                @if($lesson->is_free)
                    <span class="lesson-badge badge-free">مجاني</span>
                @else
                    <span class="lesson-badge badge-paid">مدفوع</span>
                @endif
            </div>
        </div>
        
        <!-- Lesson Statistics -->
        <div class="lesson-stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $lesson->duration }}</div>
                <div class="stat-label">مدة الدرس</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $lesson->created_at->format('M Y') }}</div>
                <div class="stat-label">تاريخ الإنشاء</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $lesson->updated_at->format('M Y') }}</div>
                <div class="stat-label">آخر تحديث</div>
            </div>
        </div>
        
        <!-- Lesson Information -->
        <div class="lesson-info-section">
            <h3 class="section-title">
                <i class="fas fa-info-circle"></i>
                معلومات الدرس
            </h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-tag"></i>
                        عنوان الدرس
                    </div>
                    <div class="info-value">{{ $lesson->title }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-video"></i>
                        رابط الفيديو
                    </div>
                    <div class="info-value">
                        <a href="{{ $lesson->video_url }}" target="_blank" class="video-link">
                            <i class="fas fa-external-link-alt"></i>
                            عرض الفيديو
                        </a>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-clock"></i>
                        مدة الدرس
                    </div>
                    <div class="info-value">{{ $lesson->duration }}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-dollar-sign"></i>
                        نوع الدرس
                    </div>
                    <div class="info-value">
                        @if($lesson->is_free)
                            <span class="lesson-badge badge-free">مجاني</span>
                        @else
                            <span class="lesson-badge badge-paid">مدفوع</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Video Preview Section -->
        <div class="lesson-info-section">
            <h3 class="section-title">
                <i class="fas fa-play-circle"></i>
                معاينة الفيديو
            </h3>
            
            <div class="video-preview">
                <div class="video-placeholder">
                    <i class="fas fa-video"></i>
                    <h4>فيديو الدرس</h4>
                    <p>اضغط على الرابط أدناه لمشاهدة الفيديو</p>
                </div>
                <a href="{{ $lesson->video_url }}" target="_blank" class="video-link">
                    <i class="fas fa-play"></i>
                    مشاهدة الفيديو
                </a>
            </div>
        </div>
        
        <!-- Lesson Actions -->
        <div class="lesson-actions">
            <a href="{{ route('doctor.courses.units.lessons.edit', [$course->id, $unit->id, $lesson->id]) }}" class="btn btn-edit">
                <i class="fas fa-edit"></i>
                تعديل الدرس
            </a>
            <form action="{{ route('doctor.courses.units.lessons.destroy', [$course->id, $unit->id, $lesson->id]) }}" 
                  method="POST" 
                  style="display: inline;"
                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    <i class="fas fa-trash"></i>
                    حذف الدرس
                </button>
            </form>
            <a href="{{ route('doctor.courses.units.show', [$course->id, $unit->id]) }}" class="btn btn-back">
                <i class="fas fa-arrow-right"></i>
                العودة للوحدة
            </a>
        </div>
    </div>
</div>
@endsection
