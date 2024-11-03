        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Exam Results</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    padding: 0;
                }
                .header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                h1 {
                    margin: 0;
                    font-size: 24px;
                }
                h2 {
                    margin: 10px 0;
                    font-size: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .section {
                    margin-bottom: 40px;
                }
                .chart-container {
                    width: 50%;
                    margin: 0 auto;
                }
            </style>
        </head>
        <body>

          

            @if ($result->isEmpty())
                <p>No results found.</p>
            @else
                @foreach ($result as $examResult)
                    <div class="header">
                    <h1>{{ $examResult->school_name }}</h1>
                    </div>
                    <div class="section">

                        <p><strong>Student:</strong> {{ $examResult->student_name }}</p>
                        <p><strong>Class:</strong> {{ $examResult->class }} <strong>Section:</strong> {{ $examResult->section }}</p>

                        <h3>Subject Result</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Total Questions</th>
                                    <th>Total Correct Answers</th>
                                    <th>Total Incorrect Answers</th>
                                    <th>Total Unanswered</th>
                                    <th>Total Marks</th>
                                    <th>Marks Obtained</th>
                                    <th>Result Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $examResult->subject_name }}</td>
                                    <td>{{ $examResult->total_question }}</td>
                                    <td>{{ $examResult->total_correct_answer }}</td>
                                    <td>{{ $examResult->total_incorrect_answer }}</td>
                                    <td>{{ $examResult->not_answer }}</td>
                                    <td>{{ $examResult->total_mark }}</td>
                                    <td>{{ $examResult->total_obtain_mark }}</td>
                                    <td>{{ $examResult->result_status }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3>Test Information</h3>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Exam Name</th>
                                    <td>{{ $examResult->exam_name }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $examResult->ex_start_date }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $examResult->ex_end_date }}</td>
                                </tr>
                                <tr>
                                    <th>Start Time</th>
                                    <td>{{ $examResult->start_time }}</td>
                                </tr>
                                <tr>
                                    <th>End Time</th>
                                    <td>{{ $examResult->end_time }}</td>
                                </tr>
                                <tr>
                                    <th>Test Duration</th>
                                    <td>{{ $examResult->ex_duration }} Minute</td>
                                </tr>
                                <tr>
                                    <th>Passing Marks</th>
                                    <td>{{ $examResult->ex_pass_mark }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                                    <canvas id="pieChart" height="200" width="200"></canvas>
                                </div>
                @endforeach
            @endif

            <!-- Chart Container -->
            <div class="chart-container">
                <canvas id="pieChart" height="200"></canvas>
            </div>

            <!-- Include Chart.js Library -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Prepare data for the pie chart
                const totalCorrect = {{ $result->sum('total_correct_answer') }};
                const totalIncorrect = {{ $result->sum('total_incorrect_answer') }};
                const totalUnanswered = {{ $result->sum('not_answer') }}; // Total unanswered questions
                const labels = ['Correct', 'Incorrect', 'Unanswered']; // Pie chart labels

                // Pie Chart
                const ctxPie = document.getElementById('pieChart').getContext('2d');
                const pieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Answer Distribution',
                            data: [totalCorrect, totalIncorrect, totalUnanswered],
                            backgroundColor: [
                                'rgba(0,128,0)', // Green for correct answers
                                'rgb(255, 0, 0)',  // Red for incorrect answers
                                'rgba(255, 255, 0)' // Yellow for unanswered questions
                            ],
                            borderColor: [
                                'rgba(255, 255, 255, 1)',
                                'rgba(255, 255, 255, 1)',
                                'rgba(255, 255, 255, 1)' // Same border for all sections
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            </script>
        </body>
        </html>
