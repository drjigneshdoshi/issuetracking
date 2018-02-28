<?php
/**
 * Created by PhpStorm.
 * User: Mihir
 * Date: 9/24/2016
 * Time: 11:56 AM
 */

include_once "../Functions/Import.php";
if(isset($_POST["search"]) && $_POST["search"] == "book") :
    $sub = $_POST["sub"];
    $title = $_POST["title"];
    ?>


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
    $qry = $db->prepare("SELECT * FROM books WHERE title=? AND subject=?");
    $qry->execute(array($title,GetSubjectIdByName($sub)));
    $cnt = $qry->rowCount();
if($cnt>0) {
    ?>
    <div class="panel-body1" >
        <table class="table" id="dataTable" width="100%">
            <thead>
            <tr align="center">
                <th>Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Publisher</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $data = $qry->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $book):

                /** @noinspection CheckImageSize */
                echo '<tr id="', $book['id'], '">
                 <td>', $book['title'], '</td>
                 <td>', $book['authorId'], '</td>
                 <td>', $book['edition'], '</td>
                 <td>', $book['publisherid'], '</td>
                 <td>',
                isBookAvailable($book["title"],$book["edition"],$book["subject"],$book["id"]) > 0 ?
                    '<a href="ConfirmBook?id='.encrypt($book['id']).'"><button type="button" class="btn btn-primary">Book</button></a>'  :
                    '<button type="button" class="btn btn-danger" disabled>Unavailable</button>'
                ,'</td>
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
<?endif?>

<?php

if(isset($_POST["search"]) && $_POST["search"] == "subject") :
    $sub = $_POST["name"];
    $data = GetBooksBySubjectName($sub);
    $list = array();
    foreach ($data as $book) {
        $list[] = array('text' => $book["title"]);
    }
    echo json_encode($list);
endif;

if(isset($_POST["search"]) && $_POST["search"] == "edition") :
    $ed = $_POST["id"];
    $data = GetBookById($ed);
    foreach ($data as $edition) {
        $list[] = array('edition' => $edition["edition"]);
    }
    echo json_encode($list);
endif;



