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
                    <h1 class="m-0">School LMS Permissions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Schools</li>
                        <li class="breadcrumb-item">Permission</li>
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

            @foreach ($boards as $item)
            <div class="form-check form-check-inline">
                @php
                    $hasPermission = false;
                    foreach ($permissions as $permission) {
                        if ($permission->board_id === $item->id) {
                            $hasPermission = true;
                            break;
                        }
                    }
                @endphp
                @if ($hasPermission)
                    <input class="form-check-input" type="checkbox" checked
                        data-id="{{ $item->id }}"
                        id="switch{{ $item->id }}"
                        onchange="handleCheckboxChange({{ $item->id }})">
                @else
                    <input class="form-check-input" type="checkbox"
                        data-id="{{ $item->id }}"
                        id="switch{{ $item->id }}"
                        onchange="handleCheckboxChange({{ $item->id }})">
                @endif
                <label class="form-check-label" for="switch{{ $item->id }}">{{ $item->board_name }}</label>
            </div>
        @endforeach


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')
    <script>
        function handleCheckboxChange(checkboxId) {
            var checkbox = $('#switch' + checkboxId);
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(checkbox)
            const isChecked = checkbox.is(':checked');


            // Checkbox is checked, send the AJAX request
            $.ajax({
                url: window.location.href, // Replace with your actual route URL
                type: 'PUT', // Or 'GET' depending on your server-side implementation
                data: {
                    isChecked,
                    board_id: checkboxId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle the response from the server
                    console.log(response);
                    showToast('Updated', '', 'success')
                },
                error: function(xhr) {
                    showToast('Error', xhr.responseText, 'error')
                    console.log('Error', xhr.responseText, 'error')

                }
            });

        }
    </script>
@endsection
