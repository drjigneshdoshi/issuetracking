<?php //$permissions->setConditions(5,6,7,8,9)->handle(GetBaseURL()); ?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        $('#dataTable').dataTable( {
            "ordering": false,
            "paging":   true,
            "columnDefs": [
                { "orderable": false, "targets": 2 }
            ]
        } );
    } );
</script>
<div id="contentRes"></div>
<div class="panel-body1" >
    <table class="table" id="dataTable" width="100%">
        <thead>
        <tr align="center">
            <td>ID</td>
            <td>Title</td>
            <td>Last Answer By</td>
            <td>Status</td>
            <?=IsAdministrator() ? "<td>Name</td>" : "" ?>
            <td>Created Date</td>
            <td>Action(s)</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $cases = FetchAssignedCase() ;
        if ( count ( $cases ) >= 1 ) {

            foreach ( $cases as $case ) {
                echo '<tr align="center">' ;
                echo '<td id="id">', $case [ 'cid' ] ,'</td>' ;
                echo '<td><a href="', BaseURLConcat ( 'viewCase?caseID=' . ToCaseID ( $case [ 'cid' ] ) ) ,'">', wrap ( $case [ 'title' ] , 31 , ' ...' ) ,'</a></td>' ;
                echo '<td>', GetCaseLastAnswer ( $case [ 'cid' ] ) ,'</td>' ;
//                echo '<td>', GetCaseLastAnswerBy ( $case [ 'cid' ] ) ,'</td>' ;
                echo '<td>', CaseStatus ( GetCaseByID($case [ 'cid' ])["status"] ) ,'</td>' ;
                echo '<td>', strftime ( '%Y-%m-%d' , strtotime ( $case [ 'added' ] ) ) ,'</td>' ;
                echo '<td>
                        <a class="btn btn-info" href="', BaseURLConcat ( 'AnswerCase?caseID=' . ToCaseID ( $case [ 'cid' ] ) ) ,'">Answer</a>&nbsp;
                    </td>' ;
                echo '</tr>' ;
            }
        }
        ?>
        </tbody>
    </table>
</div>