<x-layout>
    <br>
    <div class="text-sm">
        <div class="ml-3">
            @foreach($comments as $comment)
                <img src="/images/lary-avatar.svg" alt="Lary avatar">
                <a href="/users/{{$comment->user->id}}/posts"><h5 class="font-bold">{{$comment->user?->name }}</h5></a>

                    @can('delete', $comment)
                        <a href="{{route('comments.delete',['comment' => $comment->id])}}" class="text-red-500">Delete Comment</a>
                    @endcan
                <p class="text-blue-500">{{$comment->comments}}</p>
                <div class="mt-2 block text-gray-400 text-xs">
                    <time>{{$comment->created_at->diffForHumans()}}</time>
                </div>
            @endforeach

                @empty($comment->comments)
                {{"Want to be first commenter? then type your comment below"}}
                @endempty

            <div class="flex justify-between  items-center mt-8">
                <form method="POST" action="{{route('users.comments',['user' => auth()->user()->id, 'post' => $post->id])}}" class="flex items-center ">
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
{{--    /users/{{ auth()->user()->id }}/{{ $comments[0]->post_id }}/comments--}}

</x-layout>
