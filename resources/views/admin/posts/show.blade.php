@extends('layouts.app')

@section('content')
<div class="container" id="posts-container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-3" style="max-width: 740px;">
                <div class="row justify-content-center">
                    <div class="col-12  d-flex justify-content-center">

                        @if (str_starts_with($post->image, 'http' ))
                        <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        @else
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @endif

                    </div>
                    <div class="col-12">
                        <div class="card-body">
                            <h5 class="card-title">
                                <strong>
                                    ID: {{ $post->id }}
                                </strong>
                                <p>
                                    {{ $post->slug }}
                                </p>
                            </h5>
                            @if ( count($post->tags) > 0)
                            <h6>
                                @foreach($post->tags as $tag)
                            -- {{ $tag->name }}
                                @endforeach
                            </h6>
                            @endif
                            <p class="card-text">
                                <small class="text-muted">
                                    <strong>
                                        {{ $post->title }}
                                    </strong>
                                </small>
                            </p>
                            <p class="card-text">
                                {{ $post->content }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.posts.edit', $post->id) }}" class=" btn btn-sm btn-success">
                Edit
            </a>
            <form class="d-inline-block" action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class=" btn btn-sm btn-danger">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection