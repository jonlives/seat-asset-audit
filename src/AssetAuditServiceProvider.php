<?php
/*
This file is part of SeAT

Copyright (C) 2015, 2017  Leon Jacobs

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

namespace jonlives\Seat\AssetAudit;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Class EveapiServiceProvider
 * @package jonlives\Seat\AssetAudit;
 */
class AssetAuditServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $this->add_routes();
        $this->add_publications();
        $this->add_views();
        $this->add_translations();
    }

    /**
     * Include the routes
     */
    public function add_routes()
    {
        if (!$this->app->routesAreCached())
            include __DIR__ . '/Http/routes.php';
    }

    /**
     * Set the paths for migrations and assets that
     * should be published to the main application
     */
    public function add_publications()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ]);
    }

    /**
     * Set the path and namespace for the vies
     */
    public function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'supers');
    }

    /**
     * Include the translations and set the namespace
     */
    public function add_translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'supers');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // Merge the config with anything in the main app
        // Web package configurations
        $this->mergeConfigFrom(
            __DIR__ . '/Config/assetaudit.config.php', 'supers.config');
        $this->mergeConfigFrom(
            __DIR__ . '/Config/assetaudit.permissions.php', 'web.permissions');
        $this->mergeConfigFrom(
            __DIR__ . '/Config/assetaudit.locale.php', 'web.locale');

        // Menu Configurations
        $this->mergeConfigFrom(
            __DIR__ . '/Config/assetaudit.sidebar.php', 'package.sidebar');

    }
}
