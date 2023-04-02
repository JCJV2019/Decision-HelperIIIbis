<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;


class Navigation extends Component
{
    public $nombreRuta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nombreRuta = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navigation');
    }
}
