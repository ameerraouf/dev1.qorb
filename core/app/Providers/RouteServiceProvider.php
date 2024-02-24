<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{

    protected $namespace = 'App\Http\Controllers';
    protected $dashboardNamespace = 'App\Http\Controllers\Dashboard';
    protected $apisNamespace = 'App\Http\Controllers\APIs';
    protected $teacherNamespace = 'App\Http\Controllers\Teacher';


    public const HOME = '/home';
    public const Teacher_DASHBOARD = '/teacherhome';


    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->mapApiRoutes();
        $this->mapDashboardRoutes();
        $this->mapTeacherRoutes();
        $this->mapApisRoutes();
        $this->mapWebRoutes();
        // Route::middleware('web')
        //         ->as('teacher.')
        //         ->group(base_path('routes/teacher.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "Dashboard" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDashboardRoutes()
    {
        // Route::prefix(env('BACKEND_PATH'))
        //     // ->middleware('auth')
        //     ->namespace($this->dashboardNamespace)
        //     ->group(base_path('routes/dashboard.php'));
        Route::group([
            'namespace' => $this->dashboardNamespace
        ], function () {
            require base_path('routes/dashboard.php');
        });
    }
    protected function mapSpecialistRoutes()
    {
        // Route::prefix(env('SPECIALIST_PATH'))
        //     // ->middleware('auth')
        //     ->namespace($this->dashboardNamespace)
        //     ->group(base_path('routes/dashboard.php'));
        Route::group([
            'namespace' => $this->dashboardNamespace
        ], function () {
            require base_path('routes/dashboard.php');
        });
    }
    
    protected function mapTeacherRoutes()
    {
        Route::group([
            'namespace' => $this->teacherNamespace
        ], function () {
            require base_path('routes/teacher.php');
        });
    }



    /**
     * Define the "APIs" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApisRoutes()
    {
        Route::prefix("/api/v1")
            ->middleware('web')
            ->namespace($this->apisNamespace)
            ->group(base_path('routes/apis.php'));
    }
}
