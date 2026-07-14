<?php

namespace App\Console\Commands;

use App\Models\TreeVersion;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('tree:activate {version}')]
#[Description('Sets the currently active tree version')]
class ActivateTreeVersion extends Command
{
    /**
     * Execute the console command to update the currently active tree version.
     */
    public function handle(): int
    {
        $version = $this->argument('version');

        $treeVersion = TreeVersion::where('version', $version)->first();

        if(! $treeVersion){
            $this->error("Version {$version} not found");
            return self::FAILURE;
        }

        TreeVersion::query()->update(['is_active' => false]);
        $treeVersion->update(['is_active' => true]);

        $this->info("Version {$version} is now active");
        return self::SUCCESS;
    }
}
