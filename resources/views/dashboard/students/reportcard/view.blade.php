@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection



@section('content')
    <style>
        .headerTable {}

        .headerTable tr td {
            padding: 0.5rem;
            width: 250px;
            font-weight: bold
        }

        .headerTable tr td:first-child,
        .cell_bold {
            background: #dc3545;
            color: white;
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
                    <h1 class="m-0">ReportCard View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item">ReportCard</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <section class="content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-body">
                    <div class="row">

                        @foreach ($terms as $term)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-center mt-5">
                                    <h3>{{ $term->title }}</h3>
                                </div>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="cell_bold">Subject</td>
                                            <th class="cell_bold">Maximum Marks</th>
                                            <th class="cell_bold">Obtained Marks</th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                        @foreach ($courses as $item)
                                            <tr>
                                                <td>{{ $item->course_name }}</td>
                                                <td>{{ $term->total }}</td>
                                                <td>
                                                    @php
                                                        $total = 0;
                                                        $rec = DB::table('student_grade')
                                                            ->where('course_id', $item->id)
                                                            ->where('student_id', session('user')['id'])
                                                            ->where('term_id', $term->id)
                                                            ->first();
                                                        if (isset($rec)) {
                                                            $total = $rec->total;
                                                        }

                                                    @endphp
                                                    {{ $total }}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="cell_bold">Subject</td>
                                            <th class="cell_bold">Maximum Marks</th>
                                            <th class="cell_bold">Obtained Marks</th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection



@section('footer')
    <script>
        // const terms = @json($terms);
        // const courses = @json($courses);

        // const user = @json(session('user'));

        // console.clear()

        // console.log(terms);
        // console.log(courses);
        // console.log(user);
    </script>
@endsection
