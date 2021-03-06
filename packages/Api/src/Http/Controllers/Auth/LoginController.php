<?php

namespace Api\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use IssueTokenTrait;

    /**
     * Where to redirect users after login.
     *
     * @var Laravel\Passport\Client
     */
    protected $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->client = Client::find(2);
    }

    /**
     * Login.
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
    		'phone' => 'required',
			'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 404);
        }

        $user = User::where('phone', $request->phone)->first();

        if(!$user){
            return response()->json([
                'message' => 'user not found',
                'code' => 200
            ], 401);
        }

        $request->request->add(['email'=> $user->email]);
        return $this->issueToken($request, 'password');
    }

}
