<?php

class KirbyFootnotes {

  public static function field($field, $args = []) {
    $field->value = Kirby\Footnotes\Core::run($field->value, $field->page, $args);
    return $field;
  }

  public static function bibliography($field) {
    return Kirby\Footnotes\Core::bibliography($field);
  }

}
