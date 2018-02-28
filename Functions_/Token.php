<?php

       function CreateFormToken ( ) {
              $_ = strftime ( '%Y-%m-%d>%H:%M:%S' , time ( ) ) ;
              $_SESSION [ '_token' ] = sha1 ( $_ ) ;
              $token = $_SESSION [ '_token' ] ;
              return $token ;
       }
       
       function GetToken ( ) {
              return $_SESSION [ '_token' ] ;
       }
       
       function UnregisterToken ( ) {
              unset ( $_SESSION [ '_token' ] ) ;
       }