@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- ───────────────────── Greeting ───────────────────── --}}
        <h4 class="fw-semibold mb-1">Welcome back, Avery</h4>
        <p class="text-muted mb-4">Here’s what’s happening with your dashboard today</p>

        {{-- ───────────────────── Stat cards ───────────────────── --}}
        @php
            // card helper: [title, value, diff, positive?]
            $stats = [
                ['Total Service Requests', '1,655', '36% in total', true],
                ['Open Requests', '231', '20% in total', false],
                ['Completed', '20', '1% this month', true],
                ['Closed', '1300', '36% completed', true],
            ];
        @endphp

        <div class="row g-3 mb-5">
            @foreach ($stats as $s)
                <div class="col-6 col-md-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body px-3 py-4">
                            <h6 class="text-muted small mb-1">{{ $s[0] }}</h6>
                            <h3 class="fw-semibold mb-2">{{ $s[1] }}</h3>
                            <span
                                class="d-flex align-items-center gap-1
                                     small {{ $s[3] ? 'text-success' : 'text-danger' }}">
                                <i class="fa-solid {{ $s[3] ? 'fa-arrow-up' : 'fa-arrow-down' }} fs-6"></i>
                                {{ $s[2] }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ───────────────────── Recent Request ───────────────────── --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <h5 class="mb-0">Recent Request</h5>
            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text bg-white border-end-0"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search">
            </div>
        </div>
        <p class="text-muted mb-3 small">Manage your patients request details</p>

        {{-- Tabs --}}
        <ul class="nav nav-pills mb-3 small" id="reqTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#recent"
                    type="button">Recent</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#completed" type="button">Completed</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#selected" type="button">Selected</button>
            </li>
            <li class="ms-auto">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-1">
                    <i class="fa fa-sliders-h"></i> Filters
                </button>
            </li>
        </ul>

        <div class="tab-content" id="reqTabsContent">
            {{-- ── Recent pane ── --}}
            <div class="tab-pane fade show active" id="recent" role="tabpanel">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="small table-light">
                            <tr>
                                <th style="width:28px"><input class="form-check-input m-0" type="checkbox"></th>
                                <th>Request ID</th>
                                <th>Patient Name</th>
                                <th>UHID</th>
                                <th>Agent</th>
                                <th>Service Type</th>
                                <th>Hospital Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            {{-- Row helper --}}
                            @php
                                function row($id, $name, $email, $uhid, $agent, $service, $hospital, $status)
                                {
                                    $badge =
                                        $status === 'Open'
                                            ? '<span class="badge bg-success-subtle text-success">Open</span>'
                                            : '<span class="badge bg-danger-subtle text-danger">Closed</span>';
                                    echo "
                                  <tr>
                                     <td><input class='form-check-input m-0' type='checkbox'></td>
                                     <td class='fw-semibold'>#$id</td>
                                     <td>
                                        <div class='d-flex flex-column'>
                                            <span class='fw-medium'>$name</span>
                                            <span class='text-muted'>$email</span>
                                        </div>
                                     </td>
                                     <td>$uhid</td>
                                     <td>$agent</td>
                                     <td>$service</td>
                                     <td>$hospital</td>
                                     <td>$badge</td>
                                  </tr>";
                                }
                            @endphp

                            @php row('112653','Random Guy','simpledomain1234@gmail.com',904,'Martial Wu','SMO','Bryan Hospital','Open');  @endphp
                            @php row('113876','Twoebee James','phoenix@website.com',112,'Martial Wu','SMO','Simple Hospital','Closed'); @endphp
                            @php row('223212','Martin Webb','normal1234@website.com',987,'Martial Wu','Tele-Medicine','Simple Hospital','Open'); @endphp
                            @php row('888821','Taylor Smith','activemom@website.com',163,'Martial Wu','SMO','Simple Hospital','Open'); @endphp
                            @php row('888822','Greg Abernathy','realone@website.com',789,'Martial Wu','Tele-Medicine','Simple Hospital','Closed'); @endphp
                            @php row('200033','Darmaya Smitherson','leverage404@website.com',533,'Martial Wu','SMO','Simple Hospital','Open'); @endphp
                            @php row('113876','Twoebee James','phoenix@website.com',642,'Martial Wu','SMO','Simple Hospital','Closed'); @endphp
                            @php row('888821','Taylor Smith','activemom@website.com',832,'Martial Wu','SMO','Simple Hospital','Open'); @endphp
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Completed / Selected panes placeholder --}}
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <div class="text-center py-5 text-muted">No completed requests…</div>
            </div>
            <div class="tab-pane fade" id="selected" role="tabpanel">
                <div class="text-center py-5 text-muted">No selected requests…</div>
            </div>
        </div>

        <style>
            .table thead th {
                white-space: nowrap;
            }

            .badge.bg-success-subtle {
                background: #e6f4ea !important;
            }

            .badge.bg-danger-subtle {
                background: #fde7e9 !important;
            }

            .nav-pills .nav-link.active {
                background: #1daa5e;
            }
        </style>
    </div>
@endsection
