<?php include_once "Functions/Import.php";

if(isset($_SESSION["name"]))
{
    header("Location: home");
}

?>
<? include_once("Functions/Import.php") ?>
<!DOCTYPE HTML>
<html>
<head>

    <title>LOGIN | Digitalcreation</title>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="Asset/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="Asset/css/style.css" rel='stylesheet' type='text/css' />
    <link href="Asset/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="Asset/js/jquery.min.js"></script>
    <script src="Asset/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="Asset/js/bootstrap.min.js"></script>
    <!----webfonts--->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <!---//webfonts--->
    <!-- Bootstrap Core JavaScript -->
    <script src="Asset/js/bootstrap.min.js"></script>
    <script src="Asset/js/bootstrapValidator.js"></script>
    <style>
        .reg
        {
            padding-top: 30px;
            margin-left: 165px;
        }
        .message {
  padding-left: 35px;
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.message a {
  color: #0000FF;
  text-decoration: none;
}
    </style>
</head>

<body id="login">
<div class="login-logo">
    <a style="text-decoration:none" href="#"><h2>Issue Tracking System</h2></a>
</div>
<h2 class="form-heading">login</h2>
<div class="app-cam">
    <?php $token = CreateFormToken(); ?>

    
<!--    <div class="modal fade bs-modal-lg" id="large">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Modal Title</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn green">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        <!-- </div> -->
        <!-- /.modal-dialog -->
    <!-- </div> -->

    <form method="post" id="defaultForm" class="form-horizontal">
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="email" placeholder="Enter User Name">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="pass" placeholder="Enter Password">
            </div>
        </div>

        <input type="hidden" name="token" value="<?=$token?>"/>

        <div class="submit"><input type="submit" class="btn btn-default" id="" data-dismiss="modal" name="submit" value="Login">
        </div>       
        <div class="message">
             <p>Not registered? <a href="Register.php">Create an account</a></p>
        </div>
    </form>
</div>
<div class="app-cam" id="status"></div>
<div class="copy_layout login">
    <p>Copyright &copy; <?php echo date("Y")?> L.J Library. All Rights Reserved </p>
</div>

</body>
</html>


<script type="text/javascript">
    $(document).ready(function() {
        $("#defaultForm").bootstrapValidator({
            live: 'enable',
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Email'
                        }
                    }
                },
                pass: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Password'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            var $form = $(e.target),
                validator = $form.data('bootstrapValidator');
            var data = $form.serialize();
            $.ajax({
                type: "POST",
                url: "Actions/login.php",
                data: data,
                cache: false,
                success: function (response) {
                    console.log(response.tc);
                    if(response.tc == "0") {

                        $("#large").modal().show();

                    }
                    if (response.error === "true") {
                     $("#status").html("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Error</strong> Invalid Email or Password</div>").hide().fadeIn("slow").fadeTo(2000, 500).slideUp(500, function(){
                     $("#status").slideUp(500);
                     $('#defaultForm').data('bootstrapValidator').resetForm(true);
                     });
                     }
                     else {
                     $("#status").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success</strong> Logged In Successfully</div>").hide().fadeIn("slow").fadeTo(2000, 500).slideUp(500, function(){
                     $("#status").slideUp(500);

                        window.location.href = "home";

                        /*
					 <?if(GetRole()==="Admin"):?>                   
                        window.location.href = "main";
                    <? endif; ?>

                    <?if(GetRole()==="User"):?>                   
                        window.location.href = "CreateCase";
                    <? endif; ?>
                    /*
                    <? if(IsAdministrator()) : ?>
                    	window.location.href = "";
    				 <? endif; ?>

    				 */
                     });

                     }
                }
            });
        });
    });
</script>