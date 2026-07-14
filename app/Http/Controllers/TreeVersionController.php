<?php

namespace App\Http\Controllers;

use App\Actions\FetchTreeVersion;
use App\Http\Requests\StoreTreeVersionRequest;
use App\Models\TreeVersion;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
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
        return Inertia::render('tree-versions/Index', [
            'versions' => TreeVersion::latest('fetched_at')->get(),
        ]);
    }

    /**
     * Fetch and cache a new tree version from the GGG export repo.
     * @param StoreTreeVersionRequest $request
     * @param FetchTreeVersion $action
     * @return RedirectResponse
     * @throws ConnectionException
     */
    public function store(StoreTreeVersionRequest $request, FetchTreeVersion $action): RedirectResponse
    {
        try {
            $action->handle(...$request->validated());
        } catch (RuntimeException $e) {
            throw ValidationException::withMessages(['version' => $e->getMessage()]);
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
