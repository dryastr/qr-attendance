@extends('layouts.main')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Pengguna</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Tambah
                        Pengguna</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa"
                                type="button" role="tab" aria-controls="siswa" aria-selected="true">Siswa</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="guru-tab" data-bs-toggle="tab" data-bs-target="#guru"
                                type="button" role="tab" aria-controls="guru" aria-selected="false">Guru</button>
                        </li>
                    </ul>
                    <!-- Tabs Content -->
                    <div class="tab-content mt-3" id="userTabsContent">
                        <!-- Tab for Siswa (Role 'user') -->
                        <div class="tab-pane fade show active" id="siswa" role="tabpanel" aria-labelledby="siswa-tab">
                            <div class="table-responsive">
                                <table class="table table-xl" style="padding-top: 25px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users->where('role.name', 'user') as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td class="text-nowrap">
                                                    <!-- Dropdown Actions -->
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                                    Ubah
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('add-users.destroy', $user->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewUserModal{{ $user->id }}">
                                                                    Lihat Detail
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Edit User Modal -->
                                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editUserModalLabel{{ $user->id }}">Edit
                                                                Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('add-users.update', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="role_id{{ $user->id }}"
                                                                        class="form-label">Role</label>
                                                                    <select class="form-select"
                                                                        id="role_id{{ $user->id }}" name="role_id"
                                                                        required
                                                                        onchange="toggleEditFormFields('{{ $user->id }}')">
                                                                        <option value="" selected disabled>Pilih
                                                                        </option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->id }}"
                                                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div id="userFormFields{{ $user->id }}"
                                                                    class="{{ $user->role->name === 'user' ? '' : 'd-none' }}">
                                                                    <!-- User-specific Fields -->
                                                                    <div class="mb-3">
                                                                        <label for="nis{{ $user->id }}"
                                                                            class="form-label">NIS</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nis{{ $user->id }}" name="nis"
                                                                            value="{{ $user->nis }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jurusan_id{{ $user->id }}"
                                                                            class="form-label">Jurusan</label>
                                                                        <select class="form-select"
                                                                            id="jurusan_id{{ $user->id }}"
                                                                            name="jurusan_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($jurusans as $jurusan)
                                                                                <option value="{{ $jurusan->id }}"
                                                                                    {{ $user->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                                                                    {{ $jurusan->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tingkat_kelas_id{{ $user->id }}"
                                                                            class="form-label">Tingkat Kelas</label>
                                                                        <select class="form-select"
                                                                            id="tingkat_kelas_id{{ $user->id }}"
                                                                            name="tingkat_kelas_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($tingkatKelas as $tingkatKelasItem)
                                                                                <option
                                                                                    value="{{ $tingkatKelasItem->id }}"
                                                                                    {{ $user->tingkat_kelas_id == $tingkatKelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $tingkatKelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kelas_id{{ $user->id }}"
                                                                            class="form-label">Kelas</label>
                                                                        <select class="form-select"
                                                                            id="kelas_id{{ $user->id }}"
                                                                            name="kelas_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($kelas as $kelasItem)
                                                                                <option value="{{ $kelasItem->id }}"
                                                                                    {{ $user->kelas_id == $kelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $kelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div id="teacherFormFields{{ $user->id }}"
                                                                    class="{{ $user->role->name === 'teacher' ? '' : 'd-none' }}">
                                                                    <!-- Teacher-specific Fields -->
                                                                    <div class="mb-3">
                                                                        <label for="mata_pelajaran_id{{ $user->id }}"
                                                                            class="form-label">Mata Pelajaran</label>
                                                                        <select class="form-select"
                                                                            id="mata_pelajaran_id{{ $user->id }}"
                                                                            name="mata_pelajaran_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($mataPelajarans as $mataPelajaran)
                                                                                <option value="{{ $mataPelajaran->id }}"
                                                                                    {{ $user->mata_pelajaran_id == $mataPelajaran->id ? 'selected' : '' }}>
                                                                                    {{ $mataPelajaran->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="name{{ $user->id }}"
                                                                        class="form-label">Nama</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name{{ $user->id }}" name="name"
                                                                        value="{{ $user->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email{{ $user->id }}"
                                                                        class="form-label">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="email{{ $user->id }}" name="email"
                                                                        value="{{ $user->email }}" required>
                                                                </div>
                                                                <div class="mb-3"
                                                                    id="passwordField{{ $user->id }}">
                                                                    <label for="password{{ $user->id }}"
                                                                        class="form-label">Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password{{ $user->id }}" name="password">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="viewUserModalLabel{{ $user->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="viewUserModalLabel{{ $user->id }}">Detail Pengguna
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Check if user role is 'user' (student) -->
                                                            @if ($user->role->name === 'user')
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                <p><strong>NIS:</strong> {{ $user->nis }}</p>
                                                                <p><strong>Jurusan:</strong>
                                                                    {{ $user->jurusan->name ?? '-' }}</p>
                                                                <p><strong>Tingkat Kelas:</strong>
                                                                    {{ $user->tingkatKelas->name ?? '-' }}</p>
                                                                <p><strong>Kelas:</strong> {{ $user->kelas->name ?? '-' }}
                                                                </p>

                                                                <!-- Check if user role is 'teacher' -->
                                                            @elseif ($user->role->name === 'teacher')
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                <p><strong>Mata Pelajaran:</strong>
                                                                    {{ $user->mataPelajaran->name ?? '-' }}</p>
                                                                <p><strong>Password:</strong> ********</p>

                                                                <!-- If role is neither 'user' nor 'teacher', display default info -->
                                                            @else
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                <!-- Add any other common fields here if needed -->
                                                            @endif
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

                        <!-- Tab for Guru (Role 'teacher') -->
                        <div class="tab-pane fade" id="guru" role="tabpanel" aria-labelledby="guru-tab">
                            <div class="table-responsive">
                                <table class="table table-xl" style="padding-top: 25px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users->where('role.name', 'teacher') as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td class="text-nowrap">
                                                    <!-- Dropdown Actions -->
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editUserModal{{ $user->id }}">
                                                                    Ubah
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('add-users.destroy', $user->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#viewUserModal{{ $user->id }}">
                                                                    Lihat Detail
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!-- Edit User Modal -->
                                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="editUserModalLabel{{ $user->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editUserModalLabel{{ $user->id }}">Edit
                                                                Pengguna</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('add-users.update', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="role_id{{ $user->id }}"
                                                                        class="form-label">Role</label>
                                                                    <select class="form-select"
                                                                        id="role_id{{ $user->id }}" name="role_id"
                                                                        required
                                                                        onchange="toggleEditFormFields('{{ $user->id }}')">
                                                                        <option value="" selected disabled>Pilih
                                                                        </option>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role->id }}"
                                                                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                                                {{ $role->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div id="userFormFields{{ $user->id }}"
                                                                    class="{{ $user->role->name === 'user' ? '' : 'd-none' }}">
                                                                    <!-- User-specific Fields -->
                                                                    <div class="mb-3">
                                                                        <label for="nis{{ $user->id }}"
                                                                            class="form-label">NIS</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nis{{ $user->id }}" name="nis"
                                                                            value="{{ $user->nis }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jurusan_id{{ $user->id }}"
                                                                            class="form-label">Jurusan</label>
                                                                        <select class="form-select"
                                                                            id="jurusan_id{{ $user->id }}"
                                                                            name="jurusan_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($jurusans as $jurusan)
                                                                                <option value="{{ $jurusan->id }}"
                                                                                    {{ $user->jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                                                                    {{ $jurusan->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tingkat_kelas_id{{ $user->id }}"
                                                                            class="form-label">Tingkat Kelas</label>
                                                                        <select class="form-select"
                                                                            id="tingkat_kelas_id{{ $user->id }}"
                                                                            name="tingkat_kelas_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($tingkatKelas as $tingkatKelasItem)
                                                                                <option
                                                                                    value="{{ $tingkatKelasItem->id }}"
                                                                                    {{ $user->tingkat_kelas_id == $tingkatKelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $tingkatKelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kelas_id{{ $user->id }}"
                                                                            class="form-label">Kelas</label>
                                                                        <select class="form-select"
                                                                            id="kelas_id{{ $user->id }}"
                                                                            name="kelas_id">
                                                                            <option value="" selected disabled>Pilih
                                                                            </option>
                                                                            @foreach ($kelas as $kelasItem)
                                                                                <option value="{{ $kelasItem->id }}"
                                                                                    {{ $user->kelas_id == $kelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $kelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div id="teacherFormFields{{ $user->id }}"
                                                                    class="{{ $user->role->name === 'teacher' ? '' : 'd-none' }}">
                                                                    <!-- Teacher-specific Fields -->
                                                                    <div class="mb-3">
                                                                        <label for="mata_pelajaran_id{{ $user->id }}"
                                                                            class="form-label">Mata Pelajaran</label>
                                                                        <select class="form-select"
                                                                            id="mata_pelajaran_id{{ $user->id }}"
                                                                            name="mata_pelajaran_id">
                                                                            @foreach ($mataPelajarans as $mataPelajaran)
                                                                                <option value="{{ $mataPelajaran->id }}"
                                                                                    {{ $user->mata_pelajaran_id == $mataPelajaran->id ? 'selected' : '' }}>
                                                                                    {{ $mataPelajaran->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kelas_id{{ $user->id }}"
                                                                            class="form-label">Kelas</label>
                                                                        <select class="form-select"
                                                                            id="kelas_id{{ $user->id }}"
                                                                            name="kelas_id">
                                                                            @foreach ($kelas as $kelasItem)
                                                                                <option value="{{ $kelasItem->id }}"
                                                                                    {{ $user->kelas_id == $kelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $kelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tingkat_kelas_id{{ $user->id }}"
                                                                            class="form-label">Tingkat Kelas</label>
                                                                        <select class="form-select"
                                                                            id="tingkat_kelas_id{{ $user->id }}"
                                                                            name="tingkat_kelas_id">
                                                                            @foreach ($tingkatKelas as $tingkatKelasItem)
                                                                                <option
                                                                                    value="{{ $tingkatKelasItem->id }}"
                                                                                    {{ $user->tingkat_kelas_id == $tingkatKelasItem->id ? 'selected' : '' }}>
                                                                                    {{ $tingkatKelasItem->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="name{{ $user->id }}"
                                                                        class="form-label">Nama</label>
                                                                    <input type="text" class="form-control"
                                                                        id="name{{ $user->id }}" name="name"
                                                                        value="{{ $user->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email{{ $user->id }}"
                                                                        class="form-label">Email</label>
                                                                    <input type="email" class="form-control"
                                                                        id="email{{ $user->id }}" name="email"
                                                                        value="{{ $user->email }}" required>
                                                                </div>
                                                                <div class="mb-3"
                                                                    id="passwordField{{ $user->id }}">
                                                                    <label for="password{{ $user->id }}"
                                                                        class="form-label">Password</label>
                                                                    <input type="password" class="form-control"
                                                                        id="password{{ $user->id }}"
                                                                        name="password">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan
                                                                    Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="viewUserModal{{ $user->id }}"
                                                tabindex="-1" aria-labelledby="viewUserModalLabel{{ $user->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="viewUserModalLabel{{ $user->id }}">Detail
                                                                Pengguna</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if ($user->role->name === 'user')
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                <p><strong>NIS:</strong> {{ $user->nis }}</p>
                                                                <p><strong>Jurusan:</strong>
                                                                    {{ $user->jurusan->name ?? '-' }}</p>
                                                                <p><strong>Tingkat Kelas:</strong>
                                                                    {{ $user->tingkatKelas->name ?? '-' }}</p>
                                                                <p><strong>Kelas:</strong> {{ $user->kelas->name ?? '-' }}
                                                                </p>
                                                            @elseif ($user->role->name === 'teacher')
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                                <p><strong>Jurusan:</strong>
                                                                    {{ $user->jurusan->name ?? '-' }}</p>
                                                                <p><strong>Kelas:</strong> {{ $user->kelas->name ?? '-' }}
                                                                </p>
                                                                <p><strong>Mata Pelajaran:</strong>
                                                                    {{ $user->mataPelajaran->name ?? '-' }}</p>
                                                                <p><strong>Password:</strong> ********</p>
                                                            @else
                                                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                                            @endif
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
        </div>
    </div>


    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add-users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-select" id="role_id" name="role_id" required
                                onchange="toggleCreateFormFields()">
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="userFormFields" class="d-none">
                            <!-- User-specific Fields -->
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis">
                            </div>
                            <div class="mb-3">
                                <label for="jurusan_id" class="form-label">Jurusan</label>
                                <select class="form-select" id="jurusan_id" name="jurusan_id">
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tingkat_kelas_id" class="form-label">Tingkat Kelas</label>
                                <select class="form-select" id="tingkat_kelas_id" name="tingkat_kelas_id">
                                    @foreach ($tingkatKelas as $tingkatKelasItem)
                                        <option value="{{ $tingkatKelasItem->id }}">{{ $tingkatKelasItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select class="form-select" id="kelas_id" name="kelas_id">
                                    @foreach ($kelas as $kelasItem)
                                        <option value="{{ $kelasItem->id }}">{{ $kelasItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="teacherFormFields" class="d-none">
                            <!-- Teacher-specific Fields -->
                            <div class="mb-3">
                                <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                                <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id">
                                    @foreach ($mataPelajarans as $mataPelajaran)
                                        <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Kelas, Tingkat Kelas, and Jurusan -->
                            <div class="mb-3">
                                <label for="jurusan_id_teacher" class="form-label">Jurusan</label>
                                <select class="form-select" id="jurusan_id_teacher" name="jurusan_id_teacher">
                                    @foreach ($jurusans as $jurusan)
                                        <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tingkat_kelas_id_teacher" class="form-label">Tingkat Kelas</label>
                                <select class="form-select" id="tingkat_kelas_id_teacher"
                                    name="tingkat_kelas_id_teacher">
                                    @foreach ($tingkatKelas as $tingkatKelasItem)
                                        <option value="{{ $tingkatKelasItem->id }}">{{ $tingkatKelasItem->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas_id_teacher" class="form-label">Kelas</label>
                                <select class="form-select" id="kelas_id_teacher" name="kelas_id_teacher">
                                    @foreach ($kelas as $kelasItem)
                                        <option value="{{ $kelasItem->id }}">{{ $kelasItem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3" id="passwordField">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function toggleCreateFormFields() {
            const roleId = document.getElementById('role_id').value;
            const userFields = document.getElementById('userFormFields');
            const teacherFields = document.getElementById('teacherFormFields');
            const passwordField = document.getElementById('passwordField');
            const tingkatKelasField = document.getElementById('tingkat_kelas_id');

            if (roleId == '{{ $roles->firstWhere('name', 'user')->id }}') {
                userFields.classList.remove('d-none');
                teacherFields.classList.add('d-none');
                passwordField.classList.add('d-none');
                tingkatKelasField.classList.remove('d-none'); // Show tingkat_kelas for user
            } else if (roleId == '{{ $roles->firstWhere('name', 'teacher')->id }}') {
                teacherFields.classList.remove('d-none');
                userFields.classList.add('d-none');
                passwordField.classList.remove('d-none');
                // Hide tingkat_kelas for teacher
                document.querySelectorAll('#userFormFields .form-select[id^="tingkat_kelas_id"]').forEach(field => {
                    field.classList.add('d-none');
                });
            }
        }

        function toggleEditFormFields(userId) {
            const roleId = document.getElementById(`role_id${userId}`).value;
            const userFields = document.getElementById(`userFormFields${userId}`);
            const teacherFields = document.getElementById(`teacherFormFields${userId}`);
            const passwordField = document.getElementById(`passwordField${userId}`);
            const tingkatKelasField = document.getElementById(`tingkat_kelas_id${userId}`);

            if (roleId == '{{ $roles->firstWhere('name', 'user')->id }}') {
                userFields.classList.remove('d-none');
                teacherFields.classList.add('d-none');
                passwordField.classList.add('d-none');
                tingkatKelasField.classList.remove('d-none'); // Show tingkat_kelas for user
            } else if (roleId == '{{ $roles->firstWhere('name', 'teacher')->id }}') {
                teacherFields.classList.remove('d-none');
                userFields.classList.add('d-none');
                passwordField.classList.remove('d-none');
                // Hide tingkat_kelas for teacher
                document.querySelectorAll(`#userFormFields${userId} .form-select[id^="tingkat_kelas_id"]`).forEach(
                    field => {
                        field.classList.add('d-none');
                    });
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[id^="role_id"]').forEach(select => {
                const userId = select.id.match(/\d+/)[0];
                toggleEditFormFields(userId);
            });
        });
    </script>
@endpush
