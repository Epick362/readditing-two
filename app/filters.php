<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| oAuth2 Filter
|--------------------------------------------------------------------------
|
|
*/
Route::filter('oauth', function()
{
  // Build the provider configuration
  $provider = new League\OAuth2\Client\Provider\Reddit([
    'clientId' => Config::get('oauth.reddit.client_id'),
    'clientSecret' => Config::get('oauth.reddit.client_secret'),
    'redirectUri' => Config::get('oauth.reddit.redirect_uri'),
    'scopes' => Config::get('oauth.reddit.scopes')
  ]);

  // Check if oAuth token exists in a session, or a new one is on it's way.
  if (! Input::has('code') and ! Session::has('oauth_token'))
    $provider->authorize();

  // If we have a new code then refresh the access token stored in the session.
  if (Input::has('code'))
  {
    Session::put('oauth_token', $provider->getAccessToken('authorization_code', [ 'code' => Input::get('code') ]));
    return Redirect::back();
  }
  // If a token is stored in the session, retrieve it.
  elseif (Session::has('oauth_token'))
    $token = Session::get('oauth_token');
  // We really shouldn't get to this point, but just incase.
  else
    throw new Exception('No access token found.');

  // Check if the token has expired
  if (Carbon::createFromTimestamp($token->expires)->isPast())
  {
    $newToken = $provider->getAccessToken('refresh_token', [ 'refresh_token' => $token->refreshToken ]);
    $token->accessToken = $newToken->accessToken;
    $token->expires            = $newToken->expires;
    Session::put('oauth_token', $token);
  }
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});