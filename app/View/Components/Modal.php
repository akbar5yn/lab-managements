<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{

    public $title;
    public $button;
    /**
     * Create a new component instance.
     */
    public function __construct($attributeTitle, $attributeButton)
    {
        $this->title = $attributeTitle;
        $this->button = $attributeButton;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
