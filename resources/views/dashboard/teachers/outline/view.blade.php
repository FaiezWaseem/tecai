@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.teachers.sidebar')
@endsection

@section('content')


    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 ">
                <h6 class="m-0 font-weight-bold text-primary">Subject Outline</h6>
            </div>
            <div class="card-body" id="form-list">

                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Class</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="staticEmail" name="class_name" required
                            value="{{ $className }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Subject Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="staticEmail" name="subject_name" required
                            value="{{ $courseName }}" readonly>
                    </div>
                </div>

                <form method="POST" id="my-form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="subjects">Chapter</label>
                            <input type="text" class="form-control" id="staticEmail" name="topic_chapter" required>

                        </div>
                        <div class="col-4 form-group">
                            <label for="subjects">Topic Title</label>
                            <input type="text" class="form-control" id="staticEmail" name="topic_title" required>
                        </div>
                        <div class="col-2 form-group">
                            <label for="subjects">Date</label>
                            <input type="date" class="form-control" id="staticEmail" name="topic_deadline" required>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <input type="submit" value="Add" class="btn btn-primary">
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Chapter</th>
                                <th>Topic</th>
                                <th>Deliver Date</th>
                                <th>Covered</th>
                                <th>Remove</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Chapter</th>
                                <th>Topic</th>
                                <th>Deliver Date</th>
                                <th>Covered</th>
                                <th>Remove</th>
                            </tr>
                        </tfoot>
                        <tbody id="courses">

                            @foreach ($outline as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->chapter }} </td>
                                    <td> {{ $course->title }} </td>
                                    <td> {{ $course->deliver_date }} </td>
                                    <td>
                                        <div class="form-check">
                                            @if ($course->is_covered == 0)
                                                <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Not Covered
                                                </label>
                                            @else
                                                <input class="form-check-input" type="checkbox" checked="true"
                                                    id="flexCheckDefault" disabled="true">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Covered
                                                </label>
                                            @endif


                                        </div>
                                    </td>
                                    <td>
                                        @if ($course->is_covered == 0)
                                            <button id="delete" data-id="{{ $course->id }}"
                                                onclick="deleteClicked(this)" class="btn submit-button">
                                                <i class="fa fa-trash-alt" style="color : red;"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>


            </div>
        </div>





    </div>
    <!-- /.container-fluid -->


    <!-- /.content -->
@endsection


@section('footer')


<script>
         function deleteClicked(e) {
            var id = $(e).attr('data-id');
            console.log(id)
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Send AJAX delete request
            $.ajax({
                url: window.location.href, // Replace with your actual delete endpoint
                method: 'DELETE',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle successful response
                    showToast('Delete request', 'Delete request successful' ,'success');

                    // Optionally, you can remove the element from the DOM
                    $(e).closest('tr').remove();
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    showToast('AJAX delete request error:', status, 'error');
                }
            });
        };
</script>

@endsection