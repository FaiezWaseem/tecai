@extends('home.common')
@section('title', 'Home Page')
@section('content')
    <!-- **************** MAIN CONTENT START **************** -->
    <main>



        <div style="width: 100%; height: 0; padding-bottom: 40%; position: relative;">
            
            <img src="{{ route('school.banner') }}"
            style="position: absolute; width: 100%; height: 100%; object-fit: contain;"
            usemap="#image-map">
            {{-- <img src="{{ asset('bg.jpg') }}"
            style="position: absolute; width: 100%; height: 100%; object-fit: contain;"
            usemap="#image-map"> --}}

            <map name="image-map">
                <area target="" alt="login" title="login" href="/login" coords="1400,53,1531,116" shape="rect">
                <area target="" alt="Home" title="Home" href="/" coords="420,116,338,77,580,118"
                    shape="rect">
                <area target="" alt="Home" title="Home" href="/" coords="50,19,304,145" shape="rect">
            </map>
        </div>

        <section class="py-0 py-xl-5">
            <div class="container">
                <div class="row g-4">
                    @foreach ($boards as $board)
                        <div class="col-sm-6 col-xl-3">
                            <a href="{{ route('home.board', ['id' => $board->id, 'board_name' => $board->board_name]) }}">
                                <div
                                    class="d-flex flex-column justify-content-center align-items-center  bg-opacity-10 rounded-3">
                                    @if ($board->board_name === 'Punjab Board')
                                    <img src="{{ asset('images/Sindh Board.png') }}" class="w-full" />
                                    @else
                                    <img src="{{ asset('images/'.$board->board_name.'.png') }}" class="w-full" />
                                    @endif
                                    <div class=" h3 fw-normal mb-0">

                                        {{-- <p class="mb-0">{{ $board->board_name }}</p> --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        {{-- <div style="width: 100%; height: 0; padding-bottom: 36.25%; position: relative;">
            <img src="{{ asset('images/board.jpg') }}"
                style="position: absolute; width: 100%; height: 100%; object-fit: contain;" usemap="#image-map2">
            <map name="image-map2">
                <area target="" alt="Sindh Board" title="Sindh Board" href="/board/1/Sindh%20Board"
                    coords="106,181,440,532" shape="rect">
                <area target="" alt="Federal Board" title="Federal Board" href="/board/2/Federal%20Board"
                    coords="458,177,788,529" shape="rect">
                <area target="" alt="Punjab Board" title="Punjab Board" href="/board/3/Punjab%20Board"
                    coords="810,181,1147,536" shape="rect">
                <area target="" alt="Agha Khan" title="Agha Khan" href="/board/4/Aga%20Khan%20Board"
                    coords="1165,180,1499,535" shape="0">
            </map>
        </div> --}}






    </main>
@endsection
