<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
      //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    RateLimiter::for('login_reg', function(Request $request) {
      return Limit::perMinute(3)->by($request->email . $request->ip());
    });

    RateLimiter::for('api_global', function(Request $request) {
      return $request->user() ?
        Limit::perMinute(200)->by($request->user()->id) : 
        Limit::perMinute(50)->by($request->ip());
    });
  }
}
