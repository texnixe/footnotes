<?php

/**
 * Adding an footnotes field method: e.g. $page->text()->footnotes()->kt()
 */
field::$methods['footnotes'] = function($field, $convert=true) {
  if($convert) {
    $field->value = KirbyFootnotes::process($field->value, $field->page);
  } else {
    $field->value = KirbyFootnotes::remove($field->value);
  }
  return $field;
};

/**
 *  Pre-filtering Kirbytext if global option "footnotes.global" is set true
 */
if(c::get('footnotes.global', false)) {
  kirbytext::$post[] = function($kirbytext, $value) {
    $page = kirby()->site()->activePage();
    return KirbyFootnotes::process($value, $page);
  };
}


/**
 * KirbyFootnotes class
 */
class KirbyFootnotes {

  private static $patternFootnote = '/\[(\d+\..*?)\]/s';
  private static $patternContent  = '/\[\d+\.(.*?)\]/s';

  public static function process($text, $page) {
    $restricted = c::get('footnotes.templates', array());
    $templates  = array_map(function($t) use ($page) {
      return preg_match('/^'.$t.'$/', $page->template()) == 1 ? true : false;
    }, $restricted);

    if(!in_array(true, $templates)) {
      return self::convert($text);
    } else {
      return self::remove($text);
    }
  }

  public static function convert($text) {
    $n     = 1;
    $notes = array();

    if(preg_match_all(self::$patternFootnote, $text, $matches)) {
      foreach ($matches[0] as $fn) {
        $notes[$n] = preg_replace(self::$patternContent, '\1', $fn);

        if(substr($notes[$n], 1, 4) == '<no>') {
          $substitute  = '';
        } else {
          $substitute  = '<sup class="footnote">';
          $substitute .= '<a href="#fn-'.$n.'" id="fnref-'.$n.'">'.$n.'</a>';
          $substitute .= '</sup>';
        }
        $text      = str_replace($fn, $substitute, $text);
        $notes[$n] = kirbytext($notes[$n]);
        $notes[$n] = str_replace('<p>', '', $notes[$n]);
        $notes[$n] = str_replace('</p>', '', $notes[$n]);
        $n++;
      }

      // build footnotes references
      $text .= '<div class="footnotes" id="footnotes">';
      $text .= '<div class="footnotedivider"></div>';
      $text .= '<ol>';

      $order = 1;
      for($i = 1; $i < $n; $i++) {
        if(substr($notes[$i], 0, 4) == '<no>') {
          $text .= '<li id="fn-' . $i . '" style="list-style-type:none">';
          $text .= $notes[$i];
          $text .= '</li>';
          $notes[$i] = str_replace('<no>', "", $notes[$i]);
        } else {
          $text .= '<li id="fn-' . $i . '" value="' . $order . '">';
          $text .= $notes[$i];
          $text .= ' <span class="footnotereverse"><a href="#fnref-' . $i . '">&#8617;</a></span>';
          $text .= '</li>';
          $order++;
        }
      }
      $text .= '</ol>';
      $text .= '</div>';

      if(c::get('footnotes.smoothscroll', false)) $text .= self::script();

      return $text;
    }

    return $text;
  }

  public static function remove($text) {
    if (preg_match_all(self::$patternFootnote, $text, $matches)) {
      foreach ($matches[0] as $fn) {
          $text = str_replace($fn, "", $text);
      }
    }
    return $text;
  }

  private static function script() {
    return "<script>$(function() { $('a[href*=#]:not([href=#])').click(function() { if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) { var t = $(this.hash); t = t.length ? t : $('[name=' + this.hash.slice(1) +']'); if (t.length) { $('html,body').animate({ scrollTop: t.offset().top - ".c::get('footnotes.offset', 0)." }, 1000); return false; } } }); });</script>";
  }
}
