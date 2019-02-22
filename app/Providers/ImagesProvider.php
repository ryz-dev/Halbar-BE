<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

  class ImagesProvider extends ServiceProvider
  {
    public function boot()
    {
      View::composer(
        ['admin.images.modals'],
        'App\Http\ViewComposers\ComposerImages'
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
