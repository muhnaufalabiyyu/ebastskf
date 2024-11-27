@extends('layouts.app')
@section('title', 'Create SPR')

@section('blockstyle')
    <style>
        .select2-container .select2-selection--single {
            height: 37.5px;
            border-color: rgb(229, 229, 229);
        }
    </style>
@endsection

@section('main')
    <div class="container mt-3">
        <h4 class="mb-3" align="center">Supplier Perfomance Report<br><span
                style="font-style: italic; font-size: 20px">(Laporan Kinerja Pemasok)</span></h4>

        <div class="createbast border-top border-4 p-4">
            <div class="row mb-3">
                <form action="{{ url('inputspr') }}" method="post" id="inputspr" enctype="multipart/form-data">
                    @csrf
                    <h4 class="my-3">Informasi Umum</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="supplier_code" class="col-sm-2 col-form-label">Supplier Name<span
                                        style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="supplier_code" id="supplier_code" class="form-control" required>
                                        <option value="" selected disabled>Pilih Supplier</option>
                                        @foreach ($supplier as $suppliers)
                                            <option value="{{ $suppliers->supplier_code }}">{{ $suppliers->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="periode" class="col-sm-2 col-form-label">Periode Penilaian<span
                                        style="color:red">*</span><br></label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="periode" name="periode" required>
                                </div>
                                <div class="col-sm-6"><span style="font-size: 14px; font-style: italic">(pilih tanggal bebas
                                        di bulan dan tahun yang ingin dipilih)</span></div>
                            </div>
                        </div>
                    </div>
                    {{-- Grade Details --}}
                    <h4 class="my-3">Grading Instructions</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <table class="table table-bordered text-center">
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
                        </div>
                    </div>

                    <h4 class="my-3">Quality Performance</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Overall<span
                                        style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="qualitygrade" id="qualitygrade" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="my-3">Delivery Performance</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Overall<span
                                        style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="deliverygrade" id="deliverygrade" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="my-3">Safety and Environment Performance</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">All product complited MSDS<span
                                        style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="sne1" id="sne1" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Label : Identify, Expired date,
                                    Safety & Enviroment<span style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="sne2" id="sne2" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Packaging not Leak<span
                                        style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <select name="sne3" id="sne3" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Transportation get Permit &
                                    Emission Test<span style="color:red">*</span></label>
                                <div class="col-sm-10 mt-3">
                                    <select name="sne4" id="sne4" class="form-control" required>
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="my-3">Audit Result (optional)</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Overall</label>
                                <div class="col-sm-10">
                                    <select name="auditresultgrade" id="auditresultgrade" class="form-control">
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="my-3">Note (Finding)</h4>
                    <div class="col-12">
                        <div class="bd-left p-4" style="border-color: blue;">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Quality</label>
                                <div class="col-sm-10">
                                    <select name="notequalitygrade" id="notequalitygrade" class="form-control">
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Delivery</label>
                                <div class="col-sm-10">
                                    <select name="notedeliverygrade" id="notedeliverygrade" class="form-control">
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Safety and Environment</label>
                                <div class="col-sm-10">
                                    <select name="notesnegrade" id="notesnegrade" class="form-control">
                                        <option value="" selected disabled>Choose Grade</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Create SPR</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('blockjs')
    <script>
        $(document).ready(function() {
            $('#suppliername').select2();
        });
    </script>
@endsection
