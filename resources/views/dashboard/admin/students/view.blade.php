@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.admin.sidebar')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Students View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Students</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Actions</th>
                                <th>Regno</th>
                                <th>Photo</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Sec</th>
                                <th>DOB</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>School Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Actions</th>
                                <th>Regno</th>
                                <th>Photo</th>
                                <th>Student Name</th>
                                <th>Father Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Sec</th>
                                <th>DOB</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>School Name</th>
                                <th>Created At</th>
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
        const path = "{{ route('schooladmin.students.edit', ['id' => 3]) }}";
        console.log(path)
        setTimeout(() => {
            showLoader(true)
            fetchRecords()
        }, 1000);

        const fetchRecords = async () => {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            console.log(csrfToken)
            $.ajax({
                url: '{{ route('schooladmin.students.view') }}', // Current page URL
                type: 'POST', // or 'GET', 'PUT', etc. depending on your needs
                data: {
                    _token: csrfToken, // Include the CSRF token in the request data
                },
                dataType: 'json', // Specify the expected response data type
                success: function(data) {
                    // Handle the response from the server

                    console.log(data)
                    loadInTable(data.students)

                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the request
                    console.error(error);
                    alert('Failed to fetched Departments :  ERROR : ' + error)
                }
            });

        }

        const loadInTable = (json) => {
            const table = $('#example1 tbody');
            const size = json.length;
            console.log(size)

            for (let i = 0; i < size; i++) {
                const student = json[i];
                const row = $('<tr>');
                const actions = $('<td>').html(`
                    <a href="${replaceNumberInUrl(path , student.id)}">
                                        <i class="fa fa-edit text-primary"  ></i>
                                    </a>
                                    <button class="btn" data-toggle="modal" data-target="#DeleteModal" onclick="setdeleteModalId(${student.id})">
                                        <i class="fa fa-trash text-danger"  ></i>
                                    </button>
                    `);
                const cell0 = $('<td>').text(student.prefix+"_"+student.admission_no);
                const cell1 = $('<td>').html(`<img src="/ecoaching/thumbnail/preview/?path=${student.photo}" width="80px" height="80px" />`);
                const cell2 = $('<td>').text(student.name);
                const cell3 = $('<td>').text(student.father_name);
                const cell4 = $('<td>').text(student.email);
                const cell5 = $('<td>').text(student.class);
                const cell6 = $('<td>').text(student.section);
                const cell7 = $('<td>').text(student.dob);
                const cell8 = $('<td>').text(student.contact);
                const cell9 = $('<td>').text(student.gender);
                const cell10 = $('<td>').text(student.school_name);
                const cell11 = $('<td>').text(student.created_at);


                row.append(actions, cell0, cell1, cell2, cell3, cell4, cell5, cell6, cell7, cell8, cell9, cell10,
                    cell11);
                // Append the row to the table
                table.append(row);
            }
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            });
            showLoader(false)
        }
    </script>
@endsection
