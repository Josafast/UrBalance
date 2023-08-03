<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlideWelcomeTrack extends Component
{
    public $track;
    public function __construct()
    {
        $this->track = [
            'spends' => 'red',
            'savings' => 'yellow',
            'entrances' => 'blue',
            'debts_and_charges' => 'purple',
            'notes' => 'green'
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.glide-welcome-track');
    }
}
