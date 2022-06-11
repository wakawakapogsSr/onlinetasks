<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/test', function () {
    $connection = config('database.default');

    $driver = config("database.connections.{$connection}.driver");

    echo $connection;
    echo $driver;


    $users = DB::table('users')->get();
    dd($users);
});
*/

Auth::routes();

Route::get('/logintest', 'Auth\LoginController@login_test');

Route::group(['middleware' => 'auth'], function () {

  Route::get('/change_password', function(){
      return view('users.changePassword');
  });
  Route::post('/change_password', 'UsersController@changePasswordStore');

  Route::get('/phpmyinfo', function () {
      phpinfo();
  });

  Route::get('/generateRefreshToken/{profile_id}', function ($profile_id) {
      if(Auth::user()->email == "siridion@websko.net"){
          $profile = \App\Profile::where('id',$profile_id)->first();
          $profileId = $profile->profileId;
          $oauth = $profile->oauth;
          $url = secure_url('oauth_callback');
          $sandbox = false;
          $region = 'na';
          $eu_countries = ['UK', 'FR', 'IT', 'ES', 'DE', 'IN','SE','SEK','NL'];
          $fe_countries = ['AU', 'CN', 'HK', 'MO', 'JP', 'MN', 'KP', 'KR', 'TW', 'BN', 'KH', 'TL', 'ID', 'LA', 'MY', 'MM', 'PH', 'SG', 'TH', 'VN', 'RU'];

          if (iCheckInArray($profile->countryCode, $eu_countries) != -1) {
              $region = 'eu';
          } else if (iCheckInArray($profile->countryCode, $fe_countries) != -1) {
              $region = 'fe';
          }
          $config = array(
              "clientId" => env('AMAZON_APP_CLIENT_ID'),
              "clientSecret" => env('AMAZON_APP_CLIENT_SECRET'),
              "region" => $region,
              "accessToken" => $oauth->access_token,
              "refreshToken" => $oauth->refresh_token,
              "redirectUri" => $url,
              "sandbox" => $sandbox,
          );
          $client = new \App\Amz\AmazonAdvertisingApiV2\Client($config);
          $tmpAMZ = new \App\HelperClasses\AmzHelperClass;
          $refreshAccessToken = $tmpAMZ::getRefreshAccessToken($client);
          return response()->json([
              'profileId'=> $profileId
              ,'clientId'=>env('AMAZON_APP_CLIENT_ID')
              ,'Authorization' => "bearer {$refreshAccessToken['access_token']}"
          ]);
      }else{
          abort(403, 'Unauthorized action.');
      }
  });

  Route::get('/', 'HomeController@index');
  Route::post('home/request-actions', 'HomeController@requestActions');

  Route::resource('accounts', 'AccountController');

  Route::group(['middleware' => 'isAdmin'], function () {
      Route::resource('users', 'UsersController');
      Route::post('/users/{id}/edit', 'UsersController@update');
      Route::resource('roles', 'RoleController');
      Route::resource('permissions', 'PermissionController');
  });

  Route::get('rules/{type}', 'RuleController@index');
  Route::get('rules/{type}/{id}/edit', 'RuleController@edit');
  Route::get('rules/{type}/{id}/duplicate', 'RuleController@duplicate'); 

  Route::resource('rules', 'RuleController');
  Route::post('rules/request-actions', 'RuleController@requestActions');

  Route::get('oauth_callback', 'AccountController@oauthCallback');
  Route::post('account/connect', 'AccountController@accountConnect');
  Route::get('account/profile_sync/{internal_name}', 'AccountController@profile_sync');

  Route::get('profiles/{current_account}/', 'ProfileController@index');
  Route::post('profiles/{current_account}/refresh_table_data', 'ProfileController@refreshTableData');
  Route::post('profiles/{current_account}/sync', 'ProfileController@sync');
  Route::post('profiles/request-actions', 'ProfileController@requestActions');

  Route::get('keywords/{current_account}/{current_profile?}', 'KeywordsController@index');
  Route::post('keywords/{current_account}/{current_profile?}', 'KeywordsController@requestActions');

  Route::get('targets/{current_account}/{current_profile?}', 'TargetsController@index');
  Route::post('targets/{current_account}/{current_profile?}', 'TargetsController@requestActions');

  Route::get('searchterms/{current_account}/{current_profile?}', 'SearchTermsController@index');
  Route::post('searchterms/{current_account}/{current_profile?}', 'SearchTermsController@requestActions');

  Route::get('target-searchterms/{current_account}/{current_profile?}', 'TargetSearchTermsController@index');
  Route::post('target-searchterms/{current_account}/{current_profile?}', 'TargetSearchTermsController@requestActions');

  Route::get('productads/{current_account}/{current_profile?}', 'ProductAdController@index');
  Route::post('productads/{current_account}/{current_profile?}', 'ProductAdController@requestActions');
  
  Route::get('sp-placement/{current_account}/{current_profile?}', 'SPPlacementController@index');
  Route::post('sp-placement/{current_account}/{current_profile?}', 'SPPlacementController@requestActions');

  Route::get('sb-campaigns/{current_account}/{current_profile?}', 'SBCampaignController@index');
  Route::post('sb-campaigns/{current_account}/{current_profile?}', 'SBCampaignController@requestActions');
  
  Route::get('sbv-campaigns/{current_account}/{current_profile?}', 'SBVCampaignController@index');
  Route::post('sbv-campaigns/{current_account}/{current_profile?}', 'SBVCampaignController@requestActions');



});
