@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

            <table class="table table-info table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($posts as $post )
                    <tr>
                        <th>
                            {{ $post->id }}
                        </th>
                        <td>
                            <strong>
                                {{ $post->title }}
                            </strong>
                        </td>
                        <td>
                            {{ $post->slug }}
                        </td>

                        <td>
                            <a href="{{ route('admin.posts.show', $post->id) }}" class=" btn btn-sm btn-primary">
                                View
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="ms-1 btn btn-sm btn-success">
                                Edit
                            </a>
                            <form class="d-inline-block" action="{{ route('admin.posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="ms-1 btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            {{ $posts->links() }}

        </div>
    </div>
</div>
@endsection