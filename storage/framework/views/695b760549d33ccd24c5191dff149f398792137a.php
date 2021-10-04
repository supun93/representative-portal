<?php 
$pageTitle = "Details";
$nav_slo = "active"
?>

<?php $__env->startSection('content'); ?>
<style>
.bg-info1{
    background-color:#43abfc;
    color:white;
}
.bg-warning1{
    background-color:#f3d74c;
    color:white;
}
.bg-success1{
    background-color:#97d881;
    color:white;
}
.bg-danger1{
    background-color:#fc4349;
    color:white;
}
.bg-gray1{
    background-color:#aaa;
    color:white;
}
hr {
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
}
h6{
    margin-top:10px
}
</style>
<div class="content">
<div class="container-fluid behind">
    <div class="row mb-2">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile Details </li>
              </ol>
        </div>
      </div>
<div class="row">
<?php if($status  == 0): ?>
<div class="card">
<div class="card-body">
No Students
</div>
</div>
</div>
</div>
<?php else: ?>
<!-- /.col -->
<div class="col-md-12">
<div class="card">
        <div class="card-header">
        <div class="row">
        <div class="col-md-6">
            <h4>Registered Details</h4>
        </div>
        <div class="col-md-6">
            <h4 class="float-sm-right">Student No : <?php echo e($student->range_id); ?></h4>
        </div>
        </div>
        </div>
    <div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#">Main</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('details.general')); ?>">General</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo e(route('details.courses')); ?>">Courses</a></li>
    </ul>
    </div><!-- /.card-header -->

    <div class="col-md-12">
        <div class="card-body">
        <div class='row'>
        <div class='col-md-12'>
        <div class='row'>
        <div class='col-md-3'>
        <h6>Title</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->std_title); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Full Name</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->full_name); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=fullname' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>Name with Initials</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->name_initials); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=name_initials' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>Gender</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->gender); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Date of Birth</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->date_of_birth); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Nationality</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->nationality); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>NIC/Passport</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->nic_passport); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Email</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->email1); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=email' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>KIU Email</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->kiu_email); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Mobile No</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->tel_mobile1); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=mobile' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>Tel Residence</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->tel_residence); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Tel Work</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->tel_work); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Permenant Address</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->per_address); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=address' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>Postal Address</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->postal_address); ?></h6><hr/>
        </div>
        <div class='col-md-1'>
        <a href='<?php echo e(route("details-change.main")); ?>?det=postal_address' class='btn btn-xs btn-info'>Change</a>
        </div>
        <div class='col-md-3'>
        <h6>Registration Date</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->reg_date); ?></h6><hr/>
        </div>
        </div>
        </div>
        <div class='col-md-12'>
        <div class='row'>
        <div class='col-md-3'>
        <h6>Permenant Country</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->getCountry->country_name); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Permenant Province
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->permenantProvince->name_en ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Permenant District</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->permenantDistrict->name_en ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Permenant City</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->permenantCity->name_en ?? ''); ?></h6><hr/>
        </div>

        <div class='col-md-3'>
        <h6>Postal Country</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->postalCountry->country_name ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Postal Province
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->postalProvince->name_en ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Postal District</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->postalDistrict->name_en ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Postal City</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->postalCity->name_en ?? ''); ?></h6><hr/>
        </div>
        <div class='col-md-3'>
        <h6>Divisional Secretariat Division</h6>
        </div>
        <div class='col-md-8'>
        <h6>: <?php echo e($student->DivisionalSecretariatDivisionId->name_en ?? ''); ?></h6><hr/>
        </div>

        </div>
        </div>
        </div>
        </div>
    </div>
  
    </div>
      
</div>
<!-- /.col -->
</div>
<?php endif; ?>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/details/main.blade.php ENDPATH**/ ?>