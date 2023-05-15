<x-layout>
    @foreach($users as $user)
        <br><a href="users/{{$user->id}}/posts">  <span style="display: inline-block; vertical-align: middle;">{{$user->name}}</span> <img src="/images/lary-head.svg" alt="User Avatar" style="display: inline-block; vertical-align: middle;" /></a>
            <a href="{{$user->id}}/update"
               class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
            >Edit</a>
        <a href="{{$user->id}}/delete"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
        >Delete</a>

        <br>

@endforeach
</x-layout>
