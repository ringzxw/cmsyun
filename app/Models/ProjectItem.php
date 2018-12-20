<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectItem extends BaseModel
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
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
