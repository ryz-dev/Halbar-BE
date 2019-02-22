<?php
  namespace App\Http\ViewComposers;

  use Illuminate\View\View;
  use App\Repositories\UserRepository;
  use App\Images;

  class ComposerImages
  {
      public function compose(View $view)
      {
        $images = Images::where('dir','media')->get();
        $view->with('images',$images);
      }
  }
?>
