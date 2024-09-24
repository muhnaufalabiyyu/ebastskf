@extends('layouts.app')
@section('title', 'Approval BAST')

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">Approval Berita Acara Serah Terima<br></h4>
        @if (session('success'))
            <div class="alert alert-success" id="successalert">
                <b>Success!</b> {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger" id="erroralert">
                <b>ERROR!</b> {{ session('error') }}
            </div>
        @endif
        <div class="poready border-top border-4 mb-2 p-4">
            <div class="tbContainer">
                <table class="table table-bordered table-striped text-center nowrap tbApproval" style="font-size: 14px">
                    <thead>
                        <th>ID Supplier</th>
                        <th>BAST No.</th>
                        <th>BAST Date</th>
                        <th>PO No.</th>
                        <th>Offering Price No.</th>
                        <th>Desc.</th>
                        {{-- <th>Preview</th> --}}
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($approval as $row)
                            <tr>
                                <td>{{ $row->supplier_id }}</td>
                                <td>{{ $row->bastno }}</td>
                                <td>{{ $row->bastdt }}</td>
                                <td>{{ $row->pono }}</td>
                                <td>{{ $row->offerno }}</td>
                                <td>{{ $row->workdesc }}</td>
                                {{-- <td></td> --}}
                                <td>
                                    @if (Auth::user()->dept == 'EHS')
                                        @if ($row->status == 1)
                                            <button class="btn btn-success btn-sm" id="btnEHSModal{{ $row->id_bast }}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" id="btnUserModal{{ $row->id_bast }}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    @elseif (Auth::user()->dept == 'PURCH')
                                        <button class="btn btn-success btn-sm approve-button"
                                            data-route="{{ route('approve', ['id' => $row->id_bast, 'userappv' => Auth::user()->name]) }}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    @elseif (Auth::user()->dept == 'SCWH')
                                        @if ($row->status == 4)
                                            <button type="button" class="btn btn-success btn-sm"
                                                id="btnWh{{ $row->id_bast }}"><i class="fa fa-check"></i></button>
                                            <script>
                                                var btnWh = document.getElementById('btnWh' + {{ $row->id_bast }});

                                                btnWh.addEventListener('click', function() {
                                                    Swal.fire({
                                                        title: 'Alert!',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Approve',
                                                        confirmButtonAriaLabel: 'Save',
                                                        cancelButtonAriaLabel: 'Cancel',
                                                        input: 'text',
                                                        inputLabel: 'Mohon masukkan nomor RR yang sudah dilakukan pada SIIS',
                                                        inputPlaceholder: 'Input disini ...',
                                                        inputAttributes: {
                                                            name: 'remark',
                                                        },
                                                        icon: 'info'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            const rrnumber = Swal.getInput().value;
                                                            const currstatus = {{ $row->status }};
                                                            if (!rrnumber) {
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Oops...',
                                                                    text: 'Mohon masukkan Nomor RR yang sudah dilakukan pada SIIS',
                                                                });
                                                            } else {
                                                                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: "{{ route('approve', ['id' => $row->id_bast, 'userappv' => Auth::user()->name]) }}",
                                                                    data: {
                                                                        _token: csrfToken,
                                                                        rrno: rrnumber,
                                                                        currstatus: currstatus,
                                                                    },
                                                                    success: function(response) {
                                                                        Swal.fire({
                                                                            title: "SUCCESS!",
                                                                            text: "Nomor RR berhasil diinput!.",
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
                                                        }

                                                    });
                                                });
                                            </script>
                                        @elseif ($row->status == 2)
                                            <button class="btn btn-success btn-sm" id="btnUserModal{{ $row->id_bast }}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    @else
                                        @if (Auth::user()->gol == 4 || (Auth::user()->gol == 3 && Auth::user()->acting == 2))
                                            <button class="btn btn-success btn-sm" id="btnUserModal{{ $row->id_bast }}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    @endif
                                    <a href="{{ route('detail', ['id' => $row->id_bast, 'supplier_id' => $row->supplier_id]) }}"
                                        class="btn btn-primary btn-sm view-button">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <script>
                                $('#btnUserModal{{ $row->id_bast }}').click(function() {
                                    $('#modalRate{{ $row->id_bast }}').modal('show');
                                });
                            </script>
                            {{-- Modal Rating from User --}}
                            <div class="modal fade" id="modalRate{{ $row->id_bast }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">User Rate Job Performance
                                            </h5>
                                            <button type="button" class="close btn btn-sm btn-danger"
                                                id="closeModalRate{{ $row->id_bast }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form
                                                action="{{ route('approveuser', ['id' => $row->id_bast, 'userappv' => Auth::user()->name]) }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="radio" name="actappv" class="form-check-input"
                                                        value="1">
                                                    <label for="userOption1">Approve</label>
                                                    <input type="radio" name="actappv" class="form-check-input"
                                                        value="2">
                                                    <label for="userOption2">Request Revisi</label>
                                                </div>
                                                {{-- <div class="form-group">
                                                        <input type="radio" name="actappv" class="form-check-input" value="2">
                                                        <label for="userOption2">Request Revisi</label>
                                                    </div> --}}
                                                <br>
                                                <p>Mohon berikan penilaian terhadap hasil kerja</p>
                                                <div class="rate">
                                                    <input type="radio" id="star5_{{ $row->id_bast }}"
                                                        name="rateid{{ $row->id_bast }}" value="5" required />
                                                    <label for="star5_{{ $row->id_bast }}" title="5 Star">5 stars</label>
                                                    <input type="radio" id="star4_{{ $row->id_bast }}"
                                                        name="rateid{{ $row->id_bast }}" value="4" required />
                                                    <label for="star4_{{ $row->id_bast }}" title="4 Star">4 stars</label>
                                                    <input type="radio" id="star3_{{ $row->id_bast }}"
                                                        name="rateid{{ $row->id_bast }}" value="3" required />
                                                    <label for="star3_{{ $row->id_bast }}" title="3 Star">3 stars</label>
                                                    <input type="radio" id="star2_{{ $row->id_bast }}"
                                                        name="rateid{{ $row->id_bast }}" value="2" required />
                                                    <label for="star2_{{ $row->id_bast }}" title="2 Star">2 stars</label>
                                                    <input type="radio" id="star1_{{ $row->id_bast }}"
                                                        name="rateid{{ $row->id_bast }}" value="1" required />
                                                    <label for="star1_{{ $row->id_bast }}" title="1 Star">1 star</label>
                                                </div>
                                                <input type="hidden" name="currstatus" value="{{ $row->status }}">
                                                <div class="form-group">
                                                    <label for="userRemark" class="form-label mt-2">Remark</label>
                                                    <textarea name="userRemark" id="userRemark" cols="30" rows="5" class="form-control mt-2"></textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#closeModalRate{{ $row->id_bast }}').click(function() {
                                    $('#modalRate{{ $row->id_bast }}').modal('hide');
                                });

                                $('#btnEHSModal{{ $row->id_bast }}').click(function() {
                                    $('#modalEHSNotes{{ $row->id_bast }}').modal('show');
                                });
                            </script>
                            {{-- Modal Notes EHS --}}
                            <div class="modal fade" id="modalEHSNotes{{ $row->id_bast }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Safety Evaluation from EHS
                                            </h5>
                                            <button type="button" class="close btn btn-sm btn-danger"
                                                id="closeModalEHS{{ $row->id_bast }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Mohon berikan safety evaluation terkait pekerjaan yang sudah dilakukan</p>
                                            <form
                                                action="{{ route('approveehs', ['id' => $row->id_bast, 'userappv' => Auth::user()->name]) }}"
                                                method="post">
                                                @csrf
                                                <div class="rateehs">
                                                    <input type="radio" id="star55_{{ $row->id_bast }}"
                                                        name="rateehs{{ $row->id_bast }}" value="5" required />
                                                    <label for="star55_{{ $row->id_bast }}" title="5 Star">5
                                                        stars</label>
                                                    <input type="radio" id="star44_{{ $row->id_bast }}"
                                                        name="rateehs{{ $row->id_bast }}" value="4" required />
                                                    <label for="star44_{{ $row->id_bast }}" title="4 Star">4
                                                        stars</label>
                                                    <input type="radio" id="star33_{{ $row->id_bast }}"
                                                        name="rateehs{{ $row->id_bast }}" value="3" required />
                                                    <label for="star33_{{ $row->id_bast }}" title="3 Star">3
                                                        stars</label>
                                                    <input type="radio" id="star22_{{ $row->id_bast }}"
                                                        name="rateehs{{ $row->id_bast }}" value="2" required />
                                                    <label for="star22_{{ $row->id_bast }}" title="2 Star">2
                                                        stars</label>
                                                    <input type="radio" id="star11_{{ $row->id_bast }}"
                                                        name="rateehs{{ $row->id_bast }}" value="1" required />
                                                    <label for="star11_{{ $row->id_bast }}" title="1 Star">1 star</label>
                                                </div>
                                                <input type="hidden" name="currstatus" value="{{ $row->status }}">
                                                <div class="form-group">
                                                    <label for="userRemark" class="form-label">Remark</label>
                                                    <textarea name="ehsnotes" id="ehsnotes" cols="30" rows="5" class="form-control"></textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $('#closeModalEHS{{ $row->id_bast }}').click(function() {
                                    $('#modalEHSNotes{{ $row->id_bast }}').modal('hide');
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('blockjs')
    @if (Session::has('successapprove'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "{{ Session::get('successapprove') }}",
                icon: "success",
                confirmButtonText: "Tutup"
            }).then(() => {
                @php
                    session()->forget('successapprove');
                @endphp
            });
        </script>
    @endif

    <script>
        $('.approve-button').click(function(e) {
            e.preventDefault();
            var route = $(this).data('route');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: route,
                data: {
                    _token: csrfToken
                },
                success: function() {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script>
        $(".tbApproval").DataTable({
            dom: "Bfrtip",
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada BAST yang harus di approve."
            },
            pageLength: 10
        });
    </script>
@endsection
