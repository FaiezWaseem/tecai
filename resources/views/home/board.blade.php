@extends('home.common')
@section('title', 'Home Page')
@section('content')




    <!-- **************** MAIN CONTENT START **************** -->
    <main>


        <section class="jd-slider slider2">
            <div class="slide-inner">
              <ul class="slide-area">
                <li>
                  <img src="{{ asset('slider/slider1.jpg') }}" alt="slider 1">
                </li>
                <li style="display: none;">
                  <img src="{{ asset('slider/slider2.jpg') }}" alt="slider 2">
                </li>
                <li style="display: none;">
                  <img src="{{ asset('slider/slider3.jpg') }}" alt="slider 3">
                </li>
              </ul>
              <a class="prev" href="#">
                <i class="fas fa-angle-left fa-2x"></i>
              </a>
              <a class="next" href="#">
                <i class="fas fa-angle-right fa-2x"></i>
              </a>
            </div>
            <div class="controller">
              <a class="auto" href="#">
        
              </a>
              <div class="indicate-area"></div>
            </div>
          </section>

 


        <section class="py-0 py-xl-5">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2>Choose a Class</h2>
                    </div>
                    <div class="col-2">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Home</li>
                            <li class="breadcrumb-item active">{{ $board_name }}</li>
                        </ol>
                    </div> 
                </div>
                <div class="row g-4">
                    @foreach ($classes as $class)
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a
                                href="{{ route('home.board.classes', ['board_id' => $board_id, 'class_id' => $class->id, 'board_name' => $board_name, 'class_name' => $class->class_name]) }}">
                                <div
                                    class="card card-body shadow-sm bg-white bg-opacity-10 text-center position-relative btn-transition">
                                    <!-- Image -->
                                    <div class="bg-body mx-auto">
                                        @if ($class->thumbnail)
                                        <img loading="lazy"
                                            src="{{ Storage::disk('local')->temporaryUrl($class->thumbnail, now()->addMinutes(3)) }}"
                                            alt="thumbnail_image"
                                            class="rounded"
                                            style="max-height: 300px;"
                                            >
                                    @else
                                        <img loading="lazy"
                                            src="https://placehold.co/600x400?text={{ $class->class_name }}"
                                            alt="thumbnail_image">
                                    @endif
                                    </div>
                                    <!-- Title -->
                                    {{-- <h5 class="mb-2"><a
                                            href="{{ route('home.board.classes', ['board_id' => $board_id, 'class_id' => $class->id, 'board_name' => $board_name, 'class_name' => $class->class_name]) }}"
                                            class="stretched-link">{{ $class->class_name }}</a></h5> --}}
                                  
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
        <!-- =======================
    Counter END -->
    </main>

   
@endsection

