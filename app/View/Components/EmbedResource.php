<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EmbedResource extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $tag)
    {
        $this->data = array($src, $tag);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.embed-resource', array('src' => $this->data[0], 'tag' => $this->data[1]));
    }
}
