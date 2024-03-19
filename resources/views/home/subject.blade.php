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

                                                $ChaptersTopics = [];

                                                foreach ($slos as $item) {
                                                    $chapterName = $item['chapter_title'];
                                                    $topicTitle = $item['topic_title'];

                                                    if (!isset($ChaptersTopics[$chapterName])) {
                                                        $ChaptersTopics[$chapterName] = [];
                                                    }

                                                    if (!in_array($topicTitle, $ChaptersTopics[$chapterName])) {
                                                        $ChaptersTopics[$chapterName][] = $topicTitle;
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

                                                        <div class="accordion-body mt-3">
                                                            @if (isset($item['content']))
                                                                @foreach ($item['content'] as $content)
                                                                    <div class="d-flex justify-content-between align-items-center"
                                                                        style="height: 100px;">
                                                                        <div
                                                                            class="position-relative d-flex align-items-center">
                                                                            <div class="d-flex align-items-center">
                                                                                <!-- Video button -->
                                                                                <a href="{{ route('preview.file', ['id' => $content['id']]) }}"
                                                                                    class="icon-md mb-0 position-static flex-shrink-0 text-body"
                                                                                    style="width: 100px">
                                                                                    @if (isset($content['thumbnail']))
                                                                                        <img class='item-icon'
                                                                                            loading="lazy"
                                                                                            src='{{ Storage::disk('local')->temporaryUrl($content['thumbnail'], now()->addMinutes(3)) }}' />
                                                                                    @endif
                                                                                </a>
                                                                                <!-- Content -->
                                                                                <div class="ms-3">
                                                                                    <a href="{{ route('preview.file', ['id' => $content['id']]) }}"
                                                                                        class="d-inline-block text-truncate mb-0 h6 fw-normal w-100px w-sm-200px w-md-400px">{{ isset($content['topic_title']) ? $content['topic_title'] : '' }}</a>
                                                                                    <ul class="nav nav-divider small mb-0">
                                                                                        <li class="nav-item">
                                                                                            {{ isset($content['content_type']) ? $content['content_type'] : '' }}
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <!-- Actions Mark button -->
                                                                        <a href="{{ route('preview.file.download', ['id' => $content['id']]) }}"
                                                                            class="p-2 mb-0 text-secondary"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            aria-label="Open" data-bs-original-title="Open">
                                                                            <i class="bi bi-eye-fill"></i>
                                                                        </a>
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
                                        

                                                @foreach ($ChaptersTopics as $chapterName => $topicTitles)
                                                    <h4>{{ $chapterName }}</h4>
                                                    <ul>
                                                        @foreach ($topicTitles as $topicTitle)
                                                            <li>{{ $topicTitle }}</li>
                                                        @endforeach
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
