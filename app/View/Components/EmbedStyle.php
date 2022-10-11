<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Minify;
use App\Resource;

class EmbedStyle extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src)
    {
        $this->src = $src;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.embed-resource', array('tag' => 'style', 'text' => Minify::css(Resource::get($this->src))));
    }
}
