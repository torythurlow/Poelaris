<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLevelRangeRequest;
use App\Http\Requests\UpdateLevelRangeRequest;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LevelRangeController extends Controller
{
    /**
     * Store a newly created level range for the template.
     */
    public function store(StoreLevelRangeRequest $request, Template $template): RedirectResponse
    {
        $template->levelRanges()->create([
            ...$request->validated(),
            'sort_order' => $template->levelRanges()->count(),
        ]);

        return back();
    }

    /**
     * Update the specified level range.
     */
    public function update(UpdateLevelRangeRequest $request, Template $template, LevelRange $range): RedirectResponse
    {
        $range->update($request->validated());

        return back();
    }

    /**
     * Remove the specified level range.
     */
    public function destroy(Template $template, LevelRange $range): RedirectResponse
    {
        $range->delete();

        return back();
    }

    /**
     * Persist the new sort order for the template's level ranges.
     */
    public function reorder(Request $request, Template $template): RedirectResponse
    {
        $validated = $request->validate([
            'range_ids' => ['required', 'array'],
            'range_ids.*' => ['integer', 'exists:level_ranges,id'],
        ]);

        foreach (array_values($validated['range_ids']) as $sortOrder => $rangeId) {
            $template->levelRanges()->whereKey($rangeId)->update(['sort_order' => $sortOrder]);
        }

        return back();
    }
}
