<?php

namespace Core\Validator\Rules;

use Core\Validator\ValInterface;
use Exception;

class Email implements ValInterface {

  protected $value, $name;

  public function __construct($value, $name) {
    $this->value = $value;
    $this->name = $name;
  }

  public function validate() {
    if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
      throw new Exception("$this->name filed is not a valid email", 400);
    }
    return '';
  }
}