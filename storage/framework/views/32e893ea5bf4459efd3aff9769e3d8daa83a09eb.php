
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Student Attendance Submit | KIU Sri lanka</title>
    <!-- Custom fonts for this template-->

    <link rel="stylesheet" type="text/css" href="/outsideview/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="/outsideview/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
        .btn-check {
            position: absolute;
            clip: rect(0,0,0,0);
            pointer-events: none;
        }
        .btn-check:active+.btn-outline-success, .btn-check:checked+.btn-outline-success, .btn-outline-success.active, .btn-outline-success.dropdown-toggle.show, .btn-outline-success:active {
            color: #fff;
            background-color: #198754;
            border-color: #198754;
        }
        .btn-check:active+.btn-outline-danger, .btn-check:checked+.btn-outline-danger, .btn-outline-danger.active, .btn-outline-danger.dropdown-toggle.show, .btn-outline-danger:active {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-success:hover {
            color: #fff;
            background-color: #198754;
            border-color: #198754;
        }
        .btn-outline-success {
            color: #198754;
            border-color: #198754;
        }
        .btn-outline-danger:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        .section-heading h3 span {
            color: #dc3545;
        }
        .section-heading {
            margin: 0 0 20px !important;
        }
        .container2 {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        @media (min-width: 768px) {
            .container2 {
                width: 400px;
            }
        }
        @media (min-width: 992px) {
            .container2 {
                width: 500px;
            }
        }
        @media (min-width: 1200px) {
            .container2 {
                width: 500px;
            }
        }
        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
</head>

<body class="body-class">
    <!--Start Preloader -->

    <!-- End Preloader -->
    <div id="body-wrap">
        <!-- Begin Page Content -->
            <section id="pricing">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <div class="section-heading text-center">
                    <a><img style="width: 250px"
                                    src="/outsideview/images/KIU-Logo.png" class="logo" alt=""></a>
                        <h3>Student Attendance Submit</h3>
                    </div>
                </div>
            </div>
            <div class="container2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pricing-table text-center" style="padding: 20px !important">
                            <?php if($verified == 0): ?>
                                <div class="pricing-title" style="margin-bottom:30px">
                                    <h5>Please verify your details</h5>
                                </div>
                                <div class="bg" style="background-color: #d03a3a; color:white; padding:5px;margin-bottom: 10px;display: none" id='error_message'><b>Your NIC, Kiu Email and Student ID not match</b></div>
                                <div class="pricing-body" style="padding: 0 5%; !important">
                                    <form class="form-label-left input_mask needs-validation" method="post" action="" id="submitForm">
                                        <?php echo csrf_field(); ?>
                                        <input type="number" name="student_id" id="student_id" class="form-control" placeholder="KIU Student ID" required><br/>
                                        <input type="text" name="nic_passport" id="nic_passport" class="form-control" placeholder="NIC / Passport" required><br/>
                                        <input type="email" name="kiu_email" id="kiu_email" class="form-control" placeholder="KIU Email Address" required><br/><br/>

                                        <button class="btn btn-success">VERIFY</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-success">
                                    <h5><i class="fas fa-check-circle"></i> You have already verified</h5>
                                </div>
                                <a href="<?php echo e(route('student-attendance-submit.form', $id)); ?>" class="btn btn-success"><i class="fas fa-arrow-right"></i> View Submit Form</a>
                                <a href="<?php echo e(route('student-attendance-verify-form.reload', $id)); ?>" class="btn btn-info"><i class="fas fa-undo"></i> Verify Again</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </section>
    <!--End Pricing Section-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://www.jqueryscript.net/demo/rating-star-icons/dist/rating.js"></script>
<script>
    $("#basic").rating({
        "click": function (e) {
            console.log(e);
            $("#basicInput").val(e.stars);
        }
    });
    $("#half").rating({
    "half": true,
        "click": function (e) {
            console.log(e);
            $("#halfInput").val(e.stars);
        }
    });
  
    
    $(document).ready(function () {
        $("#submitForm").submit(function (e) { 
            e.preventDefault();
            $("#error_message").hide('fast');
            $.post("<?php echo e(route('student-attendance-verify-form.submit', $id)); ?>", $( this ).serialize())

            .done(function(response){
                if(response == 'success'){
                    window.location.href = "<?php echo e(route('student-attendance-submit.form', $id)); ?>";
                }else if(response == 'invalid'){
                    $("#error_message").html('<b>Your NIC, Kiu Email and Student ID not match</b>');
                    $("#error_message").show('fast');
                }
            })
            .fail(function (jqXHR, exception){
                var msg = '';
                  if (jqXHR.status === 0) {
                      msg = 'Not connect.\n Verify Network.';
                  } else if (jqXHR.status == 404) {
                      msg = 'Requested page not found. [404]';
                  } else if (jqXHR.status == 500) {
                      msg = 'Internal Server Error [500].';
                  } else if (exception === 'parsererror') {
                      msg = 'Requested JSON parse failed.';
                  } else if (exception === 'timeout') {
                      msg = 'Time out error.';
                  } else if (exception === 'abort') {
                      msg = 'Ajax request aborted.';
                  } else {
                      msg = 'Uncaught Error.\n' + jqXHR.responseText;
                  }
                  $("#error_message").html(msg);
                  $("#error_message").show('fast');
            });
        });
    });
</script>
</body>

</html>
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/attendance/verify-form.blade.php ENDPATH**/ ?>