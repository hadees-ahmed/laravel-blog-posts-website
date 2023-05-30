
<x-layout>
    <article>
        {{-- Remember: Unless is opposite of if statement--}}
        @unless(request()->getRequestUri() === '/users/drafts')
            @include('components._posts-header')
        @endunless

        <x-post-card :posts="$posts" :user="$user" draftUri="/users/drafts" :currentUri="request()->getRequestUri()" />
    </article>
</x-layout>
