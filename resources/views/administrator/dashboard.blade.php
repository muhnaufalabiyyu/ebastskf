@extends('administrator.layouts.app')
@section('title', 'Dashboard')

@section('main')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">User Login <span>| Now</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $total_users }}</h6>
                                        <span class="text-muted small pt-1">User logged in</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">BAST <span>| Until Now</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-file-earmark-check-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $total_bast }}</h6>
                                        <span class="text-muted small pt-1">Created</span>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Suppliers <span>| Until Now</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $total_supplier }}</h6>
                                        <span class="text-muted small pt-1">Registered</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                </div>
                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">User Login</h5>
                            <table class="table table-borderless tbuserlogin">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Supplier/Dept.</th>
                                        <th scope="col">Accessed on</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userlogin as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}.</th>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                @if ($user->dept == null)
                                                    Supplier
                                                @else
                                                    {{ $user->dept }}
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($user->last_access)) }}</td>
                                            <td><span class="badge bg-success">Verified</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- End Recent Sales -->
            </div>
            <!-- End of Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- Recent Activity -->
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title">Recent Activity</h5>

                        <div class="activity">
                            @foreach ($activity as $act)
                                <div class="activity-item d-flex">
                                    @php
                                        $activityTime = \Carbon\Carbon::parse($act->time);
                                        $currentTime = \Carbon\Carbon::now();
                                        $timeDiff = $currentTime->diffInMinutes($activityTime);
                                    @endphp

                                    @if ($timeDiff < 1)
                                        <div class="activite-label">Just now</div>
                                    @elseif ($timeDiff < 60)
                                        <div class="activite-label">{{ $timeDiff }} min</div>
                                    @else
                                        <div class="activite-label">
                                            {{ str_replace(['ago', 'from now'], '', $activityTime->diffForHumans()) }}</div>
                                    @endif
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">
                                        <span class="fw-bold text-dark">
                                            @if ($act->activity == 'approval')
                                                {{ $act->name }}
                                            @else
                                                {{ $act->supplier_name }}
                                            @endif
                                        </span>
                                        @if ($act->activity == 'approval')
                                            melakukan approval Berita Acara.
                                        @else
                                            membuat Berita Acara.
                                        @endif
                                    </div>
                                </div><!-- End activity item-->
                            @endforeach
                        </div>

                    </div>
                </div><!-- End Recent Activity -->
            </div>
        </div>
    </section>

    <section class="section">

    </section>
@endsection

@section('blockjs')
    <script>
        $(".tbuserlogin").DataTable({
            dom: "Bfrtip",
            columnDefs: [{
                targets: "_all"
            }],
            "language": {
                "emptyTable": "Tidak ada user yang sedang login"
            },
            pageLength: 10
        });
    </script>
@endsection
