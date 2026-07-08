<?php

namespace App\Models;

use App\Enums\GemColour;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['gem_link_id', 'name', 'is_support', 'colour', 'position'])]
class Gem extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gem_link_id' => 'integer',
            'name' => 'string',
            'is_support' => 'boolean',
            'colour' => GemColour::class,
            'position' => 'integer',
        ];
    }

    /**
     * Get the gem link this gem belongs to.
     *
     * @return BelongsTo<GemLink, $this>
     */
    public function gemLink(): BelongsTo
    {
        return $this->belongsTo(GemLink::class);
    }
}
