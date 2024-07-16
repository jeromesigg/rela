<?php

namespace App\View\Components;

use App\Models\HealthStatus;
use App\Models\Intervention;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddNewIntervention extends Component
{
    public $index;
    public $intervention;
    public $healthStatus;
    /**
     * Create a new component instance.
     */
    public function __construct($index, $healthStatus, Intervention $intervention)
    {
        //
    $this->index = $index;
    $this->healthStatus = $healthStatus;
    $this->intervention = $intervention;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-new-intervention');
    }
}
