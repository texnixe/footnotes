<?php

namespace Kirby\Plugins\distantnative\Footnotes;


class Methods {

  public static function field($field, $args = []) {
    $field->value = static::run($field->value, $field->page, $args);
    return $field;
  }

  public static function prefilter($kirbytext, $value) {
    return static::run($value, kirby()->site()->activePage());
  }

  protected static function run($text, $page, $args = []) {
    $args = Core::args($args);
    $core = new Core($text, $page);

    if($args['convert'] === false) {
      return $core->remove();
    } else {
      return $core->process($args['bibliography']);
    }
  }

}
