<?php

namespace App\Helper;

trait WithSweetAlert {
    /**
     * Flash a SweetAlert notification
     *
     * @param string $icon Type of alert (success, error, warning, info, question)
     * @param string $message Main message to display
     * @param array $options Additional customization options
     * @return void
     */
    public function alert(array $options = []) {
        // Default options
        $defaultOptions = [
            'icon' => 'success',
            'title' => 'Berhasil!'
        ];

        // Merge default options with provided options
        $alertOptions = array_merge($defaultOptions, $options);

        // Dispatch browser event with alert configuration
        $this->dispatch('swal', data: $alertOptions);
    }
}
