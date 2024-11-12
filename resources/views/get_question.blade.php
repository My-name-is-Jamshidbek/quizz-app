<div>
    <form method="POST" action="{{ route('question.create') }}">
        @csrf
    <input name = 'quizId' id = 'quiz_id'/>
    <button href="{{ route('question.create') }}">Submit</button>
    </form>
</div>
