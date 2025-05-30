@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('images/doctors_login.png') }}" class="rounded-circle" alt="Avatar"
                    style="width:72px;height:72px;object-fit:cover">
                <div>
                    <h4 class="fw-semibold mb-1">Willie Jennie</h4>
                    <span class="badge bg-light text-body-secondary border px-3 me-2">
                        Have uneven jawline
                    </span>
                    <a href="#" class="small text-danger text-decoration-none" data-bs-toggle="modal"
                        data-bs-target="#editPatientModal">Edit</a>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <a href="#!" class="btn btn-danger">Create Appointment</a>
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
                    <div class="pt-4">';

                        if ($title) {
                            echo '<div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="section-title mb-0">' .
                                $title .
                                '</h6>';
                            if ($updated) {
                                echo '<small class="text-muted">Last update ' . $updated . '</small>';
                            }
                            echo '</div>';
                        }

                        echo '<div class="row g-4">';
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

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="section-title mb-0">PATIENT DATA</h6>
                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus Data</button>
                    </form>
                </div>

                @php
                    section('', null, [
                        ['Age', '22 years old'],
                        ['Gender', 'Male'],
                        ['Email Address', 'willie.jennings@mail.com'],
                        ['Mobile number', '(302) 555-0107'],
                        ['Address', '8309 Barby Hill'],
                    ]);
                @endphp

                <hr class="my-4">

                @php
                    section('MEDICAL DATA', '12 June 2022', [
                        ['Blood pressure', '130 mm, 80 HG'],
                        ['Particular sickness', 'Heart Disease, Hepatitis'],
                        ['Allergic', 'Medicine allergic'],
                    ]);
                @endphp

                <hr class="my-4">

                @php
                    section('ORAL CHECK', '12 June 2022', [
                        ['Occlusi', 'Normal Bite'],
                        ['Torus Palatinus', 'No'],
                        ['Torus Mandibularis', 'No'],
                        ['Palatum', 'No'],
                        ['Diastema', 'Yes (tooth 11, 21)'],
                        ['Anomalous teeth', 'No'],
                    ]);
                @endphp
            </div>

            @for ($i = 1; $i < 4; $i++)
                <div class="tab-pane fade" id="pane-{{ $i }}" role="tabpanel">
                    <div class="text-center py-5 text-muted">Content coming soon…</div>
                </div>
            @endfor
        </div>
    </div>

    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="editPatientModalLabel">Edit Data Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patientName" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="patientName" name="name" value="Willie Jennie">
                    </div>
                    <div class="mb-3">
                        <label for="patientAge" class="form-label">Umur</label>
                        <input type="text" class="form-control" id="patientAge" name="age" value="22">
                    </div>
                    <div class="mb-3">
                        <label for="patientEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="patientEmail" name="email"
                            value="willie.jennings@mail.com">
                    </div>
                    <div class="mb-3">
                        <label for="patientPhone" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="patientPhone" name="phone"
                            value="(302) 555-0107">
                    </div>
                    <div class="mb-3">
                        <label for="patientAddress" class="form-label">Alamat</label>
                        <textarea class="form-control" id="patientAddress" name="address">8309 Barby Hill</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #dc3545;
            color: #dc3545;
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
