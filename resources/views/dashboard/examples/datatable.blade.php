@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.superadmin.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">School Admin View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Admins</li>
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
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">School Admins</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Sec</th>
                                <th>School Name</th>
                                <th>Gender</th>
                                <th>CreatedAt</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Id</th>
                                <th>Photo</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Sec</th>
                                <th>School Name</th>
                                <th>Gender</th>
                                <th>CreatedAt</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        setTimeout(() => {
            showLoader(true)
            fetchRecords()
        }, 1000);

        const fetchRecords = async () => {
            const response = await fetch('ViewActiveRecords.json')
            const json = await response.json()
            console.log(json.Data)
            await loadInTable(json.Data)
        }

        const loadInTable = (json) => {
            const table = $('#example1 tbody');
            const size = json.length;
            console.log(size)
            for (let i = 0; i < size; i++) {
                const student = json[i];
                const row = $('<tr>');
                const actions = $('<td>').text('');
                const cell0 = $('<td>').text('');
                const cell1 = $('<td>').text('');
                const cell2 = $('<td>').text(student.StudentName);
                const cell3 = $('<td>').text(student.FatherName);
                const cell4 = $('<td>').text(student.ClassName);
                const cell5 = $('<td>').text(student.StudentEmail);
                const cell6 = $('<td>').text(student.Section);
                const cell7 = $('<td>').text(student.SchoolName);
                const cell8 = $('<td>').text(student.Gender);
                const cell9 = $('<td>').text(student.CreatedAt);


                row.append( actions, cell0, cell1, cell2, cell3, cell4, cell5, cell6 , cell7, cell8 , cell9);
                // Append the row to the table
                table.append(row);
            }
            $(function() {
              $("#example1").DataTable({
                  "responsive": true,
                  "lengthChange": false,
                  "autoWidth": false,
                  "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
              }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

          });
            showLoader(false)
        }
    </script>
@endsection
