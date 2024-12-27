@extends('administrator.layouts.app')
@section('title', 'Data BAST')

@section('main')
<div class="pagetitle">
    <h1>Data BAST</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Data</li>
            <li class="breadcrumb-item active">BAST</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="card py-4">
        <div class="card-body">
            <button class="btn btn-success" id="btnExport">Export</button>
            <table class="table table-bordered table-striped text-center" id="tbbastdata"
                style="margin-bottom: 1rem; font-weight: 500">
                <thead>
                    <th>No.</th>
                    <th>No. BAST</th>
                    <th>BAST Date</th>
                    <th>Work Start</th>
                    <th>Work End</th>
                    <th>Created by</th>
                    <th>To User</th>
                    <th>Status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($bastdata as $bast)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $bast->bastno }}</td>
                            <td>{{ date('d-m-Y', strtotime($bast->bastdt)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($bast->workstart)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($bast->workend)) }}</td>
                            <td>{{ $bast->createdby }}</td>
                            <td>{{ $bast->to_user }}</td>
                            <td>
                                @if ($bast->status == 4)
                                    <select name="status" id="status" class="form-control text-center" disabled>
                                        <option value="4">On RR Warehouse</option>
                                    </select>
                                @elseif ($bast->status == 5)
                                    <select name="status" id="status" class="form-control text-center" disabled>
                                        <option value="5">Approved</option>
                                    </select>
                                @else
                                    <select name="status" id="statusbast" class="form-control text-center"
                                        data-id="{{ $bast->id_bast }}" onchange="updateStatus(this)">
                                        <option value="1" {{ $bast->status == '1' ? 'selected' : '' }}>On Approval
                                            EHS</option>
                                        <option value="2" {{ $bast->status == '2' ? 'selected' : '' }}>On Approval
                                            User</option>
                                        <option value="3" {{ $bast->status == '3' ? 'selected' : '' }}>On Approval
                                            Purchasing</option>
                                        <option value="4" {{ $bast->status == '4' ? 'selected' : '' }}>On RR
                                            Warehouse</option>
                                    </select>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('getpdf', ['id' => $bast->id_bast, 'supplier_id' => $bast->supplier_id, 'action' => 'stream']) }}"
                                    class="btn btn-info btn-sm" style="width: fit-content;" target="_blank">
                                    <i class="bi bi-file-earmark-pdf-fill"></i></a>
                                <button class="btn btn-sm btn-danger" id="delbast{{ $bast->id_bast }}"><i
                                        class="bi bi-trash"></i></button>
                                <script>
                                    var delbast = document.getElementById('delbast' + {{ $bast->id_bast }})

                                    delbast.addEventListener('click', function () {
                                        Swal.fire({
                                            title: "Apakah anda yakin?",
                                            text: "Anda tidak dapat mengembalikan data BAST yang sudah dihapus!",
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
                                                    url: "{{ route('deletebast', ['id' => $bast->id_bast, 'pono' => $bast->pono]) }}",
                                                    data: {
                                                        _token: csrfToken,
                                                    },
                                                    success: function (response) {
                                                        Swal.fire({
                                                            title: "Deleted!",
                                                            text: "BAST berhasil dihapus.",
                                                            icon: "success"
                                                        }).then((result2) => {
                                                            if (result2.isConfirmed) {
                                                                location.reload();
                                                            }
                                                        })
                                                    },
                                                    error: function (xhr, status, error) {
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
            <div class="modal fade" id="modalExport" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Export Data</h5>
                            <button type="button" class="btn btn-danger btn-sm closeHistory">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="datefrom" class="form-label">From:</label>
                                        <input type="date" name="datefrom" id="datefrom" class="form-control" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="dateto" class="form-label">To:</label>
                                        <input type="date" name="dateto" id="dateto" class="form-control" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeExport">Close</button>
                            <button type="button" class="btn btn-success">
                                <i class="bi bi-file-earmark-excel-fill"></i>Export</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('blockjs')
<script>
    $('#btnExport').click(function () {
        $('#modalExport').modal('show');
    });

    $('.closeExport').click(function () {
        $('#modalExport').modal('hide');
    });
</script>
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
<script>
    function updateStatus(selectElement) {
        var status = selectElement.value;
        var bastId = $(selectElement).data('id');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: "POST",
            url: "{{ route('updatestatus') }}",
            data: {
                id: bastId,
                status: status,
                _token: csrfToken
            },
            success: function (response) {
                Swal.fire({
                    title: "Success!",
                    text: "Status berhasil diperbarui.",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Error!",
                    text: "Gagal memperbarui status.",
                    icon: "error"
                });
            }
        });
    }
</script>

@endsection