<?php

namespace Kirby\Footnotes;

use C;
use Collection;

class Core {

  public function __construct($text, $page) {
    $this->text     = new Text($text);
    $this->matches  = new Matching;
    $this->entries  = new Collection;
    $this->template = new Template($page);
  }

  public static function run($text, $page, $args = []) {
    $args      = self::arguments($args);
    $footnotes = new self($text, $page);

    if($args['convert'] === false) {
      $footnotes->remove();
      return $footnotes->text;
    } else {
      return $footnotes->process($args['bibliography']);
    }
  }

  public static function bibliography($field) {
    $footnotes = new self($field->value, $field->page);
    $text      = $footnotes->convert(false);
    return Snippet::bibliography($footnotes->entries);
  }

  // ================================================
  //  Process footnotes
  // ================================================

  public function process($withBibliography = true) {
    if($this->template->isAllowed()) {
      $this->convert($withBibliography);
    } else {
      $this->remove();
    }

    return $this->text;
  }


  public function convert($withBibliography = true) {
    if($this->matches->find($this->text)) {

      $references = $this->matches->toArray();
      $notes      = $this->matches->strip();

      // merge duplicates
      if(c::get('plugin.footnotes.merge', true)) {
        $notes = array_unique($notes);
      }

      $count = 1;
      $order = 1;

      foreach($notes as $key => $note) {
        $note = new Note($note, $count, $order);

        $this->text->replace($references[$key], Snippet::reference($note));
        $this->entries->append($key, Snippet::entry($note));

        $count++;
        if(!$note->isHidden()) $order++;
      }

      if($withBibliography) {
        $this->text->append(Snippet::bibliography($this->entries));
      }

      // append js to script of smooth scroll active
      if(c::get('plugin.footnotes.scroll', true)) {
        $this->text->append(Snippet::js());
      }
    }
  }


  public function remove() {
    if($this->matches->find($this->text)) {
      foreach($this->matches->toArray() as $note) {
        $this->text->replace($note, '');
      }
    }
  }

  // ================================================
  //  Default arguments
  // ================================================


  public static function arguments($args = []) {
    if(is_bool($args)) {
      $args = ['convert' => $args];
    }

    $defaults = [
      'convert'      => true,
      'bibliography' => true,
    ];

    return array_merge($defaults, $args);
  }

}
