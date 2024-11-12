<x-app-layout>
    <div class="flex items-center justify-center">
        <h1 class="text-lg text-purple-700">Your result is {{ $res->result }} out of {{ $quiz->getMaxResult() }}<h1>
                @php
                    $res->isOld = true;
                    $res->save();
                @endphp
    </div>
</x-app-layout>
