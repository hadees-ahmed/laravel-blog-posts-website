<x-layout>
    <br>
    <div class="  text-sm">
        <div class="ml-3">
            @foreach($post->comments as $comment)

                <img src="/images/lary-avatar.svg" alt="Lary avatar">
                <a href="/users/{{$comment->user->id}}/posts"><h5 class="font-bold">{{$comment->user?->name . " Commented:"}}</h5></a>
                <h6>{{$comment->comments}}</h6>
                <span class="mt-2 block text-gray-400 text-xs">
                                         <time>{{$comment->created_at->diffForHumans()}}</time>
                </span>
            @endforeach

            <div class="flex justify-between  items-center mt-8">
                <form method="POST" action="/users/{{auth()->user()->id}}/{{$post->id}}/comments" class="flex items-center ">
                    @csrf
                    <textarea type="text" class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 full py-2 px-8" name="comment" placeholder="Type Comment..." required
                    ></textarea>
                    <input type="submit" value="POST" class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 full py-2 px-8 ml-8" name="comment" placeholder="Type Comment..."
                    >
                </form>
        </div>
    </div>
</x-layout>
