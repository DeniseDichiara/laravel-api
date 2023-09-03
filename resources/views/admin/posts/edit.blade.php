@extends('layouts.app')

@section('content')
<div class="container" id="posts-container">
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Insert your post's title" name="title" value="{{ old('title' , $post->title) }}">
                </div>

                @error('tag')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-4">
                    <label for="tag_id" class="form-label">
                        Tags
                    </label>
                    <div>
    
                        @foreach ($tags as $tag)
                            <input type="checkbox" name="tags[]" class="form-check-input" 
                            value="{{ $tag->id }}" @if ($post->tags->contains($tag->id) ) checked 
                            @endif>
                            <label for="tag_id" class="form-check-label me-3">
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>


                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control" placeholder="Choose an image" value="{{ old('image', 'Oops no photo') }}">
                </div>

                @error('content')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" rows="7" name="content">
                    {{ old('content' , $post->content) }}

                        {{ $post->content}}
                    </textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        Update post
                    </button>

                    <button type="reset" class="btn btn-info">
                        Reset
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection