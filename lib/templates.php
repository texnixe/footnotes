<?php

namespace Kirby\Plugins\distantnative\Footnotes;

use C;

class Templates {

  public function __construct($page) {
    $this->page = $page;
    $this->whitelist = c::get('plugin.footnotes.templates.allow', true);
    $this->blacklist = c::get('plugin.footnotes.templates.ignore', []);
  }

  public function isAllowed() {
    return $this->isWhitelisted() && !$this->isBlacklisted();
  }

  public function isWhitelisted() {
    return $this->whitelist === true || in_array($this->page->template(), $this->whitelist);
  }

  public function isBlacklisted() {
    return in_array($this->page->template(), $this->blacklist);
  }

}
