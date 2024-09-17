@extends('administrator.layouts.app')
@section('title', 'Data Departemen')

@section('main')
    <div class="pagetitle">
        <h1>Data Departemen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data</li>
                <li class="breadcrumb-item active">Departemen</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card py-4">
            <div class="card-body">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddDept">Add Department</button>
                <table class="table table-bordered table-striped text-center" id="tbbastdata"
                    style="margin-bottom: 1rem; font-weight: 500">
                    <thead style="white-space: nowrap">
                        <th>No.</th>
                        <th>Nama Dept.</th>
                        <th>Alias</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($deptdata as $dept)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $dept->nama_dept }}</td>
                                <td>{{ $dept->alias }}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modaleditdept{{ $dept->id_dept }}"><i
                                            class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-danger" id="deldept{{ $dept->id_dept }}"><i
                                            class="bi bi-trash"></i></button>
                                    <script>
                                        var deldept = document.getElementById('deldept' + {{ $dept->id_dept }})

                                        deldept.addEventListener('click', function() {
                                            Swal.fire({
                                                title: "Apakah anda yakin?",
                                                text: "Anda tidak dapat mengembalikan data Departemen yang sudah dihapus!",
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
                                                        url: "{{ route('deletedept', ['id' => $dept->id_dept]) }}",
                                                        data: {
                                                            _token: csrfToken,
                                                        },
                                                        success: function(response) {
                                                            Swal.fire({
                                                                title: "Deleted!",
                                                                text: "Departemen berhasil dihapus.",
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
                            {{-- Modal Edit Department --}}
                            <div class="modal fade" id="modaleditdept{{ $dept->id_dept }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Departemen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row g-3">
                                            <form action="{{ route('editdept', $dept->id_dept) }}" method="post">
                                                @csrf
                                                <div class="col-md-6">
                                                    <label for="deptname" class="form-label">Nama
                                                        Departemen</label>
                                                    <input type="text" class="form-control" id="deptname"
                                                        name="newdeptname" value="{{ $dept->nama_dept }}"
                                                        autocomplete="off">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="alias" class="form-label">Alias</label>
                                                    <input type="alias" class="form-control" id="alias"
                                                        name="newalias" value="{{ $dept->alias }}" autocomplete="off"
                                                        maxlength="6">
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
                    {{-- Modal Add Department --}}
                    <div class="modal fade" id="modalAddDept" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Department</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <form action="{{ route('adddept') }}" method="post">
                                        @csrf
                                        <div class="col-md-6">
                                            <label for="deptname" class="form-label">Nama
                                                Departemen</label>
                                            <input type="text" class="form-control" id="deptname" name="deptname"
                                                value="" autocomplete="off" placeholder="Nama Departemen">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="alias" class="form-label">Alias</label>
                                            <input type="alias" class="form-control" id="alias" name="alias"
                                                value="" autocomplete="off" maxlength="6"
                                                placeholder="Maksimal 6 digit">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="editbutton" class="btn btn-primary">Save
                                        changes</button>
                                    </form><!-- End Multi Columns Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('blockjs')
    <script>
        $("#tbbastdata").DataTable({
            dom: 'Bfrtip',
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Anda belum membuat daftar departemen!"
            },
            pageLength: 10
        });
    </script>
@endsection
