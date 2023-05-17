<x-layout>
    <br>
    <div class="  text-sm">
        <div class="ml-3">
            @foreach($comments as $comment)

                <img src="/images/lary-avatar.svg" alt="Lary avatar">
                <a href="/users/{{$comment->user->id}}/posts"><h5 class="font-bold">{{$comment->user?->name }}</h5></a>
                <h6 class="text-blue-500">{{$comment->comments}}</h6>
                <span class="mt-2 block text-gray-400 text-xs">
                                         <time>{{$comment->created_at->diffForHumans()}}</time>
                </span>
            @endforeach

            <div class="flex justify-between  items-center mt-8">
                <form method="POST" action="/users/{{auth()->user()->id}}/{{$post->id}}/comments" class="flex items-center ">
                    @csrf
                    <textarea class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 full py-1 px-2" name="comment" placeholder="Type Comment..."  required>{{old('comment')}}</textarea>
                    @error('comment')
                    <p class="text-red-500 text-xs mt-1">{{"Abusive language is not allowed please remove inappropriate words "}}</p>
                    @enderror
                    <input type="submit" value="POST" class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 full py-2 px-8 ml-8">

                </form>
        </div>
    </div>
    </div>
        <div class="mt-4">
            {{ $comments->links() }}
        </div>

</x-layout>
