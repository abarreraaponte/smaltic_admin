<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
	use SoftDeletes;
    
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

    abstract public function canBeDeleted();
}
