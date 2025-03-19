@extends('layouts.app')
@section('title', 'Detail Berita Acara')

@section('blockstyle')
<style>
    .td-max {
        max-width: 100px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection

@section('main')
<div class="container mt-3">
    <h4 class="mb-3" align="center">Detail Berita Acara Serah Terima Pekerjaan<br><span
            style="font-style: italic; font-size: 20px">(Detail Handover of Work)</span></h4>
    <div class="createbast border-top border-4 p-4">
        @foreach ($detail as $row)
            @foreach ($supplier as $sp)
                <h4>BAST Number : {{ $row->bastno }}<span style="float: right">
                        @if ($sp->TipeLokal == '1')
                            Local
                        @else
                            Import
                        @endif
                    </span></h4>
                <hr>
                <div class="row mb-4 mt-4">
                    <div class="px-2 col-sm-4">
                        <div class="bd-left p-4" style="border-color: green; height: 300px">
                            <h5>Job Detail</h5>
                            <table class="table table-borderless" style="width: 100%">
                                <tr>
                                    <td>Supplier</td>
                                    <td>:&nbsp {{ $row->supplier_id }}</td>
                                </tr>
                                <tr>
                                    {{-- <td></td> --}}
                                    <td colspan="2">{{ $sp->NamaSupplier }}</td>
                                </tr>
            @endforeach
                            <tr>
                                <td style="white-space: nowrap">Work Desc</td>
                                <td class="td-max">:&nbsp {{ $row->workdesc }}</td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap">Work Start</td>
                                <td>:&nbsp {{ $row->workstart }}</td>
                            </tr>
                            <tr>
                                <td style="white-space: nowrap">Work End</td>
                                <td>:&nbsp {{ $row->workend }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="px-2 col-sm-4">
                    <div class="bd-left p-4" style="border-color: red; height: 300px">
                        <h5>Job Attachment</h5>
                        <table class="table table-borderless" style="width: 100%">
                            <tr>
                                <td>Purch. Req. No</td>
                                <td>:&nbsp {{ $row->pono }} <a href="{{ Storage::url($row->copypofile) }}"
                                        class="btn btn-sm btn-danger" target="_blank" style="float: right"><i
                                            class="fas fa-file-pdf"></i></a></td>
                            </tr>
                            <tr>
                                <td>Offer Price No</td>
                                <td>:&nbsp {{ $row->offerno }} <a href="{{ Storage::url($row->offerfile) }}"
                                        class="btn btn-sm btn-danger" target="_blank" style="float: right"><i
                                            class="fas fa-file-pdf"></i></a></td>
                            </tr>
                            <tr>
                                <td>Work Report</td>
                                <td>:&nbsp View here -> <a href="{{ Storage::url($row->reportfile) }}" style="float: right"
                                        class="btn btn-sm btn-danger" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>Tax Invoice</td>
                                <td>:&nbsp;
                                    <span style="font-style: italic">
                                        {{ empty($data->taxvo) ? 'Unavailable' : 'View here->' }}
                                    </span>
                                    @if (!empty($data->taxvo))
                                        <a href="{{ Storage::url($row->workqty) }}" class="btn btn-sm btn-danger"
                                            target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>E-NOFA</td>
                                <td>:&nbsp
                                    <span style="font-style: italic">
                                        {{ empty($data->enofa) ? 'Unavailable' : 'View here->' }}
                                    </span>
                                    @if (!empty($data->enofa))
                                        <a href="{{ Storage::url($row->enofa) }}" class="btn btn-sm btn-danger" target="_blank">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="px-2 col-sm-4">
                    <div class="bd-left p-4" style="border-color: brown; height: 300px">
                        <h5>Status</h5>
                        @if ($row->status == 5)
                            <p style="font-style: italic"><b>BAST Approved</b><br>
                                @foreach ($detail as $dt0)
                                        <b>{{ $dt0->rrdt }}</b>
                                    </p>
                                @endforeach
                        @elseif ($row->status == 4)
                            <p><b>Approved by Purchasing</b><br>
                                @foreach ($detail as $dt1)
                                        <b>{{ $dt1->purchappvdt }}</b>
                                    </p>
                                @endforeach
                        @elseif ($row->status == 3)
                            <p><b>Approved by User</b><br>
                                @foreach ($detail as $dt2)
                                        <b>{{ $dt2->userappvdt }}</b>
                                    </p>
                                @endforeach
                        @elseif ($row->status == 2)
                            <p><b>Approved by EHS</b><br>
                                @foreach ($detail as $dt3)
                                        <b>{{ $dt3->ehsappvdt }}</b>
                                    </p>
                                @endforeach
                        @else
                            <p><b>BAST Created at</b><br>
                                @foreach ($detail as $dt4)
                                        <b>{{ $dt4->created_at }}</b>
                                    </p>
                                @endforeach
                        @endif
                        <div class="buttons" style="display: justify-space-between">
                            <a href="{{ route('getpdf', ['id' => $row->id_bast, 'supplier_id' => $row->supplier_id, 'action' => 'stream']) }}"
                                class="btn btn-primary" target="_blank">Show BAST</a>
                            <button class="btn btn-warning" id="btnhistory">History Approval</button>
                        </div>
                        <p class="mt-2"><b>Supplier Performance for this Job (from user)</b></p>
                        <div class="rate2">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" disabled {{ $i == $row->user_rate ? 'checked' : '' }} />
                                <label for="star{{ $i }}" title="{{ $i }} Star">{{ $i }}
                                    star</label>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="px-2 my-3 col-sm-12 table-responsive">
                <table class="table text-center" style="vertical-align: middle">
                    <thead>
                        <th style="text-align: left !important">No.</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Satuan</th>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td style="text-align: left !important">{{ $loop->iteration }}.</td>
                                <td style="text-align: left !important">{{ $item['name'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['unit'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Approval History</h5>
                            <button type="button" class="btn btn-danger btn-sm closeHistory">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <li><strong>Approved by EHS</strong></li>
                                <span>
                                    @if (is_null($row->ehsappvdt) || is_null($row->ehsappv))
                                        <i>Waiting Approval</i>
                                    @else
                                        [{{ $row->ehsappv_dt }}] | [{{ $row->ehsappv }}] <br> Remark : {{ $row->ehsnotes }} <br>
                                        Rating : {{ $row->ehs_rate }}/5
                                    @endif
                                </span>
                            </ul>

                            <ul>
                                <li><strong>Approved by User</strong></li>
                                <span>
                                    @if (is_null($row->userappvdt) || is_null($row->userappv))
                                        <i>Waiting Approval</i>
                                    @else
                                        [{{ $row->userappvdt }}] | [{{ $row->userappv }}] <br> Remark : {{ $row->usernotes }}
                                    @endif
                                </span>
                            </ul>

                            <ul>
                                <li><strong>Approved by Purchasing</strong></li>
                                <span>
                                    @if (is_null($row->purchappvdt) || is_null($row->purchappv))
                                        <i>Waiting Approval</i>
                                    @else
                                        [{{ $row->purchappvdt }}] | [{{ $row->purchappv }}]
                                    @endif
                                </span>
                            </ul>

                            <ul>
                                <li><strong>Done RR by Warehouse</strong></li>
                                <span>
                                    @if (is_null($row->rrdt))
                                        <i>Waiting RR from Warehouse</i>
                                    @else
                                        [{{ $row->rrdt }}] <br> RR Number : {{ $row->rrno }}
                                    @endif
                                </span>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary closeHistory">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->acting == 2)
                <hr>
                <div class="px-2 my-3 col-sm-12">
                    <p style="font-style: italic; font-size: 16px">*If you're having a trouble while approval process, kindly
                        contact Purchasing Department.</p>
                </div>
            @else
            @endif
            <div class="px-2 my-3 col-sm-12">
                <p style="font-style: italic; font-size: 16px">*If you upload the required files incorrectly, please contact
                    Purchasing Department.</p>
                {{-- <p style="font-style: italic; font-size: 14px">*Any changes on this BAST will be updated on history
                    page</p> --}}
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('blockjs')
<script>
    $('#btnhistory').click(function () {
        $('#modalHistory').modal('show');
    });

    $('.closeHistory').click(function () {
        $('#modalHistory').modal('hide');
    });
</script>
@endsection