<x-layout>
    @foreach($users as $user)
        <br><a href="{{route('users.posts.index', ['user' => $user->id])}}">  <span style="display: inline-block; vertical-align: middle;">{{$user->name}}</span> <img src="{{$user->getAvatar()}}" width="33" length="20" alt="User Avatar" style="display: inline-block; vertical-align: middle;" /></a>
            <a href="{{route('admin.users.update',['user' => $user->id])}}"
               class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
            >Edit</a>
        <a href="{{route('users.delete',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
        >Delete</a> <br>

@endforeach
</x-layout>
