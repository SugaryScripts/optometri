<?php

namespace App\Helper;

trait WithSweetAlert {

    public function alert($type, $title, array $options = []) {
        // Default options
        $defaultOptions = [
            'icon' => $type,
            'title' => $title
        ];

        // Merge default options with provided options
        $alertOptions = array_merge($defaultOptions, $options);

        // Remove null values to keep the payload clean
        $alertOptions = array_filter($alertOptions, function($value) {
            return $value !== null;
        });

        // Dispatch browser event with alert configuration
        $this->dispatch('swal:alert', data: $alertOptions);
    }

    public function confirmAlert($type, $title, array $options = []) {
        $defaultConfirmOptions = [
            'icon' => $type,
            'title' => $title,
            'showCancelButton' => true,
            'showConfirmButton' => true,
            'showDenyButton' => false,
        ];

        $confirmOptions = array_merge($defaultConfirmOptions, $options);

        // Add event listeners for confirmation
        if (isset($confirmOptions['onConfirmed'])) {
            $confirmOptions['onConfirm'] = $confirmOptions['onConfirmed'];
            unset($confirmOptions['onConfirmed']);
        }

        if (isset($confirmOptions['onDenied'])) {
            $confirmOptions['onDeny'] = $confirmOptions['onDenied'];
            unset($confirmOptions['onDenied']);
        }

        $this->dispatch('swal:confirm', data: $confirmOptions);
    }
}
