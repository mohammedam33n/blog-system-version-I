@extends('frontend.layouts.app')
@section('content')
    <div class="col-lg-9 col-12">










        <div class="row">
            <div class="col">


                <!-- Profile widget -->
                <div class="bg-white shadow rounded overflow-hidden">


                    <div class="px-4 pt-0 pb-4 cover">
                        <div class="media align-items-end profile-head">

                            <div class="profile mr-3">
                                <img src="{{ asset('assets/users/' . auth()->user()->user_image) }}"
                                    alt="{{ auth()->user()->username }}" width="130" class="rounded mb-2 img-thumbnail">
                            </div>

                            <div class="media-body mb-5">
                                <h4 class="mt-0 mb-0">{{ auth()->user()->name }}</h4>
                            </div>

                        </div>
                    </div>


                    {{-- <div class="bg-light p-4 d-flex justify-content-end text-center">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block">6556</h5><small class="text-muted">
                                    <i class="fas fa-image mr-1"></i>Posts</small>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block">745</h5><small class="text-muted"> <i
                                        class="fas fa-user mr-1"></i>Followers</small>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="font-weight-bold mb-0 d-block">340</h5><small class="text-muted"> <i
                                        class="fas fa-user mr-1"></i>Following</small>
                            </li>
                        </ul>
                    </div> --}}







                    <div class="col-lg-9 col-12">
                        <div class="blog-page">
                            @forelse($posts as $post)
                                <article class="blog__post d-flex flex-wrap">
                                    <div class="thumb">
                                        <a href="{{ route('post.show', $post->slug) }}">
                                            @if ($post->media->count() > 0)
                                                <img src="{{ asset('images/posts/' . $post->media->first()->file_name) }}"
                                                    alt="{{ $post->title }}">
                                            @else
                                                <img src="{{ asset('images/posts/default.png') }}" alt="blog images">
                                            @endif
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





                </div>
            </div>
        </div>








    </div>

    <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
        @include('frontend.partials.dashboard-sidebar')
    </div>
@endsection
@section('script')
@endsection
