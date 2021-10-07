<?php 
$pageTitle = "My Profile";
?>
@extends('layouts.master')
@section('content')

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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title myTitle">Main Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <b>Full Name</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->full_name}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Name with Initials</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->name_with_initials}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Date of Birth</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->date_of_birth}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>NIC/Passport</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->nic_passport}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Email Address</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->email}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Current Work Place</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->workPlace->work_place_name}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Work Place Address</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->workplace_address}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Province</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->province->name_en}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>District</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->district->name_en}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Division</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->division->name_en}}
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-2">
                                <b>Designation</b>
                            </div>
                            <div class="col-md-10">
                                : {{$user->designation->designation_name}}
                            </div>
                        </div>
                        @foreach($user->designationFieldsList as $item)
                            <hr/>
                            <div class="row">
                                <div class="col-md-2">
                                    <b>{{$item->designationField->field_name}}</b>
                                </div>
                                <div class="col-md-10">
                                    : {{$item->value}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="card card-lightblue card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-contact-details-tab" data-toggle="pill"
                                    href="#custom-tabs-contact-details" role="tab" aria-controls="custom-tabs-contact-details"
                                    aria-selected="true">Contact Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-bank-details-tab" data-toggle="pill"
                                    href="#custom-tabs-bank-details" role="tab" aria-controls="custom-tabs-bank-details"
                                    aria-selected="true">Bank Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-course-details-tab" data-toggle="pill"
                                    href="#custom-tabs-course-details" role="tab" aria-controls="custom-tabs-course-details"
                                    aria-selected="true">Course Details</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-contact-details" role="tabpanel"
                                aria-labelledby="custom-tabs-contact-details-tab">
                                @foreach($user->contactFieldsList() as $contactField)
                                    @foreach ($contactField->fieldsList as $field)
                                        @foreach($field->representativeFieldsList->where('marketing_representative_id', $user->marketing_representative_id) as $value)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <b>{{$field->field_name}}</b>
                                                </div>
                                                <div class="col-md-10">
                                                    : {{$value->value}}
                                                </div>
                                            </div>
                                            <hr/>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="tab-pane fade show" id="custom-tabs-bank-details" role="tabpanel"
                                aria-labelledby="custom-tabs-bank-details-tab">
                                @foreach($user->bankFieldsList() as $bankField)
                                    @foreach ($bankField->fieldsList as $field)
                                        @foreach($field->representativeFieldsList->where('marketing_representative_id', $user->marketing_representative_id) as $value)
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <b>{{$field->field_name}}</b>
                                                </div>
                                                <div class="col-md-10">
                                                    : {{$value->value}}
                                                </div>
                                            </div>
                                            <hr/>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="tab-pane fade show" id="custom-tabs-course-details" role="tabpanel"
                                aria-labelledby="custom-tabs-course-details-tab">
                                @foreach($user->courseDetails->groupBy('course_id') as $key => $value)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>{{$course->find($key)->abbreviation}}</b>
                                        </div>
                                        <div class="col-md-9">
                                            @foreach ($value as $row)
                                                <span class="badge badge-info" style="font-size: 14px">{{$row->batchType->description}}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        
    });
</script>
@endsection