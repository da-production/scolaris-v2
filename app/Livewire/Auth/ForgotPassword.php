<?php

namespace App\Livewire\Auth;

use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('components.layouts.auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email','exists:users,email'],
        ]);

        // store token in database
        $token = Str::random();
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email'     => $this->email,
            'token'     => $token,
            'created_at'=> now(),
        ]);
        // Password::sendResetLink($this->only('email'));
        Mail::to($this->email)->send(new ResetPasswordMail(route('password.reset',['token'=>$token])));

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
}
