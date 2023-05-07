<?php

namespace App\Models;

trait CommonModelFunctions {

    public static $superSystemAdminRoleId = 1;

    public function scopeActive($query, $active = 1) {
        return $query->where(['is_active' => $active]);
    }

    public function scopeStore($query, $store = 1) {
        return $query->where(['is_store' => $store]);
    }

    public function scopeWithLanguages($query) {
        return $query->with('languages')->whereHas('languages');
    }

    public function scopeNotify($query, $notify = 1){
        return $query->where(['notify' => $notify]);
    }
    
    public function scopeAboutUs($query, $isAboutUs = 1) {
        return $query->where(['is_about_us' => $isAboutUs]);
    }
    
    public static function getAllRoles() {

        return Role::active()->where('id', '!=', 1)->get()->pluck('title', 'id')->all();
    }
    
    public static function getAllUsers() {
        return User::active()->select(['id', \DB::raw('concat(first_name, " ", last_name, " [", email, "]") as full_name')])->get()->pluck('full_name', 'id')->all();
    }
    
    public static function getAllLanguages() {
        return Language::active()->get()->pluck('title', 'id')->all();
    }


}
