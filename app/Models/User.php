<?php

namespace App\Models;

use App\Helpers\UsersGroup;
use App\Helpers\UsersRoles;
use App\Notifications\Mail\ResetPasswordNotification;
use Doctrine\Common\Collections\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    private $roles;
    protected $fillable = [
        'firstname',
        'surname',
        'email',
        'password',
        'phone',
        'is_admin',
        'confirmed',
        'district',
        'about',
        'birthday',
    ];

    protected $dates = ['created_at', 'updated_at', 'birthday'];
	
	protected $casts = [
        'is_admin' => 'boolean',
        'confirmed' => 'boolean',
    ];

    protected $hidden = [
        'password', 'remember_token', 'balance', 'specs'
    ];
	
    public function invites()
    {
        return $this->hasMany('App\Models\Invite');
    }
	
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'owner');
    }
	
    public function catalog()
    {
		return $this->hasMany('App\Models\Catalog')->where('disabled', false)->orderBy('id', 'desc');
    }
	
    public function service()
    {
		return $this->hasMany('App\Models\Service')->where('disabled', false)->orderBy('id', 'desc');
    }
	
    public function invited_by()
    {
		return $this->hasOne('App\Models\Invite', 'used_by', 'id');
    }
	
    public function invited_users()
    {
		return $this->belongsToMany('App\Models\User', 'invites', 'user_id', 'used_by');
    }

    public function purchase_deals()
    {
		return $this->hasMany('App\Models\Deal', 'purchaser_id');
    }

    public function sell_deals()
    {
		return $this->hasMany('App\Models\Deal', 'seller_id');
    }

    public function deals() {
        return $this->hasMany('App\Models\Deal', 'seller_id')->orWhere('purchaser_id', $this->id);
    }

    public function finishedDeals() {
        return Deal::
            where(function ($query) {
                $query->where('seller_id', $this->id)
                    ->orWhere('purchaser_id', $this->id);
            })
            ->where(function ($query) {
                $query
                    ->where('state', 'finished')
                    ->orWhere('state', 'canceled');
            })->take(10);
    }

    public function activeDeals() {
        return Deal::
            where(function ($query) {
                $query->where('seller_id', $this->id)
                    ->orWhere('purchaser_id', $this->id);
            })
            ->where(function ($query) {
                $query
                    ->where('state', 'initial')
                    ->orWhere('state', 'inprogress');
            });
    }
	
    public function passiveBalance()
    {
		return $this->catalog()->sum('cost');
    }

    public function activeBalance()
    {
		return $this->balance;
    }

    public function balanceLog()
    {
        return $this->hasMany('App\Models\BalanceLog')->orderBy('id', 'desc');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function posts()
    {
        return $this->hasMany('App\Models\ForumPost')->where('first', 0);
    }

    public function specs_list()
    {
        return $this->hasMany('App\Models\Specialty');
    }

    public function specs()
    {
        return $this->belongsToMany('App\Models\CatalogCats', 'specialties', 'user_id', 'spec_id');
    }

    public function group() {
        return UsersGroup::getGroupName($this);
    }

    public function myGroup() {
        return $this->hasOne('App\Models\UsersRole', 'id', 'group_id');
    }

    public function userDistrict() {
        return $this->hasOne('App\Models\District', 'id', 'district');
    }

    public function groupPermission() {
        return UsersGroup::getGroup($this);
    }

    public function wishes() {
        return $this->hasMany('App\Models\Wish', 'user_id', 'id');
    }

    public function specs_level($id)
    {
        $info['level'] = 1;
        $info['select'] = "";
        $all = $this->posts->where('category_id', $id)->count();
        $rated = $this->posts->where('category_id', $id)->where('thanks', 1)->count();
        if ($all && $all > 10) {
            $rate = round(($rated / $all), 2);
            if ($rate >= 0.2 && $rate < 0.4) {
                $info['level'] = 2;
            } elseif ($rate >= 0.4 && $rate < 0.6) {
                $info['level'] = 3;
            } elseif ($rate >= 0.6 && $rate < 0.8) {
                $info['level'] = 4;
            } elseif ($rate >= 0.8) {
                $info['level'] = 5;
            }
        }
        if ($this->specs_list->where('spec_id', $id)->first()) {
            $info['select'] = "selected";
        }
        return $info;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function routeNotificationForSlack()
    {
        return config('project.slackUrlToken');
    }
}
