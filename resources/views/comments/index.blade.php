<x-layout>
    <br>
    <div class="text-sm">
        <div class="ml-3">
            @foreach($comments as $comment)
                <img src="/images/lary-avatar.svg" alt="Lary avatar">
                <a href="/users/{{$comment->user->id}}/posts"><h5 class="font-bold">{{$comment->user?->name }}</h5></a>

                    @can('delete', $comment)
                        @if(!$comment->trashed())
                        <a href="{{route('comments.delete',['comment' => $comment->id])}}" class="text-red-500">Delete Comment</a>
                       @endif
                    @endcan
                @if ($comment->trashed())
                    <p class="text-blue-500">{{'Comment Deleted'}}</p>
                @can('undo', $comment)
                    <a href="{{route('comments.restore', ['comment' => $comment->id])}}" class="text-green-500">{{'undo'}}</a>
                    @endif
                @else
                    <p class="text-blue-500">{{$comment->comments}}</p>
                @endif
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
                    <textarea class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 full py-1 px-2" name="comments" placeholder="Type Comment..."  required>{{old('comment')}}</textarea>

                    @error('comment')
                        <p class="text-red-500 text-xs mt-1">{{"Abusive language is not allowed please remove inappropriate words "}}</p>
                    @enderror
                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="post_id" value="{{$post->id}}">
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
