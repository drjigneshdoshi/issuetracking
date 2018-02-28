<?php
/**
 * Created by PhpStorm.
 * User: Divyank
 * Date: 08-Feb-17
 * Time: 12:47 AM
 */
include_once '../Functions/Import.php';
if(isset($_POST['report']) && $_POST['report'] == "case") {

    $db = Connection('db_case');
    $date = $_POST['date'];
    $month = MonthFromDate($date);

    if(IsUser()) {

        $query = $db->prepare("SELECT 
                          sum(case WHEN status = 'Opened' THEN 1 else 0 END ) as 'open',
                          sum(case WHEN status = 'Closed' THEN 1 else 0 END ) as 'closed', 
                          sum(case WHEN status = 'default' OR status = 'Pending' THEN 1 else 0 END ) as 'pending', 
                          sum(case WHEN status = 'Answered' THEN 1 else 0 END ) as 'answered', 
                          sum(case WHEN status = 'Discarded' THEN 1 else 0 END ) as 'discarded',
                          sum(case WHEN status = 'Resolved' THEN 1 else 0 END ) as 'resolved'
                          FROM t_cases WHERE DATE_FORMAT(added,'%M') = ? AND creatorAccountID=?");
        $query->execute(array($month,GetLoggedAccountID()));

        $query2 = $db->prepare("SELECT 
                          sum(case WHEN priority = 'High' THEN 1 else 0 END ) as 'High',
                          sum(case WHEN priority = 'Moderate' THEN 1 else 0 END ) as 'Moderate', 
                          sum(case WHEN priority = 'Normal' THEN 1 else 0 END ) as 'Low'
                          FROM t_cases WHERE DATE_FORMAT(added,'%M') = ? AND creatorAccountID=?");
        $query2->execute(array($month,GetLoggedAccountID()));


    } else {
        $query = $db->prepare("SELECT 
                          sum(case WHEN status = 'Opened' THEN 1 else 0 END ) as 'open',
                          sum(case WHEN status = 'Closed' THEN 1 else 0 END ) as 'closed', 
                          sum(case WHEN status = 'default' OR status = 'Pending' THEN 1 else 0 END ) as 'pending', 
                          sum(case WHEN status = 'Answered' THEN 1 else 0 END ) as 'answered', 
                          sum(case WHEN status = 'Discarded' THEN 1 else 0 END ) as 'discarded',
                          sum(case WHEN status = 'Resolved' THEN 1 else 0 END ) as 'resolved'
                          FROM t_cases WHERE DATE_FORMAT(added,'%M') = ?");
        $query->execute(array($month));

        $query2 = $db->prepare("SELECT 
                          sum(case WHEN priority = 'High' THEN 1 else 0 END ) as 'High',
                          sum(case WHEN priority = 'Moderate' THEN 1 else 0 END ) as 'Moderate', 
                          sum(case WHEN priority = 'Normal' THEN 1 else 0 END ) as 'Low'
                          FROM t_cases WHERE DATE_FORMAT(added,'%M') = ?");
        $query2->execute(array($month));


    }
    $data = ($query->fetchAll(2)[0]);

    $priority = ($query2->fetchAll(2)[0]);
    ?>
    <div class="graphs">
        <div class="graph_box">
            <div class="col-md-4 grid_2">
                <div class="grid_1">
                    <h3><?php echo IsUser() ? "Your":"" ?> Case Report of <?=$month?> </h3>
                    <canvas id="myChart" height="500" width="500" style="width: 500px; height: 500px;"></canvas>
                </div>
            </div>
            <div class="col-md-4 grid_2">
                <div class="grid_1">
                    <h3>Priority wise Report</h3>
                    <canvas id="myChart1" height="500" width="500" style="width: 500px; height: 500px;"></canvas>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <script>
        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?=json_encode(array_keys($data))?>,
                datasets: [{
                    label: '# of Votes',
                    data: <?=json_encode(array_values($data))?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                        ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
        var ctx2 = $("#myChart1");
        var myChart2 = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: <?=json_encode(array_keys($priority))?>,
                datasets: [{
                    label: '# of Votes',
                    data: <?=json_encode(array_values($priority))?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
<?
} else if(isset($_POST['report']) && $_POST['report'] == "avg") {

}
