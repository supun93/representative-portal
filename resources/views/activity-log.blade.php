<?php 
$pageTitle = "Activity Log";
?>
@extends('layouts.master')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

<section class="content">
    <div class="container-fluid">

        <div class="card"> 
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h4 class="header-title">{{$pageTitle}}</h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <a href="/" class="btn btn-info"><span class="fa fa-home"></span> Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
            
                <table id='empTable' class='display dataTable'>
            
                    <thead>
                      <tr>
                        <th>Login Time</th>
                        <th>Ip Address</th>
                        <th>Browser</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $('#empTable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'csv', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'excel', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'pdf', className: 'btn btn-info btn-sm mb-2' },
                { extend: 'print', className: 'btn btn-info btn-sm mb-2' },
            ],
            "lengthMenu": [[10, 25, 50, 100, 10000], [10, 25, 50, 100, "All"]],
            'processing': false,
            'serverSide': true,
            'searching': false,
            'serverMethod': 'post',
            'ajax': {
                'url': "{{route('activity-log-list.load')}}",
                'data': {
                    "_token": "{{ csrf_token() }}",
                },
                'beforeSend': function(e){
                    //loadSpin.open();
                }
            },
            'columns': [
                { data: 'Login Time' },
                { data: 'Ip Address' },
                { data: 'Browser' },
            ]
        }).on('draw.dt', function () {
            //loadSpin.close();
        });
    });
</script>
@endsection