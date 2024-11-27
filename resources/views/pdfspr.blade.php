<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Performance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .no-border {
            border: none;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .header,
        .footer {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <table>
            <tr>
                <td colspan="2" style="font-size: 20px">
                    <b>PT. SKF Indonesia</b>
                </td>
                <td style="font-size: 14px; width: 50px; text-align:left">
                    <b>To:</b><b>
                    <b>Attention:</b><br>
                    <b>Email:</b>
                </td>
                @foreach ($suppliers as $sp)
                    <td style="font-size: 14px">
                        {{ $sp->supplier_name }}<br>
                        {{ $sp->contact_person }}<br>
                        <span style="color: blue;">{{ $sp->email }}</span><br>
                    </td>
                @endforeach
            </tr>
            <tr>
                <td colspan="4" class="center" style="font-size: 18px">
                    <b>SUPPLIER PERFORMANCE REPORT</b>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="center" style="font-size: 16px">
                    <b>{{ $period }}</b>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table>
            <tr>
                <th colspan="13">Quality Performance</th>
            </tr>
            <tr>
                <th style="width: 100px">Month</th>
                <th>Jan-{{ $year }}</th>
                <th>Feb-{{ $year }}</th>
                <th>Mar-{{ $year }}</th>
                <th>Apr-{{ $year }}</th>
                <th>May-{{ $year }}</th>
                <th>Jun-{{ $year }}</th>
                <th>Jul-{{ $year }}</th>
                <th>Aug-{{ $year }}</th>
                <th>Sep-{{ $year }}</th>
                <th>Oct-{{ $year }}</th>
                <th>Nov-{{ $year }}</th>
                <th>Dec-{{ $year }}</th>
            </tr>
            <tr>
                <td>GRADE</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $qualityGrade = $monthData ? $monthData->qualitygrade : '';
                    @endphp
                    <td>{{ $qualityGrade }}</td>
                @endfor
            </tr>
        </table>

        <table style="margin-top: 5px">
            <tr>
                <th colspan="13">Delivery Performance</th>
            </tr>
            <tr>
                <th style="width: 100px">Month</th>
                <th>Jan-24</th>
                <th>Feb-24</th>
                <th>Mar-24</th>
                <th>Apr-24</th>
                <th>May-24</th>
                <th>Jun-24</th>
                <th>Jul-24</th>
                <th>Aug-24</th>
                <th>Sep-24</th>
                <th>Oct-24</th>
                <th>Nov-24</th>
                <th>Dec-24</th>
            </tr>
            <tr>
                <td>GRADE</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $deliveryGrade = $monthData ? $monthData->deliverygrade : '';
                    @endphp
                    <td>{{ $deliveryGrade }}</td>
                @endfor
            </tr>
        </table>
        <table style="margin-top: 5px">
            <tr>
                <th colspan="13">Safety & Environment Performance</th>
            </tr>
            <tr>
                <th style="width: 100px">Month</th>
                <th>Jan-24</th>
                <th>Feb-24</th>
                <th>Mar-24</th>
                <th>Apr-24</th>
                <th>May-24</th>
                <th>Jun-24</th>
                <th>Jul-24</th>
                <th>Aug-24</th>
                <th>Sep-24</th>
                <th>Oct-24</th>
                <th>Nov-24</th>
                <th>Dec-24</th>
            </tr>
            <tr>
                <td>All product complited MSDS</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $sne1 = $monthData ? $monthData->sne1 : '';
                    @endphp
                    <td>{{ $sne1 }}</td>
                @endfor
            </tr>
            <tr>
                <td>Label : Identify, Expired date, Safety & Enviroment</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $sne2 = $monthData ? $monthData->sne2 : '';
                    @endphp
                    <td>{{ $sne2 }}</td>
                @endfor
            </tr>
            <tr>
                <td>Packaging not Leak</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $sne3 = $monthData ? $monthData->sne3 : '';
                    @endphp
                    <td>{{ $sne3 }}</td>
                @endfor
            </tr>
            <tr>
                <td>Transportation get Permit & Emission Test</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $sne4 = $monthData ? $monthData->sne4 : '';
                    @endphp
                    <td>{{ $sne4 }}</td>
                @endfor
            </tr>
        </table>
        <table style="margin-top: 5px">
            <tr>
                <th colspan="13">Audit Result</th>
            </tr>
            <tr>
                <th style="width: 100px">Month</th>
                <th>Jan-24</th>
                <th>Feb-24</th>
                <th>Mar-24</th>
                <th>Apr-24</th>
                <th>May-24</th>
                <th>Jun-24</th>
                <th>Jul-24</th>
                <th>Aug-24</th>
                <th>Sep-24</th>
                <th>Oct-24</th>
                <th>Nov-24</th>
                <th>Dec-24</th>
            </tr>
            <tr>
                <td>GRADE</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $auditresultgrade = $monthData ? $monthData->auditresultgrade : '';
                    @endphp
                    <td>{{ $auditresultgrade }}</td>
                @endfor
            </tr>
        </table>
        <table style="margin-top: 5px">
            <tr>
                <th colspan="13">Note (Finding)</th>
            </tr>
            <tr>
                <th style="width: 100px">Month</th>
                <th>Jan-24</th>
                <th>Feb-24</th>
                <th>Mar-24</th>
                <th>Apr-24</th>
                <th>May-24</th>
                <th>Jun-24</th>
                <th>Jul-24</th>
                <th>Aug-24</th>
                <th>Sep-24</th>
                <th>Oct-24</th>
                <th>Nov-24</th>
                <th>Dec-24</th>
            </tr>
            <tr>
                <td>Quality</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $notequalitygrade = $monthData ? $monthData->notequalitygrade : '';
                    @endphp
                    <td>{{ $notequalitygrade }}</td>
                @endfor
            </tr>
            <tr>
                <td>Delivery</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $notedeliverygrade = $monthData ? $monthData->notedeliverygrade : '';
                    @endphp
                    <td>{{ $notedeliverygrade }}</td>
                @endfor
            </tr>
            <tr>
                <td>Safety & Environment</td>
                @for ($i = 1; $i <= 12; $i++)
                    @php
                        $monthStart = Carbon\Carbon::create($year, $i, 1)->startOfMonth()->toDateString();
                        $monthEnd = Carbon\Carbon::create($year, $i, 1)->endOfMonth()->toDateString();
                        $monthData = $spr->first(function ($item) use ($monthStart, $monthEnd) {
                            return $item->periode >= $monthStart && $item->periode <= $monthEnd;
                        });
                        $notesnegrade = $monthData ? $monthData->notesnegrade : '';
                    @endphp
                    <td>{{ $notesnegrade }}</td>
                @endfor
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <th>Grade</th>
                <th>Quality</th>
                <th>Delivery</th>
                <th>S & E</th>
                <th>Audit</th>
            </tr>
            <tr>
                <td>A</td>
                <td>Product OK</td>
                <td>On Time</td>
                <td>Compliance</td>
                <td>Excellent</td>
            </tr>
            <tr>
                <td>B</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>Good</td>
            </tr>
            <tr>
                <td>C</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>Unsatisfy</td>
            </tr>
            <tr>
                <td>D</td>
                <td>Product NG</td>
                <td>Not on time / Pick up by ourself / Stop Production</td>
                <td>No Compliance</td>
                <td>Poor</td>
            </tr>
        </table>

        <div class="footer">
            <table style="margin-top: 20px; float: right; width: 300px">
                <tr>
                    <td>
                        Approved
                    </td>
                    <td>
                        Prepared
                    </td>
                </tr>
                <tr>
                    <td style="height: 50px">
                        {{ $signatureapp }}
                    </td>
                    <td>
                        <img src="{{ public_path($signature) }}" alt="TTD Creator" width="100px">
                    </td>
                </tr>
                <tr>
                    @foreach ($appv as $app)
                        <td>
                            Mochrita Lestari
                        </td>
                        <td>
                            {{ $app->created_by }}
                        </td>
                    @endforeach

                </tr>
            </table>
        </div>
    </div>
</body>

</html>
