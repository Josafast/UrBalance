<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardValues extends Component
{
    public $balanceValues;
    public function __construct(array $balanceValues)
    {
        $colors = ['green', 'yellow', 'red', 'blue'];

        foreach ($balanceValues as $name => $value){
            $balanceValues[$name] = [$value, array_shift($colors)];
        }

        $this->balanceValues = $balanceValues;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-values');
    }
}
