@extends('frontend.layouts.app')
@section('content')
    <div class="col-lg-9 col-12">
        <div class="blog-page">

            @forelse($posts as $post)
                <article class="blog__post d-flex flex-wrap">
                    <div class="thumb">
                        <a href="{{ route('post.show', $post->slug) }}">
                            <img src="{{ $post->media->count() > 0 ? path('posts', $post->media->first()->file_name) : path('posts', null) }}"alt="blog images">
                        </a>
                    </div>
                    <div class="content">
                        <h4><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h4>
                        <ul class="post__meta">
                            <li>Posts by : <a
                                    href="{{ route('author', $post->user->username) }}">{{ $post->user->name }}</a>
                            </li>
                            <li class="post_separator">/</li>
                            <li>{{ $post->created_at->format('M d Y') }}</li>
                        </ul>
                        <p>{!! \Illuminate\Support\Str::limit($post->description, 145, '...') !!}</p>
                        <div class="blog__btn">
                            <a href="{{ route('post.show', $post->slug) }}">read more</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="text-center">No Posts found</div>
            @endforelse
        </div>
        {!! $posts->appends(request()->input())->links() !!}
    </div>

    @include('frontend.partials.sidebar')
@endsection
@section('script')
@endsection
