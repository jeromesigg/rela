<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterButtons extends Component
{
    public $intervention_classes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($interventionclasses)
    {
        //
        $this->intervention_classes = $interventionclasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filter-buttons');
    }
}
