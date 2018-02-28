<script src="Asset/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="Asset/css/bootstrap-select.css">
<?php $token = CreateFormToken(); ?>
<div class="xs">
    <h3>Add Author</h3>
    <div class="well1 white">
        <div id="status"></div>
        <form id="defaultForm" method="post" action="#" class="form-horizontal">
            <div class="form-group">
                <label class="col-lg-3 control-label">Publisher Name</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched"
                           name="publisher" placeholder="Enter Publisher Name" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label">Address</label>
                <div class="col-lg-5">
                    <input type="text"
                           class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched" name="address"
                           placeholder="Enter Address"/>
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
                <label class="col-lg-3 control-label">Phone</label>
                <div class="col-lg-5">
                    <input type="text"
                           class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched" name="phone"
                           placeholder="Enter Phone"/>
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
    $(document).ready(function() {
        // Generate a simple captcha
        $('#defaultForm').bootstrapValidator({
            live: 'disable',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                publisher: {
                    validators: {
                        notEmpty: {
                            message: 'The first name is required and cannot be empty'
                        }
                    }
                },
                address: {
                    validators: {
                        notEmpty: {
                            message: 'The last name is required and cannot be empty'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The last name is required and cannot be empty'
                        },
                        emailAddress: {
                            message: 'The input is not a valid email address'
                        }
                    }
                },phone: {
                    validators: {
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
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();

            var $form = $(e.target),
                validator = $form.data('bootstrapValidator');
            data = $form.serialize();
            $.ajax({
                type: "POST",
                url: "Actions/savePublisher",
                data: data,
                cache: false,
                success: function (response) {
                    console.log(response);
                    if (response.status === 'error') {
                        $("#status").html("<div class='panel-body1'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Error</strong> Error while saving data, Please try again later</div></div>").fadeIn();
                    }
                    else {
                        $('#defaultForm').data('bootstrapValidator').resetForm(true);
                        $("#status").html("<div class='panel-body1'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Success</strong>Publisher Saved Success</div></div>").fadeIn();
                    }
                }
            });
            $("#status").fadeTo(2000, 500).slideUp(500, function(){
                $("#status").slideUp(500);
            });
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




