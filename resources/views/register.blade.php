<x-layout>
<section>
    <main class="max-w-lg mx-auto">
            <h1 class="text-center font-bold text-xl">Register!</h1>
            <form method="POST" action="{{route('register')}}">
                @include('users.form')

    </form>
    </main>
</section>
</x-layout>

