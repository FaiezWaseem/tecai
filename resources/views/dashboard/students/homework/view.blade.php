@extends('dashboard.common')

@section('sidebar')
    @include('dashboard.students.sidebar')
@endsection

@section('content')

<style>
    .card-notice {

        text-decoration: none;
        color: #000;
        background: #ffc;
        display: block;
        height: auto;
        padding: 0.7em;
        -moz-box-shadow: 5px 5px 7px rgba(33, 33, 33, 1);
        -webkit-box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
        box-shadow: 5px 5px 7px rgba(33, 33, 33, .7);
        -moz-transition: -moz-transform .15s linear;
        -o-transition: -o-transform .15s linear;
        -webkit-transition: -webkit-transform .15s linear;
        word-wrap: break-word;

    }

    .card-notice:hover {
        transform: rotate(-2deg);
        cursor: pointer;
    }
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">HomeWorks View</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Student</li>
                        <li class="breadcrumb-item">HomeWork</li>
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
                    <h3 class="card-title">CONTENT</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row gap-2">

                        @foreach ($content as $item)
                        <div class="card-notice col-md-4 mx-2 my-3" data-toggle="modal" data-target="#contentModal" 
                             data-content="{{ $item->content }}" 
                             data-date="{{ \Carbon\Carbon::parse($item->date)->format('d-m-y') }}" 
                             data-image="{{ $item->image ? Storage::disk('local')->temporaryUrl($item->image, now()->addMinutes(3)) : '' }}">
                            <p>
                                @if ($item->image)
                                    <img src="{{ Storage::disk('local')->temporaryUrl($item->image, now()->addMinutes(10)) }}"
                                         alt="thumbnail_image" loading='lazy' width="100%" height="300px">
                                @endif
                            </p>
                            <p>{{ $item->content }}</p>
                            <p>Date: {{ \Carbon\Carbon::parse($item->date)->format('d-m-y') }}</p>
                        </div>
                    @endforeach
                    
              
                    </div>
                 
                </div>
                <!-- /.card-body -->
            </div>

                  <!-- Modal -->
                  <div class="modal fade" id="contentModal" tabindex="-1" role="dialog" aria-labelledby="contentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="contentModalLabel">Homework Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img id="modalImage" src="" alt="Homework Image" class="img-fluid" style="display: none;">
                                <p id="modalContent"></p>
                                <p id="modalDate"></p>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- /.row -->
            <!-- Main row -->

            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@section('footer')

    <script>
        $(document).ready(function() {
            $('.card-notice').on('click', function() {
                const content = $(this).data('content');
                const date = $(this).data('date');
                const image = $(this).data('image');
    
                $('#modalContent').text(content);
                $('#modalDate').text('Date: ' + date);
                if (image) {
                    $('#modalImage').attr('src', image).show();
                } else {
                    $('#modalImage').hide();
                }
            });
        });
    </script>
@endsection
