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
                        <th>No.</th>
                        <th>ID Supplier</th>
                        <th>Supplier Name</th>
                        <th>Periode</th>
                        <th>Created by</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($sprdata as $row)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $row->supplier_code }}</td>
                                <td></td>
                                <td>{{ $row->periode }}</td>
                                <td>{{ $row->created_by }}</td>
                                <td>
                                    @if ($row->status == '1')
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                            </div>
                                        </div>
                                        <marquee behavior="sliding" direction="left" scrolldelay="200"
                                            style="font-size:0.8rem;">Waiting approval by Purchasing Manager</marquee>
                                    @else
                                        <span style="color:lightgreen;"><b>SPR Approved</b></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('historyspr') }}" class="btn btn-primary btn-sm"
                                        style="width: fit-content;">
                                        <i class="fas fa-eye"></i></a>
                                    <button type="button" class="btn btn-success btn-sm" id="btnAppv{{ $row->id }}"><i
                                            class="fa fa-check"></i></button>
                                    <script>
                                        var btnAppv = document.getElementById('btnAppv' + {{ $row->id }});

                                        btnAppv.addEventListener('click', function() {
                                            Swal.fire({
                                                icon: "warning",
                                                title: "Are you sure?",
                                                text: "Lakukan approval terhadap SPR ini?",
                                                showCancelButton: true,
                                                confirmButtonText: "Yes",
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "{{ route('approvespr', ['id' => $row->id, 'userappv' => Auth::user()->name]) }}",
                                                        data: {
                                                            _token: csrfToken,
                                                        },
                                                        success: function(response) {
                                                            Swal.fire({
                                                                title: "SUCCESS!",
                                                                text: "SPR berhasil diapprove!.",
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
        $(".tbApproval").DataTable({
            dom: "Bfrtip",
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada SPR yang harus di approve."
            },
            pageLength: 10
        });
    </script>
@endsection
