<?php

namespace Kirby\Plugins\distantnative\Footnotes;

class Note {

  public function __construct($note, $count, $order) {
    $this->note  = $note;
    $this->count = $count;
    $this->order = $order;
    $this->hide  = substr($this->note, 0, 1) === '!';
  }

  public function __toString() {
    return $this->note;
  }

}
