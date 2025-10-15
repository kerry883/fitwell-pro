@extends('layouts.trainer')

@section('title', 'Analytics Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Analytics Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Performance Analytics</h1>
            <p class="text-muted mb-0">Track your performance and business metrics</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-calendar-alt me-1"></i> Last 30 Days
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-period="7">Last 7 Days</a></li>
                <li><a class="dropdown-item" href="#" data-period="30">Last 30 Days</a></li>
                <li><a class="dropdown-item" href="#" data-period="90">Last 90 Days</a></li>
                <li><a class="dropdown-item" href="#" data-period="365">Last Year</a></li>
            </ul>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($analytics['total_revenue'] ?? 0, 2) }}
                            </div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 
                                    {{ $analytics['revenue_growth'] ?? 0 }}% vs last period
                                </small>
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Sessions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $analytics['total_sessions'] ?? 0 }}
                            </div>
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-arrow-up"></i> 
                                    {{ $analytics['sessions_growth'] ?? 0 }}% vs last period
                                </small>
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-dumbbell fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Active Clients
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $analytics['active_clients'] ?? 0 }}
                            </div>
                            <div class="mt-2">
                                <small class="text-info">
                                    <i class="fas fa-user-plus"></i> 
                                    {{ $analytics['new_clients'] ?? 0 }} new this period
                                </small>
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Avg Session Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ number_format($analytics['avg_session_rate'] ?? 0, 2) }}
                            </div>
                            <div class="mt-2">
                                <small class="text-warning">
                                    <i class="fas fa-chart-line"></i> 
                                    Per session
                                </small>
                            </div>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-money-bill-wave fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>

        <!-- Sessions by Type -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sessions by Type</h6>
                </div>
                <div class="card-body">
                    <canvas id="sessionTypeChart" width="100%" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Analytics Row -->
    <div class="row">
        <!-- Client Performance -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Performing Clients</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Sessions This Month</th>
                                    <th>Total Revenue</th>
                                    <th>Progress Score</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($analytics['top_clients'] ?? [] as $client)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <span class="avatar-initials bg-primary text-white">
                                                    {{ substr($client['name'], 0, 2) }}
                                                </span>
                                            </div>
                                            <strong>{{ $client['name'] }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $client['sessions_count'] }}</td>
                                    <td>${{ number_format($client['revenue'], 2) }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: {{ $client['progress_score'] }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ $client['progress_score'] }}%</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $client['status_color'] }}">{{ $client['status'] }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-chart-line fa-2x mb-2 d-block"></i>
                                        No client data available for this period
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Insights -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Insights</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Peak Hours</span>
                            <strong>{{ $analytics['peak_hours'] ?? '9:00 AM - 11:00 AM' }}</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 75%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Client Retention</span>
                            <strong>{{ $analytics['retention_rate'] ?? 85 }}%</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $analytics['retention_rate'] ?? 85 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Avg Session Duration</span>
                            <strong>{{ $analytics['avg_session_duration'] ?? 60 }} min</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 80%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Booking Efficiency</span>
                            <strong>{{ $analytics['booking_efficiency'] ?? 92 }}%</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $analytics['booking_efficiency'] ?? 92 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Goals -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Goals Progress</h6>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#goalsModal">
                        <i class="fas fa-edit me-1"></i> Edit Goals
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">Revenue Goal</h6>
                                <div class="position-relative d-inline-block">
                                    <svg width="80" height="80" class="circular-progress">
                                        <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="8" fill="none"/>
                                        <circle cx="40" cy="40" r="35" stroke="#28a745" stroke-width="8" fill="none"
                                                stroke-dasharray="{{ 2 * pi() * 35 }}" 
                                                stroke-dashoffset="{{ 2 * pi() * 35 * (1 - ($analytics['revenue_goal_progress'] ?? 0) / 100) }}"
                                                transform="rotate(-90 40 40)"/>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <strong>{{ $analytics['revenue_goal_progress'] ?? 75 }}%</strong>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">${{ number_format($analytics['current_revenue'] ?? 0) }} / ${{ number_format($analytics['revenue_goal'] ?? 10000) }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">Sessions Goal</h6>
                                <div class="position-relative d-inline-block">
                                    <svg width="80" height="80" class="circular-progress">
                                        <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="8" fill="none"/>
                                        <circle cx="40" cy="40" r="35" stroke="#007bff" stroke-width="8" fill="none"
                                                stroke-dasharray="{{ 2 * pi() * 35 }}" 
                                                stroke-dashoffset="{{ 2 * pi() * 35 * (1 - ($analytics['sessions_goal_progress'] ?? 0) / 100) }}"
                                                transform="rotate(-90 40 40)"/>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <strong>{{ $analytics['sessions_goal_progress'] ?? 68 }}%</strong>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">{{ $analytics['current_sessions'] ?? 0 }} / {{ $analytics['sessions_goal'] ?? 100 }} sessions</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">New Clients Goal</h6>
                                <div class="position-relative d-inline-block">
                                    <svg width="80" height="80" class="circular-progress">
                                        <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="8" fill="none"/>
                                        <circle cx="40" cy="40" r="35" stroke="#17a2b8" stroke-width="8" fill="none"
                                                stroke-dasharray="{{ 2 * pi() * 35 }}" 
                                                stroke-dashoffset="{{ 2 * pi() * 35 * (1 - ($analytics['clients_goal_progress'] ?? 0) / 100) }}"
                                                transform="rotate(-90 40 40)"/>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <strong>{{ $analytics['clients_goal_progress'] ?? 40 }}%</strong>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">{{ $analytics['current_new_clients'] ?? 0 }} / {{ $analytics['clients_goal'] ?? 10 }} clients</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">Programs Goal</h6>
                                <div class="position-relative d-inline-block">
                                    <svg width="80" height="80" class="circular-progress">
                                        <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="8" fill="none"/>
                                        <circle cx="40" cy="40" r="35" stroke="#ffc107" stroke-width="8" fill="none"
                                                stroke-dasharray="{{ 2 * pi() * 35 }}" 
                                                stroke-dashoffset="{{ 2 * pi() * 35 * (1 - ($analytics['programs_goal_progress'] ?? 0) / 100) }}"
                                                transform="rotate(-90 40 40)"/>
                                    </svg>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <strong>{{ $analytics['programs_goal_progress'] ?? 85 }}%</strong>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">{{ $analytics['current_programs'] ?? 0 }} / {{ $analytics['programs_goal'] ?? 20 }} programs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($analytics['revenue_chart']['labels'] ?? []),
            datasets: [{
                label: 'Revenue',
                data: @json($analytics['revenue_chart']['data'] ?? []),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            }
        }
    });

    // Session Type Chart
    const sessionTypeCtx = document.getElementById('sessionTypeChart').getContext('2d');
    const sessionTypeChart = new Chart(sessionTypeCtx, {
        type: 'doughnut',
        data: {
            labels: @json($analytics['session_types']['labels'] ?? []),
            datasets: [{
                data: @json($analytics['session_types']['data'] ?? []),
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-initials {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 12px;
    font-weight: bold;
}

.circular-progress {
    transform: rotate(-90deg);
}

.progress {
    background-color: #f8f9fc;
}
</style>
@endpush
@endsection