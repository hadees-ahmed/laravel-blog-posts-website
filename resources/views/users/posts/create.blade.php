<x-layout>
    <section>
        <main class="max-w-lg mx-auto">
            <h1 class="text-center font-bold text-xl">Create Post!</h1>

            <form method="POST" action="{{route('posts.store')}}">
                @include('users.posts.post-form')
                <br><input class="border border-gray-400 p-2 w-full" type="submit" name="submit" value="Save As Draft">
            </form>
        </main>
    </section>
</x-layout>
