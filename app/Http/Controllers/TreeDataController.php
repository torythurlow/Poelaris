<?php

namespace App\Http\Controllers;

use App\Models\TreeVersion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Controller to handle tree data logic
 */
class TreeDataController extends Controller
{
    /**
     * Serves the tree JSON for a specified version.
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $version = $request->query('version');

        $treeVersion = $version
            ? TreeVersion::where('version', $version)->firstOrFail()
            : TreeVersion::where('is_active', true)->firstOrFail();

        $cacheKey = "tree-data-{$treeVersion->version}";

        $data = Cache::flexible($cacheKey, [3600, 86400], function () use ($treeVersion) {
            return Storage::get($treeVersion->file_path);
        });

        return response()->json(json_decode($data));

    }
}
