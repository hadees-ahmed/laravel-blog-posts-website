<x-layout>
    <section>
    <main class="max-w-lg mx-auto">
                <h1 class="text-center font-bold text-xl">Edit Details!</h1>

                <form method="POST" action="{{route('users.update')}}" enctype="multipart/form-data">

            @include('users.form')
    </form>
</main>
</section>
</x-layout>
