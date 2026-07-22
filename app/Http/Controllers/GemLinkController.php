<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGemLinkRequest;
use App\Http\Requests\UpdateGemLinkRequest;
use App\Models\GemLink;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class GemLinkController extends Controller
{
    /**
     * Add a new gem link to the level range.
     */
    public function store(StoreGemLinkRequest $request, Template $template, LevelRange $range): RedirectResponse
    {
        $range->gemLinks()->create($request->validated());

        return back();
    }

    /**
     * Rename the specified gem link.
     */
    public function update(UpdateGemLinkRequest $request, Template $template, LevelRange $range, GemLink $gemLink): RedirectResponse
    {
        $gemLink->update($request->validated());

        return back();
    }

    /**
     * Remove the specified gem link and its gems.
     */
    public function destroy(Template $template, LevelRange $range, GemLink $gemLink): RedirectResponse
    {
        $gemLink->delete();

        return back();
    }
}
