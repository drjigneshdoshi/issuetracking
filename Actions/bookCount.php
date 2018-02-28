
<?php
/**
 * Created by PhpStorm.
 * User: Divyank
 * Date: 10/5/2016
 * Time: 3:03 AM
 */
include_once "../Functions/Import.php";
if(isset($_POST["search"])) {
    $cri = explode(",",$_POST["search"]);
    if(in_array("dept",$cri)) : ?>
        <div class="form-group">
            <label class="col-lg-3 control-label">Select Department</label>
            <div class="col-lg-4">
                <select id="Criteria" class="selectpicker" title="Select Department" data-selected-text-format="count > 2" data-live-search="true" name="dept" multiple>
                    <option>MCA</option>
                    <option>MBA</option>
                    <option>MCM</option>
                </select>
            </div>
        </div>
    <?endif;?>

    <?if(in_array("title",$cri)) :?>
        <div class="form-group">
            <label class="col-lg-3 control-label">Select Title</label>
            <div class="col-lg-4">
                <select class="selectpicker" title="Select Title" data-selected-text-format="count > 2" data-live-search="true" name="title" multiple>
                    <?
                    $data = GetBooks();
                    foreach($data as $book)
                    {
                        echo '<option>'.$book['title'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    <?endif;?>

    <?if(in_array("pub",$cri)) :?>
        <div class="form-group">
            <label class="col-lg-3 control-label">Select Publisher</label>
            <div class="col-lg-4">
                <select class="selectpicker" title="Select Publisher" data-selected-text-format="count > 2" data-live-search="true" name="pub" multiple>
                    <?
                    $data = GetPublisher();
                    foreach($data as $pub)
                    {
                        echo '<option value="'.$pub["id"].'">'.$pub['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    <?endif;?>

    <?if(in_array("sub",$cri)) :?>
        <div class="form-group">
            <label class="col-lg-3 control-label">Select Subject</label>
            <div class="col-lg-4">
                <select class="selectpicker" title="Select Subject" data-selected-text-format="count > 2" data-live-search="true" name="sub" multiple>
                    <?
                    $data = GetSubjects();
                    foreach($data as $sub)
                    {
                        echo '<option value="'.$sub["id"].'">'.$sub['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    <?endif;
}

if(isset($_POST["submit"])) {

    $db = GetDatabaseConnection("library");
    $qry = array();

    if(isset($_POST["dept"])) {
        $qry[] = 'department IN("' . implode('", "', explode(",",$_POST["dept"]))  . '") ';
    }
    if(isset($_POST["title"])) {
        $qry[] = 'title IN("' . implode('", "', explode(",",$_POST["title"])) . '") ';
    }
    if(isset($_POST["pub"])) {
        $qry[] = 'publisherid IN("' . implode('", "', explode(",",$_POST["pub"])) . '") ';
    }
    if(isset($_POST["sub"]) != "") {
        $qry[] = 'subject IN("' . implode('", "', explode(",",$_POST["sub"])) . '") ';
    }

    $str ="";

    if(count($qry) > 1) {

        foreach ($qry as $cnt) {
            $str .= $cnt. " OR ";
        }
        $str = substr($str,0,-3);
    } else {
        $str = $qry[0];
    }

    $qry = "SELECT *FROM books WHERE ".$str;
    $query = $db->prepare($qry);
    if($query->execute()) :?>

        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#dataTable').dataTable( {
                    "ordering": false,
                    "paging":   true,
                    "columnDefs": [
                        { "orderable": false, "targets": 2 }
                    ]
                });
            });
        </script>
        <div class="panel-body1" >
            <table class="table" id="dataTable" width="100%">
                <thead>
                <tr align="center">
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Edition</th>
                    <th>Publisher</th>
                    <th>Department</th>
                    <th>Total In Stock</th>
                    <th>Total Issued</th>
                    <th>Total Damaged</th>
                    <th>Total Removed</th>
                    <th>Total Lost</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt = 0;
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                $totalBooks = array();
                foreach ($data as $book):
                    echo '<tr id="', $book['id'], '">
                        <td>', ++$cnt, '</td>
                        <td>', $book['title'], '</td>
                        <td>', GetAuthorById($book['authorId']), '</td>
                        <td>', $book['edition'], '</td>
                        <td>', $book['department'], '</td>
                        <td>', GetPublisherByID($book['publisherid'])["name"], '</td>
                        <td>', GetTotalAvailableBooksById($book['id']), '</td>
                        <td>', GetTotalIssuedBooksById($book['id']), '</td>
                        <td>', GetTotalDamagedBooksById($book['id']), '</td>
                        <td>', GetTotalRemovedBooksById($book['id']), '</td>
                        <td>', GetTotalLostBooksById($book['id']), '</td>
                    </tr>';
                    $ssn = getSSNByBookID($book["id"]);
                    foreach ($ssn as $bk) {
                        array_push($totalBooks,$bk["ssnNo"]);
                    }
                endforeach;
                ?>
                </tbody>
            </table>
        </div>
        <div class="panel-body1">
            <div class="well" style="width: 30%">
                <b>Total Books : </b><?=$cnt?>

            </div>

            <div class="well" style="width: 30%">
                <b>Total Resources : </b><?=$resources = count(GetWorkers())?>
            </div>

            <div class="well" style="width: 30%">
                <b>Total Working Days : </b><?=$days = GetSettingValue("StockCountDays")?>
            </div>

            <div class="well" style="width: 30%">
                <b>Total Books Per Day to be count : </b><?=$tbook = ceil($cnt = 10000 / $days)?>
            </div>

            <div class="well" style="width: 30%">
                <b>Avg Books Per Worker : </b><?=ceil($tbook / $resources)?>
            </div>

            <button class="btn btn-info" id="count">Generate Count Sheet</button>
        </div>
        <script>
            $(document).ready(function () {
                $("#count").click(function () {
                    console.log("test");
                    if (confirm("Are you sure you want to generate count sheet?")) {
                        <?
                        $db = GetDatabaseConnection("library");
                        $booksCount = ceil(count($totalBooks) / count(GetWorkers()));
                        $cnt = 0;
                        foreach (GetWorkers() as $worker) {

                            $db = GetDatabaseConnection("Stock");

                            $table = $worker["id"] ;
                            $query = $db->prepare("CREAT");
                        }

                        ?>
                    }
                });
            });
        </script>
        <?
    else :
        print_r($query->errorInfo());
    endif;
}
