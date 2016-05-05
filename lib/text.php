<?php

namespace Kirby\Plugins\distantnative\Footnotes;

class Text {

  public function __construct($text) {
    $this->text = $text;
  }

  public function append($text) {
    $this->text .= $text;
  }

  public function replace($find, $replace) {
    $this->text = str_replace($find, $replace, $this->text);
  }

  public function __toString() {
    return $this->text;
  }

}
