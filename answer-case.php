<?php
// $permissions->setConditions(5,6,7,8,9)->handle(GetBaseURL());
$id = isset ( $_GET [ "caseID" ] ) ? $_GET [ "caseID" ] : null ;
$case = GetCaseByID ( $id ) ;
?>
<form method="POST">
    <table border="0" width="100%" cellpadding="4" cellspacing="1">
        <tr>
            <td colspan="2" align="center"><div class="well">Responding to the case ( <b><?php echo $case [ 'title' ] ?></b> ) !</div></td>
        </tr>
        <tr>
            <td align="right" width="15%"><div class="well">Case Description</div></td>
            <td style="padding: 5px 5px 5px 15px;"><div class="well"><?php echo nl2br ( parseBBCode ( $case [ 'content' ] ) ) ?></div></td>
        </tr>
        <?php $last_answer = nl2br ( parseBBCode ( GetLatestAnswerText ( CaseID ( $id ) ) ) ) ; ?>
        <?php if ( ! empty ( $last_answer ) ) : ?>
            <tr>
                <td align="right" width="20%"><div class="well">Latest Answer</div></td>
                <td style="padding: 5px 5px 5px 15px;"><div class="well"><?php echo $last_answer ?></div></td>
            </tr>
        <?php endif ; ?>
        <tr>
            <td align="right"><div class="well">Latest Answer By</div></td>
            <td style="padding: 5px 5px 5px 15px;"><div class="well"><?php echo GetCaseLastAnswer ( $case [ 'cid' ] ) ; ?></div></td>
        </tr>
        <tr>
            <td align="right" width="20%"><div class="well">Status</div></td>
            <td style="padding: 5px 5px 5px 15px;"><div class="well"><?php echo CaseStatus(GetCaseByID($case['cid'])['status']) ?></div></td>
        </tr>
        <?if(!(GetCaseByID($case['cid'])['status'] == "Closed" || GetCaseByID($case['cid'])['status'] == "Resolved" || GetCaseByID($case['cid'])['status'] == "Discarded")): ?>

            <tr>
                <td align="right"><div class="well">Answer</div></td>
                <td style="padding: 5px 5px 5px 15px;"><div class="well"><textarea name="description" id="description" cols="67" rows="4"></textarea></div></td>
            </tr>
            <tr>
                <td align="right"><div class="well">After Answer</div></td>
                <td style="padding: 5px 5px 5px 15px;"><div class="well">
                        <select name="after" class="select" id="after" class="selectpicker">
                            <option value="">Leave Default State</option>
                            <option value="Resolved">Resolved</option>
                            <?=IsAdministrator() ? '<option value="Closed">Set Closed</option>' : null ?>
                            <?=IsUser() ? '<option value="Discarded">Discard</option>' : null ?>
                        </select>
                    </div>
                </td>
            </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Answer" class="btn btn-info col-lg-offset-4" name="answer" /></td>
        </tr>
        <?endif;?>
    </table>

    <?php

    if ( isset ( $_POST [ "answer" ] ) ) {
        $answer = $_POST [ "description" ] ;
        $state = strlen ( $_POST [ "after" ] ) > 0 ? $_POST [ "after" ] : 'Answered' ;
        if ( SaveAnswerAndSetState ( $id , $answer , $state ) ) {
            $message = null ;
            $message .= '<span class="inline-info"> ';
            $message .= 'Case answered successfully.' ;
            $message .= '</span>' ;
            $_SESSION [ '$.response.message' ] = $message ;
            header ( 'Location: ' . BaseURLConcat ( 'answerCase?caseID=' . $id ) ) ;
        }
    }
    ?>
</form>