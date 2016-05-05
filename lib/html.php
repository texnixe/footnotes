<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use C;
use Tpl;

class Html {

  public static function mark($note) {
    return static::snippet('mark', [
      'count'  => $note->count,
      'order'  => $note->order,
      'hide'   => $note->hide,
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
      'note'   => $note->hide ? trim(substr($note, 1)) : trim($note),
      'count'  => $note->count,
      'order'  => $note->order,
      'hide'   => $note->hide,
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
