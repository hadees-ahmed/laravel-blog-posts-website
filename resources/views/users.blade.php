<x-layout>
    @foreach($users as $user)
        <br><a href="{{route('users.posts.index', ['user' => $user->id])}}">  <span style="display: inline-block; vertical-align: middle;">{{$user->name}}</span> <img src="{{$user->getAvatar()}}" width="33" length="20" alt="User Avatar" style="display: inline-block; vertical-align: middle;" /></a>
            <a href="{{route('admin.users.update',['user' => $user->id])}}"
               class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
            >Edit</a>

        <a href="{{route('users.delete',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-red-500 rounded-full py-2 px-8 pl-9"
        >Delete</a>

        <a href="{{!$user->is_Admin ? route('users.promote',['user' => $user->id]) : route('users.demote',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
        >{{$user->is_Admin ? 'Demote' : 'Make Admin'}}</a>

{{--    <p>&#x1F6AB;</p>--}}
        <a href="{{!$user->is_banned ? route('users.ban',['user' => $user->id]) : route('users.unban',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-red-400 rounded-full py-2 px-8 pl-9"
        >@if(!$user->is_banned)
             Unban &#x2705;
            @else
                Ban &#x1F6AB;
        @endif </a>
        @if($user->is_Admin)
            <h class="text-green-600">(Admin)</h>
        @endif
        <br>
@endforeach
</x-layout>
