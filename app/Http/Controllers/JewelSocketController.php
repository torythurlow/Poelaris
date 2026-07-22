<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJewelSocketRequest;
use App\Http\Requests\UpdateJewelSocketRequest;
use App\Models\JewelSocketAssignment;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;

class JewelSocketController extends Controller
{
    /**
     * Assign a jewel to a socket node within the level range.
     */
    public function store(StoreJewelSocketRequest $request, Template $template, LevelRange $range): RedirectResponse
    {
        $validated = $request->validated();

        $range->jewelSocketAssignments()->updateOrCreate(
            ['socket_node_id' => $validated['socket_node_id']],
            ['jewel_name' => $validated['jewel_name'] ?? null, 'notes' => $validated['notes'] ?? null],
        );

        return back();
    }

    /**
     * Update the jewel assigned to a socket.
     */
    public function update(UpdateJewelSocketRequest $request, Template $template, LevelRange $range, JewelSocketAssignment $jewel): RedirectResponse
    {
        $jewel->update($request->validated());

        return back();
    }

    /**
     * Remove a jewel assignment from a socket.
     */
    public function destroy(Template $template, LevelRange $range, JewelSocketAssignment $jewel): RedirectResponse
    {
        $jewel->delete();

        return back();
    }
}
