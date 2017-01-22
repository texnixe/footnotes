<?php

class KirbyFootnotes {

  public static function field($field, $args = []) {
    return Kirby\Footnotes\Methods::field($field, $args);

  }

  public static function bibliography($field) {
    return Kirby\Footnotes\Methods::bibliography($field);
  }
  
}
