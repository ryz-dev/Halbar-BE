<?php

  function costumTheme($params = array())
  {
      $dataArray = new \App\Classes\TemplateModule;
      $listArray = $dataArray->setupTheme();

      $section = $params['section'];
      $type = $params['type'];
      $id = $params['id'];

      return $listArray['setup']->$section->$type->$id;
  }
