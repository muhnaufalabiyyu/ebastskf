@extends('layouts.app')
@section('title', 'Create BAST')

@section('main')
<div class="container mt-3">
    <h4 class="mb-3" align="center">Buat Berita Acara Serah Terima Pekerjaan<br><span
            style="font-style: italic; font-size: 20px">(Handover of Work)</span></h4>

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
                                <td>{{ $sp->supplier_name }}
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">Alamat</td>
                                <td style="vertical-align: top">:&nbsp;</td>
                                <td>{{ $sp->address }}, {{ $sp->address_2 }}, {{ $sp->city }}
                                </td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td>:&nbsp;</td>
                                <td><i>Unavailable</i>
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
            <form action="{{ url('inputbast') }}" method="post" id="inputbast" enctype="multipart/form-data">
                @csrf
                <h4 class="my-3">Detail Pekerjaan</h4>
                <div class="col-12">
                    <div class="bd-left p-4" style="border-color: blue;">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">No. Purchase Order</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="ponumber" placeholder="No. Purchase Order"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label">No. Ref. Penawaran
                                Harga</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="offernumber"
                                    placeholder="No. Ref. Penawaran Harga" required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Dibuat Oleh</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="createdby" name="createdby"
                                    value="{{ Auth::user()->name }}" readonly required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="jobname" class="col-sm-2 col-form-label">Nama Pekerjaan<span
                                    style="color:red">*</span><br><span
                                    style="font-size: 14px; font-style: italic">(penulisan sesuai di
                                    PO)</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jobname" name="jobname"
                                    placeholder="Nama Pekerjaan" required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="startdate" class="col-sm-2 col-form-label">Tanggal Mulai<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="startdate" name="startdate" required>
                            </div>
                            <label for="enddate" class="col-sm-2 col-form-label">Tanggal Selesai<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="enddate" name="enddate" required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="jobname" class="col-sm-2 col-form-label">User Approval<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <select name="userapproval" id="userapproval" class="form-control" required>
                                    <option value="" selected disabled>Pilih User (Departemen)</option>
                                    @foreach ($dept as $rdept)
                                        <option value="{{ $rdept->alias }}">{{ $rdept->alias }} -
                                            {{ $rdept->nama_dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="my-3">Lampiran</h4>
                <div class="col-12">
                    <div class="bd-left p-4" style="border-color: blue;">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Salinan PO<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control onlypdf" id="copypo" name="copypo"
                                    accept="application/pdf" required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Penawaran Harga<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control onlypdf" id="offerfile" name="offerfile"
                                    accept="application/pdf" required>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Bukti Pengerjaan<span
                                    style="color:red">*</span></label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control onlypdf" id="reportfile" name="reportfile"
                                    accept="application/pdf" required>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="my-3">Lain lain <span style="font-size: 16px"><i>(hanya jika dibutuhkan)</i></span>
                </h4>
                <div class="col-12">
                    <div class="bd-left p-4" style="border-color: blue;">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Lampiran E-NOFA</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control onlypdf" id="enofafile" name="enofafile"
                                    accept="application/pdf">
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Faktur Pajak</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control onlypdf" id="fakturpajak" name="fakturpajak"
                                    accept="application/pdf">
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="my-3">Item in Charge <i>(penulisan sesuai dengan PO)</i></h3>
                <div class="col-12">
                    <div class="bd-left p-4" style="border-color: blue;">
                        <label for="itemCharge" class="form-label">Pilih Jumlah Item terlebih dahulu</label>
                        <select name="itemCharge" id="itemCharge" class="form-control mb-3">
                            <option selected disabled>Jumlah Item in Charge</option>
                            @for ($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <table class="table table-bordered table-striped text-center tbItemPO" id="tbItemPO">
                            <thead>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Item Spec.</th>
                                <th style="width: 100px">Quantity</th>
                                <th style="width: 100px">Unit</th>
                            </thead>
                            <tbody id="tableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3" id="createbtn" disabled>Create BAST</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('blockjs')
<script>
    // IDR Formatter
    function formatToIDR(value) {
        const formatter = new Intl.NumberFormat('id-ID', {});
        return formatter.format(value);
    };

    $(document).ready(function () {
        const allowfiles = new Set(['application/pdf']);
        const onlypdf = document.querySelectorAll('.onlypdf');

        onlypdf.forEach(function (pdf) {
            pdf.addEventListener('change', function () {
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
    });

    const itemqty = document.getElementById('itemCharge');
    const tbody = document.getElementById('tableBody');
    const createbtn = document.getElementById('createbtn');

    itemqty.addEventListener('change', function () {
        const qty = parseInt(this.value, 10);
        tbody.innerHTML = '';
        createbtn.removeAttribute('disabled');

        for (let i = 1; i <= qty; i++) {
            const row = document.createElement('tr');

            row.innerHTML = `
            <td>${i}.</td>
            <td><input name="items[${i}][itemname]" type="text" class="form-control" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" placeholder="Add item here" required></td>
            <td><input name="items[${i}][itemspec]" type="text" class="form-control" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" required></td>
            <td style="width: 100px"><input name="items[${i}][qtyitem]" type="number" class="form-control" required></td>
            <td style="width: 100px"><input name="items[${i}][unititem]" type="text" class="form-control" style="text-transform:uppercase" onkeypress="return /[0-9a-zA-Z]/i.test(event.key)" required></td>
        `;
            tbody.appendChild(row);
        }
    });
</script>
@endsection