<?php

namespace App\Http\Controllers;

use App\Actions\FetchTreeVersion;
use App\Http\Requests\StoreTreeVersionRequest;
use App\Models\TreeVersion;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

/**
 * Controller for managing different tree versions
 */
class TreeVersionController extends Controller
{
    /**
     * List all tree versions.
     * @return Response
     */
    public function index(): Response
    {
        $versions = TreeVersion::all()
            ->sort(fn (TreeVersion $a, TreeVersion $b) => version_compare($b->version, $a->version))
            ->values();

        return Inertia::render('tree-versions/Index', [
            'versions' => $versions,
        ]);
    }

    /**
     * Fetch and cache a new tree version from the GGG export repo.
     * @param StoreTreeVersionRequest $request
     * @param FetchTreeVersion $action
     * @return RedirectResponse
     */
    public function store(StoreTreeVersionRequest $request, FetchTreeVersion $action): RedirectResponse
    {
        try {
            $action->handle(...$request->validated());
        } catch (RuntimeException|ConnectionException $e) {
            Inertia::flash('toast', ['type' => 'error', 'message' => $e->getMessage()]);

            return to_route('tree-versions.index');
        }

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Tree version fetched.')]);

        return to_route('tree-versions.index');
    }

    /**
     * Set the given tree version as the active one.
     * @param TreeVersion $treeVersion
     * @return RedirectResponse
     */
    public function activate(TreeVersion $treeVersion): RedirectResponse
    {
        TreeVersion::query()->update(['is_active' => false]);
        $treeVersion->update(['is_active' => true]);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Tree version activated.')]);

        return to_route('tree-versions.index');
    }
}
