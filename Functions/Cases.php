<?php

function GetLoggedAccountCountCases ( ) {
    $accountid = GetLoggedAccountID ( ) ;
    if ( $accountid > 0 ) {
        $db = Connection ( 'db_case' ) ;
        $sql = $db->query ( 'SELECT COUNT(*) FROM `t_cases` WHERE `creatorAccountID` = ? AND `status` = "Answered"' ) ;
        $sql->execute(array($accountid));
        $count = $sql->fetch ( PDO::FETCH_NUM ) ;
        return intval ( $count [ 0 ] ) ;
    }
}

function GetLoggedAccountCases ( ) {
    $accountid = GetLoggedAccountID ( ) ;
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT DISTINCT t_cases.* FROM `t_cases` LEFT JOIN t_case_answers ca ON t_cases.cid = ca.cid WHERE `creatorAccountID` = ? ORDER BY ca.date DESC' ) ;
    $sql->execute ( array($accountid) ) ;
    $data = $sql->fetchAll ( PDO::FETCH_ASSOC ) ;
    return $data;
}

function AnswerHighlight ( $h , $type = 'User' ) {
    if ( $h === 'Administrator' or $h === 'Admin' ) {
        return '<font color="red">Administrator</font>' ;
    } elseif ( $h === 'LabAssistant' ) {
        return '<font color="green">LabAssistant</font>' ;
    } elseif ( $h === 'User' ) {
        if ( $type === 'Creator' ) {
            return '<font color="#ff7200">Creator ...</font>' ;
        } elseif ( IsAdministrator ( ) || isLabAssistant ( ) ) {
            return '<font color="#ff7200">Creator ...</font>' ;
        } else {
            return '<font color="#ff7200">You ...</font>' ;
        }
    } elseif ( empty ( $h ) ) {
        return '<font color="#535353">None</font>' ;
    }
}

function CaseStatus ( $s ) {
    if ( $s === 'Opened' ) {
        return '<span class="st" style="color: #054b00;font-weight: bold">Opened</span>' ;
    } elseif ( $s === 'Closed' ) {
        return '<span class="st" style="color: darkred;font-weight: bold"">Closed</span>';
    } elseif ( $s === 'Pending' ) {
        return '<span class="st" style="color: #f7941d;font-weight: bold"">Pending</span>' ;
    } elseif ( $s === 'wip' ) {
        return '<span class="st" style="color: #9358ac;font-weight: bold"">Work In Progress</span>';
    } elseif ( $s === 'Answered' ) {
        return '<span class="st" style="color: #5600f7;font-weight: bold"">Answered</span>';
    } elseif ( $s === 'Discarded' ) {
        return '<span class="st" style="color: red;font-weight: bold"">Discarded</span>';
    } elseif ( $s === 'Resolved' ) {
        return '<span class="st" style="color: #01cd00;font-weight: bold"">Resolved</span>';
    } elseif ( $s === 'Assigned' ) {
        return '<span class="st" style="color: #9c6936;font-weight: bold"">Assigned</span>';
    }
}

function GetCaseLastAnswer ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT ca.answerHighlight, ca.date FROM t_cases c LEFT JOIN t_case_answers ca ON c.cid = ca.cid 
              WHERE c.cid = :cid ORDER BY ca.date DESC LIMIT 1' ) ;
    $sql->bindParam ( ':cid' , $caseID , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    $data = $sql->fetch( PDO::FETCH_ASSOC ) ;
    return AnswerHighlight ( $data [ 'answerHighlight' ] , ( ! IsUser ( ) ? 'Creator' : null ) ) ;
}

function GetCaseLastAnswerBy ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT ca.answerBy, ca.date FROM t_cases c LEFT JOIN t_case_answers ca ON c.cid = ca.cid 
              WHERE c.cid = :cid ORDER BY ca.date DESC LIMIT 1' ) ;
    $sql->bindParam ( ':cid' , $caseID , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    $data = $sql->fetch( PDO::FETCH_ASSOC ) ;
    return $data [ 'answerBy' ];
}

function GetLatestAnswerText ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT ca.answerHighlight, ca.date, ca.answer FROM t_cases c LEFT JOIN t_case_answers ca ON c.cid = ca.cid 
              WHERE c.cid = :cid ORDER BY ca.date DESC LIMIT 1' ) ;
    $sql->bindParam ( ':cid' , $caseID , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    $data = $sql->fetch( PDO::FETCH_ASSOC ) ;
    return $data [ 'answer' ] ;
}

function IsSelfLatestAnswer ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT ca.answerHighlight FROM t_cases c LEFT JOIN t_case_answers ca ON c.cid = ca.cid 
              WHERE c.cid = :cid ORDER BY ca.date DESC LIMIT 1' ) ;
    $sql->bindParam ( ':cid' , $caseID , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    $data = $sql->fetch( PDO::FETCH_ASSOC ) ;
    if ( IsAdministrator ( ) ) {
        $h = 'Admin' ;
    } elseif ( isLabAssistant ( ) ) {
        $h = 'LabAssistant' ;
    } elseif ( IsUser ( ) ) {
        $h = 'User' ;
    }
    return $data [ 'answerHighlight' ] === $h ? true : false ;
}

function GetLatestCases ( ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT DISTINCT t_cases.* FROM `t_cases` LEFT JOIN t_case_answers ca ON t_cases.cid = ca.cid ORDER BY ca.date DESC' ) ;
    $sql->execute ( ) ;
    return $sql->fetchAll ( PDO::FETCH_ASSOC ) ;
}

