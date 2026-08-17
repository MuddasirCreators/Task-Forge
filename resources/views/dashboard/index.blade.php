@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ================= GREETING BANNER ================= --}}
<div class="dash-hero mb-4">
    <div class="dash-hero__content">
        <h1 class="dash-hero__title">
            Good {{ now()->format('A') === 'AM' ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, 
            <span class="dash-hero__name">{{ $currentUser->name }}!</span> 👋
        </h1>
        <p class="dash-hero__subtitle">
            Here’s what’s happening with your workspace today.
        </p>
        <div class="dash-hero__badge">
            <i class="bi bi-lightning-charge-fill"></i>
            Let’s build something great today!
        </div>
    </div>

    <div class="dash-hero__image">
        <img src="{{ asset('images/right.png') }}" alt="Workspace" class="dash-hero__img">
    </div>
</div>

{{-- ================= TOP STATS ================= --}}
<div class="dash-stats mb-4">

    <div class="dash-stat-card">
        <div class="dash-stat-card__top">
            <div class="dash-stat-card__icon bg-green-soft">
                <i class="bi bi-folder2"></i>
            </div>
            <div>
                <span class="dash-stat-card__label">Total Projects</span>
                <span class="dash-stat-card__value">{{ $totalProjects }}</span>
            </div>
        </div>
        <div class="dash-stat-card__meta positive">
            <i class="bi bi-arrow-up"></i> Live data
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-card__top">
            <div class="dash-stat-card__icon bg-blue-soft">
                <i class="bi bi-check2-square"></i>
            </div>
            <div>
                <span class="dash-stat-card__label">Tasks Completed</span>
                <span class="dash-stat-card__value">{{ $doneTasks }}</span>
            </div>
        </div>
        <div class="dash-stat-card__meta positive">
            <i class="bi bi-arrow-up"></i> Live data
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-card__top">
            <div class="dash-stat-card__icon bg-orange-soft">
                <i class="bi bi-clock"></i>
            </div>
            <div>
                <span class="dash-stat-card__label">In Progress</span>
                <span class="dash-stat-card__value">{{ $progressTasks }}</span>
            </div>
        </div>
        <div class="dash-stat-card__meta">
            Live data
        </div>
    </div>

    <div class="dash-stat-card">
        <div class="dash-stat-card__top">
            <div class="dash-stat-card__icon bg-purple-soft">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <span class="dash-stat-card__label">Team Members</span>
                <span class="dash-stat-card__value">{{ $totalAdmins + $totalManagers + $totalMembers }}</span>
            </div>
        </div>
        <div class="dash-stat-card__meta positive">
            <i class="bi bi-arrow-up"></i> Live data
        </div>
    </div>

</div>

{{-- ================= MAIN GRID ================= --}}
<div class="dash-main-grid mb-4">

    {{-- Tasks Created (Last 6 Months) --}}
    <div class="tf-card">
        <div class="tf-card__header">
            <div class="tf-card__icon"><i class="bi bi-graph-up"></i></div>
            <h3 class="tf-card__title">Tasks Created (Last 6 Months)</h3>
        </div>
        <div class="tf-card__body">
            <div class="chart-box chart-box--lg">
                <canvas id="monthlyTaskChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Tasks (Top 5) --}}
    <div class="tf-card">
        <div class="tf-card__header">
            <div class="tf-card__icon"><i class="bi bi-list-task"></i></div>
            <h3 class="tf-card__title">Recent Tasks</h3>
            <a href="{{ route('tasks.index') }}" class="tf-btn tf-btn--ghost tf-btn--sm" style="margin-left:auto;">View All</a>
        </div>
        <div class="tf-card__body p-0">
            <div class="activity-list">
                @forelse($recentTasks->take(5) as $task)
                    <div class="activity-item">
                        <div class="activity-icon 
                            @if($task->status === 'Done') bg-green-soft
                            @elseif($task->status === 'In Progress') bg-blue-soft
                            @else bg-orange-soft
                            @endif">
                            <i class="bi 
                                @if($task->status === 'Done') bi-check-lg
                                @elseif($task->status === 'In Progress') bi-play-fill
                                @else bi-circle
                                @endif"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ \Illuminate\Support\Str::limit($task->title, 38) }}</div>
                            <div class="activity-meta">
                                {{ $task->project->name ?? 'No Project' }} •
                                {{ $task->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-content">
                            <div class="activity-title text-muted">No recent tasks found</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ================= BOTTOM GRID ================= --}}
<div class="dash-bottom-grid">

    {{-- Tasks Overview --}}
    <div class="tf-card">
        <div class="tf-card__header">
            <div class="tf-card__icon"><i class="bi bi-pie-chart"></i></div>
            <h3 class="tf-card__title">Tasks Overview</h3>
        </div>
        <div class="tf-card__body">
            <div class="tasks-overview-wrap">
                <div class="doughnut-wrapper">
                    <div class="chart-box chart-box--sm">
                        <canvas id="tasksOverviewChart"></canvas>
                    </div>
                    <div class="doughnut-center">
                        <span class="doughnut-total">{{ $totalTasks }}</span>
                        <span class="doughnut-label">Total Tasks</span>
                    </div>
                </div>

                <div class="tasks-overview-legend">
                    <div class="legend-row">
                        <span class="legend-dot" style="background:#16a34a;"></span>
                        <span>Completed</span>
                        <strong>{{ $doneTasks }}</strong>
                    </div>
                    <div class="legend-row">
                        <span class="legend-dot" style="background:#3b82f6;"></span>
                        <span>In Progress</span>
                        <strong>{{ $progressTasks }}</strong>
                    </div>
                    <div class="legend-row">
                        <span class="legend-dot" style="background:#f59e0b;"></span>
                        <span>Pending</span>
                        <strong>{{ $todoTasks }}</strong>
                    </div>
                    <div class="legend-row">
                        <span class="legend-dot" style="background:#ef4444;"></span>
                        <span>Overdue</span>
                        <strong>{{ $overdueTasks }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tasks by Priority --}}
    <div class="tf-card">
        <div class="tf-card__header">
            <div class="tf-card__icon"><i class="bi bi-bar-chart"></i></div>
            <h3 class="tf-card__title">Tasks by Priority</h3>
        </div>
        <div class="tf-card__body">
            <div class="priority-list">
                <div class="priority-item">
                    <div class="priority-item__left">
                        <span class="priority-dot prio-high-dot"></span>
                        <span class="priority-name">High</span>
                    </div>
                    <div class="priority-bar-wrap">
                        <div class="priority-bar">
                            <div class="priority-fill prio-high-fill" 
                                 style="width: {{ $totalTasks > 0 ? round(($highPriorityTasks / $totalTasks) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <span class="priority-count">{{ $highPriorityTasks }}</span>
                </div>

                <div class="priority-item">
                    <div class="priority-item__left">
                        <span class="priority-dot prio-medium-dot"></span>
                        <span class="priority-name">Medium</span>
                    </div>
                    <div class="priority-bar-wrap">
                        <div class="priority-bar">
                            <div class="priority-fill prio-medium-fill" 
                                 style="width: {{ $totalTasks > 0 ? round(($mediumPriorityTasks / $totalTasks) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <span class="priority-count">{{ $mediumPriorityTasks }}</span>
                </div>

                <div class="priority-item">
                    <div class="priority-item__left">
                        <span class="priority-dot prio-low-dot"></span>
                        <span class="priority-name">Low</span>
                    </div>
                    <div class="priority-bar-wrap">
                        <div class="priority-bar">
                            <div class="priority-fill prio-low-fill" 
                                 style="width: {{ $totalTasks > 0 ? round(($lowPriorityTasks / $totalTasks) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    <span class="priority-count">{{ $lowPriorityTasks }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="tf-card">
        <div class="tf-card__header">
            <div class="tf-card__icon"><i class="bi bi-info-circle"></i></div>
            <h3 class="tf-card__title">Quick Stats</h3>
        </div>
        <div class="tf-card__body">
            <div class="quick-stat">
                <div class="quick-stat__icon bg-green-soft">
                    <i class="bi bi-people"></i>
                </div>
                <div class="quick-stat__info">
                    <span class="quick-stat__label">Total Clients</span>
                    <span class="quick-stat__value">{{ $totalClients }}</span>
                </div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat__icon bg-blue-soft">
                    <i class="bi bi-kanban"></i>
                </div>
                <div class="quick-stat__info">
                    <span class="quick-stat__label">Total Tasks</span>
                    <span class="quick-stat__value">{{ $totalTasks }}</span>
                </div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat__icon bg-orange-soft">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="quick-stat__info">
                    <span class="quick-stat__label">Time Logs</span>
                    <span class="quick-stat__value">{{ $totalTimeLogs }}</span>
                </div>
            </div>
            <div class="quick-stat">
                <div class="quick-stat__icon bg-red-soft">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="quick-stat__info">
                    <span class="quick-stat__label">Overdue Tasks</span>
                    <span class="quick-stat__value">{{ $overdueTasks }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    new Chart(document.getElementById('monthlyTaskChart'), {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [{
                label: 'Tasks Created',
                data: @json($monthlyTaskCounts),
                borderColor: '#1a7a4a',
                backgroundColor: 'rgba(26, 122, 74, 0.12)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1a7a4a',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('tasksOverviewChart'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Pending', 'Overdue'],
            datasets: [{
                data: [{{ $doneTasks }}, {{ $progressTasks }}, {{ $todoTasks }}, {{ $overdueTasks }}],
                backgroundColor: ['#16a34a', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });

});
</script>
@endpush