<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Nav extends Component
{
    public $items;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = $this->prepareItems(Config::get('nav'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav');
    }
    protected function prepareItems($items)
    {
        $user = Auth::user();

        return array_filter($items, function ($item) use ($user) {
            return ($user && $user->can($item['ability']));
        });
        return $items;
    }
}
