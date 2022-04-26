<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ObservationTable extends Component
{
    public $observation_classes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($observationclasses)
    {
        //
        $this->observation_classes = $observationclasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.observation-table');
    }
}
