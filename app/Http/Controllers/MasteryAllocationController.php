<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMasteryAllocationRequest;
use App\Models\LevelRange;
use App\Models\MasteryAllocation;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class MasteryAllocationController extends Controller
{
    /**
     * Allocate or change a mastery effect within the level range.
     */
    public function store(StoreMasteryAllocationRequest $request, Template $template, LevelRange $range): RedirectResponse
    {
        $validated = $request->validated();

        $range->masteryAllocations()->updateOrCreate(
            ['mastery_node_id' => $validated['mastery_node_id']],
            ['effect_id' => $validated['effect_id']],
        );

        return back();
    }

    /**
     * Change the effect chosen for an already-allocated mastery.
     */
    public function update(StoreMasteryAllocationRequest $request, Template $template, LevelRange $range, MasteryAllocation $mastery): RedirectResponse
    {
        $mastery->update(['effect_id' => $request->validated('effect_id')]);

        return back();
    }
}
