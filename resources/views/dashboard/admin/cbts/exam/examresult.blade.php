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
                    <h1 class="m-0">CBTS Exam View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">CBTS</li>
                        <li class="breadcrumb-item">Exam</li>
                        <li class="breadcrumb-item active">Result</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-info text-white text-center">
                    <h3 class="card-title">School Result Card</h3>
                </div>
                <div class="card-body">
                    @if ($result->isEmpty())
                        <p class="text-center">No results found.</p>
                    @else
                        @foreach ($result as $examResult)
                            <div class="result-card mb-4 p-4 border rounded text-center">
                                <!-- School and Exam Name -->
                                <h2 class="font-weight-bold">{{ $examResult->school_name }}</h2>
                                <h4 class="font-weight-bold">{{ $examResult->exam_name }}</h4>

                                <!-- Student and Exam Details -->
                                <h5 class="font-weight-bold mt-4">Student and Exam Details</h5>
                                <p><strong>Student:</strong> {{ $examResult->student_name }}</p>
                                <p><strong>Class:</strong> {{ $examResult->class }} <strong>Section:</strong> {{ $examResult->section }}</p>
                                <p><strong>Subject:</strong> {{ $examResult->subject_name }}</p>
                                <p><strong>Chapter:</strong>
                                @foreach ($examchapter as $chapter)
                                @if ($chapter->exam_id == $examResult->exam_id)
                                {{ $chapter->chapter_name }}
                                @endif
                                @endforeach
                                </p>
                                <!-- Performance Summary -->
                                <h5 class="font-weight-bold mt-4">Performance Summary</h5>
                                <p><strong>Total Questions:</strong> {{ $examResult->total_question }}</p>
                                <p><strong>Total Correct Answers:</strong> {{ $examResult->total_correct_answer }}</p>
                                <p><strong>Total Incorrect Answers:</strong> {{ $examResult->total_incorrect_answer }}</p>
                                <p><strong>Total Marks:</strong> {{ $examResult->total_mark }}</p>
                                <p><strong>Total Obtained Marks:</strong> {{ $examResult->total_obtain_mark }}</p>
                                <p><strong>Result Status:</strong> {{ $examResult->result_status }}</p>
                            </div>
                        @endforeach
                    @endif

                    <!-- Small Charts -->
                    <h5 class="font-weight-bold mt-4">Performance Charts</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="barChart" height="200" width="200"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="pieChart" height="200" width="200"></canvas>
                        </div>
                        <a href="{{ route('schooladmin.cbts.exam.results.pdf', ['exam_id' => $exam_id]) }}" class="btn btn-primary mb-3">Download PDF</a>

                    </div>
                </div>
            </div>
            <!-- /.card -->
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

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(function() {
            // Initialize DataTable
            $("#example1").DataTable({
                "responsive": true,
                "info": false,
                "autoWidth": false,
                paging: false,
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Prepare data for charts
            const totalCorrect = {{ $result->sum('total_correct_answer') }};
            const totalIncorrect = {{ $result->sum('total_incorrect_answer') }};
            const labels = ['Correct', 'Incorrect'];

            // Bar Chart
            const ctxBar = document.getElementById('barChart').getContext('2d');
            const barChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Total Correct', 'Total Incorrect'],
                    datasets: [{
                        label: 'Answers',
                        data: [totalCorrect, totalIncorrect],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',  // Light Blue
                            'rgba(255, 99, 132, 0.6)'    // Light Red
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',      // Dark Blue
                            'rgba(255, 99, 132, 1)'       // Dark Red
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                display: false // Hide y-axis labels
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 12 // Smaller x-axis labels
                                }
                            }
                        }
                    },
                    maintainAspectRatio: false // Allows the chart to fill its container
                }
            });

            // Pie Chart
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Answer Distribution',
                        data: [totalCorrect, totalIncorrect],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',  // Light Blue
                            'rgba(255, 205, 86, 0.6)'    // Light Yellow
                        ],
                        borderColor: [
                            'rgba(255, 255, 255, 1)',
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false // Allows the chart to fill its container
                }
            });
        });
    </script>
    
@endsection
