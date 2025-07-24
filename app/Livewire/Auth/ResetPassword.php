<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;



#[Layout('components.layouts.auth')]
class ResetPassword extends Component
{
    #[Locked]
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    
    /**
     * Mount the component.
     */
    public function mount(string $token)
    {
        $this->token = $token;
        $model = new class extends \Illuminate\Database\Eloquent\Model {
            protected $table = 'password_reset_tokens';
        };
        $token = $model->where('token', $this->token)->first();
        
        if(is_null($token)) {
            return redirect(route('login'));
        }
        if($token->created_at->addMinutes(15)->isPast()) {
            $model->where('token', $this->token)->delete();
            redirect(route('login'))->with('error', 'Token expired');
        }

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $model = new class extends \Illuminate\Database\Eloquent\Model {
            protected $table = 'password_reset_tokens';
        };

        $token = $model->where([
            ['token', $this->token],
        ])->first();

        if($token->email != $this->email) {
            $this->addError('email',"L’adresse email saisie est invalide ou introuvable. Merci de vérifier vos informations.");
            return;
        }

        if (is_null($token)) {
            $this->addError('email', __('The provided password reset token is invalid.'));
            return;
        }

        $user = User::where('email', $token->email)->first();

        if (is_null($user)) {
            $this->addError('email', __('The provided password reset token is invalid.'));
            return;
        }
        try{
            DB::beginTransaction();
            $user->password = Hash::make($this->password);
            $user->save();
            // We will attempt to reset the password on the user with the new password
            
            $model->where([
                ['email', $this->email],
                ['token', $this->token],
            ])->delete();
    
            DB::commit();
            
            Session::flash('status', __('Your password has been reset!'));

            $this->redirectRoute('login', navigate: true);
        }catch(\Exception $e){
            DB::rollBack();
            $this->addError('email', __('The provided password reset token is invalid.'));
            return;
        }
    }
}
