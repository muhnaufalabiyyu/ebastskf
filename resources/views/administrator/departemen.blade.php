@extends('administrator.layouts.app')
@section('title', 'Data Departemen')

@section('blockstyle')
    <style>
        .table-container {
            overflow: auto;
            height: fit-content;
        }
    </style>
@endsection

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

            </div>
            <div class="table-container">
                <table class="table table-bordered table-striped text-center" id="tbbastdata"
                    style="margin-bottom: 1rem; font-weight: 500">
                    <thead style="white-space: nowrap">
                        <th>No.</th>
                        <th>Action</th>
                        <th>Nama Dept.</th>
                        <th>Alias</th>
                        <th>Manager 1</th>
                        <th>Email Manager 1</th>
                        <th>Manager 2</th>
                        <th>Email Manager 2</th>
                        <th>Supervisor 1</th>
                        <th>Email Supervisor 1</th>
                        <th>Supervisor 2</th>
                        <th>Email Supervisor 2</th>
                    </thead>
                    <tbody>
                        @foreach ($deptdata as $dept)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
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
                                <td>{{ $dept->nama_dept }}</td>
                                <td>{{ $dept->alias }}</td>
                                <td>{{ $dept->manager1 }}</td>
                                <td>{{ $dept->emailmgr1 }}</td>
                                <td>{{ $dept->manager2 }}</td>
                                <td>{{ $dept->emailmgr2 }}</td>
                                <td>{{ $dept->spv1 }}</td>
                                <td>{{ $dept->emailspv1 }}</td>
                                <td>{{ $dept->spv2 }}</td>
                                <td>{{ $dept->emailspv2 }}</td>
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
                                                    <div class="col-md-6">
                                                        <label for="mgr1" class="form-label">Manager 1</label>
                                                        <select name="mgr1" id="mgr1" class="form-control">
                                                            @foreach ($mgrdata as $mgr)
                                                                <option value="{{ $mgr->name }}"
                                                                    {{ $dept->manager1 == $mgr->name ? 'selected' : '' }}>
                                                                    {{ $mgr->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="emailmgr1" class="form-label">Email Manager
                                                            1</label>
                                                        <input type="emailmgr1" class="form-control" id="emailmgr1"
                                                            name="newemailmgr1" value="{{ $dept->emailmgr1 }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="mgr2" class="form-label">Manager 2</label>
                                                        @php
                                                            $foundManager2 = false;
                                                        @endphp

                                                        <select name="mgr2" id="mgr2" class="form-control">
                                                            @if (!$foundManager2)
                                                                <option value="" selected>Pilih Manager 2
                                                                </option>
                                                            @endif
                                                            @foreach ($mgrdata as $mgr)
                                                                <option value="{{ $mgr->name }}"
                                                                    {{ $dept->manager2 == $mgr->name ? 'selected' : '' }}>
                                                                    {{ $mgr->name }}
                                                                </option>

                                                                @if ($dept->manager2 == $mgr->name)
                                                                    @php
                                                                        $foundManager2 = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="emailmgr2" class="form-label">Email Manager
                                                            2</label>
                                                        <input type="emailmgr2" class="form-control" id="emailmgr2"
                                                            name="newemailmgr2" value="{{ $dept->emailmgr2 }}" readonly>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="spv1" class="form-label">Supervisor 1</label>
                                                        @php
                                                            $foundSupervisor1 = false;
                                                        @endphp

                                                        <select name="spv1" id="spv1" class="form-control">
                                                            @if (!$foundSupervisor1)
                                                                <option value="" selected>Pilih
                                                                    Supervisor 1</option>
                                                            @endif
                                                            @foreach ($spvdata as $spv)
                                                                <option value="{{ $spv->name }}"
                                                                    {{ $dept->spv1 == $spv->name ? 'selected' : '' }}>
                                                                    {{ $spv->name }}
                                                                </option>

                                                                @if ($dept->spv1 == $spv->name)
                                                                    @php
                                                                        $foundSupervisor1 = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="emailspv1" class="form-label">Email Supervisor
                                                            1</label>
                                                        <input type="email" class="form-control" id="emailspv1"
                                                            name="newemailspv1" value="{{ $dept->emailspv1 }}" readonly>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="spv2" class="form-label">Supervisor 2</label>
                                                        @php
                                                            $foundSupervisor2 = false;
                                                        @endphp

                                                        <select name="spv2" id="spv2" class="form-control">
                                                            @if (!$foundSupervisor2)
                                                                <option value="" selected>Pilih
                                                                    Supervisor 2</option>
                                                            @endif
                                                            @foreach ($spvdata as $spv)
                                                                <option value="{{ $spv->name }}"
                                                                    {{ $dept->spv2 == $spv->name ? 'selected' : '' }}>
                                                                    {{ $spv->name }}
                                                                </option>

                                                                @if ($dept->spv2 == $spv->name)
                                                                    @php
                                                                        $foundSupervisor2 = true;
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="emailspv2" class="form-label">Email Supervisor
                                                            2</label>
                                                        <input type="email" class="form-control" id="emailspv2"
                                                            name="newemailspv2" value="{{ $dept->emailspv2 }}" readonly>
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
                            </tr>
                        @endforeach
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
                                                <input type="text" class="form-control" id="deptname"
                                                    name="deptname" value="" autocomplete="off"
                                                    placeholder="Nama Departemen">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="alias" class="form-label">Alias</label>
                                                <input type="alias" class="form-control" id="alias" name="alias"
                                                    value="" autocomplete="off" maxlength="6"
                                                    placeholder="Maksimal 6 digit">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newmgr1" class="form-label">Manager 1</label>
                                                <select name="newmgr1" id="newmgr1" class="form-control">
                                                    <option selected disabled>Pilih Manager 1</option>
                                                    @foreach ($mgrdata as $mgr)
                                                        <option value="{{ $mgr->name }}">
                                                            {{ $mgr->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newemailmgr1" class="form-label">Email Manager
                                                    1</label>
                                                <input type="newemailmgr1" class="form-control" id="newemailmgr1"
                                                    name="emailmgr1" value="" readonly
                                                    placeholder="Email Manager 1">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newmgr2" class="form-label">Manager 2</label>
                                                <select name="newmgr2" id="newmgr2" class="form-control">
                                                    <option selected disabled>Pilih Manager 2</option>
                                                    @foreach ($mgrdata as $mgr)
                                                        <option value="{{ $mgr->name }}">
                                                            {{ $mgr->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newemailmgr2" class="form-label">Email Manager
                                                    2</label>
                                                <input type="newemailmgr2" class="form-control" id="newemailmgr2"
                                                    name="emailmgr2" value="" readonly
                                                    placeholder="Email Manager 2">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="newspv1" class="form-label">Supervisor 1</label>
                                                <select name="newspv1" id="newspv1" class="form-control">
                                                    <option selected disabled>Pilih Supervisor 1</option>
                                                    @foreach ($spvdata as $spv)
                                                        <option value="{{ $spv->name }}">
                                                            {{ $spv->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newemailspv1" class="form-label">Email Supervisor
                                                    1</label>
                                                <input type="email" class="form-control" id="newemailspv1"
                                                    name="emailspv1" value="" readonly
                                                    placeholder="Email Supervisor 1">
                                            </div>

                                            <div class="col-md-6">
                                                <label for="newspv2" class="form-label">Supervisor 2</label>
                                                <select name="newspv2" id="newspv2" class="form-control">
                                                    <option selected disabled>Pilih Supervisor 2</option>
                                                    @foreach ($spvdata as $spv)
                                                        <option value="{{ $spv->name }}">
                                                            {{ $spv->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="newemailspv2" class="form-label">Email Supervisor
                                                    2</label>
                                                <input type="email" class="form-control" id="newemailspv2"
                                                    name="emailspv2" value="" readonly
                                                    placeholder="Email Supervisor 2">
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
                    </tbody>
                </table>
            </div>
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
                "emptyTable": "Tidak ada BAST yang dibuat oleh Supplier"
            },
            pageLength: 10
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            function updateMail(userName, emailInput) {
                var userName = $(userName).val();

                if (userName) {
                    $.ajax({
                        url: '/get-user-email/' + userName,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (data.email) {
                                $(emailInput).val(data.email);
                            } else {
                                $(emailInput).val('');
                            }
                        },
                        error: function() {
                            alert('Error retrieving email.');
                        }
                    });
                } else {
                    $(emailInput).val('');
                }
            }

            $('#mgr1').on('change', function() {
                updateMail('#mgr1', '#emailmgr1');
            });

            $('#mgr2').on('change', function() {
                updateMail('#mgr2', '#emailmgr2');
            });

            $('#spv1').on('change', function() {
                updateMail('#spv1', '#emailspv1');
            });

            $('#spv2').on('change', function() {
                updateMail('#spv2', '#emailspv2');
            });

            $('#newmgr1').on('change', function() {
                updateMail('#newmgr1', '#newemailmgr1');
            });

            $('#newmgr2').on('change', function() {
                updateMail('#newmgr2', '#newemailmgr2');
            });

            $('#newspv1').on('change', function() {
                updateMail('#newspv1', '#newemailspv1');
            });

            $('#newspv2').on('change', function() {
                updateMail('#newspv2', '#newemailspv2');
            });
        });
    </script>
@endsection
