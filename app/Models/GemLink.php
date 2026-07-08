<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['level_range_id', 'name'])]
class GemLink extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level_range_id' => 'integer',
            'name' => 'string',
        ];
    }

    /**
     * Get the level range this gem link belongs to.
     *
     * @return BelongsTo<LevelRange, $this>
     */
    public function levelRange(): BelongsTo
    {
        return $this->belongsTo(LevelRange::class);
    }

    /**
     * Get the gems within this gem link.
     *
     * @return HasMany<Gem, $this>
     */
    public function gems(): HasMany
    {
        return $this->hasMany(Gem::class);
    }
}
