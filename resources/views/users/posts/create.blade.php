<x-layout>
    <section>
        <main class="max-w-lg mx-auto">
            <h1 class="text-center font-bold text-xl">Create Post!</h1>

            <form method="POST" action="{{route('posts.store')}}">
        @include('users.posts.post-form')
    </form>
        </main>
    </section>
</x-layout>
