<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNodeAllocationRequest;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class NodeAllocationController extends Controller
{
    /**
     * Allocate a passive tree node within the level range.
     */
    public function store(StoreNodeAllocationRequest $request, Template $template, LevelRange $range): RedirectResponse
    {
        $validated = $request->validated();

        $range->nodeAllocations()->updateOrCreate(
            ['node_id' => $validated['node_id']],
            ['node_type' => $validated['node_type']],
        );

        return back();
    }

    /**
     * Remove an allocated node from the level range.
     */
    public function destroy(Template $template, LevelRange $range, string $nodeId): RedirectResponse
    {
        $range->nodeAllocations()->where('node_id', $nodeId)->delete();

        return back();
    }
}
