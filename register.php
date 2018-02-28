<? include_once("Functions/Import.php") ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Register</title>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- Bootstrap Core CSS -->
    <link href="Asset/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <!-- Custom CSS -->
    <link href="Asset/css/style.css" rel='stylesheet' type='text/css' />
    <link href="Asset/css/font-awesome.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="Asset/js/jquery.min.js"></script>
    <!----webfonts--->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <!---//webfonts--->
    <!-- Bootstrap Core JavaScript -->
    <script src="Asset/js/bootstrap.min.js"></script>
    <script src="Asset/js/bootstrapValidator.js"></script>
    <?=loadResource("css","bootstrap-select.css") ?>
    <?=loadResource("js","bootstrap-select.js") ?>

</head>
<body id="login">
<div class="login-logo">
    <a style="text-decoration:none" href="#"><h2>Library Stock Management</h2></a>
</div>
<h2 class="form-heading">Register</h2>
<div class="app-cam">
    <?php $token = CreateFormToken(); ?>
    <form method="post" id="defaultForm" class="form-horizontal">

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="name" placeholder="Enter Name">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="radio" title="male" name="Gender" value="m" checked>Male &nbsp;
                <input type="radio" title="female" name="Gender" value="f">Female
            </div>
        </div>

        <div class="form-group" >
            <div class="col-sm-12">
                <select title="Select Department" id="dept" name="dept" class="selectpicker">
                    <option>MCA</option>
                    <option>MCM</option>
                    <option>MBA</option>
                </select>
            </div>
        </div>

        <div class="form-group" id="div">
            <div class="col-sm-12">
                <select title="Select Division" name="div" class="selectpicker">
                    <option>IET</option>
                    <option>IMS</option>
                    <option>ICA</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="enroll" id="enroll" placeholder="Enter Enrollment No">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="phone" id="enroll" placeholder="Enter Phone No">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="email" placeholder="Enter Email">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="pass" id="pass" placeholder="Enter Password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="password" name="cpass" id="cpass" placeholder="Confirm Password">
            </div>
        </div>

        <input type="hidden" name="token" value="<?=$token?>"/>

        <div class="submit"><input type="submit" class="btn btn-default" id="" data-dismiss="modal" value="Register"></div>
    </form>
</div>
<div class="app-cam" id="status"></div>
<div class="copy_layout login">
    <p>Copyright &copy; 2016 L.J Library. All Rights Reserved </p>
</div>
</body>
</html>


<script type="text/javascript">
    $(document).ready(function() {
        $("#div").hide();

        $("#dept").change(function () {

            if($("#dept").val() == "MCA") {
                $("#div").show();
            }
        });
        var email = $('#email').val();
        var enroll = $('#enroll').val();

        $("#defaultForm").bootstrapValidator({
            live: 'enable',
            excluded: ':disabled',
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Email is required'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        },
                        remote: {
                            type: 'POST',
                            data: {email: email, validate: "email"},
                            url: 'Actions/validate.php',
                            message: 'Email is already registered, please try another',
                            delay: 3000
                        }
                    }
                },
                pass: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Password'
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Phone No'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Phone No should only contain Numbers'
                        }
                    }
                },
                name: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Name'
                        },
                        regexp: {
                            regexp: /^[A-z]+$/,
                            message: 'Name should only contain letters'
                        }
                    }
                },
                enroll: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Enrollment No'
                        },
                        remote: {
                            type: 'POST',
                            data: {enroll: enroll, validate: "enroll"},
                            url: 'Actions/validate.php',
                            message: 'Enrollment no is already registered',
                            delay: 3000
                        },stringLength: {
                            min: 12,
                            max: 12,
                            message: 'Please Enter Valid Enrollment No'
                        },
                        regexp: {
                            regexp: /^[0-9_\.]+$/,
                            message: 'Enrollment No should only contain numbers'
                        }
                    }
                },
                cpass: {
                    validators: {
                        notEmpty: {
                            message: 'Please Enter Confirm Password'
                        },identical: {
                            field: 'pass',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
                dept: {
                    validators: {
                        notEmpty: {
                            message: 'Select Department'
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
                url: "Actions/register.php",
                data: data,
                cache: false,
                success: function (response) {
                    console.log(response);
                    if (response.error === "true") {
                        $("#status").html("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Error</strong> Invalid Email or Password</div>").hide().fadeIn("slow").fadeTo(2000, 500).slideUp(500, function(){
                            $("#status").slideUp(500);
                            $("#pass").val("");
                        });
                    }
                    else {
                        $("#status").html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success</strong> Logged In Successfully</div>");
                        $(".app-cam").fadeIn("slow").fadeTo(2000, 500).slideUp(500, function(){
                            $(".app-cam").slideUp(500);
                            window.location.href = "home";
                        });

                    }
                }
            });
        });
    });
</script>