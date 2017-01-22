<?php

namespace Kirby\Footnotes;

use C;
use Collection;

class Core {

  public function __construct($text, $page) {
    $this->text     = new Text($text);
    $this->matches  = new Matches;
    $this->entries  = new Collection;
    $this->template = new Templates($page);
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
    if($this->matches->match($this->text)) {

      $notes = $this->matches->clean();

      // merge duplicates
      if(c::get('plugin.footnotes.merge', true)) {
        $notes = array_unique($notes);
      }

      $count = 1;
      $order = 1;

      foreach($notes as $key => $note) {
        $note = new Note($note, $count, $order);

        $mark = html::mark($note);
        $this->text->replace($this->matches->toArray()[$key], $mark);

        $entry = html::entry($note);
        $this->entries->append($key, $entry);

        $count++;
        if(!$note->hide) $order++;
      }

      if($withBibliography) {
        $this->text->append(html::bibliography($this->entries));
      }

      // append js to script of smooth scroll active
      if(c::get('plugin.footnotes.scroll', true)) {
        $this->text->append(html::js());
      }
    }
  }


  public function remove() {
    if($this->matches->match($this->text)) {
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
