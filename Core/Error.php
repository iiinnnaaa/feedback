<?php

namespace Core;

class Error{

  const SHOW_ERRORS = true;

  public static function errorHandler($level, $message, $file, $line){
    if(error_reporting() !== 0){
      throw new \ErrorException($message, 0, $level, $file, $line);
    }
  }

  public static function exceptionHandler($exception){

    //Code is 404 (not found) or 500 (general error)
    $code = $exception->getCode();
    if($code != 404){
      $code = 500;
    }
    http_response_code($code);

    if(self::SHOW_ERRORS){
    echo "<h1>Fatal error</h1>";
    echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
    echo "<p>Message: '" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
    } else{
      $log = dirname(__DIR__) .'/logs/' .date('Y-m-d H-i') . '.txt';
      ini_set('error_log', $log);

      $message = "Uncaught exception: '" . get_class($exception) ."'" ." with message ' " .$exception->getMessage() ."'" . "\nStack trace: " .$exception->getTraceAsString()
        ."\nThrown in" .$exception->getFile() ." on line " .$exception->getLine();

      error_log($message);
      View::renderTemplate("$code.html");
    }
  }
}