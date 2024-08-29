<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modalForm extends Component
{
    /**
     * Create a new component instance.
     */
    public $annees;
    public $semestres;
    public $specialites;
    public $matieres;
    public $niveaux;

    public function __construct($annees,$niveaux, $semestres, $specialites, $matieres)
    {
               $this->annees = $annees;
        $this->semestres = $semestres;
        $this->specialites = $specialites;
        $this->matieres = $matieres;
        $this->niveaux = $niveaux;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-form');
    }
}
