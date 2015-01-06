<?php

kirbytext::$pre[] = function($kirbytext, $value) {

  $n = 1;
  $notes = array();
  if (preg_match_all('/\[(\d+\. .*?)\]/s', $value, $matches)) {
    foreach ($matches[0] as $fn) {
        $note = preg_replace('/\[\d+\. (.*?)\]/s', '\1', $fn);
        $notes[$n] = $note;

        if (substr($notes[$n],0,4) == '<no>') :
          $notes[$n] = str_replace('<no>', "", $notes[$n]);
          $value = str_replace($fn, "", $value);
        else :
          $value = str_replace($fn, '<sup class="footnote"><a href="#fn-'.$n.'" id="fnref-'.$n.'">'.$n.'</a></sup>', $value);
        endif;
        $n++;
    }


    if (true) { // TODO: if is single article
        $value .= "<div class='footnotes' id='footnotes'>";
        $value .= "<div class='footnotedivider'></div>";

        $value .= "<ol>";
        for ($i=1; $i<$n; $i++) {
            $value .= "<li id='fn-".$i."'>".$notes[$i]." <span class='footnotereverse'><a href='#fnref-".$i."'>&#8617;</a></span></li>";
        }
        $value .= "</ol>";
        $value .= "</div>";
    }
  }

  return $value;

};
