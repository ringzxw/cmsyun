<?php

namespace App\Models;

class Project extends BaseModel
{
    protected $fillable = ['name', 'sort', 'address'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function items()
    {
        return $this->hasMany(ProjectItem::class);
    }
}
