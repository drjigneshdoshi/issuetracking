<div class="panel-body1">
    <?php
    $id = isset ( $_GET [ "caseID" ] ) ? $_GET [ "caseID" ] : null ;
    if ( ! IsCaseOwner ( $id , GetLoggedAccountID ( ) ) ) :
        echo '<span class="inline-help">This case does not exist or was deleted.</span>' ;
    else : ?>
        <?php
        $case = GetCaseByID ( $id ) ;
        $answers = GetCaseAnswers ( $id ) ;
        echo '<table id="dataTable" cellspacing="100px" cellpadding="100px" width="100%">' ;
        echo '<thead>' ;
        echo '<tr>' ;
        echo '<td align="right" width="20%"><div class="well">Case ID : </div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well">', $id ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"width="20%"><div class="well">Title : </div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well">', $case [ 'title' ] ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"width="20%"><div class="well">Lab : </div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well">', $case [ 'lab' ] ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"width="20%"><div class="well">PC : </div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well">', $case [ 'pc' ] ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"><div class="well">Created Date :</div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well">', strftime ( '%Y/%m' , strtotime ( $case [ 'added' ] ) ) ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right" ><div class="well">Reason :</div></td>' ;
        echo '<td style="padding: 0 0 0 5px"><div class="well"><b>', $case [ 'reason' ] ,'</b></div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"><div class="well">Priority :</div> </td>' ;
        echo '<td  style="padding: 0 0 0 5px"><div class="well"><b>', $case [ 'priority' ] ,'</b></div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"><div class="well">Content :</div></td>' ;
        echo '<td  style="padding: 0 0 0 5px"><div class="well">', parseBBCode ( $case [ 'content' ] ) ,'</div></td>' ;
        echo '</tr>' ;
        echo '<tr>' ;
        echo '<td align="right"><div class="well">Status :</td>' ;
        echo '<td  style="padding: 0 0 0 5px"><div class="well">', CaseStatus ( $case [ 'status' ] ) ,'</div></td>' ;
        echo '</tr>' ;
        echo '</thead>' ;
        $attachments = GetCaseAttachments ( $id ) ;
        if ( count ( $attachments ) >= 1 ) {
            echo '<tr>' ;
            echo '<td align="right"><div class="well">Attachments :</div></td>' ;
            echo '<td  style="padding: 0 0 0 5px"><div class="well">' ;
            foreach ( $attachments as $attachment ) {
                $t = CaseAttachmentThumb ( $attachment [ "attachment" ] ) ;
                if ( file_exists ( $t ) ) {
                    echo '<a class="hint--right" data-hint="<img src='.BaseURLConcat ( $attachment [ "attachment" ]).' />"><img src=', BaseURLConcat ( $t ) ,' id="', BaseURLConcat ( $attachment [ "attachment" ]    ) ,'" class="case-attachment-img" /></a> ' ;
                }
            }
            echo '</div></td>' ;
            echo '</tr>' ;
        }
        echo '</table>' ;
        echo '<hr class="sep">' ;
        $_answersHTML = array ( ) ;
        $i = 1 ;
        foreach ( $answers as $answer ) {
            $answerDate = strftime ( '%A, %b of %Y at %H:%M' , strtotime ( $answer [ 'date' ] ) ) ;
            $content = null ;
            $content .= '<div class="well">' ;
            $content .= '<table border="0">' ;
            $content .= '<tr>' ;
            $content .= '<td>#<b>'. $i .'</b> | Answer By :: '. AnswerHighlight ( $answer [ 'answerHighlight' ] ) .', '. $answerDate .'</td>' ;
            $content .= '</tr>' ;
            $content .= '<tr>' ;
            $content .= '<td>'. nl2br ( parseBBCode ( $answer [ 'answer' ] ) ) .'</td>' ;
            $content .= '</tr>' ;
            $content .= '</table>' ;
            $content .= '</div>' ;
            $_answersHTML [ $answer [ 'answerID' ] ] = $content ;
            ++ $i ;
        }
        if ( isset ( $_SESSION [ '$.response.message' ] ) ) {
            echo $_SESSION [ '$.response.message' ] ;

            unset ( $_SESSION [ '$.response.message' ] ) ;
        }
        if ( count ( $_answersHTML ) || !IsUser()) {
            echo implode ( '<hr class="sep">' , $_answersHTML ) ;
            if ((!IsSelfLatestAnswer ( CaseID ( $id ) ) && $case [ 'status' ] !== "Closed") && (caseAssignedTo($case['cid']) == GetLoggedAcctName() || IsUser() || IsAdministrator())) {
                echo '<form method="POST" style="margin-top: 20px">' ;
                echo '<table border="0">' ;
                echo '<tr>' ;
                echo '<td>Respond to this case ...</td>' ;
                echo '</tr>' ;
                echo '<tr>' ;
                echo '<td><textarea name="description" id="description" cols="50" rows="3"></textarea></td>' ;
                echo '</tr>' ;
                echo '<tr>' ;
                echo '<td><input type="submit" value="Answer" name="answer" /></td>' ;
                echo '</tr>' ;
                echo '</table>' ;
                echo '</form>' ;
                if ( isset ( $_POST [ "answer" ] ) ) {
                    if ( ! IsEmpty ( $_POST [ "description" ] ) ) {
                        if ( IsUser ( ) ) {
                            $state = 'Pending' ;
                        } else $state = 'Answered' ;

                        if ( SaveAnswerAndSetState ( $id , $_POST [ "description" ] , $state ) ) {
                            $_SESSION [ '$.response.message' ] = '<div class="alert alert-success">
	                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                    <strong>Success</strong> Answer Sent Successfully
                                                                    </div>' ;
                            header ( 'Location: ' . BaseURLConcat ( 'viewCase?caseID=' . $id ) ) ;
                        }
                    } else {
                        echo '<br /><div class="alert alert-danger">
	                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	                            <strong>Empty Answer!</strong> Can\'t send empty answer
                            </div>' ;
                    }
                }
            }
        } else {
            echo '<font size="2" color="#333">No response so far :(</font>' ;
        }
        ?>
    <?php endif; ?>


</div>