<?php

namespace App\Livewire\Administrateur;

use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class PermissionsWire extends Component
{
    use WithPagination;
    public ?Permission $permission;
    public $name;

    public function render()
    {
        $permissions = Permission::paginate(10);
        return view('livewire.administrateur.permissions-wire',compact('permissions'));
    }

    public function store(){
        $this->validate([
            'name'  => ['required','unique:permissions,name','max:255']
        ]);
        $permission = Permission::create(['name' => $this->name]);

        if($permission){
            $this->reset();
            $this->dispatch('$refresh');
            Toaster::success('Permission ajoutée avec succès');
        }
    }

    public function editPermission(Permission $permission){
        $this->permission = $permission;
        Flux::modal('edit-permission')->show();
        $this->name = $permission->name;
    }

    public function closeEdit(){
        $this->reset('name','permission');
        Flux::modal('edit-permission')->close();
    }

    public function update(){
        $this->validate([
            'name'      => ['required',Rule::unique('permissions','name')->ignore($this->permission->id)]
        ]);

        // update and toaster
        $this->permission->update([
            'name'      => $this->name
        ]);

        $this->reset('name','permission');
        Flux::modal('edit-permission')->close();

    }

    public function deletePermission(Permission $permission){
        $permission->delete();
    }
}
