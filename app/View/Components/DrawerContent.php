<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DrawerContent extends Component
{
    public $help;
    /**
     * Create a new component instance.
     */
    public function __construct($help = null)
    {
        $this->help = $help;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.drawer-content');
    }
}
