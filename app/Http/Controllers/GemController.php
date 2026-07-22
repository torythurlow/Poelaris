<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGemRequest;
use App\Models\Gem;
use App\Models\GemLink;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class GemController extends Controller
{
    /**
     * Add a gem to the specified gem link.
     */
    public function store(StoreGemRequest $request, Template $template, LevelRange $range, GemLink $gemLink): RedirectResponse
    {
        $gemLink->gems()->create($request->validated());

        return back();
    }

    /**
     * Remove a gem from the specified gem link.
     */
    public function destroy(Template $template, LevelRange $range, GemLink $gemLink, Gem $gem): RedirectResponse
    {
        $gem->delete();

        return back();
    }
}
