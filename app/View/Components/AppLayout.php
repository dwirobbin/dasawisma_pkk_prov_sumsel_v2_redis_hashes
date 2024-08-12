<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    public $styles = null;
    public $scripts = null;

    public function render(): View
    {
        return view('layouts.app');
    }
}
