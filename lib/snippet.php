<?php

namespace Kirby\Footnotes;

use C;
use Tpl;

class Snippet {

  public static function reference($note) {
    return static::snippet('reference', [
      'count'  => $note->count,
      'order'  => $note->order,
      'hidden' => $note->isHidden(),
    ]);
  }

  public static function bibliography($entries) {
    if($entries->count() == 0) return null;

    return static::snippet('bibliography', [
      'entries' => $entries
    ]);
  }

  public static function entry($note) {
    return static::snippet('entry', [
      'note'   => $note->isHidden() ? trim(substr($note, 1)) : trim($note),
      'count'  => $note->count,
      'order'  => $note->order,
      'hidden' => $note->isHidden(),
    ]);
  }

  public static function js() {
    return static::snippet('script', [
      'offset' => c::get('plugin.footnotes.scroll.offset', 0),
      'speed'  => c::get('plogin.footnotes.scroll.speed', 500),
    ]);
  }

  protected static function snippet($name, $data) {
    return tpl::load(dirname(__DIR__) . DS . 'snippets' . DS . $name . '.php', $data);
  }

}
