<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use A;
use C;
use Tpl;

class Core {

  public $text = '';
  public $page = null;

  private $matches       = null;
  private $entries       = '';
  private $templates     = null;
  private $regexFootnote = '/\[(\d+\..*?)\]/s';
  private $regexContent  = '/\[\d+\.(.*?)\]/s';


  public function __construct($text, $page) {
    $this->text      = $text;
    $this->page      = $page;
    $this->templates = array(
      'allowed' => c::get('plugin.footnotes.templates.allow', true),
      'ignore'  => c::get('plugin.footnotes.templates.ignore', array())
    );
  }

  public static function defaultArgs($args = array()) {
    if(is_bool($args)) {
      $args = array('convert' => $args);
    }
    $defaults = array(
      'convert'      => true,
      'bibliography' => true,
    );
    return a::merge($defaults, $args);
  }


  public function process($bibliography = true) {
    $check = ($this->templates['allowed'] === true or
              in_array($this->page->template(), $this->templates['allowed'])) and
             !in_array($this->page->template(), $this->templates['ignore']);

    return $check ? $this->convert($bibliography) : $this->remove();
  }


  public function convert($bibliography = true) {
    if(preg_match_all($this->regexFootnote, $this->text, $this->matches)) {

      $fns = array_map(array($this, '_clean'), $this->matches[0]);

      // merge duplicates
      if(c::get('plugin.footnotes.merge', false)) $fns = array_unique($fns);

      $count = 1;
      $order = 1;

      foreach($fns as $key => $fn) {
        $args = array(
          'fn'     => $fn,
          '#'      => $count,
          'no.'    => $order,
          'hide'   => substr($fn, 0, 4) === '<no>'
        );

        $replace = $this->_reference($args);
        $this->_replace($key, $replace);

        $entry = $this->_entry($args);
        $this->_bibentry($entry);

        $count++;
        if(!$args['hide']) $order++;
      }

      if($bibliography) $this->text .= $this->_bibliography();

      // append js to script of smooth scroll active
      if(c::get('plugin.footnotes.smoothscroll', true)) $this->text .= $this->_script();
    }

    return $this->text;
  }


  public function remove() {
    if (preg_match_all($this->regexFootnote, $this->text, $this->matches)) {
      foreach($this->matches[0] as $fn) {
          $this->text = str_replace($fn, '', $this->text);
      }
    }
    return $this->text;
  }

  public static function bibliography($field) {
    $self = new self($field->value, $field->page);
    $text = $self->convert(false);
    return $self->_bibliography();
  }


  private function _replace($key, $replace) {
    if(c::get('plugin.footnotes.merge', false)) {
      $regex      =     preg_quote($this->matches[0][$key]);
      $regex      = '#'.preg_replace('/(\\\[[0-9]*\\\. )/', '\[[0-9]*\. ', $regex).'#';
      $this->text =     preg_replace($regex, $replace, $this->text);
    } else {
      $this->text = str_replace($this->matches[0][$key], $replace, $this->text);
    }
  }


  private function _clean($fn) {
    $fn  = preg_replace($this->regexContent, '\1', $fn);
    return str_replace(array('<p>','</p>'), '', kirbytext($fn));
  }


  private function _bibentry($entry) {
    $this->entries .= $entry;
  }


  private function _bibliography() {
    if(empty($this->entries)) return false;

    return $this->snippet('bibliography', [
      'entries' => $this->entries
    ]);
  }


  private function _reference($p) {
    return $this->snippet('reference', [
      'hide'   => $p['hide'],
      'count'  => $p['#'],
      'number' => $p['no.'],
    ]);
  }


  private function _entry($p) {
    return $this->snippet('entry', [
      'hide'   => $p['hide'],
      'count'  => $p['#'],
      'number' => $p['no.'],
      'note'   => $p['fn']
    ]);
  }


  private function _script() {
    return $this->snippet('script', [
      'offset' => c::get('plugin.footnotes.offset', 0),
      'speed'  => c::get('plogin.footnotes.smoothscroll.speed', 500),
    ]);
  }

  protected function snippet($snippet, $args) {
    return tpl::load(__DIR__ . DS . 'snippets' . DS . $snippet . '.php', $args);
  }
}
