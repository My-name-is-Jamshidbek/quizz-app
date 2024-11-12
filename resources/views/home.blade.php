
@vite('resources/css/styles.css')
<x-app-layout title="Home Page">

    <body class="font-light antialiased">

        <div class="container">
            <!-- header -->
            <div class="header">
                <h1>Featured Tests</h1>
                <p>
                    This is a collection of various test questions designed to assess your knowledge in different
                    fields.
                    You can select a test to view the details and attempt it.
                </p>
            </div>
            <!-- header -->
            <div class="content .flex-column">
                @foreach ($featuredQuizzes as $quiz)
                <!-- row -->
                <div class="row">
                    <!--  -->
                    <div class="data">
                        <!--  -->
                        <div class="text">

                            <p>{{ $quiz->category }} Level 1</p>
                            <div class="info">
                                <p>Publisher: {{ $quiz->author->name }}</p>
                                <p>Category: {{ $quiz->category }}</p>
                                <p>Date: {{ $quiz->created_date }}</p>
                            </div>

                        </div>
                        <!--  -->
                    </div>
                    <!--  -->
                    <div class="data">
                        <!--  -->
                        <div class="city">
                        </div>
                        <!--  -->
                        <div class="price">
                            <a href="{{ route('quiz.show', $quiz->id) }}"><button>Take Test</button></a>
                        </div>
                    </div>
                    <!--  -->
                </div>
                @endforeach
            </div>
            <a href="{{ route('quiz.index') }}">Load more tests...</a>
        </div>
    </body>
</x-app-layout>
