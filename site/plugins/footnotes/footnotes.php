<?php

function convert_footnotes($text) {
  $n = 1;
  $notes = array();
  if (preg_match_all('/\[(\d+\. .*?)\]/s', $text, $matches)) {
    foreach ($matches[0] as $fn) {
        $note = preg_replace('/\[\d+\. (.*?)\]/s', '\1', $fn);
        $notes[$n] = $note;

        if (substr($notes[$n],0,4) == '<no>') :
          $notes[$n] = str_replace('<no>', "", $notes[$n]);
          $text = str_replace($fn, "", $text);
        else :
          $text = str_replace($fn, '<sup class="footnote"><a href="#fn-'.$n.'" id="fnref-'.$n.'">'.$n.'</a></sup>', $text);
        endif;
        $n++;
    }


    if (true) { // TODO: if is single article
        $text .= "<div class='footnotes' id='footnotes'>";
        $text .= "<div class='footnotedivider'></div>";

        $text .= "<ol>";
        for ($i=1; $i<$n; $i++) {
            $text .= "<li id='fn-".$i."'>".$notes[$i]." <span class='footnotereverse'><a href='#fnref-".$i."'>&#8617;</a></span></li>";
        }
        $text .= "</ol>";
        $text .= "</div>";

        if (c::get('footnotes.smoothscroll', false)) :
          $text .= "<script>$(function() { $('a[href*=#]:not([href=#])').click(function() { if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) { var t = $(this.hash); t = t.length ? t : $('[name=' + this.hash.slice(1) +']'); if (t.length) { $('html,body').animate({ scrollTop: t.offset().top - ".c::get('footnotes.offset', 0)." }, 1000); return false; } } }); });</script>";
        endif;
    }

    return $text;
  }

  $value = $text;

  return $value;
}


/**
 * Adding an footnotes field method: e.g. $page->text()->footnotes()->kirbytext()
 */
field::$methods['footnotes'] = function($field) {
  $field->value = convert_footnotes($field->value);
  return $field;
};

/**
 *  Pre-filtering Kirbytext if option "footnotes.global" is set true
 */
if(c::get('footnotes.global', false)) {
  kirbytext::$post[] = function($kirbytext, $value) {
    return convert_footnotes($value);
  };
}

