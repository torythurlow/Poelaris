<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['template_id', 'label', 'level_min', 'level_max', 'sort_order', 'notes'])]
class LevelRange extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'template_id' => 'integer',
            'label' => 'string',
            'level_min' => 'integer',
            'level_max' => 'integer',
            'sort_order' => 'integer',
            'notes' => 'string',
        ];
    }

    /**
     * Get the template this level range belongs to.
     *
     * @return BelongsTo<Template, $this>
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the node allocations within this level range.
     *
     * @return HasMany<NodeAllocation, $this>
     */
    public function nodeAllocations(): HasMany
    {
        return $this->hasMany(NodeAllocation::class);
    }

    /**
     * Get the mastery allocations within this level range.
     *
     * @return HasMany<MasteryAllocation, $this>
     */
    public function masteryAllocations(): HasMany
    {
        return $this->hasMany(MasteryAllocation::class);
    }

    /**
     * Get the jewel socket assignments within this level range.
     *
     * @return HasMany<JewelSocketAssignment, $this>
     */
    public function jewelSocketAssignments(): HasMany
    {
        return $this->hasMany(JewelSocketAssignment::class);
    }

    /**
     * Get the gem links within this level range.
     *
     * @return HasMany<GemLink, $this>
     */
    public function gemLinks(): HasMany
    {
        return $this->hasMany(GemLink::class);
    }

    /**
     * Scope the query to order level ranges by their sort order.
     *
     * @param  Builder<LevelRange>  $query
     * @return Builder<LevelRange>
     */
    #[Scope]
    protected function ordered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
