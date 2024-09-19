@extends('administrator.layouts.app')
@section('title', 'List User SKF')

@section('main')
    <div class="pagetitle">
        <h1>SKF User Access</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User Access</li>
                <li class="breadcrumb-item active">SKF User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card py-4">
            <div class="card-body">
                <a href="{{ route('adduserskf') }}" class="btn btn-primary" id="btnAddUser">Add User SKF</a>
                <table class="table table-bordered table-striped text-center" id="tbskfuser"
                    style="margin-bottom: 1rem; font-weight: 500">
                    <thead>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>E-mail</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Last Access</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->dept }}</td>
                                <td>{{ $user->jabatan }}</td>
                                @if (!empty($user->last_access))
                                    <td>{{ date('d-m-Y H:i:s', strtotime($user->last_access)) }}</td>
                                @else
                                    <td>Never</td>
                                @endif
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modaleditskfusr{{ $user->id }}"><i
                                            class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-danger" id="deluserskf{{ $user->id }}"><i
                                            class="bi bi-trash"></i></button>
                                    <script>
                                        var delusrskf = document.getElementById('deluserskf' + {{ $user->id }})

                                        delusrskf.addEventListener('click', function() {
                                            Swal.fire({
                                                title: "Apakah anda yakin?",
                                                text: "Anda tidak dapat mengembalikan data user yang telah dihapus!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Ya, hapus!"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "{{ route('deleteuserskf', $user->id) }}",
                                                        data: {
                                                            _token: csrfToken,
                                                        },
                                                        success: function(response) {
                                                            Swal.fire({
                                                                title: "Deleted!",
                                                                text: "User berhasil dihapus.",
                                                                icon: "success"
                                                            }).then((result2) => {
                                                                if (result2.isConfirmed) {
                                                                    location.reload();
                                                                }
                                                            })
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error(xhr.responseText);
                                                        }
                                                    });
                                                }
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <div class="modal fade" id="modaleditskfusr{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User SKF</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row g-3">
                                            <form action="{{ route('edituserskf', $user->id) }}" method="post">
                                                @csrf
                                                <div class="col-md-6">
                                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                                    <input type="text" class="form-control" id="fullname"
                                                        name="newfullname" value="{{ $user->name }}" autocomplete="off">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="newmail"
                                                        value="{{ $user->email }}" autocomplete="off">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="dept" class="form-label">Departemen</label>
                                                    <select name="newdept" id="dept" class="form-control">
                                                        @foreach ($depts as $dept)
                                                            <option value="{{ $dept->alias }}"
                                                                {{ $user->dept == $dept->alias ? 'selected' : '' }}>
                                                                {{ $dept->nama_dept }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="newjabatan" class="form-label">Jabatan</label>
                                                    <select name="newjabatan" id="newjabatan" class="form-control">
                                                        <option value="1" {{ $user->level == '1' ? 'selected' : '' }}>Manager</option>
                                                        <option value="2" {{ $user->level == '2' ? 'selected' : '' }}>Supervisor</option>
                                                        <option value="3" {{ $user->level == '3' ? 'selected' : '' }}>Staff</option>
                                                    </select>                                                    
                                                </div>
                                                <input type="hidden" name="gol" value="{{ $user->gol }}">
                                                <div class="col-md-6">
                                                    <label for="password" class="form-label">New Password<br><span
                                                            style="font-size: 12px"><i>Don't fill this if don't want to
                                                                change
                                                                your password</i></span></label>
                                                    <input type="password" name="newpassword" class="form-control password">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="confirm_password" class="form-label"
                                                        id="pass_placeholder">Re-type your new
                                                        password<br><span style="font-size: 12px"><i>Don't fill this if you
                                                                don't want to change your password</i></span></label>
                                                    <input name="password2" type="password"
                                                        class="form-control confirm_password">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" id="editbutton" class="btn btn-primary">Save
                                                changes</button>
                                            </form><!-- End Multi Columns Form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('blockjs')
    <script>
        $("#tbskfuser").DataTable({
            dom: 'Bfrtip',
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada SKF User yang terdaftar"
            },
            pageLength: 10
        });
    </script>
@endsection
