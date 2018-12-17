<?php

namespace App\Models;

class ProjectItem extends BaseModel
{
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // 定义一个访问器
    public function getFullNameAttribute()
    {
        return $this->project->name.'-'.$this->name;
    }
}
