<?php

namespace Kirby\Footnotes;

use C;

require_once('lib/core.php');
require_once('lib/text.php');
require_once('lib/matching.php');
require_once('lib/note.php');
require_once('lib/snippet.php');
require_once('lib/template.php');
require_once('legacy.php');

// $page->text()->footnotes()->kt()
$kirby->set('field::method', ['footnotes', 'ft'], function ($field, $args = []) {
    $field->value = Core::run($field->value, $field->page, $args);
    return $field;
});

// plugin.footnotes.global
if (c::get('plugin.footnotes.global', false)) {
    kirbytext::$post[] = function ($kirbytext, $value) {
        Core::run($value, kirby()->site()->activePage());
    };
}
