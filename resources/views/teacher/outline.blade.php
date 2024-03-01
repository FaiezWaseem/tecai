@extends('layout')
@section('title', 'Outline')
@section('content')

    <!-- Page Wrapper -->
    <div id="wrapper">



        @include('components.sidebar')


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('components.nav')
                <!-- End of Topbar -->



            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('components.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->



   



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