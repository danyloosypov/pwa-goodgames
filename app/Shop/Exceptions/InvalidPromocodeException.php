<?php namespace App\Shop\Exceptions;

use Illuminate\Http\Request;
use Exception;

class InvalidPromocodeException extends Exception {

    protected $message;
    protected $status = 422;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function render()
    {
        return response()->json([
            'message' => $this->message,
        ], $this->status);
    }
}