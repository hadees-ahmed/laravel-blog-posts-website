<x-layout>
    <article>
        @include('components._posts-header')
        <x-post-card :posts="$posts"/>
    </article>
</x-layout>

