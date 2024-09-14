@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Kelas</h5>
                            <p class="card-text">{{ $kelasCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Siswa</h5>
                            <p class="card-text">{{ $studentCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Guru</h5>
                            <p class="card-text">{{ $teacherCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Siswa Terlambat</h5>
                            <p class="card-text">{{ $lateCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Siswa Tepat Waktu</h5>
                            <p class="card-text">{{ $onTimeCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Siswa Tidak Absen</h5>
                            <p class="card-text">{{ $noAttendanceCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Kehadiran</h5>
                            <canvas id="attendanceChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>

    <script>
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Terlambat', 'Tepat Waktu', 'Tidak Absen'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: [{{ $lateCount }}, {{ $onTimeCount }}, {{ $noAttendanceCount }}],
                    backgroundColor: ['#dc3545', '#28a745', '#6c757d'],
                    borderColor: ['#c82333', '#218838', '#5a6268'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
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
@endpush
