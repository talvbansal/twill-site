<?php

namespace Talvbansal\TwillSite;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class TwillSiteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/twill-site.php' => config_path('twill-site.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/twill-site.php', 'twill-site');

        // if the glide sources are set to disk names lets fetch the flysystem driver for glide to use...
        if ($this->isDisk(env('GLIDE_SOURCE', ''))) {
            config()->set('twill.glide.source', Storage::disk(env('GLIDE_SOURCE', 'do_spaces'))->getDriver());
        }

        if ($this->isDisk(env('GLIDE_CACHE', ''))) {
            config()->set('twill.glide.cache', Storage::disk(env('GLIDE_CACHE', 'do_spaces'))->getDriver());
        }
    }

    private function isDisk(string $diskName = ''): bool
    {
        return array_key_exists($diskName, config('filesystems.disks'));
    }
}
