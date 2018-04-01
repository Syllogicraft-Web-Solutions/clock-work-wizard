<?php

function is_starts_with_vowel($string) {

     $vowels = array('a', 'e', 'i', 'o', 'u');
     
     foreach ($vowels as $key => $vowel) {
          if ($vowel == strtolower($string[0]))
               return true;
     }
     return false;
}

/* function change_char_to_this($from, $to) {
     return str_replace($from, $to);
} */