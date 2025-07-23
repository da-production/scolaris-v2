<?php

namespace App\Livewire;

use App\Actions\ResetPasswordAction;
use App\Jobs\ResetPasswordJob;
use App\Models\Candidat;
use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Layout('components.layouts.guest')]
class CandidatForgotPasswordWire extends Component
{
    public $numero_bac;
    public $annee_bac;
    public $email;

    public $message;

    public function render()
    {
        return view('livewire.candidat-forgot-password-wire');
    }

    public function send()
    {
        $this->reset('message');
        $this->validate([
            'email'         => ['required', 'string', 'email', 'max:255'],
            'numero_bac'    => ['required', 'numeric','digits:8'],
            'annee_bac'     => ['required', 'integer','digits:4', 'max:' . now()->year],
        ]);

        $candidat = Candidat::where([
            ['email',$this->email],
            ['numero_bac', $this->numero_bac],
            ['annee_bac', $this->annee_bac],
        ])
        ->whereYear('exercice',Date('Y'))
        ->first();

        if(is_null($candidat)){
            $this->addError('email','candidat introvable');
            return;
        }
        
        // store token in database
        $token = Str::random();
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'guard'     => 'candidat',
            'email'     => $this->email,
            'token'     => $token,
            'created_at'=> now(),
        ]);
        // Password::sendResetLink($this->only('email'));
        // todo make it option to enable job
        $getOptions = Cache::rememberForever('options_inscription', function(){
            return Option::where('model_type', 'inscription')->get();
        });
        foreach ($getOptions as $option) {
            $options[$option->name] = $option->value;
        }
        $options = collect($options);
        if($options->get('can_use_cronjob_candidat')){
            $this->sendCodeWithJob($token);
        }else{
            $this->sendCodeWithoutJob($token);
        }
        $this->message = 'un lien a ete envoye a votre boite email';

    }

    public function sendCodeWithJob($token)
    {
        ResetPasswordJob::dispatch($this->email,$token);
    }

    public function sendCodeWithoutJob($token)
    {
        ResetPasswordAction::send($this->email,$token);
    }

}
