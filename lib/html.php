<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use C;
use Tpl;

class Html {

  public static function mark($note) {
    return static::snippet('mark', [
      'hide'   => $note->hide,
      'count'  => $note->count,
      'order'  => $note->order,
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
      'hide'   => $note->hide,
      'count'  => $note->count,
      'order'  => $note->order,
      'note'   => $note->note
    ]);
  }

  public static function js() {
    return static::snippet('script', [
      'offset' => c::get('plugin.footnotes.offset', 0),
      'speed'  => c::get('plogin.footnotes.smoothscroll.speed', 500),
    ]);
  }

  protected static function snippet($name, $data) {
    return tpl::load(dirname(__DIR__) . DS . 'snippets' . DS . $name . '.php', $data);
  }

}
