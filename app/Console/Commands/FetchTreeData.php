<?php

namespace App\Console\Commands;

use App\Models\TreeVersion;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

#[Signature('tree:fetch {league} {version}')]
#[Description('Fetch and cache the official GGG passive skill tree JSON for a league')]
class FetchTreeData extends Command
{
    /**
     * Execute the console command to fetch the selected version and league's tree data.
     * @throws ConnectionException
     */
    public function handle(): int
    {
        $league = $this->argument('league');
        $version = $this->argument('version');
        $path = "trees/{$version}.json";
        $url  = "https://raw.githubusercontent.com/grindinggear/skilltree-export/{$version}/data.json";

        $this->info("Fetching tree data for {$league} ({$version}) from GGG export repo...");

        $response = Http::timeout(60)->retry(3, 2000)->get($url);

        if ($response->failed()) {
            $this->error("Failed to fetch: HTTP {$response->status()}");
            $this->error("Check that version tag '{$version}' exists at https://github.com/grindinggear/skilltree-export/releases");
            return self::FAILURE;
        }

        $data = $response->json();

        if(! isset($data['nodes']) || ! isset($data['groups'])){
            $this->error('Response is missing from expected keys (nodes, groups). Wrong file or version?');
            return self::FAILURE;
        }

        Storage::put($path, $response->body());

        TreeVersion::create([
            'league_name' => $league,
            'version' => $version,
            'file_path' => $path,
            'fetched_at' => now(),
            'is_active' => false
        ]);

        $this->info("Saved to storage/app/{$path}");
        $this->info("Run `sail artisan tree:activate {$version}` when ready to switch to this version.");
        return self::SUCCESS;
    }
}
