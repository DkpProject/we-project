<?php

namespace App\Helpers;

use App\Models\Deal;
use App\Models\Poll;
use App\Models\PollsAnswer;
use App\Models\User;
use App\Models\UsersRole;
use App\Models\UsersRolesRule;

class UsersRoles
{
    private $user, $role, $nextRole;

    public function __construct(User $user) {
        $this->user = $user;
        if ($this->role == null) $this->checkRules($this->user);
    }

    public function getRole() {
        if ($this->role == null) $this->checkRules($this->user);
        return $this->role;
    }

    public function getProgress() {
        if ($this->role == null) $this->checkRules($this->user);
        return $this->nextRole->rules;
    }

    public function getNextRole() {
        if ($this->role == null) $this->checkRules($this->user);
        return $this->nextRole;
    }

    private function checkRules($user) {
        $this->role = UsersRole::where('default', true)->changeable()->first();
        foreach(UsersRole::where('default', false)->changeable()->orderBy('sort', 'asc')->get() as $role) {
            $this->nextRole = $role;
            if (!$this->checkAll($user)) break;
            $this->role = $role;
        }
    }

    private function checkAll($user) {
        $status = true;
        if (!$this->checkInvites($user, $this->nextRole)) $status = false;
        if (!$this->checkPolls($user, $this->nextRole)) $status = false;
        if (!$this->checkGoods($user, $this->nextRole)) $status = false;
        if (!$this->checkDeals($user, $this->nextRole)) $status = false;
        if (!$this->checkReg($user, $this->nextRole)) $status = false;
        return $status;
    }

    private function checkInvites(User $user, UsersRole $role) {
        $rule = $role->rules->where('type', 'invites')->first();
        if (is_null($rule)) return true;
        $rule->count = $user->invites()->where('used_by', '>', '0')->count();
        if ($rule->if == 'equal') return $this->equal($rule->count, $rule->value);
        if ($rule->if == 'less') return $this->less($rule->count, $rule->value);
        if ($rule->if == 'more') return $this->more($rule->count, $rule->value);
    }

    private function checkGoods(User $user, UsersRole $role) {
        $rule = $role->rules->where('type', 'goods')->first();
        if (is_null($rule)) return true;
        $rule->count = $user->catalog->where('user_id', $user->id)->sum('cost');
        if ($rule->if == 'equal') return $this->equal($rule->count, $rule->value);
        if ($rule->if == 'less') return $this->less($rule->count, $rule->value);
        if ($rule->if == 'more') return $this->more($rule->count, $rule->value);
    }

    private function checkReg(User $user, UsersRole $role) {
        $rule = $role->rules->where('type', 'reg')->first();
        if (is_null($rule)) return true;
        $rule->count = $user->created_at->diffInDays($user->created_at->now());
        if ($rule->if == 'equal') return $this->equal($rule->count, $rule->value);
        if ($rule->if == 'less') return $this->less($rule->count, $rule->value);
        if ($rule->if == 'more') return $this->more($rule->count, $rule->value);
    }

    private function checkPolls(User $user, UsersRole $role) {
        $rule = $role->rules->where('type', 'polls')->first();
        if (is_null($rule)) return true;
        $rule->count = count(PollsAnswer::category(0)->where('user_id', $user->id)->whereRaw('TO_DAYS(NOW()) - TO_DAYS(created_at) <= 30')->groupBy('poll_id')->get());
        if(($pollsCount = Poll::where('category_id', 0)->whereRaw('TO_DAYS(NOW()) - TO_DAYS(created_at) <= 30')->count()) < $rule->value)
            $rule->value = $pollsCount;
        if ($rule->if == 'equal') return $this->equal($rule->count, $rule->value);
        if ($rule->if == 'less') return $this->less($rule->count, $rule->value);
        if ($rule->if == 'more') return $this->more($rule->count, $rule->value);
    }

    private function checkDeals(User $user, UsersRole $role) {
        $rule = $role->rules->where('type', 'deals')->first();
        if (is_null($rule)) return true;
        $rule->count = Deal::where(function ($query) use ($user) {
            $query->where('seller_id', $user->id)->orWhere('purchaser_id', $user->id);
        })->where('status', 6)->whereRaw('TO_DAYS(NOW()) - TO_DAYS(created_at) <= 30')->count();
        if ($rule->if == 'equal') return $this->equal($rule->count, $rule->value);
        if ($rule->if == 'less') return $this->less($rule->count, $rule->value);
        if ($rule->if == 'more') return $this->more($rule->count, $rule->value);
    }

    private function equal($count, $value) {
        if ($count == $value) return true;
        return false;
    }

    private function less($count, $value) {
        if ($count <= $value) return true;
        return false;
    }

    private function more($count, $value) {
        if ($count >= $value) return true;
        return false;
    }

}