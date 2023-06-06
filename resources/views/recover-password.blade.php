<x-layout>
    <main class="max-w-lg mx-auto">
        <h1 class="text-center font-bold text-xl">Recover Password!</h1>
        <form method="POST" action="{{route('verification.code')}}">
            @csrf
            <div class="mb-6">
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">email</label>
                <input class="border border-gray-400 p-2 w-full mb-2"  type="email" name="email" value="{{old('email')}}" required>
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                <input class="border border-gray-400 p-2 w-full" type="submit" value="SendCode"><br>
            </div>
        </form>
    </main>
</x-layout>
