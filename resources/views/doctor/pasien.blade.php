@extends('layouts.app')

@section('content')
    {{-- ───────────────────── Tabs (Active / Inactive) ───────────────────── --}}
    <ul class="nav nav-tabs border-bottom mb-3" id="patientTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#activePane" type="button">Active
                Treatment</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#inactivePane" type="button">Inactive
                Treatment</button>
        </li>
    </ul>

    <div class="tab-content" id="patientTabsContent">
        {{-- ───────────────────── Active list ───────────────────── --}}
        <div class="tab-pane fade show active" id="activePane">

            {{-- Toolbar --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="mb-0">
                    <span class="fw-semibold">72</span> <small class="text-muted">total patients</small>
                </h5>

                <div class="d-flex align-items-center gap-2 ms-auto">
                    <button class="btn btn-light border d-flex align-items-center gap-2">
                        <i class="fa fa-sliders-h"></i><span>Filters</span>
                    </button>

                    <div class="btn-group">
                        <button class="btn btn-light border">
                            <i class="fa fa-th"></i>
                        </button>
                        <button class="btn btn-light border active">
                            <i class="fa fa-list"></i>
                        </button>
                    </div>

                    <a href="#!" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="fa fa-plus"></i><span>Add Patient</span>
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th style="width:28px;">
                                <input class="form-check-input m-0" type="checkbox">
                            </th>
                            <th>PATIENT NAME <i class="fa fa-chevron-down ms-1 text-muted small"></i></th>
                            <th>PHONE <i class="fa fa-chevron-down ms-1 text-muted small"></i></th>
                            <th>EMAIL</th>
                            <th>ADDRESS <i class="fa fa-chevron-down ms-1 text-muted small"></i></th>
                            <th>REGISTERED</th>
                            <th>LAST VISIT</th>
                            <th>LAST TREATMENT</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- ── Row template ── --}}
                        @php
                            // Quick helper for avatar cell
                            function avatar($src, $initials = null, $color = '#e0e7ff')
                            {
                                if ($src) {
                                    return '<img src="' .
                                        asset($src) .
                                        '" class="rounded-circle"
                                                 style="width:32px;height:32px;object-fit:cover">';
                                }
                                return '<span class="d-inline-flex rounded-circle text-white justify-content-center
                                                align-items-center fw-semibold"
                                              style="width:32px;height:32px;background:' .
                                    $color .
                                    '">' .
                                    $initials .
                                    '</span>';
                            }
                        @endphp

                        {{-- 1 --}}
                        <tr>
                            <td><input class="form-check-input m-0" type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {!! avatar('images/avatars/willie.jpg') !!}
                                    Willie Jennie
                                </div>
                            </td>
                            <td><i class="fa fa-phone me-1 text-muted"></i>(302) 555-0107</td>
                            <td><i class="fa fa-envelope me-1 text-muted"></i>willie.jennings@example.com</td>
                            <td>8309 Barby Hill</td>
                            <td>Mar 12 2021</td>
                            <td>05 Jun 2021</td>
                            <td>Tooth Scaling + Bleach</td>
                        </tr>

                        {{-- 2 --}}
                        <tr>
                            <td><input class="form-check-input m-0" type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {!! avatar('images/avatars/michelle.jpg') !!}
                                    Michelle Rivera
                                </div>
                            </td>
                            <td><i class="fa fa-phone me-1 text-muted"></i>(208) 555-0112</td>
                            <td><i class="fa fa-envelope me-1 text-muted"></i>michelle.rivera@example.com</td>
                            <td>534 Victoria Trail</td>
                            <td>Mar 12 2021</td>
                            <td>03 May 2021</td>
                            <td>Tooth Scaling + Veneer</td>
                        </tr>

                        {{-- 3 --}}
                        <tr>
                            <td><input class="form-check-input m-0" type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {!! avatar(null, 'TJ', '#c7d2fe') !!}
                                    Tim Jennings
                                </div>
                            </td>
                            <td><i class="fa fa-phone me-1 text-muted"></i>(225) 555-0118</td>
                            <td><i class="fa fa-envelope me-1 text-muted"></i>tim.jennings@example.com</td>
                            <td>87 Dahle Way</td>
                            <td>Mar 10 2021</td>
                            <td>17 Oct 2021</td>
                            <td>Tooth Scaling</td>
                        </tr>

                        {{-- continue adding rows exactly as you need … --}}
                        {{-- 4 --}}
                        <tr>
                            <td><input class="form-check-input m-0" type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {!! avatar(null, 'DC', '#fecdd3') !!}
                                    Deanna Curtis
                                </div>
                            </td>
                            <td><i class="fa fa-phone me-1 text-muted"></i>(229) 555-0109</td>
                            <td><i class="fa fa-envelope me-1 text-muted"></i>deanna.curtis@example.com</td>
                            <td>755 Butterfield Place</td>
                            <td>Mar 09 2021</td>
                            <td>26 Oct 2020</td>
                            <td>Root Canal Treatment</td>
                        </tr>

                        {{-- … up to however many preview rows you’d like --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ───────────────────── Inactive pane (placeholder) ───────────────────── --}}
        <div class="tab-pane fade" id="inactivePane">
            <div class="text-center py-5 text-muted">No data yet…</div>
        </div>
    </div>

    <style>
        .table td,
        .table th {
            white-space: nowrap;
        }

        .table-hover tbody tr:hover {
            background: #fafafa;
        }

        .nav-tabs .nav-link.active {
            border-bottom: 2px solid #1976d2;
            color: #1976d2;
        }

        .btn-group .btn.active {
            background: #f1f5f9;
        }
    </style>
@endsection
