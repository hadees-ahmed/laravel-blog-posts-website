<x-layout>
    <article>
        @include('components._posts-header')
        <x-post-card :posts="$posts" :user="$user"/>
    </article>
</x-layout>

