<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['league_name', 'version', 'is_active', 'file_path', 'fetched_at'])]
class TreeVersion extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'league_name' => 'string',
            'version' => 'string',
            'is_active' => 'boolean',
            'file_path' => 'string',
            'fetched_at' => 'datetime',
        ];
    }

    /**
     * Scope the query to only the active tree version.
     *
     * @param  Builder<TreeVersion>  $query
     * @return Builder<TreeVersion>
     */
    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', 1);
    }
}
