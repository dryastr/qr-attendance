@extends('layouts.main')

@section('title', 'Manajemen Siswa')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Siswa</h4>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl" style="padding-top: 25px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>NIS</th>
                                    <th class="d-none">Absen Terakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nis }}</td>
                                        <td class="d-none">
                                            @php
                                                $attendance = $student->attendances
                                                    ? $student->attendances->last()
                                                    : null;
                                                $absenTime = $attendance ? $attendance->absen_at : null;
                                            @endphp
                                            @if ($absenTime)
                                                {{ \Carbon\Carbon::parse($absenTime)->format('H:i:s') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($absenTime && \Carbon\Carbon::parse($absenTime)->gt(\Carbon\Carbon::parse('07:00')))
                                                <span class="badge bg-danger">Terlambat</span>
                                            @elseif($absenTime)
                                                <span class="badge bg-success">Tepat Waktu</span>
                                            @else
                                                <span class="badge bg-secondary">Belum Absen</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $student->id }}">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Detail Siswa -->
                                    <div class="modal fade" id="detailModal{{ $student->id }}" tabindex="-1"
                                        aria-labelledby="detailModalLabel{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $student->id }}">Detail
                                                        Siswa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Nama:</strong> {{ $student->name }}</p>
                                                    <p><strong>NIS:</strong> {{ $student->nis }}</p>
                                                    <p><strong>Kelas:</strong> {{ $student->kelas->name }}</p>
                                                    <p><strong>Email:</strong> {{ $student->email }}</p>
                                                    <p><strong>Absen Terakhir:</strong>
                                                        @if ($absenTime)
                                                            {{ \Carbon\Carbon::parse($absenTime)->format('d-m-Y H:i:s') }}
                                                        @else
                                                            Tidak ada data absensi
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
