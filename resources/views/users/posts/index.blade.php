{{--<x-layout>--}}
{{--    <article>--}}
{{--        @php--}}
{{--            $draftUri = "/users/drafts";--}}
{{--            $currentUri = request()->getRequestUri();--}}
{{--        @endphp--}}

{{--        @if($currentUri !== $draftUri)--}}
{{--            @include('components._posts-header')--}}
{{--        @endif--}}
{{--        <x-post-card :posts="$posts" :user="$user" :draftUri="$draftUri" :currentUri="$currentUri"/>--}}
{{--    </article>--}}
{{--</x-layout>--}}

<x-layout>
    <article>
        {{-- Remember: Unless is opposite of if statement--}}
        @unless(request()->getRequestUri() === '/users/drafts')
            @include('components._posts-header')
        @endunless

        <x-post-card :posts="$posts" :user="$user" draftUri="/users/drafts" :currentUri="request()->getRequestUri()" />
    </article>
</x-layout>
