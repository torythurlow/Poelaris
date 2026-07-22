<?php

namespace App\Models;

use App\Enums\BanditChoice;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['guest_id', 'tree_version_id', 'name', 'class_id', 'ascendancy_name', 'bandit_choice'])]
class Template extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'guest_id' => 'integer',
            'tree_version_id' => 'integer',
            'name' => 'string',
            'class_id' => 'integer',
            'ascendancy_name' => 'string',
            'bandit_choice' => BanditChoice::class,
        ];
    }

    /**
     * Get the guest this template belongs to.
     *
     * @return BelongsTo<Guest, $this>
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Get the tree version this template uses.
     *
     * @return BelongsTo<TreeVersion, $this>
     */
    public function treeVersion(): BelongsTo
    {
        return $this->belongsTo(TreeVersion::class);
    }

    /**
     * Get the level ranges within this template.
     *
     * @return HasMany<LevelRange, $this>
     */
    public function levelRanges(): HasMany
    {
        return $this->hasMany(LevelRange::class);
    }

    /**
     * Map the {range} route parameter to the levelRanges relation for scoped bindings.
     */
    protected function childRouteBindingRelationshipName($childType)
    {
        return $childType === 'range' ? 'levelRanges' : parent::childRouteBindingRelationshipName($childType);
    }
}
