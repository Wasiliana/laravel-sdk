<?php

namespace Wasiliana\LaravelSdk\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallPackage extends Command
{
    protected $signature = 'wasiliana:install';

    protected $description = 'Publish wasiliana config file';


    public function handle()
    {
        $this->info('Installing Wasiliana LaravelSdk');

        $this->info('Publishing configuration...');

        if (!$this->configExists('wasiliana.php')) {
            $this->publishConfiguration();
        } else {
            if ($this->shouldOverwriteConfig()) {
                $this->info('Overwriting configuration file...');
                $this->publishConfiguration($force = true);
            } else {
                $this->info('Existing configuration was not overwritten');
            }
        }
        $this->info('Installed Wasiliana LaravelSdk');
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig()
    {
        return $this->confirm('Config file already exists. Do you want to overwrite it?', false);
    }

    private function publishConfiguration($forcePublish = false)
    {
        $params = [
            '--provider' => "Wasiliana\LaravelSdk\LaravelSdkServiceProvider",
            '--tag'
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}
