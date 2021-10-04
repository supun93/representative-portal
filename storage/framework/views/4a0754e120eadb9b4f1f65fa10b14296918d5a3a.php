<?php
$pageTitle = 'Dashboard'; ?>

<?php $__env->startSection('content'); ?>
    <div class="content">
        <div class="container-fluid behind">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('dashbord')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notice Board </li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="card-body row">
                    <div class="col-md-3">
                        <label for="">Category</label>
                        <select name='category_id' id='category_id' class='form-control' required>
                            <option value=''>Select Category</option>
                            <?php $__currentLoopData = $messageCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value='<?php echo e($index->category_id); ?>'><?php echo e($index->category_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="">Category Title</label>
                        <div class="input-group mb-3">
                            <select name='category_title_id' id='category_title_id' class='form-control' required>
                                <option value='' categoryid="none">Select Category Title
                                </option>
                                <?php $__currentLoopData = $messageCategoryTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value='<?php echo e($index->title_id); ?>' categoryid="<?php echo e($index->category_id); ?>">
                                        <?php echo e($index->title_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button class="btn btn-primary input-group-append" id='load'>Load</button>
                        </div>
                    </div>

                </div>
                <div id="table-data">
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 connectedSortable ui-sortable">
                            <!-- Notice Board  -->

                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    Notice Board
                                </h3>

                                <div class="card-tools" id="paginate_buttons">
                                    <?php echo e($notice->links()); ?>

                                </div>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body" id="notice_board_div">
                                <ul class="todo-list ui-sortable" data-widget="todo-list">

                                    <?php $__currentLoopData = $notice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if ($notice->view == 0) {
                                        $status = '<small class="badge badge-success"
                                            id="message_status' . $notice->notice_id . '">Unread</small>';
                                        } else {
                                        $status = '';
                                        } ?>
                                        <li>
                                            <!-- drag handle -->
                                            <input type='hidden' class='message_id' value='<?php echo e($notice->notice_id); ?>'>
                                            <input type='hidden' class='read_status' value='<?php echo e($notice->view); ?>'>
                                            <a class='readMessage' href='#'>
                                                <span class="handle ui-sortable-handle">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </span>
                                                <!-- todo text -->
                                                <span class="text"><?php echo e($notice->category->category_name); ?> -
                                                    <?php echo e($notice->categoryTitle->title_name); ?> -
                                                    <?php echo e($notice->notice_title); ?></span>
                                                <!-- Emphasis label -->
                                                <small class="badge badge-danger"><i class="far fa-clock"></i>
                                                    <?php echo e($notice->notice_date); ?></small> <?php echo $status; ?>

                                                <!-- General tools such as edit or delete-->
                                            </a>
                                        </li>

                                        <div class="collapse direct-chat-text" id="demo<?php echo e($notice->notice_id); ?>">
                                            <?php echo e($notice->notice_title); ?>

                                            <?php echo $notice->notice_text; ?>

                                            <?php $attachments = App\NoticeAttachments::where('notice_id',
                                            '=', $notice->slo_notice_id)->get(); ?>
                                            <?php if(count($attachments) != 0): ?>
                                            <?php endif; ?>
                                            <?php $x = 1; ?>
                                            <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(ENV('MAIN_LINK_URL')); ?>/storage/<?php echo e($item->file); ?>"
                                                    target="_black">Attachment <?php echo e($x); ?></a><br />
                                                <?php $x++; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <!-- right col -->
                </div>

            </div>

        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo e(asset('/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $("#category_title_id").children('option').hide();

            $("#category_id").change(function() {
                $('#category_title_id').prop('selectedIndex', 0);
                $("#category_title_id").children('option').hide();
                $("#category_title_id").children("option[categoryid^=none]").show();
                $("#category_title_id").children("option[categoryid^=" + $(this).val() + "]").show();
            });

            function loadData(page, category_id, category_title_id) {
                $.ajax({
                    url: "/noticeboard/load",
                    type: "GET",
                    cache: false,
                    data: {
                        page: page,
                        category_id: category_id,
                        category_title_id: category_title_id
                    },
                    success: function(response) {
                        $("#table-data").html(response);
                    }
                });
            }

            $(document).on("click", ".pagination li a", function(e) {
                e.preventDefault();
                var pageId = $(this).html();
                var category_id = $("#category_id").val();
                var category_title_id = $("#category_title_id").val();
                loadData(pageId, category_id, category_title_id);
            });

            $(document).on("click", "#load", function(e) {
                e.preventDefault();
                var pageId = 1;
                var category_id = $("#category_id").val();
                var category_title_id = $("#category_title_id").val();
                var category_id = $("#category_id").val();
                var category_title_id = $("#category_title_id").val();
                if (category_id == "" && category_title_id == "") {
                    //return;
                }
                loadData(pageId, category_id, category_title_id);
            });

            $("select").change(function(e) {
                e.preventDefault();
                $("#paginate_buttons").hide();
            });

            $(".readMessage").click(function() {

                var selection = $("#selection").val();
                var li = $(this).closest("li"), // Finds the closest row <tr>
                    id = li.find(".message_id").val();

                read_status = li.find(".read_status").val();
                if (read_status == 0) {
                    if (selection == '0') {
                        loadSpin.toggle();
                    }
                    $.ajax({
                        type: 'GET',
                        url: "<?php echo e(route('message.read', '')); ?>/" + id
                    }).then(function(data) {

                        $("#demo" + id).slideToggle("fast");
                        if (selection == '0') {
                            loadSpin.toggle();
                            $("#selection").val(3);
                        } else {
                            $("#selection").val(0);
                        }
                        li.find(".read_status").val(1);
                        $("#message_status" + id).html('');
                    });
                } else {
                    $("#demo" + id).slideToggle("fast");
                }
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xamppp\htdocs\push student portal\kiu-student-portal\resources\views/noticeboard/view.blade.php ENDPATH**/ ?>