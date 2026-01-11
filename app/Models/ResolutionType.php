<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResolutionType extends Model
{
    use HasFactory;

    public function workTask(): HasOne
    {
        return $this->hasOne(WorkTask::class);
    }

    public function workTasks(): HasMany
    {
        return $this->hasMany(WorkTask::class);
    }
}
