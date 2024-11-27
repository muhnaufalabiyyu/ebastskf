@extends('layouts.app')
@section('title', 'History Supplier Performance Report')

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">Riwayat <i>Supplier Performance Report</i><br><span
                style="font-style: italic; font-size: 20px">(SPR History)</span></h4>
        @if (session('error'))
            <div class="alert alert-danger" id="erroralert">
                <b>ERROR!</b> {{ session('error') }}
            </div>
        @endif
        <div class="poready border-top border-4 mb-2 p-4">
            <div class="tbContainer">
                <table class="table table-bordered table-striped text-center nowrap tbHistory" style="font-size: 14px">
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
                                <td>{{ $row->supplier_name }}</td>
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
                                    <a href="{{ route('getpdfspr', ['supplier_code' => $row->supplier_code, 'periode' => $row->periode, 'id' => $row->id]) }}"
                                        class="btn btn-primary btn-sm" style="width: fit-content;">
                                        <i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <br> --}}
            </div>
        </div>
    </div>
@endsection

@section('blockjs')
    @if (Session::has('sprsuccess'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "{{ Session::get('sprsuccess') }}",
                icon: "success",
                confirmButtonText: "Tutup"
            }).then(() => {
                @php
                    session()->forget('sprsuccess');
                @endphp
            });
        </script>
    @endif

    <script>
        $(".tbHistory").DataTable({
            dom: "Bfrtip",
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada BAST yang sudah dibuat."
            },
            pageLength: 10
        });
    </script>
@endsection
