<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAllprofiles()
    {
        if (Auth::user()->hasRole('Super Admin')) {
            return Profile::where('status', 1)->select(DB::raw("CONCAT(internal_name,' (',countryCode,')') AS internal_name, id"))->pluck('internal_name', 'id');
        } else {
            return $this->hasMany('App\Profile', 'created_by', 'id')->select(DB::raw("CONCAT(internal_name,' (',countryCode,')') AS internal_name, id"))->pluck('internal_name', 'id');
        }
    }

    public function getAllCreatedRules()
    {
        if (Auth::user()->hasRole('Super Admin')) {
            return Rule::pluck('name', 'name')->toArray();
        } else {
            return $this->hasMany('App\Rule', 'created_by', 'id')->pluck('name', 'name')->toArray();
        }
    }


    public function getAllUserAccount()
    {
        if (!Auth::user()->hasRole("Super Admin")) {

            $accounts = Account::select('accounts.*')->join('profiles as p', function ($join) {
                $join->on('accounts.id', '=', 'p.account_id');
            })->where('created_by', Auth::user()->id)->where('accounts.status', 1)->where('accounts.deleted_at', NULL)->groupBy('account_id')->get();


        } else {

            $accounts = Account::select('accounts.*')->join('profiles as p', function ($join) {
                $join->on('accounts.id', '=', 'p.account_id');
            })->where('accounts.status', 1)->where('accounts.deleted_at', NULL)->groupBy('account_id')->get();


        }


        return $accounts;

    }


    public function getAllAccountWiseprofiles($account_id)
    {
        if (Auth::user()->hasRole('Super Admin')) {
            return Profile::where('status', 1)->where('account_id', $account_id)->get();
        } else {
            return $this->hasMany('App\Profile', 'created_by', 'id')->where('account_id', $account_id)->where('status', 1)->get();
        }
    }

}
