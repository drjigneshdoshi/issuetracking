<script src="Asset/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="Asset/css/bootstrap-select.css">
<?php $token = CreateFormToken(); ?>
<div class="xs">
    <h3>Add Member</h3>
    <div class="well1 white">
        <div id="status"></div>
        <form id="defaultForm" method="post" action="#" class="form-horizontal">
            <div class="form-group" id="name">
                <label class="col-lg-3 control-label">Full name</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched"
                           name="name" placeholder="Name"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Email</label>
                <div class="col-lg-5">
                    <input type="text" id="email"
                           class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched" name="email"
                           placeholder="Enter Email"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Password</label>
                <div class="col-lg-5">
                    <input type="password"
                           class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched" name="pwd"
                           placeholder="Enter Password"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Confirm Password</label>
                <div class="col-lg-5">
                    <input type="password"
                           class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched" name="cpwd"
                           placeholder="Confirm Password"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Phone No</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched"
                           name="phone" placeholder="Phone No"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Role</label>
                <div class="col-lg-5">
                    <select class="selectpicker" name="role">
                        <option value="1">Lab Assistant</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="token" value="<?=$token?>"/>

            <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                    <button type="button" class="btn btn-primary" id="validateBtn" name="AddUser" value="Add">Add
                    </button>
                    <button type="button" class="btn btn-info" id="resetBtn">Reset form</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var email = $('#email').val();
        $("#defaultForm").bootstrapValidator({
            live: 'enable',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh gly-spin'
            },
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The name is required'
                        }
                    }
                },
                phone: {
                    validators: {
                        notEmpty: {
                            message: 'The Phone no is required'
                        },
                        stringLength: {
                            min: 10,
                            max: 11,
                            message: 'Enter 10 digit phone no'
                        },
                        regexp: {
                            regexp: /^[0-9_\.]+$/,
                            message: 'The Phone can only consist of number'
                        }
                    }
                },
                pwd: {
                    validators: {
                        notEmpty: {
                            message: 'Password is required'
                        },
                        stringLength: {
                            min: 6,
                            max: 32,
                            message: 'Password length must be grater then 6'
                        },
                        cpwd: {
                            field: 'confirmPassword',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
                cpwd: {
                    validators: {
                        notEmpty: {
                            message: 'Password is required'
                        },
                        stringLength: {
                            min: 6,
                            max: 32,
                            message: 'Password length must be grater then 6'
                        },
                        identical: {
                            field: 'pwd',
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
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
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
            var $form = $(e.target),
            validator = $form.data('bootstrapValidator');
            data = $form.serialize();
            $.ajax({
                type: "POST",
                url: "Actions/saveUser.php",
                data: data,
                cache: false,
                success: function (response) {
                    if (response.status === 'error') {
                        $("#status").html("<div class='panel-body1'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Error</strong> Error while saving data, Please try again later</div></div>").fadeIn();
                    }
                    else {
                        $('#defaultForm').data('bootstrapValidator').resetForm(true);
                        $("#status").html("<div class='panel-body1'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success</strong> Member Added Successfully</div></div>").fadeIn();
                    }
                }
            });
            $("#status").fadeTo(2000, 500).slideUp(500, function(){
                $("#status").slideUp(500);
            });
        });

        // Validate the form manually
        $('#validateBtn').click(function () {
            $('#defaultForm').bootstrapValidator('validate');
        });

        $('#resetBtn').click(function () {
            $('#defaultForm').data('bootstrapValidator').resetForm(true);
        });
    });
/*
  <? if(IsAdministrator()) : ?>

     <? endif; ?>


*/
</script>


