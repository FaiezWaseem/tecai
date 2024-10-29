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
                    <h1 class="m-0">BULK IMPORT STUDENTS</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.home.view') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item active">import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center mb-4">
                <a href="/student-import.csv" class="btn btn-primary">Download Template CSV</a>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="school_id">School <span class="text-danger">*</span></label>
                        <select class="form-control" name="school_id">
                            <option value="-1">--Select School--</option>
                            @foreach ($schools as $item)
                                <option value="{{ $item->id }}">{{ $item->school_name }}</option>
                            @endforeach
                        </select>
                        <span id="school_id_Error" class="error invalid-feedback hide"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="class">Class <span class="text-danger">*</span></label>
                        <select class="form-control" name="class"></select>
                        <span id="class_Error" class="error invalid-feedback hide"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="section">Sec <span class="text-danger">*</span></label>
                        <input type="text" name="section" class="form-control" id="section" placeholder="Enter Section"
                            maxlength="100">
                        <span id="section_Error" class="error invalid-feedback hide"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="csv_file">Students CSV <span class="text-danger">*</span></label>
                        <input type="file" name="csv_file" class="form-control" id="csv_file" accept=".csv">
                        <span id="csv_file_Error" class="error invalid-feedback hide"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <input type="button" value="CREATE" class="btn btn-success" id="createButton">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {


            function postDataToServer(jsonData) {
                $.ajax({
                    url: window.location.href, // Replace with your server endpoint
                    type: 'POST',
                    data: {
                        students : JSON.stringify(jsonData)
                    }, // Convert the JSON object to a string
                    success: function(response) {
                        // Handle success response
                        alert('students Imported Successfully');
                        console.log('Server response:', response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        alert('Error posting data to the server: ' + error);
                        console.error('Error:', xhr.responseText);
                    }
                });
            }


            // Fetch classes based on selected school
            $('select[name="school_id"]').on('change', function() {
                var schoolId = $(this).val();
                $.ajax({
                    url: "{{ route('schooladmin.school.classes.list') }}",
                    type: 'POST',
                    data: {
                        school_id: schoolId
                    },
                    success: function(response) {
                        var classDropdown = $('select[name="class"]');
                        classDropdown.empty(); // Remove existing options
                        $.each(response, function(index, cls) {
                            classDropdown.append('<option value="' + cls.class_name +
                                '">' + cls.class_name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching classes:', error);
                    }
                });
            });

            // Handle CSV file reading
            $('#createButton').on('click', function() {
                var fileInput = $('#csv_file')[0];
                if (fileInput.files.length === 0) {
                    console.error('No file selected');
                    return;
                }
                var file = fileInput.files[0];

                // Get the selected school ID, class, and section
                var schoolId = $('select[name="school_id"]').val();
                var className = $('select[name="class"]').val();
                var section = $('#section').val();

                // Validation: Check for empty values
                if (!schoolId || schoolId === "-1") {
                    alert('Please select a school.');
                    return;
                }
                if (!className) {
                    alert('Please select a class.');
                    return;
                }
                if (!section) {
                    alert('Please enter a section.');
                    return;
                }


                var headerMapping = {
                    "STD Name": "name",
                    "Father Name": "father_name",
                    "Email": "email",
                    "AdmissionNo": "admission_no",
                    "Group": "group",
                    "DOB": "dob",
                    "Contact": "contact",
                    "Gender": "gender",
                };

                var reader = new FileReader();

                reader.onload = function(event) {
                    var csvContent = event.target.result;
                    var lines = csvContent.split('\n'); // Split content by new lines
                    if (lines.length > 0) {
                        var headers = lines[0].split(','); // Get headers from the first line
                        var jsonData = []; // Array to hold the JSON objects

                        // Loop through the remaining lines to create JSON objects
                        for (var i = 1; i < lines.length; i++) {
                            var line = lines[i].trim(); // Trim whitespace
                            if (line) { // Check if line is not empty
                                var values = line.split(','); // Split the line into values
                                var jsonObject = {
                                    school_id: schoolId,
                                    class_name: className,
                                    section
                                };
                                headers.forEach((header, index) => {
                                    var mappedKey = headerMapping[header
                                        .trim()]; // Get the mapped key
                                    if (mappedKey) {
                                        jsonObject[mappedKey] = values[index] ? values[index]
                                            .trim() : null; // Map header to value
                                    }
                                });
                                jsonData.push(jsonObject); // Add the object to the array
                            }
                        }
                        postDataToServer(jsonData);
                        console.log('CSV as JSON:', jsonData); // Log the resulting JSON
                    } else {
                        alert('No data in CSV file OR Invalid CSV file');
                        console.error('No data in CSV file');
                    }
                };

                reader.onerror = function() {
                    console.error('Error reading file');
                };

                reader.readAsText(file);
            });
        });
    </script>
@endsection
