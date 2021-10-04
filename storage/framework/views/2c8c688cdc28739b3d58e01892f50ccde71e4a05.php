
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
    <?php
        $checkRight = 0;
    ?>
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
            margin: 0 0 40px !important;
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
                    <div class="section-heading text-center"><br/>
                    <a><img style="width: 220px" src="/outsideview/images/KIU-Logo.png" class="logo" alt=""></a>
                        <h3>Student Attendance</h3>
                    </div>
                </div>
            </div>
            <?php if($check == 0): ?>
                <div class="alert alert-danger">
                    <h3 style="text-align: center">
                        <i class="fas fa-exclamation-triangle"></i>  You are not in this class
                        <br/><br/>
                        <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                    </h3>
                </div> 
            <?php elseif($submitted != 0): ?>
                <div class="alert alert-success">
                    <h3 style="text-align: center">
                        <i class="fas fa-check"></i>  Attendance submitted successfully
                        <br/><br/>
                        <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                        <?php
                            Session::forget('verifiedStudentId');
                        ?>
                    </h3>
                </div> 
            <?php elseif(date('Y-m-d') > $item->tt_date): ?>
                <div class="alert alert-danger">
                    <h3 style="text-align: center">
                        <i class="fas fa-exclamation-triangle"></i>  You cannot submit attendance for this because class day is now over
                    </h3>
                    <hr/>
                    <p style="color:#a94442; text-align: center">
                        <?php echo e($item->module->module_code); ?> - <?php echo e($item->module->module_name); ?> <br/>
                        <?php echo e($item->academictimetable->academicyear->year_name); ?> - <?php echo e($item->academictimetable->semester->semester_name); ?> <br/>
                        <?php echo e($item->academictimetable->batch->batch_name); ?> <br/>
                        <?php echo e($item->tt_date); ?> | <?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?>

                    </p>
                    <br/>
                    <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                </div> 
            <?php elseif(date('Y-m-d') < $item->tt_date): ?>
                <div class="alert alert-danger">
                    <h3 style="text-align: center">
                        <i class="fas fa-exclamation-triangle"></i> You cannot submit attendance to this class because this class day is not today
                    </h3>
                    <hr/>
                    <p style="color:#a94442; text-align: center">
                        <?php echo e($item->module->module_code); ?> - <?php echo e($item->module->module_name); ?> <br/>
                        <?php echo e($item->academictimetable->academicyear->year_name); ?> - <?php echo e($item->academictimetable->semester->semester_name); ?> <br/>
                        <?php echo e($item->academictimetable->batch->batch_name); ?> <br/>
                        <?php echo e($item->tt_date); ?> | <?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?>

                    </p>
                    <br/>
                    <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                </div> 
            <?php else: ?>
                <?php
                    $startTime = strtotime($item->start_time);
                    $endTime = strtotime($item->end_time);
                    $nowTime = time();
                ?>
                <?php if($startTime > $nowTime): ?>
                <div class="alert alert-danger">
                    <h3 style="text-align: center">
                        <i class="fas fa-exclamation-triangle"></i> You cannot submit attendance to this class because this class not started yet
                    </h3>
                    <p style="color:#a94442; text-align: center">
                        <?php echo e($item->module->module_code); ?> - <?php echo e($item->module->module_name); ?> <br/>
                        <?php echo e($item->academictimetable->academicyear->year_name); ?> - <?php echo e($item->academictimetable->semester->semester_name); ?> <br/>
                        <?php echo e($item->academictimetable->batch->batch_name); ?> <br/>
                        <?php echo e($item->tt_date); ?> | <?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?>

                    </p>
                    <br/>
                    <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                </div>
                <?php elseif($nowTime > $endTime): ?> 
                <div class="alert alert-danger">
                    <h3 style="text-align: center">
                        <i class="fas fa-exclamation-triangle"></i> This class is ended. You cannot submit attendance to this class 
                    </h3>
                    <p style="color:#a94442; text-align: center">
                        <?php echo e($item->module->module_code); ?> - <?php echo e($item->module->module_name); ?> <br/>
                        <?php echo e($item->academictimetable->academicyear->year_name); ?> - <?php echo e($item->academictimetable->semester->semester_name); ?> <br/>
                        <?php echo e($item->academictimetable->batch->batch_name); ?> <br/>
                        <?php echo e($item->tt_date); ?> | <?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?>

                    </p>
                    <br/>
                    <center><a href='http://student.kiu.ac.lk' class="btn btn-default">Close</a></center>
                </div>
                <?php else: ?>
                <?php
                    $checkRight = 1;
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pricing-table text-center">
                            <div class="alert alert-warning">
                                <h6><b>Please submit your attendance before end this class</b></h6>
                                <br/>
                                <center>
                                    <b>Student ID: <?php echo e($studentDetails->range_id); ?><br/>
                                    Student Name: <?php echo e($studentDetails->name_initials); ?></b>
                                </center>
                            </div>
                            <center>
                                <input type="hidden" id="leftTime" value="<?php echo e($endTime - $nowTime); ?>">
                                <span id="time"><h2>00:00:00</h2></span>
                            </center>
                            <div class="pricing-title">
                                <h6>
                                    <?php echo e($item->module->module_code); ?> - <?php echo e($item->module->module_name); ?> <br/>
                                    <?php echo e($item->academictimetable->academicyear->year_name); ?> - <?php echo e($item->academictimetable->semester->semester_name); ?> <br/>
                                    <?php echo e($item->academictimetable->batch->batch_name); ?> <br/>
                                    <?php echo e($item->tt_date); ?> | <?php echo e($item->start_time); ?> - <?php echo e($item->end_time); ?>

                                
                                </h6>
                            </div><br/>
                            <div class="pricing-body" style="padding: 0 5%">
                                <form class="form-label-left input_mask needs-validation" method="post" action="" id="submitForm" novalidate>
                                <?php echo csrf_field(); ?>
                                    
                                    <?php
                                        $x=0;
                                    ?>
                                    <?php $__currentLoopData = $item->lecturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php
                                        $x++;
                                    ?>
                                    <div class="row" style="padding: 10px;border-top:1px solid rgb(224, 220, 220); text-align: left">
                                        <div class="col-md-4" style="padding-top: 10px">
                                        <?php echo e($row->lecturer->name_with_init); ?>

                                            
                                        </div>
                                        <div class="col-md-4">
                                            <span id="half<?php echo e($x); ?>" style="font-size: 1.5em;margin-right: 20px !important" ></span> <span id='rating_html'></span>
                                            <input type="hidden" name="lecturer_id[]" value="<?php echo e($row->lecturer->lecturer_id); ?>">
                                            <input type="hidden" id="basicInput<?php echo e($x); ?>" name="rating[]" required='true'>
                                        </div>
                                        <div class="col-md-4">
                                            <textarea name="note[]" class="form-control" style="height:40px !important" placeholder="Note"></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <br/>
                                    <button type="submit" class="btn btn-success" style="margin-bottom: 20px">Submit Attendance</button>
                                </form>
                            </div>
                            <center><a href='http://student.kiu.ac.lk' class="btn btn-danger">Close</a></center>
                            <br>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
    <!--End Pricing Section-->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
