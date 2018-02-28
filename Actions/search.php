<?php
/**
 * Created by PhpStorm.
 * User: Mihir
 * Date: 9/24/2016
 * Time: 11:56 AM
 */

include_once "../Functions/Import.php";
if(isset($_POST["search"]) && $_POST["search"] == "User") :

    $search = $_POST["search"];
    $option = $_POST["option"];
    $detail = $_POST["detail"];
    ?>
    <script type="text/javascript">

        $(document).ready(function()
        {
            $('table#dataTable td a.delete').click(function()
            {
                if (confirm("Are you sure you want to delete this record?"))
                {
                    var id = $(this).parent().parent().attr('id');
                    var data = 'id=' + id ;
                    var parent = $(this).parent().parent();
                    console.log(data);
                    $.ajax(
                        {
                            type: "POST",
                            url: "Actions/delete_row.php",
                            data: data,
                            cache: false,
                            success: function()
                            {
                                parent.fadeOut('slow', function() {$(this).remove();});
                            }
                        });
                }
            });
            $('table#dataTable tr:odd').css('background',' #FFFFFF');
        });
        $(document).ready(function()
        {
            $('table#dataTable td a.update').click(function()
            {
                var id = $(this).parent().parent().attr('id');
                var data = 'id=' + id ;

                $.ajax(
                    {
                        type: "POST",
                        url: "Action/data.php",
                        data: data,
                        cache: false,
                        success: function()
                        {
                            $("#contents").load('data.php').hide().fadeIn('slow');
                        }
                    });

            });
        });
        $(document).ready(function()
        {
            $('table#dataTable td a.info').click(function()
            {
                var id = $(this).parent().parent().attr('id');
                var data = 'id=' + id ;

                $.ajax(
                    {
                        type: "POST",
                        url: "Action/info.php",
                        data: data,
                        cache: false,
                        success: function()
                        {
                            $("#contents").load('Action/info.php').hide().fadeIn('slow');
                        }
                    });

            });
        });


    </script>

    <link rel="stylesheet" type="text/css" href="../Asset/css/dataTables.bootstrap.css">
    <script type="text/javascript" language="javascript" src="../Asset/js/JQuery.Datatables.js"></script>
    <script type="text/javascript" language="javascript" src="../Asset/js/dataTables.bootstrap.js"></script>
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
    <?php

    $db = GetDatabaseConnection ( 'library' ) ;

    if($option == "Email") {
        $query = "SELECT * FROM user WHERE email='".$detail."'" ;
    } else $query = "SELECT * FROM user WHERE name='".$detail."'" ;
    $qry = $db->prepare($query);
    $qry->execute();
    $cnt = $qry->rowCount();
if($cnt>0) {
    ?>
    <div class="panel-body1" >
        <table class="table" id="dataTable" width="100%">
            <thead>
            <tr align="center">
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $prg):

                /** @noinspection CheckImageSize */
                echo '<tr id="',$id= $prg['id'], '">
                 <th scope="row">', $prg['id'], '</th>
                 <td>', $prg['name'], '</td>
                 <td>', $prg['phone'], '</td>
                 <td>', $prg['email'], '</td>
                 <td>', GetRole($prg['pv']), '</td>
                </tr>';
            endforeach;
            } else {
                echo '<div class="panel-body1"> <div class="alert alert-danger">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            	<strong>Error</strong> Data Not Found
            </div></div>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
    $db = GetDatabaseConnection("library");
    $qry = $db->prepare("SELECT * FROM issue WHERE uid=?");
    $qry->execute($id);
    $cnt=$qry->rowCount();

    ?>


    <?if($cnt>0) {?>
    <div class="panel-body1" >
        <table class="table" id="dataTable" width="100%">
            <thead>
            <tr align="center">
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $prg):

                /** @noinspection CheckImageSize */
                echo '<tr id="', $prg['id'], '">
                 <th scope="row">', $prg['id'], '</th>
                 <td>', $prg['name'], '</td>
                 <td>', $prg['phone'], '</td>
                 <td>', $prg['email'], '</td>
                 <td>', GetRole($prg['pv']), '</td>
                </tr>';
            endforeach;
            } else {
                echo '<div class="panel-body1"> <div class="alert alert-danger">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            	<strong>Error</strong> Data Not Found
            </div></div>';
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="contents"></div>
<?endif?>
