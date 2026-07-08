<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['level_range_id', 'socket_node_id', 'jewel_name', 'notes'])]
class JewelSocketAssignment extends Model
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
            'socket_node_id' => 'string',
            'jewel_name' => 'string',
            'notes' => 'string',
        ];
    }

    /**
     * Get the level range this jewel socket assignment belongs to.
     *
     * @return BelongsTo<LevelRange, $this>
     */
    public function levelRange(): BelongsTo
    {
        return $this->belongsTo(LevelRange::class);
    }
}
