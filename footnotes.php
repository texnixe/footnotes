<?php

namespace Kirby\distantnative\Footnotes;

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
$kirby->set('field::method', ['footnotes', 'ft'], function($field, $args = []) {
  return Methods::field($field, $args);
});

// plugin.footnotes.global
if(c::get('plugin.footnotes.global', false)) {
  kirbytext::$post[] = function($kirbytext, $value) {
    Methods::prefilter($kirbytext, $value);
  };
}
