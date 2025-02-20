<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class index.blade extends Component
{
    /**
     * Crea una nueva instancia del componente.
     */
    public function __construct()
    {
        //
    }

    /**
     * hace el Get de la vista / contenido  que representa al componente.
     */
    public function render(): View|Closure|string
    {
        return view('components.index.blade.php');
    }
}
