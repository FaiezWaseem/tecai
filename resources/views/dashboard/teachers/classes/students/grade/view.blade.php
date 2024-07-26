@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.teachers.sidebar')
@endsection



@section('content')

<style>
    .headerTable {

    }
    .headerTable tr td{
        padding: 0.5rem;
        width: 250px;
        font-weight: bold
    }
    .headerTable tr td:first-child , .cell_bold{
        background: #dc3545;
        color : white;
        font-weight: bold
    }
    tr {
        text-align: center;
    }

</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <table border="1"  class="headerTable">
                        <tbody>
                            <tr>
                                <td >student</td>
                                <td>{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <td >Class</td>
                                <td>{{ $class->class_name }}</td>
                            </tr>
                            <tr>
                                <td  >Course </td>
                                <td>
                                    {{ $course->course_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">student</li>
                        <li class="breadcrumb-item">Grade</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <table style="width : 100%;" border="1">
                <thead>
                    <tr>
                        <th>HEAD</th>
                        <th>TOTAL</th>
                        <th>OBTAINED</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($terms as $item)
                        <tr>


                            <td class="cell_bold" >{{ $item->title }}</td>
                            <td>{{ $item->total }}</td>
                            <td></td>

                        </tr>
                    @endforeach
                    <tr>


                        <td class="cell_bold"  >Total :</td>
                        <td></td>
                        <td>95 - <small>Hardcoded Change it</small></td>

                    </tr>
                </tbody>
            </table>

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
