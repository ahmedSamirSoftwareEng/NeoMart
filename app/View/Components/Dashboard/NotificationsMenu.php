<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NotificationsMenu extends Component
{
    public $notifications;
    public $newCount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($count = 5)
    {
        $this->notifications = Auth::user()->notifications()->limit($count)->get();
        $this->newCount = Auth::user()->unreadNotifications()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.notifications-menu');
    }
}
