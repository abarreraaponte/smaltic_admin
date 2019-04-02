<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'uuid',
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
     * @param $query
     * @return mixed
     * Defines the Local Scope only query active records.
     */
    public function scopeActive($query)
    {
        return $query->where('active',  '=', 1);
    }
    /**
     * @param $query
     * @return mixed
     * Defines a Scope to only query inactive records.
     */
    public function scopeInactive($query)
    {
        return $query->where('active', '=', 0);
    }

    /**
     * Renders the model inactive.
     */
    public function inactivate()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }
        $this->active = false;
        $this->save();
    }

    /**
     * Reactivates the Model.
     */
    public function reactivate()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }
        $this->active = true;
        $this->save();
    }

    /**
    *
    * Add List of roles to be selected
    **/
    public static function roles()
    {
        return collect([
            [
                'name' => 'admin',
                'label' => __('Administrator'),
            ],
            [
                'name' => 'user',
                'label' => __('User'),
            ],
        ]);
    }
    
    /**
    *
    * Gets the role label
    **/
    public function getRoleLabel()
    {
        return $this->roles()->where('name', $this->role)->pluck('label')->first();
    }

}
