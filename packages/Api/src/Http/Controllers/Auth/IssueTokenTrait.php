<?php

namespace Api\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

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
        dd();
		$proxy = Request::create('oauth/token', 'POST');

    	return Route::dispatch($proxy);

	}

}
