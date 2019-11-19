<?php

namespace Api\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

	public function issueToken(Request $request, $grantType, $scope = ""){
		$params = [
    		'grant_type' => $grantType,
    		'client_id' => $this->client->id,
    		'client_secret' => $this->client->secret,
    		'scope' => '*'
    	];

        if($grantType !== 'social'){
            $params['username'] = $request->username ?: $request->email;
        }

        $request->request->add($params);
        $proxy = Request::create('oauth/token', 'POST');
        // $request->request->add('user',auth()->user());

        $token = Route::dispatch($proxy);

        $json = json_decode($token->getContent(), true);

        if(isset($json['error'])){
            return response()->json([
                'message' => "auth error",
                'code' => 401
            ], 401);
        }

        $user = User::where('phone',$request->phone)->first();
        return response()->json([
            'token' => $json,
            'user' => $user
        ], 200);

	}

}
