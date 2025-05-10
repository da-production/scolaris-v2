<?php

namespace App\Livewire\Administrateur;

use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesWire extends Component
{
    public $name;
    public $selectedPermissions = [];
    public Role $role;
    public function render()
    {
        $permissions = Permission::all();
        $roles = Role::with('permissions')->paginate();
        // dd($permissions);
        return view('livewire.administrateur.roles-wire',compact('permissions','roles'));
    }

    public function store(){
        $this->validate([
            'name'  => ['required','unique:roles,name','max:255']
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
            DB::commit();
            $this->reset();
            $this->dispatch('$refresh');
            $this->dispatch('resetTomSelect');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function assignPermissionToRole($role, $permission){
        $role->givePermissionTo($permission);
    }

    public function selectedValuesUpdated($values){
        $this->selectedPermissions = $values;
    }

    #[On('updateSelectedPermissions')]
    public function updateSelectedPermissions($values)
    {
        $this->selectedPermissions = $values;
    }

    public function editRole(Role $role){
        $this->reset();
        $this->role = $role->load('permissions');
        $this->dispatch('setDefaultSelected',$role->permissions->pluck('name'));
        $this->name = $role->name;
        Flux::modal('edit-role-modal')->show();
    }


    public function update(){
        $this->validate([
            'name'      => ['required','max:255',Rule::unique('roles','name')->ignore($this->role->id)],
        ]);

        try{
            DB::beginTransaction();
            $this->role->update($this->only('name'));
            $this->role->syncPermissions($this->selectedPermissions);
            DB::commit();
            Flux::modal('edit-role-modal')->close();
            $this->reset();
            $this->dispatch('$refresh');

            // toast notification
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            // toast notification
        }

    }

    public function delete (Role $role){
        $role->delete();
        $this->reset();
        $this->dispatch('$refresh');
    }
}
