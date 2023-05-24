<div class="mb-6">
@csrf
    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="title">Title</label>

    <input class="border border-gray-400 p-2 w-full" type="text" name="title" value="{{old('title',isset($post)? $post->title  : 'fake data fake data fake data fake data' )}}">
    @error('title')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror

    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="body">Body</label>

    <textarea  name="body" class="border border-gray-400 p-2 w-full">{{old('body',isset($post)? $post->body  : 'fake data fake data fake data fake datafake data fake datafake data fake datafake data fake datafake data fake data')}}</textarea>
    @error('body')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror

    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="excerpt">Excerpt</label>

    <textarea  name="excerpt" class="border border-gray-400 p-2 w-full">{{old('excerpt',isset($post)? $post->excerpt  : 'fake data fake datafake data fake datafake data fake datafake data')}}</textarea>
    @error('excerpt')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror

    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="category">Categories</label>
    <select name="category_id" class="flex-1  bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">
        @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
        @endforeach
    </select>

    @error('category_id')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</div>
