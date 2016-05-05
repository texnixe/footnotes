<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use C;

require_once('lib/core.php');
require_once('lib/text.php');
require_once('lib/matches.php');
require_once('lib/note.php');
require_once('lib/html.php');
require_once('lib/templates.php');
require_once('lib/methods.php');
require_once('lib/legacy.php');

// $page->text()->footnotes()->kt()
$ftFieldMethod = function($field, $args = []) {
  return Methods::field($field, $args);
};

$kirby->set('field::method', 'footnotes', $ftFieldMethod);
$kirby->set('field::method', 'ft',        $ftFieldMethod);


// plugin.footnotes.global
if(c::get('plugin.footnotes.global', false)) {
  kirbytext::$post[] = function($kirbytext, $value) {
    Methods::prefilter($kirbytext, $value);
  };
}
