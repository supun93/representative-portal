<?php
    $pageTitle = "Timetable";
?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <style type="text/css">
            #warning-message {
                display: none;
            }

            @media  only screen and (orientation: portrait) {
                #wrapper {
                    display: none;
                }

                #warning-message {
                    display: block;
                }
            }

            @media  only screen and (orientation: landscape) {
                #warning-message {
                    display: none;
                }
            }
        </style>
        <div id="wrapper" class="container-fluid behind">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">TimeTable</li>
                    </ol>
                </div>
            </div>
        </div>

        <div id="warning-message">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                View Timetable Clearly Rotate your Screen to Landscape Mode
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo e($exportUrl); ?>" id="create_form" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h4 class="header-title">
                                        Timetable
                                    </h4>
                                </div>
                                <div class="col-sm-4">
                                    <div class="float-right">
                                        <div class="btn btn-success btn-add-row" onclick="return exportTimetable();">
                                            <span class="fa fa-file-excel"></span> Export
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Academic Year</label>
                                        <input type="text" class="form-control" name="academic_year_id" placeholder="Select Academic Year">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Semester</label>
                                        <input type="text" class="form-control" name="semester_id" placeholder="Select Semester">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date From</label>
                                                <input type="text" class="form-control date-picker" name="date_from">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date Till</label>
                                                <input type="text" class="form-control date-picker" name="date_till">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group display-flex justify-content-center">
                                        <div class="btn btn-success" style="margin-top: 30px;" onclick="return filterTimetable();">Filter Timetable</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="group_id" value="<?php echo e($groupId); ?>">
                    <input type="hidden" name="upcoming_only" value="<?php echo e($upcomingOnly); ?>">
                </form>

                <div id="timetable-form">
                    <main-component ref="comp"></main-component>
                </div>
            </div>
        </div>
    </div>

    <script>
        let academic_year_id_ms = null;
        let semester_id_ms = null;
        let vueApp = null;

        $(document).ready(function () {
            vueApp = new Vue({
                components: {"main-component": StudentTimetable}
            }).$mount('#timetable-form');

            filterTimetable();

            $(".date-picker").datepicker({
                format	: "yyyy-mm-dd",
                orientation: 'top'
            });

            academic_year_id_ms = $("input[name='academic_year_id']").magicSuggest({
                allowFreeEntries: false,
                toggleOnClick: true,
                maxSelection:1,
                data: "/academic_year/search_data",
                dataUrlParams:{"_token":"<?php echo e(csrf_token()); ?>", "limit" : "0"},
            });

            semester_id_ms = $("input[name='semester_id']").magicSuggest({
                allowFreeEntries: false,
                toggleOnClick: true,
                maxSelection:1,
                data: "/academic_semester/search_data",
                dataUrlParams:{"_token":"<?php echo e(csrf_token()); ?>", "limit" : "0"},
            });
        });

        function pushData(data) {

            vueApp.$refs.comp.pushData(data)
        }

        function exportTimetable() {

            $("#create_form").submit();
        }

        function filterTimetable() {
            //show preloader
            showPreloader($('#create_form'), true);

            $.ajax({
                url: "/timetable/get_timetable",
                type: "POST",
                dataType: "json",
                data: $('#create_form').serialize(),
                success: serverResponse,
                error: onError
            });
        }

        function serverResponse(responseText) {
            //Hide preloader
            hidePreloader($('#create_form'));
            $('#create_form button[type="submit"]').removeAttr("disabled");

            if (responseText.notify.status && responseText.notify.status === "success") {
                if (responseText.data) {
                    pushData(responseText.data);
                }
            } else {
                showNotifications(responseText.notify)
            }
        }

        function onError() {
            //Hide preloader
            hidePreloader($("#create_form"));
            $('#create_form button[type="submit"]').removeAttr("disabled");

            let errorText = [];
            let errorData = [];

            errorText.push('Something went wrong. Please try again.');

            errorData.status = "warning";
            errorData.notify = errorText;

            showNotifications(errorData)
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/erpv2std.kiu.lk/resources/views/timetable/view.blade.php ENDPATH**/ ?>