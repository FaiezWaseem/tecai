@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.teachers.sidebar')
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
                    <table border="1" class="headerTable">
                        <tbody>

                            <tr>
                                <td>Class</td>
                                <td>{{ $class->class_name }}</td>
                            </tr>
                            <tr>
                                <td>Course </td>
                                <td>
                                    {{ $course->course_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">student</li>
                        <li class="breadcrumb-item active">Views</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-body">
                    <form method="POST">
                        {{ csrf_field() }}

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="cell_bold">Student</td>
                                        @foreach ($terms as $item)
                                    <th class="cell_bold">{{ $item->title }} ({{ $item->total }})</td>
                                        @endforeach
                                    <th class="cell_bold">Total</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($students as $item)
                                    <tr>


                                        <td>{{ $item->name }}</td>
                                        @foreach ($terms as $term)
                                            <td>
                                                <input type="number" id="_std_{{ $term->id }}_{{ $item->id }}"
                                                    onkeyup="updateTotal(this, '{{ $term->id }}', '{{ $item->id }}')"
                                                    data-id="{{ $term->id }},{{ $item->id }}"
                                                    max="{{ $term->total }}" min="0" value="0"
                                                    name="_std_{{ $term->id }}_{{ $item->id }}" />
                                            </td>
                                        @endforeach

                                        <td> <input type="number" disabled id="_total_{{ $item->id }}" /> </td>
                                        {{-- <td>
                                            <a
                                                href="{{ route('teacher.class.students.grades.view', ['class_id' => $class->id, 'course_id' => $course->id, 'student_id' => $item->id]) }}">View
                                                Individual</a>
                                        </td> --}}

                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="cell_bold">Student</td>
                                        @foreach ($terms as $item)
                                    <th class="cell_bold">{{ $item->title }} {{ $item->total }}</td>
                                        @endforeach
                                    <th class="cell_bold">Total</th>
                                </tr>

                            </tfoot>
                        </table>
                        <div class="d-flex justify-content-end">
                            <input type="submit" value="SAVE" class="btn btn-danger" style="min-width: 8rem">

                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>
@endsection


@section('footer')
    <script>
        var json = <?php echo json_encode($studentGrades); ?>;
        for (let ac of json) {
            const input = document.getElementById(`_std_${ac.term_id}_${ac.student_id}`)
            input.value = ac.total
            updateTotal(input, ac.term_id, ac.student_id)
        }

        function updateTotal(inputElement, termId, stdId) {
            const finalInput = document.getElementById(`_total_${stdId}`);
            const previousValue = Number(inputElement.dataset.previousValue) || 0;
            const currentValue = Number(inputElement.value);
            const maxValue = Number(inputElement.max);

            // Ensure the current value doesn't exceed the max value
            const newValue = Math.min(currentValue, maxValue);
            inputElement.value = newValue;

            const newTotal = Number(finalInput.value) - previousValue + newValue;
            finalInput.value = newTotal;
            inputElement.dataset.previousValue = newValue;
        }
    </script>
@endsection
