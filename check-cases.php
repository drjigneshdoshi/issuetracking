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

<div class="panel-body1" >
    <table class="table" id="dataTable" width="100%">
        <thead>
        <tr align="center">
            <td>ID</td>
            <td>Title</td>
            <td>Last Answer By</td>
            <td>Created Date</td>
            <td>Status</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $cases = GetLoggedAccountCases ( ) ;
        if ( count ( $cases ) >= 1 ) {
            foreach ( array_reverse($cases) as $case ) {
                echo '<tr align="center">' ;
                echo '<td>', $case [ 'cid' ] ,'</td>' ;
                echo '<td><a href="', BaseURLConcat ( 'viewCase?caseID=' . ToCaseID ( $case [ 'cid' ] ) ) ,'">', wrap ( $case [ 'title' ] , 31 , ' ...' ) ,'</a></td>' ;
                echo '<td>', GetCaseLastAnswer ( $case [ 'cid' ] ) ,'</td>' ;
                echo '<td>', strftime ( '%Y-%m-%d' , strtotime ( $case [ 'added' ] ) ) ,'</td>' ;
                echo '<td>', CaseStatus ( $case [ 'status' ] ) ,'</td>' ;
                echo '</tr>' ;
            }
        } else {
            echo '<tr align="center">' ;
            echo '<td colspan="5">You have not created any case.</td>' ;
            echo '</tr>' ;
        }
        ?>
        </tbody>
    </table>
</div>