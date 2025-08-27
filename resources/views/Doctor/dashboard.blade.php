@extends('Doctor.layout')

@section('styles')
<style>
    .dashboard-container {
        padding: 2rem 0;
        min-height: 100vh;
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    }
    
    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 20px;
        padding: 3rem;
        margin-bottom: 3rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
        position: relative;
        overflow: hidden;
        animation: slideInUp 0.8s ease-out;
    }
    
    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(56, 189, 248, 0.1) 50%, transparent 70%);
        animation: shimmer 3s infinite;
    }
    
    .welcome-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }
    
    .welcome-greeting {
        color: #38bdf8;
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 1rem;
        opacity: 0;
        animation: fadeInUp 0.8s ease-out 0.2s forwards;
    }
    
    .welcome-title {
        color: #fff;
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 50%, #0891b2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        opacity: 0;
        animation: fadeInUp 0.8s ease-out 0.4s forwards;
    }
    
    .welcome-subtitle {
        color: #94a3b8;
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0;
        animation: fadeInUp 0.8s ease-out 0.6s forwards;
    }
    
    .welcome-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        opacity: 0;
        animation: fadeInUp 0.8s ease-out 0.8s forwards;
    }
    
    .welcome-stat {
        text-align: center;
        padding: 1rem 2rem;
        background: rgba(255,255,255,0.05);
        border-radius: 15px;
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
    }
    
    .welcome-stat-number {
        color: #38bdf8;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .welcome-stat-label {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .stat-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: slideInUp 0.8s ease-out forwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .stat-card:nth-child(6) { animation-delay: 0.6s; }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s;
    }
    
    .stat-card:hover::before {
        left: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    
    .stat-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        filter: blur(20px);
        opacity: 0.3;
    }
    
    .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .trend-up {
        color: #10b981;
    }
    
    .trend-down {
        color: #ef4444;
    }
    
    .stat-number {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stat-label {
        color: #94a3b8;
        font-size: 1rem;
        margin-bottom: 1rem;
    }
    
    .stat-description {
        color: #64748b;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    /* Icon Colors */
    .stat-courses .stat-icon { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .stat-units .stat-icon { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .stat-lessons .stat-icon { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    .stat-subscriptions .stat-icon { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .stat-assistants .stat-icon { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .stat-revenue .stat-icon { background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%); }
    
    /* Recent Activities */
    .activities-section {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.1);
        opacity: 0;
        animation: slideInUp 0.8s ease-out 0.7s forwards;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    
    .section-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-title i {
        color: #38bdf8;
    }
    
    .view-all-btn {
        background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .view-all-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(56, 189, 248, 0.3);
        color: #fff;
        text-decoration: none;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: rgba(255,255,255,0.02);
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        background: rgba(255,255,255,0.05);
        transform: translateX(5px);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        color: #fff;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        color: #94a3b8;
        font-size: 0.85rem;
    }
    
    .activity-status {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-new { background: rgba(16, 185, 129, 0.2); color: #10b981; }
    .status-updated { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
    .status-completed { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
        opacity: 0;
        animation: slideInUp 0.8s ease-out 0.9s forwards;
    }
    
    .quick-action-card {
        background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }
    
    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.3);
        text-decoration: none;
    }
    
    .quick-action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: #fff;
    }
    
    .quick-action-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .quick-action-desc {
        color: #94a3b8;
        font-size: 0.9rem;
    }
    
    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .welcome-title {
            font-size: 2.5rem;
        }
        
        .welcome-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('main')
<div class="dashboard-container" dir="rtl">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="welcome-greeting">
                <i class="fas fa-sun"></i>
                {{ $greeting ?? 'مرحباً' }}
            </div>
            <h1 class="welcome-title">
                {{ Auth::guard('doctor')->user()->name }}
            </h1>
            <p class="welcome-subtitle">
                مرحباً بك في لوحة التحكم الخاصة بك. استعد لإلهام طلابك وإحداث فرق في حياتهم التعليمية
            </p>
            <div class="welcome-stats">
                <div class="welcome-stat">
                    <div class="welcome-stat-number">{{ $totalCourses ?? 0 }}</div>
                    <div class="welcome-stat-label">دورة</div>
                </div>
                <div class="welcome-stat">
                    <div class="welcome-stat-number">{{ $totalStudents ?? 0 }}</div>
                    <div class="welcome-stat-label">طالب</div>
                </div>
                <div class="welcome-stat">
                    <div class="welcome-stat-number">{{ $totalLessons ?? 0 }}</div>
                    <div class="welcome-stat-label">درس</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card stat-courses">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12%</span>
                </div>
            </div>
            <div class="stat-number">{{ $totalCourses ?? 0 }}</div>
            <div class="stat-label">إجمالي الدورات</div>
            <div class="stat-description">عدد الدورات التي قمت بإنشائها</div>
        </div>

        <div class="stat-card stat-units">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>8%</span>
                </div>
            </div>
            <div class="stat-number">{{ $totalUnits ?? 0 }}</div>
            <div class="stat-label">إجمالي الوحدات</div>
            <div class="stat-description">عدد الوحدات في جميع الدورات</div>
        </div>

        <div class="stat-card stat-lessons">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>15%</span>
                </div>
            </div>
            <div class="stat-number">{{ $totalLessons ?? 0 }}</div>
            <div class="stat-label">إجمالي الدروس</div>
            <div class="stat-description">عدد الدروس في جميع الوحدات</div>
        </div>

        <div class="stat-card stat-subscriptions">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>23%</span>
                </div>
            </div>
            <div class="stat-number">{{ $totalSubscriptions ?? 0 }}</div>
            <div class="stat-label">إجمالي الاشتراكات</div>
            <div class="stat-description">عدد الطلاب المشتركين في دوراتك</div>
        </div>

        <div class="stat-card stat-assistants">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>5%</span>
                </div>
            </div>
            <div class="stat-number">{{ $totalAssistants ?? 0 }}</div>
            <div class="stat-label">المساعدين النشطين</div>
            <div class="stat-description">عدد المساعدين الذين يعملون معك</div>
        </div>

        <div class="stat-card stat-revenue">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-trend trend-up">
                    <i class="fas fa-arrow-up"></i>
                    <span>18%</span>
                </div>
            </div>
            <div class="stat-number">{{ number_format($totalRevenue ?? 0) }}</div>
            <div class="stat-label">إجمالي الإيرادات</div>
            <div class="stat-description">الإيرادات من اشتراكات الدورات</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('doctor.courses.create') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <i class="fas fa-plus"></i>
            </div>
            <div class="quick-action-title">إنشاء دورة جديدة</div>
            <div class="quick-action-desc">ابدأ في إنشاء دورة تعليمية جديدة</div>
        </a>
        
        <a href="{{ route('doctor.subscriptions.create') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="quick-action-title">إضافة طالب</div>
            <div class="quick-action-desc">أضف طالب جديد إلى إحدى دوراتك</div>
        </a>
        
        <a href="{{ route('doctor.assistants.create') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="quick-action-title">إضافة مساعد</div>
            <div class="quick-action-desc">عين مساعد جديد لمساعدتك</div>
        </a>
        
        <a href="{{ route('doctor.subscriptions.index') }}" class="quick-action-card">
            <div class="quick-action-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="quick-action-title">عرض الإحصائيات</div>
            <div class="quick-action-desc">راجع إحصائيات دوراتك وطلابك</div>
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add some interactive animations
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add pulse animation to welcome stats
    const welcomeStats = document.querySelectorAll('.welcome-stat');
    welcomeStats.forEach((stat, index) => {
        stat.style.animationDelay = `${1 + index * 0.2}s`;
        stat.style.animation = 'pulse 2s infinite';
    });
});
</script>
@endsection