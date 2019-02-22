<?php
  namespace App\Http\ViewComposers;

  use Illuminate\View\View;
  use App\Repositories\UserRepository;
  use TemplateModule;

  class ComposerCustomizer
  {
      public function compose(View $view)
      {
        $view->with('customizer',TemplateModule::setupTheme());
      }
  }
?>
