<!--<script type="text/javascript">
    $(function(){

    });
</script>-->
<script>
    $(document).ready(function() {

        $('#more').click(function(e){

            var aCount = 0;
            ++aCount ;
            if(aCount <= 9){
                var attachment = $('input[name="attachments[]"]').slice(0,1).clone();
                $('.attachments #attachments').append(attachment);
                $('.attachments #attachments').append('<br />');
            }
            e.preventDefault();
        });

    });
</script>
<div class="xs">
    <h3>Create Case</h3>
    <div class="well1 white">
        <div id="status"></div>
        <form method="POST" enctype="multipart/form-data" id="defaultForm"  class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-3 control-label">Title</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control1"
                           name="title" placeholder="Enter Case Title" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Priority</label>
                <div class="col-lg-3">
                    <select class="select" title="Select Priority" name="priority" id="priority">
                        <option value="Normal">Normal</option>
                        <option value="Moderate">Moderate</option>
                        <option value="High">High</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Reason</label>
                <div class="col-lg-3">
                    <select class="select" title="Select Reason" name="reason" id="reason">
                        <optgroup label="Hardware">
                            <option value="Missing Hardware">Missing Hardware</option>
                            <option value="Not Working">Not Working</option>
                            <option value="Damaged">Damaged</option>
                        </optgroup>
                        <optgroup label="Software">
                            <option value="Not Installed">Not Installed</option>
                            <option value="Corrupted">Corrupted</option>
                            <option value="Not Working">Not Working</option>
                        </optgroup>
                        <optgroup label="Access">
                            <option value="login">Password Reset</option>
                        </optgroup>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Lab</label>
                <div class="col-lg-3">
                    <select id="nm" class="select" data-live-search="true" name="lab" title="Select Lab No">
                        <?php
                        $labs = getLabs();

                        foreach($labs as $lab)
                        {
                            echo '<option value='.$lab['lab'].'>'.$lab['lab'].'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Location</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched"
                           name="pc" placeholder="Enter PC Number" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="description">Description</label>
                <div class="col-lg-5">
                    <textarea id="description" class="form-control1" name="description"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="description">Attachments</label>
                <div class="col-lg-8 attachments">
                    <input type="file" name="attachments[]" />
                    <a href="#" id="more">+ More</a>
                    <div id="attachments"></div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">

                    <input type="submit"  class="btn btn-primary" name="create" value="Create" />
                    <button type="reset" class="btn btn-info" id="resetBtn">Reset form</button>
                </div>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        $('#defaultForm').bootstrapValidator({
            live: 'disable',
            message: 'This value is not valid',
            excluded: ':disabled',
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Title'
                        }
                    }
                },
                pc: {
                    validators: {
                        notEmpty: {
                            message: 'Enter PC No'
                        }
                    }
                },
                lab: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Lab'
                        }
                    }
                },
                reason: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Reason'
                        }
                    }
                },
                priority: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Priority'
                        }
                    }
                },
                description: {
                    validators: {
                        notEmpty: {
                            message: 'Please Select Description'
                        }
                    },stringLength: {
                        min: 15,
                        message: 'Description should contain at least 20 words'
                    }
                }
            }
        });

        // Validate the form manually
        $('#validateBtn').click(function() {
            $('#defaultForm').bootstrapValidator('validate');
        });

        $('#resetBtn').click(function() {
            $('#defaultForm').data('bootstvrapValidator').resetForm(true);
        });
    });
</script>
<?php
if ( isset ( $_POST [ "create" ] ) ) {
    $title = $_POST [ "title" ] ;
    $reason = $_POST [ "reason" ] ;
    $description = $_POST [ "description" ] ;
    $attachments = $_FILES [ "attachments" ] ;
    $priority = $_POST [ "priority" ] ;
    $lab = $_POST [ "lab" ] ;
    $pc = $_POST [ "pc" ] ;

    $accountid = GetLoggedAccountID ( ) ;
    $db = Connection ( 'db_case' ) ;
    $case = $db->prepare ( 'INSERT INTO t_cases ( creatorAccountID , title , content , reason , priority, lab, pc ) VALUES ( ?, ?, ?, ?, ?, ? ,? )' ) ;
    $case->bindValue ( 1 , $accountid , PDO::PARAM_INT ) ;
    $case->bindValue ( 2 , $title , PDO::PARAM_STR ) ;
    $case->bindValue ( 3 , $description , PDO::PARAM_STR ) ;
    $case->bindValue ( 4 , $reason , PDO::PARAM_STR ) ;
    $case->bindValue ( 5 , $priority , PDO::PARAM_STR ) ;
    $case->bindValue ( 6 , $lab , PDO::PARAM_STR ) ;
    $case->bindValue ( 7 , $pc , PDO::PARAM_STR ) ;
    $case->execute ( ) ;
    $caseID = $db->lastInsertId ( ) ;
    if ( count ( $attachments ) >= 1 && $caseID > 0 ) {
        $uploaded = 0 ;
        $_attach = array ( ) ;
        if ( ! is_dir ( 'Attachments' ) ) mkdir ( 'Attachments' , 0777 , true ) ;
        if ( ! is_dir ( 'Attachments/thumb' ) ) mkdir ( 'Attachments/thumb' , 0777 , true ) ;
        for ( $i = 0 , $k = count ( $attachments [ "name" ] ) ; $i < $k ; ++ $i ) {
            $fileName = $attachments [ "name" ] [ $i ] ;
            $fileType = $attachments [ "type" ] [ $i ] ;
            $tmp = $attachments [ "tmp_name" ] [ $i ] ;
            if ( in_array ( $fileType , array ( 'image/png' , 'image/jpeg' ) ) ) {
                $ext = pathinfo ( $fileName , PATHINFO_EXTENSION ) ;
                $_name = md5 ( time ( ) . uniqid ( ) )  ;
                $destination = sprintf ( 'Attachments/%s.%s' , $_name , $ext ) ;
                $destination_thumb = sprintf ( 'Attachments/thumb/%s.%s' , $_name , $ext ) ;
                if ( move_uploaded_file ( $tmp , $destination ) ) {
                    ++ $uploaded ;
                    $query = $db->prepare ( 'INSERT INTO t_case_attachments ( cid , attachment , addedBy ) VALUES ( ? , ? , ? )' ) ;
                    $query->bindValue ( 1 , $caseID , PDO::PARAM_INT ) ;
                    $query->bindValue ( 2 , $destination , PDO::PARAM_STR ) ;
                    $query->bindValue ( 3 , $accountid , PDO::PARAM_INT ) ;
                    if ( $query->execute ( ) ) {
                        CreateThumbnail ( 100 , 100 , 100 , $destination , $destination_thumb ) ;
                    }

                    die(print_r($query->errorInfo()));
                }
            }
        }
    }
    if ( $caseID > 0 ) {
        echo '<div class="panel-body1"> ';
        echo '<span class="inline-info"> ';
        echo 'The case was submitted successfully. <br />' ;
        echo 'CaseID: #<b>' . $caseID . '</b><br />' ;
        echo 'Submitted date: ' . strftime ( '%d, %b of %Y' , time ( ) ) . '<br />' ;
        echo 'Title: ', $title ,'<br />' ;
        echo 'Reason: ', $reason ,', Priority: ', $priority ,'<br />' ;
        echo '</span>' ;
        echo '</div>' ;
    }

}
?>


