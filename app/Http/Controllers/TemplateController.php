<?php

namespace App\Http\Controllers;

use App\Actions\CalculatePointBudget;
use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Models\LevelRange;
use App\Models\Template;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TemplateController extends Controller
{
    public function __construct(private readonly CalculatePointBudget $calculator) {}

    /**
     * List all templates belonging to the current guest.
     */
    public function index(Request $request): Response
    {
        $templates = $request->guest()->templates()->with('treeVersion')->latest()->get();

        return Inertia::render('Home', [
            'templates' => $templates,
        ]);
    }

    /**
     * Store a newly created template for the current guest.
     */
    public function store(StoreTemplateRequest $request): RedirectResponse
    {
        $template = $request->guest()->templates()->create($request->validated());

        return to_route('templates.show', $template);
    }

    /**
     * Display the specified template with its level ranges and allocations.
     */
    public function show(Template $template): Response
    {
        $template->load('treeVersion');

        $ranges = $template->levelRanges()
            ->ordered()
            ->with(['nodeAllocations', 'masteryAllocations', 'jewelSocketAssignments', 'gemLinks.gems'])
            ->get()
            ->map(fn (LevelRange $range): array => [
                'range' => $range,
                'point_budget' => $this->calculator->handle($range, $template->bandit_choice),
            ]);

        return Inertia::render('Templates/Show', [
            'template' => $template,
            'ranges' => $ranges,
        ]);
    }

    /**
     * Update the specified template.
     */
    public function update(UpdateTemplateRequest $request, Template $template): RedirectResponse
    {
        $template->update($request->validated());

        return back();
    }

    /**
     * Remove the specified template.
     */
    public function destroy(Template $template): RedirectResponse
    {
        $template->delete();

        return to_route('home');
    }
}
