@extends('layouts.app')
@section('title', 'Edit BAST')

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">Ubah Berita Acara Serah Terima Pekerjaan<br><span
                style="font-style: italic; font-size: 20px">(Handover of Work)</span></h4>
        @foreach ($detail as $bast)
            <div class="createbast border-top border-4 p-4">
                <div class="row mb-3">
                    <h4 class="mb-3">Informasi</h4>
                    <div class="px-2 col-6">
                        <div class="bd-left p-4" style="border-color: blue; height: 250px">
                            <h5 class="mb-3">Dikerjakan oleh</h5>
                            <table class="tbInfo">
                                @foreach ($supplier as $sp)
                                    <tr>
                                        <td style="width: 120px">Nama Supplier</td>
                                        <td>:&nbsp;</td>
                                        <td>{{ $sp->NamaSupplier }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top">Alamat</td>
                                        <td style="vertical-align: top">:&nbsp;</td>
                                        <td>{{ $sp->Alamat1 }}, {{ $sp->Alamat2 }}, {{ $sp->Kota }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kontak</td>
                                        <td>:&nbsp;</td>
                                        <td>Kontak disini
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="px-2 col-6">
                        <div class="bd-left p-4" style="border-color: blue; height: 250px">
                            <h5 class="mb-3">Ditujukan kepada</h5>
                            <table class="tbInfo">
                                <tr>
                                    <td style="width: 140px">Nama Perusahaan</td>
                                    <td>:&nbsp;</td>
                                    <td>SKF Indonesia</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top">Alamat</td>
                                    <td style="vertical-align: top">:&nbsp;</td>
                                    <td>Jl. Tipar - Inspeksi Cakung Drain, Cakung, RT.1/RW.9, Cakung Barat, RT.1/RW.9,
                                        Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kontak</td>
                                    <td>:&nbsp;</td>
                                    <td>0210123991</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <form action="{{ url('inputedit') }}" method="post" id="inputedit" enctype="multipart/form-data">
                        @csrf
                        <h4 class="my-3">Detail Pekerjaan</h4>
                        <div class="col-12">
                            <div class="bd-left p-4" style="border-color: blue;">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">No. Purchase Order</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="ponumber"
                                            value="{{ $bast->pono }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">No. Berita Acara</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="bastnumber"
                                            value="{{ $bast->bastno }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">No. Ref. Penawaran
                                        Harga</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="offernumber"
                                            value="{{ $bast->offerno }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Dibuat Oleh</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="createdby" name="createdby"
                                            value="{{ $bast->createdby }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="jobname" class="col-sm-2 col-form-label">Nama Pekerjaan<span
                                            style="color:red">*</span><br><span
                                            style="font-size: 14px; font-style: italic">(penulisan sesuai di
                                            PO)</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="jobname" name="jobname"
                                            value="{{ $bast->workdesc }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="startdate" class="col-sm-2 col-form-label">Tanggal Mulai<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="startdate" name="startdate"
                                            value="{{ $bast->workstart }}" required>
                                    </div>
                                    <label for="enddate" class="col-sm-2 col-form-label">Tanggal Selesai<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" id="enddate" name="enddate"
                                            value="{{ $bast->workend }}" required>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="jobname" class="col-sm-2 col-form-label">User Approval<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-10">
                                        <select name="userapproval" id="userapproval" class="form-control" required>
                                            @foreach ($dept as $rdept)
                                                <option value="{{ $rdept->alias }}"
                                                    @if ($rdept->alias == $bast->to_user) selected @endif>
                                                    {{ $rdept->alias }} - {{ $rdept->nama_dept }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Edit BAST</button>
        @endforeach
        </form>
    </div>
    </div>
    </div>
@endsection

@section('blockjs')
    <script>
        $(document).ready(function() {
            const allowfiles = new Set(['application/pdf']);
            const onlypdf = document.querySelectorAll('.onlypdf');

            onlypdf.forEach(function(pdf) {
                pdf.addEventListener('change', function() {
                    if (!allowfiles.has(this.files[0].type)) {
                        Swal.fire({
                            title: "ERROR!",
                            text: "Format file yang diizinkan adalah PDF!",
                            icon: "error",
                            confirmButtonText: "Tutup"
                        });
                        this.value = '';
                    } else {
                        // alert("OK");
                    }
                });
            });

        })
    </script>
    <script>
        $(".tbItemPO").DataTable({
            // searching: "false",
            dom: "rtip",
            columnDefs: [{
                className: "dt-center",
                targets: "_all"
            }],
            pageLength: 10
        });
    </script>
@endsection
