<?php

namespace App\Actions;

use App\Models\TreeVersion;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class FetchTreeVersion
{
    /**
     * Download the GGG passive tree JSON for a league/version, cache it to
     * disk, and record it as a TreeVersion.
     *
     * @throws ConnectionException
     * @throws RuntimeException
     */
    public function handle(string $league, string $version): TreeVersion
    {
        $path = "trees/{$version}.json";
        $url = "https://raw.githubusercontent.com/grindinggear/skilltree-export/{$version}/data.json";

        $response = Http::timeout(60)->retry(3, 2000, throw: false)->get($url);

        if ($response->failed()) {
            throw new RuntimeException(
                "Failed to fetch: HTTP {$response->status()}. Check that version tag '{$version}' exists at https://github.com/grindinggear/skilltree-export/releases"
            );
        }

        $data = $response->json();

        if (! isset($data['nodes']) || ! isset($data['groups'])) {
            throw new RuntimeException('Response is missing expected keys (nodes, groups). Wrong file or version?');
        }

        Storage::put($path, $response->body());

        return TreeVersion::create([
            'league_name' => $league,
            'version' => $version,
            'file_path' => $path,
            'fetched_at' => now(),
            'is_active' => false,
        ]);
    }
}
