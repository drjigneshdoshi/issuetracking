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

</script>

<link rel="stylesheet" type="text/css" href="Asset/css/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="Asset/js/JQuery.Datatables.js"></script>
<script type="text/javascript" language="javascript" src="Asset/js/dataTables.bootstrap.js"></script>
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
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $db = GetDatabaseConnection ( 'db_case' ) ;
        $query = $db->prepare('SELECT * FROM t_user') ;
        if($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $prg):

                /** @noinspection CheckImageSize */
                echo '<tr id="', $prg['id'], '">
                 <th scope="row">', $prg['id'], '</th>
                 <td>', $prg['name'], '</td>
                 <td>', $prg['phone'], '</td>
                 <td>', $prg['email'], '</td>
                 <td>', GetRole($prg['pv']), '</td>
                 <td width="15%">
                    <a class="delete" ><img src="Asset/images/delete.png"></a>&nbsp;
                    <!--<a class="update"><img src="Asset/images/edit.png"></a>&nbsp;
                    <a class="info"><img src="Asset/images/xmag.png" width="24" height="24"></a>&nbsp;-->
                 </td>
                </tr>';
            endforeach;
        }
        ?>
        </tbody>
    </table>
</div>
<div id="contents"></div>
<script>
    $(document).ready(function()
    {
        $('#Update').click(function()
        {
            alert("works");
        });
    });
</script>