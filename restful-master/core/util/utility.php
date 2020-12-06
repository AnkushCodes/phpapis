<?php
class Utility{
 
   public static function getPathValue($paths){
    $uri = explode('/', $paths);
    return $uri;
   }

}
?>