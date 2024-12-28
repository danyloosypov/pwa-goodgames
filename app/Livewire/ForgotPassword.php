<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PasswordResetMail;

class ForgotPassword extends Component
{
    public $email;
    public $code;
    public $password;
    public $password_confirmation;

    public $isCodeSent = false;
    public $isCodeVerified = false;
    public $errorMessage = '';

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
        'password_confirmation' => 'required|same:password',
        'code' => 'required_if:isCodeSent,true',
    ];

    public function sendResetCode()
    {
        $this->validate(['email' => 'required|email|exists:users,email']);
    
        $user = User::where('email', $this->email)->first();
        $resetCode = Str::random(6);
    
        // Check if a token already exists for this email
        $existingToken = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->first();
    
        if ($existingToken) {
            // Update the existing token
            DB::table('password_reset_tokens')
                ->where('email', $this->email)
                ->update([
                    'token' => $resetCode,
                    'created_at' => now(),
                ]);
        } else {
            // Insert a new token
            DB::table('password_reset_tokens')->insert([
                'email' => $this->email,
                'token' => $resetCode,
                'created_at' => now(),
            ]);
        }
    
        // Send the email with the reset code
        Mail::to($this->email)->send(new PasswordResetMail($resetCode));
    
        $this->isCodeSent = true;
        $this->resetErrorBag();
        session()->flash('message', 'A reset code has been sent to your email!');
    }
    

    public function verifyCode()
    {
        $this->validate(['code' => 'required']);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $this->email)
            ->where('token', $this->code)
            ->first();

        if ($resetRecord) {
            $this->isCodeVerified = true;
            $this->resetErrorBag();
        } else {
            $this->errorMessage = 'Invalid code. Please try again.';
        }
    }

    public function resetPassword()
    {
        $this->validate();

        $user = User::where('email', $this->email)->first();

        $user->update([
            'password' => bcrypt($this->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $this->email)->delete();

        session()->flash('message', 'Password reset successful!');

        $this->reset(['password', 'password_confirmation']);

        // Reset any validation errors
        $this->resetErrorBag();

        $this->dispatch('passwordResetSuccess');
    }

    public function render()
    {
        return view('livewire.forgot-password');
    }
}