function ToCaseID ( $id ) {
    return preg_replace ( '![^\d]!' , null , md5 ( $id ) ) . '-' . $id ;
}

function CaseID ( $id ) {
    $id = explode ( '-' , $id );
    return array_pop ( $id ) ;
}

function GetCaseByID ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $cid = CaseID ( $caseID );
    $sql = $db->prepare ( 'SELECT * FROM `t_cases` WHERE cid = :cid' ) ;
    $sql->bindParam ( ':cid' , $cid , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    return $sql->fetch( PDO::FETCH_ASSOC ) ;
}

function GetCaseAttachments ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $_id = CaseID ( $caseID ) ;
    $sql = $db->prepare ( 'SELECT * FROM `t_case_attachments` WHERE cid = :cid' ) ;
    $sql->bindParam ( ':cid' , $_id , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    return $sql->fetchAll ( PDO::FETCH_ASSOC ) ;
}

function GetCaseAnswers ( $caseID ) {
    $db = Connection ( 'db_case' ) ;
    $_id = CaseID ( $caseID ) ;
    $sql = $db->prepare ( 'SELECT * FROM `t_case_answers` WHERE cid = :cid' ) ;
    $sql->bindParam ( ':cid' , $_id , PDO::PARAM_INT ) ;
    $sql->execute ( ) ;
    return $sql->fetchAll ( PDO::FETCH_ASSOC ) ;
}

function CaseAttachmentThumb ( $t ) {
    $fname = pathinfo ( $t , PATHINFO_FILENAME ) . '.' . pathinfo ( $t , PATHINFO_EXTENSION ) ;
    return sprintf ( 'Attachments/thumb/%s' , $fname ) ;
}

function IsCaseOwner ( $id , $accountid ) {
    $case = GetCaseByID ( $id ) ;
    if ( IsUser ( ) ) {
        return ( int ) $case [ 'creatorAccountID' ] === intval ( $accountid ) ;
    } else {
        // all is owner, if not are user.
        return true ;
    }
}

function CaseDeleteAttachment ( $aid ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'DELETE FROM `t_case_attachments` WHERE aid = :aid' ) ;
    $sql->bindParam ( ':aid' , $aid , PDO::PARAM_INT ) ;
    return $sql->execute ( ) ;
}

function SaveAnswerAndSetState ( $id ,  $answer , $state ) {
    $db = Connection ( 'db_case' ) ;
    $_id = CaseID ( $id ) ;
    $high = 'User' ;
    if ( IsAdministrator ( ) ) {
        $high = 'Admin' ;
    } elseif ( isLabAssistant ( ) ) {
        $high = 'LabAssistant' ;
    }

    $q = $db->prepare ( 'INSERT INTO `t_case_answers`( `cid`, `answer`, `answerHighlight`, `answerBy` ) VALUES ( ?, ?, ?, ? )' ) ;
    $q->bindValue ( 1 , $_id , PDO::PARAM_INT ) ;
    $q->bindValue ( 2 , $answer , PDO::PARAM_STR ) ;
    $q->bindValue ( 3 , $high , PDO::PARAM_STR ) ;
    $q->bindValue ( 4 , $_SESSION["name"] , PDO::PARAM_STR ) ;
    if ( $q->execute ( ) ) {
        SetState ( $id , $state ) ;
        return true ;
    }
}

function SetState ( $caseid , $state ) {
    $db = Connection ( 'db_case' ) ;
    $q = $db->prepare ( 'UPDATE t_cases SET status = ? WHERE cid = ?' ) ;
    $q->execute ( array ( $state , CaseID ( $caseid ) ) ) ;
}

function getLabs() {

    $db = Connection( 'db_case' );

    $query = $db->prepare( 'SELECT *FROM t_labs' );
    $query->execute();
    return $query->fetchAll( PDO::FETCH_ASSOC );
}

function createLog($name, $desc) {

    $db = Connection('db_case');

    $query = $db->prepare("INSERT INTO t_log (uid, des, createdAt) VALUES (?,?,CURRENT_TIMESTAMP)");
    $query->execute(array($name,$desc));
}

function GetAssignedCaseByCaseId($cid,$uid) {

    $db = Connection('db_case');

    $query = $db->prepare("SELECT *FROM t_assign WHERE uid=? AND cid=?");
    $query->execute(array($uid,$cid));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return @$data[0];
}

function caseAssignedTo($id) {

    $db = Connection('db_case');

    $query = $db->prepare("SELECT *FROM t_assign WHERE cid = ? ORDER BY time LIMIT 1");
    $query->execute(array($id));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return FetchAccountNameById(@$data[0]['uid']);
}


function GetLatestCasesById ( $id ) {
    $db = Connection ( 'db_case' ) ;
    $sql = $db->prepare ( 'SELECT t_cases.* FROM `t_cases` LEFT JOIN t_case_answers ca ON t_cases.cid = ca.cid GROUP BY ca.cid ORDER BY ca.date DESC ' ) ;
    $sql->execute ( ) ;
    return $sql->fetchAll ( PDO::FETCH_ASSOC ) ;
}

function FetchAssignedCase () {

    $db = Connection('db_case');

    $query = $db->prepare("SELECT *FROM t_assign WHERE uid=?");
    $query->execute(array(GetLoggedAccountID()));
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $cases = [];
    foreach ($data as $case) {

        $cases[] = GetCaseByID($case["cid"]);

    }
    return $cases;
}