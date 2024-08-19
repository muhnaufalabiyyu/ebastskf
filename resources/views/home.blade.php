@extends('layouts.app')
@section('title', 'Purchase Order Ready to BAST')

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">OUTSTANDING PO / READY TO BAST</h4>
        <div class="poready border-top border-4 mb-2 p-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tbContainer">
                            <table class="table table-bordered table-striped text-center nowrap tbPOReady">
                                <thead>
                                    <th>PO Number</th>
                                    <th>ID Supplier</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($po as $row)
                                        <tr>
                                            <td>{{ $row->no_po }}</td>
                                            <td>{{ $row->supplier_code }}</td>
                                            <td>{{ $row->date_po }}</td>
                                            <td><a href="{{ route('createbast', ['pono' => $row->no_po]) }}"
                                                    class="btn btn-primary btn-md">Create BAST</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('blockjs')
    <script>
        $(".tbPOReady").DataTable({
            dom: "Bfrtip",
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada Purchase Order yang harus di BAST."
            },
            pageLength: 10
        });
    </script>
@endsection
