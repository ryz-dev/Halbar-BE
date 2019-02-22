<?php
  function setting($params = '')
  {
      $setting = App\Settings::first();
      return $setting[$params];
  }

  function nav($params = array())
  {
      $nav = App\Menus::where('status', $params['position'])->orderBy('sort')->get();
      return $nav;
  }

  function blogs($params = array())
  {
      if ($params['limit'] == null) {
          $blogs = App\Posts::where('status', 'publish')
      ->where('published', '<=', \DB::raw('now()'));
          return $blogs;
      }
      $blogs = App\Posts::where('status', 'publish')
    ->where('published', '<=', \DB::raw('now()'))
    ->limit($params['limit']);
      return $blogs;
  }

  function readMore($params = array())
  {
      $text = strip_tags($params['text']);
      $stringCut = substr($text, 0, $params['limit']);
      $endPoint = strrpos($stringCut, ' ');
      $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
      return $string;
  }
