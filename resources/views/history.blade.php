@extends('layouts.app')
@section('title', 'History BAST')

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">Riwayat Berita Acara Serah Terima<br><span
                style="font-style: italic; font-size: 20px">(BAST History)</span></h4>
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
                        <th>BAST No.</th>
                        <th>BAST Date</th>
                        <th>PO No.</th>
                        <th>Offering Price No.</th>
                        <th>Desc.</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($bast as $row)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $row->supplier_id }}</td>
                                <td>{{ $row->bastno }}</td>
                                <td>{{ $row->bastdt }}</td>
                                <td>{{ $row->pono }}</td>
                                <td>{{ $row->offerno }}</td>
                                <td>{{ $row->workdesc }}</td>
                                <td>
                                    @if ($row->status == '1' || $row->status == '0')
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                        <marquee behavior="sliding" direction="left" scrolldelay="200"
                                            style="font-size:0.8rem;">Waiting approval by EHS</marquee>
                                    @elseif ($row->status == '2')
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="25" aria-valuemax="100" style="width: 25%"></div>
                                        </div>
                                        <marquee behavior="sliding" direction="left" scrolldelay="200"
                                            style="font-size:0.8rem;">Waiting approval by {{ $row->to_user }}</marquee>
                                    @elseif ($row->status == '3')
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="50" aria-valuemax="100" style="width: 50%"></div>
                                        </div>
                                        <marquee behavior="sliding" direction="left" scrolldelay="200"
                                            style="font-size:0.8rem;">Waiting approval by Purchasing</marquee>
                                    @elseif ($row->status == '4')
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0"
                                                aria-valuemin="75" aria-valuemax="100" style="width: 75%"></div>
                                        </div>
                                        <marquee behavior="sliding" direction="left" scrolldelay="200"
                                            style="font-size:0.8rem;">Waiting RR from Warehouse</marquee>
                                    @else
                                        <span style="color:lightgreen;"><b>BAST Approved</b></span>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->acting == 1)
                                        <a href="{{ route('editbast', ['id' => $row->id_bast, 'supplier_id' => $row->supplier_id]) }}"
                                            class="btn btn-warning btn-sm" style="width: fit-content"><i
                                                class="fas fa-edit"></i></a>
                                    @endif
                                    <a href="{{ route('getpdf', ['id' => $row->id_bast, 'supplier_id' => $row->supplier_id, 'action' => 'download']) }}"
                                        class="btn btn-danger btn-sm" style="width: fit-content;" target="_blank">
                                        <i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('detail', ['id' => $row->id_bast, 'supplier_id' => $row->supplier_id]) }}"
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
    @if (Session::has('successbast'))
        <script>
            Swal.fire({
                title: "SUCCESS!",
                text: "{{ Session::get('successbast') }}",
                icon: "success",
                confirmButtonText: "Tutup"
            }).then(() => {
                @php
                    session()->forget('successbast');
                @endphp
            });
        </script>
    @endif

    <script>
        setTimeout(function() {
            var alert = document.getElementById('successalert');
            if (alert) {
                var opacity = 1;
                var interval = 50;
                var fadeOutDuration = 1000;

                var fadeOutInterval = setInterval(function() {
                    if (opacity > 0) {
                        opacity -= interval / fadeOutDuration;
                        alert.style.opacity = opacity;
                    } else {
                        alert.style.display = 'none';
                        clearInterval(fadeOutInterval);
                    }
                }, interval);
            }
        }, 5000);
    </script>

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
