<?php

namespace App\Models;

use App\Enums\NodeType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['level_range_id', 'node_id', 'node_type'])]
class NodeAllocation extends Model
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
            'node_id' => 'string',
            'node_type' => NodeType::class,
        ];
    }

    /**
     * Get the level range this node allocation belongs to.
     *
     * @return BelongsTo<LevelRange, $this>
     */
    public function levelRange(): BelongsTo
    {
        return $this->belongsTo(LevelRange::class);
    }
}
