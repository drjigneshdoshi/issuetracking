<?php

       function CreateThumbnail ( $t_x , $t_y , $qualidade , $c_original , $c_final ) {
              $thumbnail = imagecreatetruecolor ( $t_x , $t_y ) ;
              $original = $c_original ;
              $igInfo = getImageSize ( $c_original ) ;
              switch ( $igInfo[ 'mime' ] ) {
                     case 'image/gif':
                            if ( imagetypes ( ) & IMG_GIF ) {
                                   $originalimage = imageCreateFromGIF ( $original ) ;
                            } 
                            break ;
                     case 'image/jpeg':
                            if ( imagetypes () & IMG_JPG ) {
                                   $originalimage = imageCreateFromJPEG ( $original ) ;
                            } 
                            break ;
                     case 'image/png':
                            if ( imagetypes () & IMG_PNG ) {
                                   $originalimage = imageCreateFromPNG ( $original ) ;
                            } 
                            break ;
                     case 'image/wbmp':
                            if ( imagetypes () & IMG_WBMP ) {
                                   $originalimage = imageCreateFromWBMP ( $original ) ;
                            } 
                            break ;
                     default:
                            $ermsg = $igInfo[ 'mime' ] . ' formato não suportado <br />' ;
                            break ;
              } ;
              $nLargura = $igInfo[ 0 ] ;
              $nAltura = $igInfo[ 1 ] ;

              if ( ($nLargura > $t_x ) and ($nAltura > $t_y) ) {
                     if ( $t_x <= $t_y ) {
                            $nLargura = ( int ) (($igInfo[ 0 ] * $t_y) / $igInfo[ 1 ]) ;
                            $nAltura = $t_y ;
                     } else {
                            $nLargura = $t_x ;
                            $nAltura = ( int ) (($igInfo[ 1 ] * $t_x) / $igInfo[ 0 ]) ;
                            if ( $nAltura < $t_y ) {
                                   $nLargura = ( int ) (($igInfo[ 0 ] * $t_y) / $igInfo[ 1 ]) ;
                                   $nAltura = $t_y ;
                            } ;
                     } ;
              } ;

              $x_pos = ($t_x / 2) - ( $nLargura / 2) ;
              $y_pos = ($t_y / 2) - ($nAltura / 2) ;
              imagecopyresampled ( $thumbnail , $originalimage , $x_pos , $y_pos , 0 , 0 , $nLargura , $nAltura , $igInfo[ 0 ] , $igInfo[ 1 ] ) ;
              imagejpeg ( $thumbnail , $c_final , $qualidade ) ;
              imagedestroy ( $thumbnail ) ;
              return true ;
       }
