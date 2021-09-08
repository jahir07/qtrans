<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;


class Packages extends Component
{
    
    use WithPagination;    

    public $pid, $name, $email, $package_type, $field_text, $words, $duration, $discount, $language, $complementary;
    
    public function rules()
    {
        return [
            'name'  => 'required',
            'email'  => 'required',
            'package_type'  => 'required',
            'field_text'  => 'required',
            'complementary'  => 'required',
        ];
    }
    
    /**
     * Reset Form Value after submit.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->name= '';
        $this->email= '';
        $this->package_type= '';
        $this->words= '';
        $this->duration= '';
        $this->discount= '';
        $this->language= '';
    }

    /**
     * Save Package.
     *
     * @return void
     */
    public function savePackage()
    {
        $this->validate();
        Package::create([
            'name' => $this->name,
            'email' => $this->email,
            'package_type' => $this->package_type,
            'field_text' => $this->field_text,
            'words' => $this->words,
            'duration' => $this->duration,
            'discount' => $this->discount,
            'language' => $this->language,
            'complementary' => $this->complementary,
        ]);
        $this->resetForm();
        return back()->with('package_created', 'Package Saved Successfull');
    }

    /**
     * Delete Package.
     *
     * @param Package $package
     * @return void
     */
    public function delete( Package $package ){
        $package->delete();
    }
}
