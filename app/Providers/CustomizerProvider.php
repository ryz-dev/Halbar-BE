<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

  class CustomizerProvider extends ServiceProvider
  {
    public function boot()
    {
      View::composer(
        ['admin.templates.customizer'],
        'App\Http\ViewComposers\ComposerCustomizer'
      );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
      //
    }
  }
?>
