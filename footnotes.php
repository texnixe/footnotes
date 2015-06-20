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
    $allowed = c::get('footnotes.templates.allow', true);
    $ignored = c::get('footnotes.templates.ignore', array());


    if(($allowed === true or in_array($page->template(), $allowed)) and !in_array($page->template(), $ignored)) {
      return self::convert($text);
    } else {
      return self::remove($text);
    }
  }

  public static function convert($text) {

    if(preg_match_all(self::$patternFootnote, $text, $matches)) {

      // start footnotes list
      $list  = '<div class="footnotes" id="footnotes">';
      $list .= '<div class="footnotedivider"></div>';
      $list .= '<ol>';


      $footnotes = array_map(function($fn) {
        // separate footnotes from leading number
        $fn = preg_replace(self::$patternContent, '\1', $fn);

        // enable Kirbytext in footnotes
        $fn = kirbytext($fn);
        $fn = str_replace(array('<p>','</p>'), '', $fn);
        return $fn;
      }, $matches[0]);

      // merge duplicates
      if(c::get('footnotes.merge', false)) $footnotes = array_unique($footnotes);


      $count = 1;
      $order = 1;

      foreach($footnotes as $key => $fn) {
        $hidden  = substr($fn, 0, 4) == '<no>';
        $replace = self::reference($fn, $count, $order, $hidden);
        $list   .= self::entry($fn, $count, $order, $hidden);

        if(!$hidden) $order++;
        $count++;

        if(c::get('footnotes.merge', false)) {
          $regex = preg_quote($matches[0][$key]);
          $regex = '#'.preg_replace('/(\\\[[0-9]*\\\. )/', '\[[0-9]*\. ', $regex).'#';
          $text  = preg_replace($regex, $replace, $text);
        } else {
          $text = str_replace($matches[0][$key], $replace, $text);
        }
      }


      // close footnotes list and append to text
      $list .= '</ol></div>';
      $text .= $list;

      // append js to script of smooth scroll active
      if(c::get('footnotes.smoothscroll', false)) $text .= self::script();
    }

    return $text;
  }

  public static function reference($fn, $count, $order, $hidden) {
    return $hidden ? '' : '<sup class="footnote"><a href="#fn-'.$count.'" id="fnref-'.$count.'">'.$order.'</a></sup>';
  }

  public static function entry($fn, $count, $order, $hidden) {
    return $hidden ? '<li id="fn-'.$count.'" style="list-style-type:none">'.$fn.'</li>' : '<li id="fn-'.$count.'" value="'.$order.'">'.$fn.' <span class="footnotereverse"><a href="#fnref-'.$count.'">&#8617;</a></span></li>';
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
