<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FilterButtonsJavascript extends Component
{
    public $healthinformation;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($healthinformation)
    {
        //
        $this->healthinformation = $healthinformation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.filter-buttons-javascript');
    }
}
