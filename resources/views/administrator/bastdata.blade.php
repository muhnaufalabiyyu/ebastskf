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
                                    <a href="{{ route('getpdf', ['id' => $bast->id_bast, 'supplier_id' => $bast->supplier_id, 'action' => 'stream']) }}"
                                        class="btn btn-info btn-sm" style="width: fit-content;" target="_blank">
                                        <i class="bi bi-file-earmark-pdf-fill"></i></a>
                                    <button class="btn btn-sm btn-danger" id="delbast{{ $bast->id_bast }}"><i
                                            class="bi bi-trash"></i></button>
                                    <script>
                                        var delbast = document.getElementById('delbast' + {{ $bast->id_bast }})

                                        delbast.addEventListener('click', function() {
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
                                                        success: function(response) {
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
@endsection
