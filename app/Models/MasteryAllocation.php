<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['level_range_id', 'mastery_node_id', 'effect_id'])]
class MasteryAllocation extends Model
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
            'mastery_node_id' => 'string',
            'effect_id' => 'string',
        ];
    }

    /**
     * Get the level range this mastery allocation belongs to.
     *
     * @return BelongsTo<LevelRange, $this>
     */
    public function levelRange(): BelongsTo
    {
        return $this->belongsTo(LevelRange::class);
    }
}
