<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InterventionClose extends Component
{
    public $close;
    /**
     * Create a new component instance.
     */
    public function __construct($close = false)
    {
        //
        $this->close = $close;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.intervention-close');
    }
}
