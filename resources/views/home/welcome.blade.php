@extends('home.common')
@section('title', 'Home Page')
@section('content')
    <!-- **************** MAIN CONTENT START **************** -->
    <main>

        <style>

            .hero .container {

                background-image: url("{{ asset('images/home_bg.jpg') }}");
                background-size: cover;
                background-position: center;
                /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
     

                min-height: 500px;

                /* max-width: 95%; */
                /* Set the desired maximum width */
                margin: 0 auto;
            }
            .hero {
                padding-top: 1rem;
            }
            .hero .container{
                display: flex;
                align-items: center;
                padding : 1rem;
            }
            .hero-child{
                display: flex;
                align-items: center
            }
        </style>
      <section class="hero">
        <div class="container rounded">
            <div class="row hero-child">
               
            </div>
        </div>
    </section>


        <section class="py-0 py-xl-5">
            <div class="container">
                <h1>Boards</h1>
            </div>
        </section>

        <!-- =======================
                        Counter START -->
        <section class="py-0 py-xl-5">
            <div class="container">
                <style>
                    .course-count {
                        bottom: 30%;
                    }
                </style>
                <div class="row g-4">
                    @php
                        $icons = ['fas fa-user-graduate', 'fas fa-book', 'fas fa-chalkboard-teacher', 'fas fa-flask'];
                        $backgroundColors = ['bg-primary', 'bg-danger', 'bg-success', 'bg-info'];
                    @endphp

                    @foreach ($boards as $index => $board)
                        @php
                            $iconIndex = $index % count($icons);
                            $bgColorIndex = $index % count($backgroundColors);
                            $iconClass = $icons[$iconIndex];
                            $bgColorClass = $backgroundColors[$bgColorIndex];
                        @endphp

                        <div class="col-sm-6 col-xl-3">
                            <a href="{{ route('home.board', ['id' => $board->id, 'board_name' => $board->board_name]) }}">
                                <div
                                    class="position-relative d-flex justify-content-center align-items-center p-4 bg-transparent bg-opacity-10 rounded-3 flex-column">
                                    <span
                                        class="fs-1 lh-1 mb-0 p-4 rounded {{ $bgColorClass }} w-75 d-flex justify-content-center align-items-center"
                                        style="min-height: 160px">
                                        <i class="{{ $iconClass }} text-light"></i>
                                    </span>
                                    <div
                                    style="border-radius: 20px"
                                        class="course-count position-absolute bg-white bottom-5 shadow-sm py-2 text-black px-4 rounded-10">
                                        4 Courses
                                    </div>
                                    <div class="h6 fw-normal mb-0">
                                        <p class="mb-0 mt-5 fs-5">{{ $board->board_name }}</p>
                                    </div>
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
