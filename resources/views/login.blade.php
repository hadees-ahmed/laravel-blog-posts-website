<x-layout>
    <main class="max-w-lg mx-auto">
        <h1 class="text-center font-bold text-xl">Login!</h1>
    <form method="POST" action="{{route('login')}}">
        @csrf
        <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">email</label>
        <input class="border border-gray-400 p-2 w-full"  type="email" name="email" value="{{old('email')}}" required>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password">password</label>
        <input class="border border-gray-400 p-2 w-full" type="password" name="password" value="" required>
            <a href="{{route('forgot.password')}}" class="block mb-2 uppercase font-bold text-xs text-gray-700">Forgot Password?</a>
        <input class="border border-gray-400 p-2 w-full" type="submit" value="Login"><br>
        </div>
    </form>
    </main>
</x-layout>
