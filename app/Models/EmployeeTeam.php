<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTeam extends Model
{
    protected $guarded = [];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class,'manager_id');
    }
}
