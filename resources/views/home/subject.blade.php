@extends('home.common')
@section('title', 'Home Page')
@section('content')

    <main>

        <!-- =======================
                                                            Page intro START -->
        <section class="bg-blue py-7">
            <div class="container">
                <div class="row justify-content-lg-between">

                    <div class="col-lg-8">
                        <!-- Title -->

                        <h1 class="text-white">{{ $course_name }}</h1>
                    </div>


                </div>
            </div>
        </section>
        <!-- =======================
                                                            Page intro END -->

        <!-- =======================
                                                            Page content START -->
        <section class="pt-0">
            <div class="container">
                <div class="row">
                    <!-- Main content START -->
                    <div class="col-12">
                        <div class="card shadow rounded-2 p-0 mt-n5">
                            <!-- Tabs START -->
                            <div class="card-header border-bottom px-4 pt-3 pb-0">
                                <ul class="nav nav-bottom-line py-0" id="course-pills-tab" role="tablist">
                                    <!-- Tab item -->
                                    <li class="nav-item me-2 me-sm-4" role="presentation">
                                        <button class="nav-link mb-2 mb-md-0 active" id="course-pills-tab-1"
                                            data-bs-toggle="pill" data-bs-target="#course-pills-1" type="button"
                                            role="tab" aria-controls="course-pills-1" aria-selected="true">Course
                                            Materials</button>
                                    </li>
                                    <!-- Tab item -->
                                    <li class="nav-item me-2 me-sm-4" role="presentation">
                                        <button class="nav-link mb-2 mb-md-0" id="course-pills-tab-2" data-bs-toggle="pill"
                                            data-bs-target="#course-pills-2" type="button" role="tab"
                                            aria-controls="course-pills-2" aria-selected="false"
                                            tabindex="-1">SLOs</button>
                                    </li>

                                </ul>
                            </div>
                            <!-- Tabs END -->

                            <!-- Tab contents START -->
                            <div class="card-body p-sm-4">
                                <div class="tab-content" id="course-pills-tabContent">
                                    <!-- Content START -->
                                    <div class="tab-pane fade active show" id="course-pills-1" role="tabpanel"
                                        aria-labelledby="course-pills-tab-1">
                                        <!-- Accordion START -->
                                        <div class="accordion accordion-icon accordion-border" id="accordionExample2">
                                            @php
                                                $transformedResponse = [];

                                                foreach ($contents as $item) {
                                                    $chapterFound = false;

                                                    foreach ($transformedResponse as &$chapter) {
                                                        if ($chapter['chapterName'] === $item['chapter_title']) {
                                                            $chapterFound = true;
                                                            break;
                                                        }
                                                    }

                                                    if ($chapterFound) {
                                                        $chapter['content'][] = [
                                                            'content_type' => $item['content_type'],
                                                            'content_link' => $item['content_link'],
                                                            'topic_title' => $item['topic_title'],
                                                            'thumbnail' => $item['thumbnail'],
                                                            'id' => $item['id'],
                                                        ];
                                                    } else {
                                                        $transformedResponse[] = [
                                                            'chapterName' => $item['chapter_title'],
                                                            'id' => $item['id'],
                                                            'content' => [
                                                                [
                                                                    'content_type' => $item['content_type'],
                                                                    'content_link' => $item['content_link'],
                                                                    'topic_title' => $item['topic_title'],
                                                                    'thumbnail' => $item['thumbnail'],
                                                                    'id' => $item['id'],
                                                                ],
                                                            ],
                                                        ];
                                                    }
                                                }

                                            @endphp
                                            @foreach ($transformedResponse as $item)
                                                <div class="accordion-item mb-3">
                                                    <h6 class="accordion-header font-base" id="heading-2">
                                                        <button class="accordion-button fw-bold rounded d-flex"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-{{ isset($item['id']) ? $item['id'] : '' }}"
                                                            aria-expanded="true" aria-controls="collapse-2">
                                                            {{ isset($item['chapterName']) ? $item['chapterName'] : '' }}
                                                            <span
                                                                class="small ms-0 ms-sm-2 d-none d-sm-block">({{ isset($item['content']) ? count($item['content']) : '' }}
                                                                Topics)</span>
                                                        </button>
                                                    </h6>
                                                    <div id="collapse-{{ isset($item['id']) ? $item['id'] : '' }}"
                                                        class="accordion-collapse collapse" aria-labelledby="heading-2"
                                                        data-bs-parent="#accordionExample2" style="">

                                                        <div class="d-flex justify-content-between flex-wrap mt-3">
                                                            @if (isset($item['content']))
                                                                @foreach ($item['content'] as $content)
                                                                    <div class="card" style="width: 18rem;">
                                                                        @if (isset($content['thumbnail']))
                                                                            <img src='{{ Storage::disk('local')->temporaryUrl($content['thumbnail'], now()->addMinutes(20)) }}'
                                                                                class="card-img-top" alt="..."
                                                                                loading="lazy"
                                                                                 style="height: 250px !important; width: 100%; ">
                                                                                
                                                                        @endif

                                                                        <div class="card-body">
                                                                            <h5 class="card-title">
                                                                                {{ isset($content['topic_title']) ? $content['topic_title'] : '' }}
                                                                            </h5>
                                                                            <a href="{{ route('preview.file', ['id' => $content['id']]) }}"
                                                                                class="btn btn-primary">View</a>
                                                                        </div>
                                                                    </div>

                                                                    <hr> <!-- Divider -->
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <!-- Accordion body END -->
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Accordion END -->
                                    </div>
                                    <!-- Content END -->

                                    <!-- Content START -->
                                    <div class="tab-pane fade" id="course-pills-2" role="tabpanel"
                                        aria-labelledby="course-pills-tab-2">
                                        <div class="card">

                                            <!-- Card body -->
                                            <div class="card-body p-0 pt-3">



                                                @foreach ($transformedResponse as $item)
                                                    <h4> {{ isset($item['chapterName']) ? $item['chapterName'] : '' }}</h4>
                                                    <ul>
                                                        @if (isset($item['content']))
                                                            @foreach ($item['content'] as $content)
                                                                <li>{{ isset($content['topic_title']) ? $content['topic_title'] : '' }}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                @endforeach


                                            </div>
                                        </div>
                                    </div>
                                    <!-- Content END -->


                                </div>
                            </div>
                            <!-- Tab contents END -->
                        </div>
                    </div>
                    <!-- Main content END -->
                </div><!-- Row END -->
            </div>
        </section>
        <!-- =======================
                                                            Page content END -->

    </main>


    <script>
        var content = <?php echo json_encode($contents); ?>;
        console.log(content);
        const transformedResponse = content.reduce((acc, item) => {
            const existingChapter = acc.find(chapter => chapter.chapterName === item.chapter_title);
            if (existingChapter) {
                existingChapter.content.push({
                    content_type: item.content_type,
                    content_link: item.content_link,
                    topic_title: item.topic_title,
                    id: item.id,
                });
            } else {
                acc.push({
                    chapterName: item.chapter_title,
                    id: item.id,
                    content: [{
                        id: item.id,
                        content_type: item.content_type,
                        content_link: item.content_link,
                        topic_title: item.topic_title,
                    }]
                });
            }
            return acc;
        }, []);
        // console.log(transformedResponse)
    </script>

@endsection