<script src="https://www.jqueryscript.net/demo/rating-star-icons/dist/rating.js"></script>
<script>
    var ratingsCount = "<?php echo e(count($item->lecturers)); ?>";

    <?php if($submitted == 0 && $checkRight == 1): ?>
        <?php for($i = 1; $i <= count($item->lecturers); $i++): ?>
            $("#half<?php echo e($i); ?>").rating({
                "half": true,
                "click": function (e) {
                    $("#basicInput<?php echo e($i); ?>").val(e.stars);
                    if(e.stars <= 1){
                        $("#rating_html").html('<i style="color:#e43636"><i class="fa fa-frown-o"></i> <b>WORST</b></i>');
                    } else if(e.stars <= 2){
                        $("#rating_html").html('<i style="color:#f97332"><i class="fa fa-meh-o"></i> <b>BAD</b></i>');
                    } else if(e.stars <= 3){
                        $("#rating_html").html('<i style="color:#da9701"><i class="fa fa-smile-o"></i> <b>NEUTRAL</b></i>');
                    } else if(e.stars <= 4){
                        $("#rating_html").html('<i style="color:#7bc700"><i class="fa fa-smile-o"></i> <b>GOOD</b></i>');
                    } else if(e.stars <= 5){
                        $("#rating_html").html('<i style="color:#03b500"><i class="fa fa-smile-o"></i> <b>EXCELLENT</b></i>');
                    }
                }
            });
        <?php endfor; ?>
    <?php endif; ?>
      
    function startTimer(duration, display) {
      var timer = duration, hours , minutes, seconds;
      setInterval(function () {
        seconds  = Math.floor(timer % 60);
        minutes  = Math.floor((timer/60) % 60);
        hours = Math.floor((timer/(60*60)));

        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.innerHTML = "<h2>" + hours + " : " +  minutes + " : " + seconds + "</h2>";
        
        if(timer == 0){
          location.reload();
        }
        if (--timer < 0) {
            timer = duration;
        }

      }, 1000);
    }
    
    $(document).ready(function () {

        <?php if($submitted == 0 && $checkRight == 1): ?>
            var leftTime = $("#leftTime").val();
            var fiveMinutes = leftTime;
            display = document.querySelector('#time');
            startTimer(fiveMinutes, display);

            $("#submitForm").submit(function (e) { 
                e.preventDefault();

                var reqlength = $('[required="true"]').length;
                var value = $('[required="true"]').filter(function () {
                    return this.value != '';
                });

                if (value.length>=0 && (value.length !== reqlength)) {
                    $.alert({
                        closeIcon: false,
                        title: 'RATINGS REQUIRED',
                        content: 'Please make sure all lecturers are rated',
                        type: 'red',
                        typeAnimated: true,
                        autoClose: 'ok|5000',
                        icon: '',
                        backgroundDismiss: true,
                        buttons: {
                            ok : {
                            //isHidden: true,
                            text: 'Ok..',
                            btnClass: 'btnClass',
                            close: function () {

                            }
                            }
                        }
                    });
                    return;
                }


                var data = $( this ).serialize();
                $.confirm({
                    title: 'Are you sure?',
                    content: "You won't be able to do this?",
                    backgroundDismissAnimation: 'glow',
                    type: 'orange',
                    typeAnimated: true,
                    autoClose: 'cancel|10000',
                    buttons: {
                        confirm: {
                            text: 'Yes, do it!',
                            btnClass: 'btn-success',
                            keys: ['enter', 'shift'],
                            action: function(){
                                $.post("<?php echo e(route('student-attendance.submit', $id)); ?>", data)
                                .done(function(response){
                                    if(response == 'success'){
                                        location.reload();
                                    }else if(response == 'expire'){
                                        window.location.href = "<?php echo e(route('student-attendance-verify.form', $id)); ?>";
                                    }
                                })
                                .fail(function(error){
                                    alert('error');
                                }); 
                            }
                        },
                        cancel: {
                            text: 'Cancel',
                            btnClass: 'btn-danger',
                            keys: ['esc'],
                            action: function(){
                                
                            }
                        }
                    }
                });  
            });
        <?php endif; ?>
    });

</script>
</body>

</html>
<?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/attendance/submit-form.blade.php ENDPATH**/ ?>