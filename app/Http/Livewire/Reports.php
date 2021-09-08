<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;


class Reports extends Component
{
    use WithPagination;    
    
    public function render()
    {        
        return view('livewire.reports', [
            'packages'  => Package::paginate(10),
        ]);
    }

    public function delete( Package $package ){
        $package->delete();
    }
}