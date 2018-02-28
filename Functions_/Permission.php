<?php

class Permission {

    private $id ;

    /**
     * PDO Object
     * @var PDO
     */
    private $dbObject = null ;

    /**
     * PDO Statement
     * @var PDOStatement
     */
    private $query = null ;

    /**
     * Permissions
     * @var Array
     */
    private $pvs = array ( ) ;

    public function __construct ( $userID , PDO $dbObject ) {
        $this->id = intval ( $userID ) ;
        $this->dbObject = $dbObject ;
    }

    public function setConditions ( /* ... */ ) {
        foreach ( func_get_args ( ) as $pv )
            $this->pvs [ ] = ( int ) $pv ;
        return $this ;
    }

    public function hasConditions ( ) {
        return count ( $this->pvs ) >= 0 ? true : false ;
    }

    public function accountIDExists ( ) {
        $this->query = $this->dbObject->prepare ( 'SELECT COUNT(*) FROM `t_user` WHERE `id` = :id' ) ;
        $this->query->bindParam ( ':id' , $this->id , PDO::PARAM_INT ) ;
        $this->query->execute () ;
        return $this->query->fetchColumn ( ) >= 1 ? true : false ;
    }

    public function getUserPV ( ) {
        if ( $this->accountIDExists ( ) && $this->hasConditions ( ) ) {
            $this->query = $this->dbObject->prepare ( 'SELECT pv FROM `t_user` WHERE `id` = :id' ) ;
            $this->query->bindParam ( ':id' , $this->id , PDO::PARAM_INT ) ;
            $this->query->execute () ;
            return $this->query->fetchColumn ( ) ;
        } else return 0 ;
    }

    public function isValid () {
        $pv = $this->getUserPV ( ) ;
        foreach ( $this->pvs as $_pv ) {
            if ( ( int ) $pv ===  ( int ) $_pv )
                return true ;
        }
        return false ;
    }

    public function handle ( $redirect , $storeMessage = null ) {
        if ( ! $this->isValid ( ) ) {
            if ( ! is_null ( $storeMessage ) ) {
                if ( ! isset ( $_SESSION ) )
                    session_start ( ) ;
                $_SESSION [ '$.page.message' ] = $storeMessage ;
            }
            header ( sprintf ( 'Location: %s' , $redirect ) , true ) ;
            exit ;
        }
    }
}
