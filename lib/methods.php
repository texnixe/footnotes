<?php

namespace Kirby\distantnative\Footnotes;


class Methods {

  public static function field($field, $args = []) {
    $field->value = static::run($field->value, $field->page, $args);
    return $field;
  }

  public static function prefilter($kirbytext, $value) {
    return static::run($value, kirby()->site()->activePage());
  }

  protected static function run($text, $page, $args = []) {
    $core = new Core($text, $page);
    $args = Core::arguments($args);

    if($args['convert'] === false) {
      $core->remove();
      return $core->text;
    } else {
      return $core->process($args['bibliography']);
    }
  }

  public static function bibliography($field) {
    $core = new Core($field->value, $field->page);
    $text = $core->convert(false);
    return html::bibliography($core->entries);
  }
}
