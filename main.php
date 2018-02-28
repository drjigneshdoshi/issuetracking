<script src="Asset/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="Asset/css/bootstrap-select.css">
<div class="xs">
    
    <h3>Dashboard</h3>
    <div id="error"></div>
    <div class="col_2">
        <div class="col-md-4 span_7">
            <div class="cal1 cal_2"></div>
        </div>

        <div class="col-md-8 stats-info col_6">
            <div class="panel-heading">
                <h4 class="panel-title">Report</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="defaultForm">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Report</label>
                        <div class="col-lg-4">
                            <select title="" id="report" name="report">
                                <option value="">Select Report</option>
                                <option value="avg">Average Resolve Time</option>
                                <option value="case">Cases</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-1">
                            <button type="button" class="btn btn-primary" id="sub" name="sub">Generate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div id="contents">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js" type="javascript"></script>


</div>

<script>
    $(document).ready(function () {

        let now = new Date();
        let day = ("0" + now.getDate()).slice(-2);
        let month = ("0" + (now.getMonth() + 1)).slice(-2);
        let date = now.getFullYear() + "-" + (month) + "-" + (day);
        clndr = $('.cal1');
        $("#error").hide();
        let thisDate = moment().format('YYYY-MM-DD');
        clndr.clndr({
            clickEvents: {
                click: function (target) {
                    if ($(target.element).hasClass('inactive')) {
                        $("#submit").hide();
                        $("#error").html('<div id="error" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <strong>Error</strong> Please select valid date </div>').hide().fadeIn("slow").fadeTo(2000, 500).slideUp(500, function () {
                            $("#error").slideUp(500);
                            $("#contents").html("");
                        });
                    } else {
                        date = target.date._i;
                    }
                }
            },
            trackSelectedDate: true,
            ignoreInactiveDaysInSelection: true,
            constraints: {
                endDate: thisDate
            }
        });

        $("#sub").click(function () {
            let data = $("#defaultForm").serialize();
            data = data+"&date="+date;
            $.ajax({
                type: "POST",
                url: "Actions/generateReport.php",
                data: data,
                cache: false,
                success: function (data) {
                    $("#contents").html(data);
                    console.log(data)
                }
            });

        });
        $('#report').selectize({

        });
    });
                     <?if(IsUser()):?>                   
                        window.location.href = "CreateCase";
                    <? endif; ?>
                    <?if(IsLabAssistant()):?>                   
                        window.location.href = "LatestCase";
                    <? endif; ?>
                  
</script>
<link rel="stylesheet" href="Asset/css/clndr.css" type="text/css" />
<script src="Asset/js/underscore-min.js" type="text/javascript"></script>
<script src= "Asset/js/moment-2.2.1.js" type="text/javascript"></script>
<script src="Asset/js/clndr.js" type="text/javascript"></script>