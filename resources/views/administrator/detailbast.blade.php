@extends('administrator.layouts.app')
@section('title', 'Data BAST')

@section('main')
    <div class="pagetitle">
        <h1>Data BAST</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Data</li>
                <li class="breadcrumb-item active">Detail BAST</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            @foreach ($bastdata as $bast)
            <div class="card-body">
                <h5 class="card-title">BAST NO. {{ $bast->bastno}}</h5>
                <div class="row">
                    <div class="col-6">
                    <h6>{{ $bast->workdesc }}</h6>
                    </div>
                    <div class="col-6">
                        <h6>
                        @if ($bast->status == 1)
                            Waiting Approval by EHS
                        @endif
                        @if ($bast->status == 2)
                            Waiting Approval by User
                        @endif
                        @if ($bast->status == 3)
                            Waiting Approval by Purchasing
                        @endif
                        @if ($bast->status == 4)
                            Waiting RR by Warehouse
                        @endif
                        @if ($bast->status == 5)
                            <i>BAST Approved</i>
                        @endif
                        </h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
@endsection

@section('blockjs')
@endsection
