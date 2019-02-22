<?php

  namespace App\Classes;

use App\Template;
  use File;
  use Yaml;

  class TemplateModule
  {
      public function getDirectory()
      {
          $files = File::directories(resource_path('views/front/'));
          for ($i=0; $i <count($files) ; $i++) {
              $destroy = explode('/', $files[$i]);
              $current[strtolower(end($destroy))] = [
          'folder' => strtolower(end($destroy)),
          'info' => resource_path('/views/front/').strtolower(end($destroy)).'/info.yml'
        ];
          }
          return $this->getInfo($current);
      }

      public function setupTheme()
      {
          $path = $this->activeTheme()->path;
          require resource_path('views/front/'.$path.'/function.php');
          $res = array(
        'setup'=>json_decode($this->activeTheme()->setup),
        'default'=>$data
      );
          return $res;
      }

      public function staticPage()
      {
          if (isset($this->activeTheme()->path)) {
              $path = $this->activeTheme()->path;
              $files = File::files(resource_path('views/front/'.$path.'/pages'));
              $fill = array('blade','php','.','-');
              for ($i=0; $i <count($files) ; $i++) {
                  $destroy = explode('/', $files[$i]);
                  if (end($destroy) !== 'index.blade.php' and end($destroy) !== 'default.blade.php') {
                      $readyPages[] = [
              'value' => str_replace('.blade.php', '', end($destroy)),
              'name' => trim(str_replace($fill, ' ', ucwords(strtolower(end($destroy)))))
            ];
                  }
              }
              if (isset($readyPages)) {
                  return $readyPages;
              }
          }
      }

      public function getInfo($files)
      {
          foreach ($files as $key => $value) {
              $info = Yaml::parse(file_get_contents($files[$key]['info']));
              $list[] = array_merge(['path'=>$key], $info);
          }
          return $list;
      }

      public function activeTheme()
      {
          return Template::where('status', 'true')->first();
      }

      public function copyAssets($path)
      {
          $destination = public_path('assets/front/'.$path);
          if (!file_exists($destination)) {
              mkdir($destination, 0777, true);
          }
          $files = File::directories(resource_path('views/front/'.$path.'/assets'));
          for ($i=0; $i <count($files) ; $i++) {
              $destroy = explode('/', $files[$i]);
              $lastDestination = $destination.'/'.end($destroy);
              if (!file_exists($lastDestination)) {
                  mkdir($lastDestination, 0777, true);
              }
              File::copyDirectory($files[$i], $lastDestination);
          }
      }
  }
