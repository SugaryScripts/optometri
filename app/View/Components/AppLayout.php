<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component {

    public $sessionData;

    public function __construct() {
        $defaults = [
            'preset' => 'preset-1',
            'sidebar_caption' => true,
            'layout' => 'vertical',
            'direction' => 'ltr',
            'theme_contrast' => true,
            'theme' => 'dark',
        ];

        // Load session data or fallback to database or defaults
        $this->sessionData = [
            'preset' => session('pc_preset') ?? $defaults['pc_preset'],
            'sidebar_caption' => session('pc_sidebar_caption') ?? $defaults['pc_sidebar_caption'],
            'layout' => session('pc_layout') ?? $defaults['pc_layout'],
            'direction' => session('pc_direction') ?? $defaults['pc_direction'],
            'theme_contrast' => session('pc_theme_contrast') ?? $defaults['pc_theme_contrast'],
            'theme' => session('pc_theme') ?? $defaults['pc_theme'],
        ];

        // Store these in session for subsequent requests
        foreach ($this->sessionData as $key => $value) {
            session([$key => $value]);
        }
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View {
        return view('layouts.app');
    }
}
