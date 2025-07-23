<?php

namespace App\Livewire;

use App\Actions\ResetPasswordAction;
use App\Jobs\ResetPasswordJob;
use App\Models\Candidat;
use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

#[Layout('components.layouts.guest')]
class CandidatForgotPasswordWire extends Component
{
    public $numero_bac;
    public $annee_bac;
    public $email;

    public $message;
    public $error;

    public function render()
    {
        return view('livewire.candidat-forgot-password-wire');
    }

    public function send()
    {
        $this->reset('message','error');
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
        try{
            $token = Str::random();
            DB::beginTransaction();
            DB::table('password_reset_tokens')->where('email', $this->email)->delete();
            DB::table('password_reset_tokens')->insert([
                'guard'     => 'candidat',
                'email'     => $this->email,
                'token'     => $token,
                'created_at'=> now(),
            ]);
            $getOptions = Cache::rememberForever('options_inscription', function(){
                return Option::where('model_type', 'inscription')->get();
            });
            foreach ($getOptions as $option) {
                $options[$option->name] = $option->value;
            }
            $options = collect($options);
            if(config('app.cronjob') && $options->get('can_use_cronjob_candidat')){
                $this->sendCodeWithJob($token);
            }else{
                $this->sendCodeWithoutJob($token);
            }
            $this->message = 'Un lien a été envoyé à votre boîte email.';
            DB::commit();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            $this->error = "Une erreur s’est produite. Veuillez réessayer.";
            DB::rollBack();
        }

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
