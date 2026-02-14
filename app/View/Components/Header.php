<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $title, $link, $createLink, $icon, $caption, $countData;

    public function __construct($title, $link, $createLink, $icon, $caption, $countData)
    {
        $this->title = $title;
        $this->link = $link;
        $this->createLink = $createLink;
        $this->icon = $icon;
        $this->caption = $caption;
        $this->countData = $countData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
