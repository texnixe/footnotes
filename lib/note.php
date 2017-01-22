<?php

namespace Kirby\Footnotes;

class Note {

  public function __construct($note, $count, $order) {
    $this->note    = $note;
    $this->count   = $count;
    $this->order   = $order;
  }

  public function __toString() {
    return $this->note;
  }

  public function isHidden() {
    return substr($this->note, 0, 1) === '!';
  }

}
