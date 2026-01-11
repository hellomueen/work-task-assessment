<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkTask extends Model
{
    use HasFactory;

    public function call(): BelongsTo
    {
        return $this->belongsTo(Call::class);
    }

    public function resolutionType(): BelongsTo
    {
        return $this->belongsTo(ResolutionType::class);
    }
}
