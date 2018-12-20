<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mysql.admin';

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account',
        'password',
        'contact',
        'contact_mobile',
        'last_login_time',
        'last_login_ip',
        'frequency',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    /**
     * 设置密码时候进行哈希处理
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * 管理员角色名
     * @return mixed
     */
    public function getRoleNameAttribute()
    {
        return $this->roles->name ?? '';
    }
}
