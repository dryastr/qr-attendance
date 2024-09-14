@extends('layouts.main')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="row">
        <!-- Card: Late Attendance -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Absen Terlambat</h5>
                    <h2 class="card-text">{{ $lateCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: On-time Attendance -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Absen Tepat Waktu</h5>
                    <h2 class="card-text">{{ $onTimeCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: No Attendance -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tidak Ada Absen</h5>
                    <h2 class="card-text">{{ $noAttendanceCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Attendance Chart -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Terlambat', 'Tepat Waktu', 'Tidak Absen'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: [{{ $chartData['late'] }}, {{ $chartData['onTime'] }},
                        {{ $chartData['noAttendance'] }}
                    ],
                    backgroundColor: ['#dc3545', '#28a745', '#6c757d'],
                    borderColor: ['#c82333', '#218838', '#5a6268'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

@endsection
