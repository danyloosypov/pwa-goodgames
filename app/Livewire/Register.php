<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class Register extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $avatar;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', 'min:6'],
        'avatar' => 'nullable|image|max:1024',
    ];

    public function register()
    {
        $this->validate();

        $avatarPath = '';
        
        if ($this->avatar) {
            // Generate a unique file name
            $avatarFileName = time() . '.' . $this->avatar->getClientOriginalExtension();
            
            // Set the target path to the public directory
            $destinationPath = public_path('avatars/' . $avatarFileName);
            
            // Move the uploaded file to the public directory
            $this->avatar->move(public_path('avatars'), $avatarFileName);
            
            // Set the avatar path for the user model
            $avatarPath = 'avatars/' . $avatarFileName;
        }
        

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'avatar' => $avatarPath, 
        ]);

        Auth::login($user);

        session()->flash('success', 'Registration successful!');

        $this->dispatch('registerSuccessfull');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
