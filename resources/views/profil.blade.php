@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/avatar_placeholder.jpg') }}" class="rounded-circle" alt="Avatar"
                    style="width:72px;height:72px;object-fit:cover">

                <div>
                    <h4 class="fw-semibold mb-1">Willie Jennie</h4>

                    <span class="badge bg-light text-body-secondary border px-3 me-2">
                        Have uneven jawline
                    </span>
                    <a href="#!" class="small text-primary text-decoration-none">Edit</a>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="#!" class="btn btn-primary">Create Appointment</a>

                <div class="dropdown">
                    <button class="btn btn-link text-secondary fs-5 p-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end small">
                        <li><a class="dropdown-item" href="#!">Print Card</a></li>
                        <li><a class="dropdown-item" href="#!">Archive</a></li>
                        <li><a class="dropdown-item text-danger" href="#!">Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>


        {{-- ───────────────────── Tabs ───────────────────── --}}
        <ul class="nav nav-tabs border-bottom mb-4" id="profileTabs" role="tablist">
            @php
                $tabs = ['Patient Information', 'Appointment History', 'Next Treatment', 'Medical Record'];
            @endphp
            @foreach ($tabs as $k => $label)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $k === 0 ? 'active' : '' }}" id="tab-{{ $k }}"
                        data-bs-toggle="tab" data-bs-target="#pane-{{ $k }}" type="button" role="tab">
                        {{ $label }}
                    </button>
                </li>
            @endforeach
        </ul>


        <div class="tab-content" id="profileTabsContent">

            <div class="tab-pane fade show active" id="pane-0" role="tabpanel">
                @php
                    function section($title, $updated = null, $rows = [])
                    {
                        echo '
                    <div class="pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="section-title mb-0">' .
                            $title .
                            '</h6>';
                        if ($updated) {
                            echo '<small class="text-muted">Last update ' . $updated . '</small>';
                        }
                        echo '</div>
                          <div class="row g-4">';
                        foreach ($rows as $row) {
                            echo '
                        <div class="col-md-4">
                            <p class="text-muted mb-0">' .
                                $row[0] .
                                '</p>
                            <p class="fw-medium mb-0">' .
                                $row[1] .
                                '</p>
                        </div>';
                        }
                        echo '</div></div>';
                    }
                @endphp

                @php section('PATIENT DATA', null, [['Age', '22 years old'], ['Gender', 'Male'], ['Email Address', 'willie.jennings@mail.com'], ['Mobile number', '(302) 555-0107'], ['Address', '8309 Barby Hill']]); @endphp

                <hr class="my-4">

                @php section('MEDICAL DATA', '12 June 2022', [['Blood pressure', '130 mm, 80 HG'], ['Particular sickness', 'Heart Disease, Hepatitis'], ['Allergic', 'Medicine allergic']]); @endphp

                <hr class="my-4">

                @php section('ORAL CHECK', '12 June 2022', [['Occlusi', 'Normal Bite'], ['Torus Palatinus', 'No'], ['Torus Mandibularis', 'No'], ['Palatum', 'No'], ['Diastema', 'Yes (tooth 11, 21)'], ['Anomalous teeth', 'No']]); @endphp

            </div>

            @for ($i = 1; $i < 4; $i++)
                <div class="tab-pane fade" id="pane-{{ $i }}" role="tabpanel">
                    <div class="text-center py-5 text-muted">Content coming soon…</div>
                </div>
            @endfor
        </div>
    </div>

    {{-- ───────────────────── Quick CSS tweaks ───────────────────── --}}
    <style>
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #1976d2;
            color: #1976d2;
        }

        .section-title {
            position: relative;
            padding-left: 1rem;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 3px;
            height: calc(100% - 6px);
            width: 3px;
            background: #000;
        }
    </style>
@endsection
