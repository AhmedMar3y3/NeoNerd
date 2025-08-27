@extends('Assistant.layout')

@section('title', 'لوحة التحكم')

@section('styles')
<style>
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
    }

    .greeting {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .welcome-message {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #4a5568;
        position: relative;
        overflow: hidden;
    }

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
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        border-color: #667eea;
    }

    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .recent-activities {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #4a5568;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #e2e8f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        border-left: 4px solid #667eea;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: rgba(255,255,255,0.1);
        transform: translateX(5px);
    }

    .activity-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        color: #667eea;
        width: 40px;
        text-align: center;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 0.25rem;
    }

    .activity-time {
        font-size: 0.85rem;
        color: #a0aec0;
    }

    .quick-actions {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #4a5568;
    }

    .action-grid {
        display: grid;
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .action-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        width: 30px;
        text-align: center;
    }

    .doctor-info {
        background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        border-radius: 15px;
        padding: 1.5rem;
        border: 1px solid #4a5568;
        margin-bottom: 2rem;
    }

    .doctor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1rem;
    }

    .doctor-name {
        text-align: center;
        font-size: 1.2rem;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 0.5rem;
    }

    .doctor-role {
        text-align: center;
        color: #a0aec0;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .greeting {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
</style>
@endsection

@section('main')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <h1 class="greeting">{{ $greeting }}</h1>
            <p class="welcome-message">مرحباً بك في لوحة تحكم المساعد، يمكنك إدارة اشتراكات الدورات بسهولة</p>
        </div>
    </div>

    <!-- Doctor Info Section -->
    <div class="doctor-info">
        <div class="doctor-avatar pulse">
            <i class="fas fa-user-md"></i>
        </div>
        <div class="doctor-name">{{ $assistant->doctor->name }}</div>
        <div class="doctor-role">الدكتور المسؤول</div>
    </div>

    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_courses'] }}</div>
            <div class="stat-label">الدورات المتاحة</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_units'] }}</div>
            <div class="stat-label">الوحدات</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-play-circle"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_lessons'] }}</div>
            <div class="stat-label">الدروس</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-number">{{ $statistics['total_subscriptions'] }}</div>
            <div class="stat-label">الاشتراكات</div>
        </div>

    </div>

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="section-title">
                <i class="fas fa-bolt"></i>
                الإجراءات السريعة
            </h3>
            
            <div class="action-grid">
                <a href="{{ route('assistant.subscriptions.index') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <span>إدارة الاشتراكات</span>
                </a>

                <a href="{{ route('assistant.subscriptions.create') }}" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span>إنشاء اشتراك جديد</span>
                </a>

                <a href="{{ route('assistant.subscriptions.index') }}?status=active" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span>الاشتراكات المفعلة</span>
                </a>

                <a href="{{ route('assistant.subscriptions.index') }}?status=inactive" class="action-btn">
                    <div class="action-icon">
                        <i class="fas fa-pause-circle"></i>
                    </div>
                    <span>الاشتراكات المتوقفة</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection