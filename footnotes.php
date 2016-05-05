<?php

require_once('core.php');

use Kirby\Plugins\distantnative\Footnotes\Core as Footnotes;

// Footnotes field method: $page->text()->footnotes()->kt()
field::$methods['footnotes'] = function($field, $args = array()) {
  $args         = Footnotes::defaultArgs($args);
  $footnotes    = new Footnotes($field->value, $field->page, $args);
  $field->value = $args['convert'] ? $footnotes->process($args['bibliography']) : $footnotes->remove();
  return $field;
};

// Kirbytext pre-filter (if option 'footnotes.global' is true)
if(c::get('footnotes.global', false)) {
  kirbytext::$post[] = function($kirbytext, $value) {
    $args      = Footnotes::defaultArgs();
    $footnotes = new Footnotes($value, kirby()->site()->activePage());
    return $footnotes->process($args['bibliography']);
  };
}
