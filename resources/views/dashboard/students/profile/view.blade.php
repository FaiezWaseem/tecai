@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection



@section('content')


<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">
                User Profile <small>(Personal Info)</small>
            </h3>
        </div>
    </div>
    <div class="row profile">
        <div class="col-md-12">
            <div class="tabbable tabbable-custom tabbable-full-width">
                <div class="tab-content">
                    <div id="tab_1_3" class="tab-pane active">
                        <div class="row profile-account">
                            <div class="col-md-3">
                                <div class="photo-swipe-image" data-pswp-uid="1">
                                    <a href="/ecoaching/thumbnail/preview/?path={{ $student->photo}}"
                                        itemprop="contentUrl" data-size="1800x2937"><img
                                            class="img-responsive new-img"
                                            width="200px"
                                            src="/ecoaching/thumbnail/preview/?path={{ $student->photo}}">
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1_1">
                                        <div class="portlet">
                                            <div class="portlet-body" style="display: block;">
                                                <table class="table table-hover table-striped table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:20%">
                                                                Father Name : </th>
                                                            <td>
                                                                {{ $student->father_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:20%">
                                                                Name </th>
                                                            <td>
                                                                {{ $student->name }}
                                                            </td>
                                                        </tr>
                        
                                                        <tr>
                                                            <th style="width:20%">
                                                                Class </th>
                                                            <td>
                                                                {{ $student->class }} ({{$student->section}}) </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:20%">
                                                                Student Registration # </th>
                                                            <td>
                                                                {{ $student->admission_no }} </td>
                                                        </tr>

                                                        <tr>
                                                            <th style="width:20%">
                                                                Roll No </th>
                                                            <td>
                                                            </td>
                                                        </tr>
                                                        <tr class="odd">
                                                            <th style="width:20%">
                                                                Username </th>
                                                            <td>
                                                                {{ $student->prefix }}_{{ $student->admission_no }} </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:20%">
                                                                Email </th>
                                                            <td>
                                                                {{ $student->email }}
                                                            </td>
                                                        </tr>
                                                      
                        
                                                        <tr>
                                                            <th style="width:20%">
                                                                Gender </th>
                                                            <td>
                                                                {{ $student->gender }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:20%">
                                                                Date Of Birth </th>
                                                            <td>
                                                                {{ $student->dob }} </td>
                                                        </tr>
                                           
                                                        <tr>
                                                            <th style="width:20%">
                                                                Phone </th>
                                                            <td>
                                                                {{ $student->contact }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:20%">
                                                                 Group </th>
                                                            <td>
                                                                {{ $student->group }}
                                                            </td>
                                                        </tr>
                                                 
                                                  
                           
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-md-9-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const data = <?php echo json_encode(json_decode($student)); ?>;
    console.log(data);
</script>

@endsection