<?php

namespace App\Livewire\Administrateur;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UtilisateursWire extends Component
{
    public $selectedRoles = [];
    public $selectedPermissions = [];

    public UserForm $form;
    public ?User $user;

    public function render()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::with('roles','permissions')->paginate();
        return view('livewire.administrateur.utilisateurs-wire',compact('roles','permissions','users'));
    }

    #[On('updateSelectedRoles')]
    public function updateSelectedRoles($values){
        $this->selectedRoles = $values;
    }

    #[On('updateSelectedPermissions')]
    public function updateSelectedPermissions($values){
        $this->selectedPermissions = $values;
    }

    public function store()
    {

        try{
            DB::beginTransaction();
            $user = $this->form->store();
            if(count($this->selectedRoles)>0) $user->syncRoles($this->selectedRoles);
            if(count($this->selectedPermissions)>0) $user->syncPermissions($this->selectedPermissions);
            DB::commit();
            $this->form->reset();
            $this->dispatch('$refresh');
            $this->dispatch('resetTomSelect');
            //toaster success
        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // Ajoute toutes les erreurs à l'ErrorBag de Livewire
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
    
            // Ajoute une erreur générale si c'est une autre exception
            $this->addError('server', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }

    public function edit(User $user){
        $this->form->reset();
        $this->resetErrorBag();
        $this->reset('user');
        $this->user = $user->load('roles','permissions');
        $this->dispatch('setDefaultRoles',$user->roles->pluck('name'));
        $this->dispatch('setDefaultPermissions',$user->permissions->pluck('name'));
        $this->form->setUser($this->user);
        Flux::modal('edit-user-modal')->show();
    }

    public function update()
    {
        try{
            DB::beginTransaction();
            $user = $this->form->update();
            if($user){
                $this->form->user->syncRoles($this->selectedRoles);
                $this->form->user->syncPermissions($this->selectedPermissions);
            }
            DB::commit();
            Flux::modal('edit-user-modal')->close();
            $this->form->reset();
            $this->dispatch('$refresh');
            $this->dispatch('resetTomSelect');
            //toaster success
        }catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            // Ajoute toutes les erreurs à l'ErrorBag de Livewire
            $this->setErrorBag($e->validator->getMessageBag());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
    
            // Ajoute une erreur générale si c'est une autre exception
            $this->addError('server', 'Une erreur est survenue lors de l\'enregistrement.');
        }
    }

    public function delete(User $user){
        $user->delete();
        // toaster notification
    }
}
