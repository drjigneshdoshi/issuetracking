<script src="Asset/js/bootstrap-select.js"></script>
<link rel="stylesheet" href="Asset/css/bootstrap-select.css">
<?php $token = CreateFormToken(); ?>
<div class="xs">
    <h3>Add Lab</h3>
    <div class="well1 white">
        <div id="status"></div>
        <form id="defaultForm" method="post" action="#" class="form-horizontal">
            <div class="form-group" id="name">
                <label class="col-lg-3 control-label">Lab Name</label>
                <div class="col-lg-5">
                    <input type="text" class="form-control1 ng-invalid ng-invalid-required ng-valid-pattern ng-touched"
                           name="name" id="name" placeholder="Name"/>
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
        var lab = $('#name').val();
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
                        },
                        remote: {
                            type: 'POST',
                            data: {lab, validate: "lab"},
                            url: 'Actions/validate.php',
                            message: 'Email is already registered, please try another',
                            delay: 3000
                        }
                    }
                },
            }
        });

        // Validate the form manually
        $('#validateBtn').click(function () {
            $('#defaultForm').bootstrapValidator('validate');
        });

        $('#resetBtn').click(function () {
            $('#defaultForm').data('bootstrapValidator').resetForm(true);
        });
    });
</script>




