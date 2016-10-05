<?php

class Ferramentas
{

  private static $jsfiles = [];
  private static $jsposition = 'HEAD';
  private static $positions = [
    'HEAD'=>1,
    'BODY_TOP'=>2,
    'BODY_END'=>3,
  ];

  public static function SetJsfile($file, $jsposition,$type='')
  {
    self::$jsposition = $jsposition;
    self::$jsfiles[] = [
      'position'=>$jsposition,
      'file'=>$file,
      'type'=>$type
    ];
  }

  public static function GetJsfile($jsposition)
  {
    $scripts = '';
    foreach (self::$jsfiles as $k => $file) {
      if($file['position'] == $jsposition)
      {
        $scripts .= "<script {$file['type']} src='{$file['file']}' charset='utf-8'></script>";
      }
    }

    return $scripts;


  }


}
