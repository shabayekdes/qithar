<?php

namespace Api\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use IssueTokenTrait;

    private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6',
			'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 404);
		}

		$user = User::create([
    		'name' => $request->name,
			'email' => $request->email,
			'phone' => $request->phone,
			'password' => bcrypt($request->password),
		]);

        return $this->issueToken($request, 'password');

	}
}