<?php

       function parseBBCode ( $text ) {
              $search = array (
                  '/\[b\](.*?)\[\/b\]/is' ,
                  '/\[i\](.*?)\[\/i\]/is' ,
                  '/\[center\](.*?)\[\/center\]/is' ,
                  '/\[url="(.*?)"\](.*?)\[\/url\]/is' 
               ) ;
              $replace = array (
                  '<strong>$1</strong>' ,
                  '<i>$1</i>' ,
                  '<div style="text-align: center">$1</div>' ,
                  '<a href="$1">$2</a>' 
               ) ;
              return preg_replace ( $search , $replace , $text ) ;
       }

