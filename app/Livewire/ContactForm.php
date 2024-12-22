<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Callback;
use Carbon\Carbon;

class ContactForm extends Component
{
    public $email;
    public $name;
    public $message;

    protected $rules = [
        'email' => 'required|email',
        'name' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    public function submit()
    {
        // Validate form inputs
        $this->validate();

        // Save the data into the 'callbacks' table
        Callback::create([
            'email' => $this->email,
            'name' => $this->name,
            'text' => $this->message,
            'date' => Carbon::now(), // Add date automatically
        ]);

        // Optionally, clear the form fields after submission
        $this->resetForm();

        // Optionally, display success message
        session()->flash('success', 'Your message has been sent successfully!');
    }

    public function resetForm()
    {
        $this->email = '';
        $this->name = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
