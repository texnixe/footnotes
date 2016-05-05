<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use C;

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

  public function replaceMark($mark, $key, $matches) {
    if(c::get('plugin.footnotes.merge', true)) {
      $this->replaceMatched($key, $matches, $mark);
    } else {
      $this->replace($matches[$key], $mark);
    }
  }

  protected function replaceMatched($key, $matches, $replace) {
    $regex      =     preg_quote($matches[$key]);
    $regex      = '#'.preg_replace('/(\\\[[0-9]*\\\. )/', '\[[0-9]*\. ', $regex).'#';
    $this->text =     preg_replace($regex, $replace, $this->text);
  }

  public function __toString() {
    return $this->text;
  }

}
