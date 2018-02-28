<?php
$permissions->setConditions(1,2,3)->handle(GetBaseURL()); ?>
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
            <td>Name</td>
            <td>Created Date</td>
            <td>Status</td>
            <td>Assign Case</td>
            <td>Case assigned To</td>
            <td width="10%">Action(s)</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $cases = GetLatestCases ( ) ;
        if ( count ( $cases ) >= 1 ) {

            $staffs = getStaff();
            $staffopt = "";
            if(IsAdministrator()):
                foreach ($staffs as $staff) {

                    $staffopt .= "<option>".$staff['name']."</option>";
                } else : $staffopt .= "<option>".GetLoggedAcctName()."</option>";
            endif;

            foreach ( array_reverse($cases) as $case ) {

                /*if(!IsAdministrator() && $case['status'] != "Open" && caseAssignedTo($case['cid']) != GetLoggedAcctName()) */
				if(false)
				{
                    $assign = '<a class="btn btn-info" disabled="">Answer</a>&nbsp;
                                <a class="btn btn-danger assign" id="assign" disabled="">Assign</a>';
                } else {
                    $assign = '<a class="btn btn-info" href="'. BaseURLConcat ( 'AnswerCase?caseID=' . ToCaseID ( $case [ 'cid' ] ) ) .'">Answer</a>&nbsp;
                                <a class="btn btn-danger assign" id="assign" >Assign</a>';
                }
                echo '<tr align="center">' ;
                echo '<td id="id">', $case [ 'cid' ] ,'</td>' ;
                echo '<td><a href="', BaseURLConcat ( 'viewCase?caseID=' . ToCaseID ( $case [ 'cid' ] ) ) ,'">', wrap ( $case [ 'title' ] , 31 , ' ...' ) ,'</a></td>' ;
                echo '<td>', GetCaseLastAnswer ( $case [ 'cid' ] ) ,'</td>' ;
                echo '<td>', GetCaseLastAnswerBy ( $case [ 'cid' ] ) ,'</td>' ;
                echo '<td>', strftime ( '%d-%m-%Y' , strtotime ( $case [ 'added' ] ) ) ,'</td>' ;
                echo '<td>', CaseStatus ( GetCaseByID($case [ 'cid' ])["status"] ) ,'</td>' ;
                echo '<td id="name"><select>'.$staffopt.'</select> </td>' ;
                echo '<td>',caseAssignedTo($case['cid']),'</td>' ;
                echo '<td>
                        '.$assign.'
                    </td>' ;
                echo '</tr>' ;
            }
        } else {

        }
        ?>
        </tbody>
        <script>
            $(document).ready( function() {
                $(".selectize").selectize({
                    create : false
                });

                $(".assign").click(function (e) {


                    var name = $(this).parent().parent().children('td#name').children().val();
                    var id = $(this).parent().parent().children('td#id').html();
                    var data = "name="+name+"&id="+id+"&assign=true";


                    $.ajax({

                        type : "POST",
                        url : "Actions/assignTask.php",
                        data : data,
                        success : function (response) {

                            console.log(response);
                            if(response == "1") {
                                $("#contentRes").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Success!</strong> Task Assigned Successfully </div>').fadeIn("slow").delay(3000).fadeOut("slow");
                            } else if (response == "assigned") {

                                $("#contentRes").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Warning!</strong> This Case is already assigned to this member</div>').fadeIn("slow").delay(3000).fadeOut("slow");
                            } else if (response == "notOpen") {

                                $("#contentRes").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Warning!</strong> This Case is not open</div>').fadeIn("slow").delay(3000).fadeOut("slow");
                            }
                        }

                    })
                })

            });
        </script>
    </table>
</div>