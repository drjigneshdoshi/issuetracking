<?php

       require_once '../Functions/Database.php' ;
       require_once '../Functions/Accounts-Characters.php' ;
       require_once '../Functions/Others.php' ;
       require_once '../Functions/BaseURL.php' ;
       require_once '../Functions/Cases.php' ;
       
       $file = str_replace ( GetBaseURL ( ) , null , $_POST [ "src" ] ) ;
       if ( file_exists ( ".." . $file ) ) {
              if ( CaseDeleteAttachment ( $_POST [ "id" ] ) ) {
                     unlink ( ".." . $file ) ;
                     echo "true" ;
              } else echo "false" ;
       } else echo "false" ;