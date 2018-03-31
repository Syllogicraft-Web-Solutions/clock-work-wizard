<?php

function is_starts_with_vowel($string) {

     $vowels = array('a', 'e', 'i', 'o', 'u');
     
     foreach ($vowels as $key => $vowel) {
          if ($vowel == strtolower($string[0]))
               return true;
     }
     return false;
}