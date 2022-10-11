<?php

namespace App\View\Components\Templates;

use Illuminate\View\Component;

class Master extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($noLocaleStyle = false)
    {
        $this->nls = $noLocaleStyle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.templates.master', array(
            'nls' => $this->nls == 'true'
        ));
    }
}
