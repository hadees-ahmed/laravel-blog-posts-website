<!doctype html>

<title>Laravel From Scratch Blog</title>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<script src="//unpkg.com/alpinejs" defer></script>

<body style="font-family: Open Sans, sans-serif">
<section class="px-6 py-8">
    <nav class="md:flex md:justify-between md:items-center">
        <div>
            <a href="{{route('posts')}}">
                <img src="/images/logo.svg" alt="Laracasts Logo" width="165" height="16">
            </a>
        </div>

        <div class="mt-8 md:mt-0 flex items-center">
            @guest()
                <a href="{{route('register')}}" class="text-xs font-bold uppercase">Register</a>
                <a href="{{route('login')}}" class="ml-3 text-xs font-bold uppercase">Login</a>
            @else
                @if(auth()->user()->is_Admin)
                    <a href="{{route('users.index')}}" class="text-xs font-bold uppercase mr-6 text-blue-500">Manage Users</a>

                @endif

                <a href="{{route('users.update')}}" class="text-xs font-bold uppercase mr-6 text-blue-500">Profile</a>
                <h class="text-xs font-bold uppercase ">{{"Welcome back! " . auth()->user()->name}}</h>
                <form method="POST" action="{{route('logout')}}" class="text-xs font-semibold text-blue-500 ml-6">
                    @csrf
                    <button type="submit">LogOut</button>
                </form>
            @endguest



{{--                <a href="#" class="bg-blue-500 ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-5">--}}
{{--                Subscribe for Updates--}}
{{--            </a>--}}
        </div>





    </nav>

   {{$slot}}

    <footer class="bg-gray-100 border border-black border-opacity-5 rounded-xl text-center py-16 px-10 mt-16">
        <img src="/images/lary-newsletter-icon.svg" alt="" class="mx-auto -mb-6" style="width: 145px;">
        <h5 class="text-3xl">Stay in touch with the latest posts</h5>
        <p class="text-sm mt-3">Promise to keep the inbox clean. No bugs.</p>

        <div class="mt-10">
            <div class="relative inline-block mx-auto lg:bg-gray-200 rounded-full">

                <form method="POST" action="#" class="lg:flex text-sm">
                    <div class="lg:py-3 lg:px-5 flex items-center">
                        <label for="email" class="hidden lg:inline-block">
                            <img src="/images/mailbox-icon.svg" alt="mailbox letter">
                        </label>

                        <input id="email" type="text" placeholder="Your email address"
                               class="lg:bg-transparent py-2 lg:py-0 pl-4 focus-within:outline-none">
                    </div>

                    <button type="submit"
                            class="transition-colors duration-300 bg-blue-500 hover:bg-blue-600 mt-4 lg:mt-0 lg:ml-3 rounded-full text-xs font-semibold text-white uppercase py-3 px-8"
                    >
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </footer>
</section>
@if(session()->has('success'))
    <div class="fixed bottom-0 right-0 bg-blue-500 text-white py-2 px-4 rounded-xl mb-2">
        <p>
            {{session('success')}}
        </p>
    </div>
@endif
@if(session()->has('failed'))
    <div class="fixed bottom-0 right-0 bg-blue-500 text-white py-2 px-4 rounded-xl mb-2">
        <p>
            {{session('failed')}}
        </p>
    </div>
@endif
</body>
