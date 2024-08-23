@extends('administrator.layouts.app')
@section('title', 'List User Supplier')

@section('main')
    <div class="pagetitle">
        <h1>Supplier User Access</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User Access</li>
                <li class="breadcrumb-item active">Supplier User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card py-4">
            <div class="card-body">
                <a href="{{ route('addusersupplier') }}" class="btn btn-primary" id="btnAddUser">Add User Supplier</a>
                <div class="tbContainer pb-2">
                    <table class="table table-bordered table-striped text-center nowrap" id="tbsupplieruser"
                        style="margin-bottom: 1rem; font-weight: 500">
                        <thead>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>E-mail</th>
                            <th>Supplier ID</th>
                            <th>Supplier Name</th>
                            <th>Last Access</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->supplier_id }}</td>
                                    <td>{{ $user->NamaSupplier }}</td>
                                    @if (!empty($user->last_access))
                                        <td>{{ date('d-m-Y H:i:s', strtotime($user->last_access)) }}</td>
                                    @else
                                        <td>Never</td>
                                    @endif
                                    <td>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#modaleditsupplierusr{{ $user->id }}"><i
                                                class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-sm btn-danger" id="delusersupplier{{ $user->id }}"><i
                                                class="bi bi-trash"></i></button>
                                        <script>
                                            var delusr = document.getElementById('delusersupplier' + {{ $user->id }})

                                            delusr.addEventListener('click', function() {
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
                                                            url: "{{ route('deleteusersupplier', $user->id) }}",
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
                                    <div class="modal fade" id="modaleditsupplierusr{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User SKF</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row g-3">
                                                    <form action="{{ route('editusersupplier', $user->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="col-md-6">
                                                            <label for="fullname" class="form-label">Nama Lengkap</label>
                                                            <input type="text" class="form-control" id="fullname"
                                                                name="newfullname" value="{{ $user->name }}"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control" id="email"
                                                                name="newmail" value="{{ $user->email }}"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="password" class="form-label">New Password<br><span
                                                                    style="font-size: 12px"><i>Don't fill this if don't want
                                                                        to
                                                                        change
                                                                        your password</i></span></label>
                                                            <input type="password" name="newpassword"
                                                                class="form-control password">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="confirm_password" class="form-label"
                                                                id="pass_placeholder">Re-type your new
                                                                password<br><span style="font-size: 12px"><i>Don't fill this
                                                                        if you
                                                                        don't want to change your
                                                                        password</i></span></label>
                                                            <input name="password2" type="password"
                                                                class="form-control confirm_password">
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <label for="supplier" class="form-label">Supplier Code</label>
                                                            <input type="text" class="form-control" id="supplier"
                                                                name="supplierid" value="{{ $user->supplier_id }}" readonly>
                                                        </div> --}}
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('blockjs')
    <script>
        $("#tbsupplieruser").DataTable({
            dom: 'Bfrtip',
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada Supplier User yang terdaftar"
            },
            pageLength: 10
        });
    </script>
@endsection
