@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- ───────────────────── Heading ───────────────────── --}}
        <h4 class="fw-semibold mb-0">Appointment List</h4>
        <p class="text-muted">{{ \Carbon\Carbon::now()->format('F d, Y') }}</p>

        {{-- ───────────────────── Filters + search ───────────────────── --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div class="btn-group btn-group-sm" id="apptFilters" role="group">
                <button class="btn btn-primary active" data-bs-toggle="pill" data-bs-target="#all">All</button>
                <button class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#new">New&nbsp;Appts</button>
                <button class="btn btn-outline-primary" data-bs-toggle="pill"
                    data-bs-target="#checkedin">Checked-in</button>
                <button class="btn btn-outline-primary" data-bs-toggle="pill" data-bs-target="#completed">Completed</button>
            </div>

            <div class="input-group input-group-sm w-auto">
                <span class="input-group-text bg-white border-end-0"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search…">
            </div>
        </div>

        {{-- ───────────────────── Tab panes ───────────────────── --}}
        <div class="tab-content">

            {{-- ── All (default) ── --}}
            <div class="tab-pane fade show active" id="all">
                <div class="row g-4">

                    {{-- Helper for card --}}
                    @php
                        /*
                         * card(
                         *   [0] = name        [1] = phone
                         *   [2] = datetime    [3] = doctor / location
                         *   [4] = items[]     [5] = total
                         *   [6] = status      ['new','in','done','cancel']
                         */
                        function card($x)
                        {
                            $badge = match ($x[6]) {
                                'new' => '<span class="badge bg-primary-subtle text-primary">New</span>',
                                'in' => '<span class="badge bg-warning-subtle text-warning">Checked-in</span>',
                                'done' => '<span class="badge bg-success-subtle text-success">Completed</span>',
                                'cancel' => '<span class="badge bg-danger-subtle  text-danger">Cancelled</span>',
                            };
                            echo '
                        <div class="col-12 col-md-6 col-lg-4">
                          <div class="card h-100 shadow-sm border-0">
                            <div class="card-body small">

                              <!-- Header -->
                              <div class="d-flex justify-content-between mb-1">
                                <div>
                                  <h6 class="fw-semibold mb-0">' .
                                $x[0] .
                                '</h6>
                                  <span class="text-muted">' .
                                $x[1] .
                                '</span>
                                </div>
                                ' .
                                $badge .
                                '
                              </div>

                              <!-- Meta -->
                              <ul class="list-unstyled mb-2">
                                <li class="d-flex align-items-center gap-2">
                                  <i class="fa fa-clock text-muted"></i>
                                  <span>' .
                                $x[2] .
                                '</span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                  <i class="fa fa-user-md text-muted"></i>
                                  <span>' .
                                $x[3] .
                                '</span>
                                </li>
                              </ul>

                              <!-- Items -->
                              <p class="text-muted mb-1">' .
                                count($x[4]) .
                                ' procedures</p>';
                            foreach ($x[4] as $item) {
                                echo '<div class="d-flex justify-content-between"><span>' .
                                    $item[0] .
                                    '</span><span class="text-nowrap">' .
                                    $item[1] .
                                    '</span></div>';
                            }
                            echo '
                              <div class="d-flex justify-content-between mt-2 fw-semibold">
                                <span>Total</span><span class="text-primary">' .
                                $x[5] .
                                '</span>
                              </div>

                            </div>
                          </div>
                        </div>';
                        }
                    @endphp


                    {{-- Demo cards --}}
                    @php card(['David Moore', '+1 987 654 3210', '11 : 00 AM, 08 Feb 2024', 'Dentist – Room 1', [['Scaling', '$12.00'], ['X-Ray', '$7.50'], ['Fluoride', '$3.00']], '$22.50', 'new']); @endphp

                    @php card(['Esther Howard', '+1 987 654 3210', '11 : 30 AM, 08 Feb 2024', 'Dentist – Room 2', [['Cleaning', '$14.00'], ['Sealant', '$8.00']], '$22.00', 'new']); @endphp

                    @php card(['Arlene McCoy', '+1 987 654 3210', '01 : 00 PM, 08 Feb 2024', 'Dentist – Room 5', [['Whitening', '$13.00'], ['Polish', '$3.50'], ['Exam', '$4.50']], '$21.00', 'in']); @endphp

                    @php card(['Courtney Henry', '+1 987 654 3210', '05 : 00 PM, 08 Feb 2024', 'Dentist – Room 9', [['Crown prep', '$14.00']], '$14.00', 'cancel']); @endphp

                    @php card(['Devon Lane', '+1 987 654 3210', '06 : 00 PM, 08 Feb 2024', 'Dentist – Room 10', [['Retainer check', '$12.00']], '$12.00', 'done']); @endphp

                    @php card(['Ronald Richards', '+1 987 654 3210', '08 : 00 PM, 08 Feb 2024', 'Dentist – Room 11', [['Invisalign adj.', '$20.50']], '$20.50', 'done']); @endphp

                </div> {{-- row --}}
            </div>

            {{-- Extra panes (place-holders) --}}
            <div class="tab-pane fade" id="new">
                <div class="text-center py-5 text-muted">No new appointments…</div>
            </div>
            <div class="tab-pane fade" id="checkedin">
                <div class="text-center py-5 text-muted">Nobody checked-in…</div>
            </div>
            <div class="tab-pane fade" id="completed">
                <div class="text-center py-5 text-muted">No completed appointments…</div>
            </div>
        </div>

        {{-- ───────────────────── Tiny CSS helpers ───────────────────── --}}
        <style>
            .badge.bg-primary-subtle {
                background: #e7f1ff !important;
            }

            .badge.bg-warning-subtle {
                background: #fff4e5 !important;
            }

            .badge.bg-success-subtle {
                background: #e6f4ea !important;
            }

            .badge.bg-danger-subtle {
                background: #fde7e9 !important;
            }
        </style>
    </div>
@endsection
