<x-layout>
    @foreach($users as $user)
        <br><a href="{{route('users.posts.index', ['user' => $user->id])}}">  <span style="display: inline-block; vertical-align: middle;">{{$user->name}}</span> <img src="{{$user->getAvatar()}}" width="33" length="20" alt="User Avatar" style="display: inline-block; vertical-align: middle;" /></a>
            <a href="{{route('admin.users.update',['user' => $user->id])}}"
               class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-green-300 rounded-full py-2 px-8 pl-9"
            >Edit</a>

        <a href="{{route('users.delete',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-red-500 rounded-full py-2 px-8 pl-9"
        >Delete &#128465;</a>

        @if(!$user->is_banned && $user->id != auth()->user()->id)
        <a href="{{!$user->is_Admin ? route('users.promote',['user' => $user->id]) : route('users.demote',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8 pl-9"
        > {{$user->is_Admin ? 'Demote' : 'Make Admin'}}</a>
        @endif
        @if($user->id != auth()->user()->id)
        <a href="{{!$user->is_banned ? route('users.ban',['user' => $user->id]) : route('users.unban',['user' => $user->id])}}"
           class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-red-500 rounded-full py-2 px-8 pl-9"
        >@if(!$user->is_banned)
             Ban &#x1F6AB;
            @else
                Unban &#x2705;
        @endif </a>
        @endif
        @if($user->is_Admin)
            <h class="text-green-600">(Admin)</h>
        @endif
        <br>
@endforeach
</x-layout>
