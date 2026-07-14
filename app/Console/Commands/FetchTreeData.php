<?php

namespace App\Console\Commands;

use App\Actions\FetchTreeVersion;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use RuntimeException;

#[Signature('tree:fetch {league} {version}')]
#[Description('Fetch and cache the official GGG passive skill tree JSON for a league')]
class FetchTreeData extends Command
{
    /**
     * Execute the console command to fetch the selected version and league's tree data.
     * @throws ConnectionException
     */
    public function handle(FetchTreeVersion $action): int
    {
        $league = $this->argument('league');
        $version = $this->argument('version');

        $this->info("Fetching tree data for {$league} ({$version}) from GGG export repo...");

        try {
            $treeVersion = $action->handle($league, $version);
        } catch (RuntimeException $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $this->info("Saved to storage/app/{$treeVersion->file_path}");
        $this->info("Run `sail artisan tree:activate {$version}` when ready to switch to this version.");
        return self::SUCCESS;
    }
}
