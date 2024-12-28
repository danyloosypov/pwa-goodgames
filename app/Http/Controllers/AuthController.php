<?php

namespace App\Http\Controllers;

use App\Events\SendCode;
use App\Http\Requests\ForgotCodeRequest;
use App\Http\Requests\ForgotEmailRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class AuthController extends Controller
{

	public function register(RegisterRequest $r)
	{
		$data = $r->validated();

		$data['id_roles'] = 2;
		$data['password'] = Hash::make($data['password']);

		$user = new User($data);
		$user->save();

		return $this->response();
	}

	public function login(LoginRequest $r)
	{	
		$data = $r->validated();
		
		if (Auth::attempt($data)) {

			return $this->response([
				'redirect'	=> route('account', '', false),
			]);
		}

		return $this->error();
	}
	
	public function sendCode(ForgotEmailRequest $r)
	{
		$data = $r->validated();

		if (isset($data['email'])) {
			$user = User::where('email', $data['email'])
				->first();
		} 

		if (empty($user)) {
			return $this->error();
		}

		$user->setCode();

		SendCode::dispatch($user);

		return $this->response([
			'user_id' => $user->id
		]);
	}

	public function checkCode(ForgotCodeRequest $r)
	{
		$data = $r->validated();

		$user = User::find($data['user_id']);

		if (empty($user)) {
			return $this->error([]);
		}

		return $this->response();
	}

	public function changePassword(ForgotPasswordRequest $r)
	{	
		$data = $r->validated();

		$user = User::where('id', $data['user_id'])
		->where('code', $data['code'])
		->first();

		if (empty($user)) {
			return $this->error([]);
		}

		$user->changePassword($data['password']);

		return $this->response([]);
	}

	public function logout()
	{
		Auth::logout();

		return $this->response([
			'link'	=> route('home', [], true),
		]);
	}
}