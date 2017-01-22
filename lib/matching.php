<?php

namespace Kirby\Footnotes;

class Matching {

  protected $matches;

  public function find($text) {
    return preg_match_all('/\[(\^.*?)\]/s', $text, $this->matches);
  }

  public function strip() {
    $self = $this;
    return array_map(function($match) use($self) {
      $match = preg_replace('/\[(\^(.*?))\]/s', '\2', $match);
      $match = str_replace(array('<p>','</p>'), '', kirbytext($match));
      return $match;
    }, $this->toArray());
  }

  public function toArray() {
    return $this->matches[0];
  }

}
