<?php

namespace Kirby\Plugins\distantnative\Footnotes;

class Matches {

  protected $matches;

  protected $footnotes = '/\[(\d+\..*?)\]/s';
  protected $notes     = '/\[\d+\.(.*?)\]/s';

  public function match($text) {
    return preg_match_all($this->footnotes, $text, $this->matches);
  }

  public function clean() {
    $self = $this;
    return array_map(function($match) use($self) {
      $match = preg_replace($self->notes, '\1', $match);
      $match = str_replace(array('<p>','</p>'), '', kirbytext($match));
      return $match;
    }, $this->toArray());
  }

  public function toArray() {
    return $this->matches[0];
  }

}
