<?php

namespace Kirby\Plugins\distantnative\Footnotes;

class Note {

  public function __construct($note, $count, $order) {
    $this->note = $note;
    $this->count = $count;
    $this->order = $order;
    $this->hide  = substr($this->note, 0, 4) === '<no>';
  }

}
