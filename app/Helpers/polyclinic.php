<?php

if (!function_exists('polyclinicBadge')) {
    function polyclinicBadge($type)
    {
        $types = [
            1 => ['label' => 'General Dentistry', 'class' => 'bg-primary', 'icon' => 'fa-tooth'],
            2 => ['label' => 'Orthodontics', 'class' => 'bg-success', 'icon' => 'fa-teeth-open'],
            3 => ['label' => 'Endodontics', 'class' => 'bg-warning', 'icon' => 'fa-teeth'],
            4 => ['label' => 'Esthetic Dentistry', 'class' => 'bg-info', 'icon' => 'fa-smile'],
        ];

        return $types[$type] ?? [
            'label' => 'General Practice',
            'class' => 'bg-secondary',
            'icon' => 'fa-hospital'
        ];
    }
}
