<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use A;
use C;
use Collection;
use Tpl;

class Core {

  public function __construct($text, $page) {
    $this->text     = new Text($text);
    $this->matches  = new Matches;
    $this->entries  = new Collection;
    $this->template = new Templates($page);
  }

  // ================================================
  //  Process Footnotes
  // ================================================

  public function process($bibliography = true) {
    if($this->template->isAllowed()) {
      return $this->convert($bibliography);
    } else {
      return $this->remove();
    }
  }


  public function convert($bibliography = true) {

    if($this->matches->match($this->text)) {
      $notes = $this->matches->clean();

      // merge duplicates
      if(c::get('plugin.footnotes.merge', false)) {
        $notes = array_unique($notes);
      }

      $count = 1;
      $order = 1;

      foreach($notes as $key => $note) {
        $note = new Note($note, $count, $order);

        $mark = html::mark($note);
        $this->text->replaceMark($mark, $key, $this->matches->toArray());

        $entry = html::entry($note);
        $this->entries->append($key, $entry);
      }

      if($bibliography) {
        $this->text->append(html::bibliography($this->entries));
      }

      // append js to script of smooth scroll active
      if(c::get('plugin.footnotes.smoothscroll', true)) {
        $this->text->append(html::js());
      }
    }

    return $this->text;

  }


  public function remove() {

    if($this->matches->match($this->text)) {
      foreach($this->matches->toArray() as $note) {
          $this->text->replace($note);
      }
    }

    return $this->text;

  }


  public static function args($args = []) {
    if(is_bool($args)) {
      $args = array('convert' => $args);
    }
    $defaults = array(
      'convert'      => true,
      'bibliography' => true,
    );
    return a::merge($defaults, $args);
  }



  public static function bibliography($field) {
    $self = new self($field->value, $field->page);
    $text = $self->convert(false);
    return html::bibliography();
  }

}
