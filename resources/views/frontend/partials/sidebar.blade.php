

<div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
	<div class="wn__sidebar">


		<!-- Start Single Widget -->
		<aside class="widget search_widget">
			<h3 class="widget-title">Search</h3>

			{!! Form::open(['route' => 'search', 'method' => 'get']) !!}
				<div class="form-input">
					{!! Form::text('keyword', old('keyword', request()->keyword), ['placeholder' => 'Search...']) !!}
					{!! Form::button('<i class="fa fa-search"></i>', ['type' => 'submit']) !!}
				</div>
			{!! Form::close() !!}

		</aside>
		<!-- End Single Widget -->


		<!-- Start Single Widget -->
		<aside class="widget recent_widget">
			<h3 class="widget-title">Recent</h3>
			<div class="recent-posts">
				<ul>

					@foreach($recent_posts as $recent_post)
                    <li>
                        <div class="post-wrapper d-flex">
                            <div class="thumb">
                                <a href="{{ route('post.show', $recent_post->slug) }}">


                                    <img src="{{ $recent_post->media->count() > 0 ? path('posts', $recent_post->media->first()->file_name) : path('posts', null) }}"alt="blog images">



                                </a>
                            </div>
                            <div class="content">
                                <h4><a href="{{ route('post.show', $recent_post->slug) }}">{{ \Illuminate\Support\Str::limit($recent_post->title, 15, '...') }}</a></h4>
                                <p>	{{ $recent_post->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach

				</ul>
			</div>
		</aside>
		<!-- End Single Widget -->


		<!-- Start Single Widget -->
		<aside class="widget comment_widget">
			<h3 class="widget-title">Comments</h3>

			{{-- {{ dd($recent_comments) }} --}}

			@foreach($recent_comments as $recent_comment)
			<ul>
				<li>
					<div class="post-wrapper">
						<div class="thumb">
							<img src="{{ asset('frontend/images/blog/comment/1.jpeg')}}" alt="Comment images">
						</div>
						<div class="content">
							<p>{{ $recent_comment->name  }}:</p>
							{!! \Illuminate\Support\Str::limit($recent_comment->comment,25,"...") !!}

						</div>
					</div>
				</li>
			</ul>
			@endforeach


		</aside>
		<!-- End Single Widget -->


		<!-- Start Single Widget -->
		<aside class="widget category_widget">
			<h3 class="widget-title">Categories</h3>

			@foreach ( $global_categories as $category )
			<ul>
				<li><a href="{{route('category',$category->slug)}}">{{$category->name }}</a></li>
			</ul>
			@endforeach

		</aside>
		<!-- End Single Widget -->


		<!-- Start Single Widget -->
		<aside class="widget archives_widget">
			<h3 class="widget-title">Archives</h3>

			@foreach ($global_archives as $key => $val )
			<ul>
				<li><a href="{{route('archive',$key.'-'.$val)}}">{{ date("F", mktime(0, 0, 0, $key, 1)) . ' ' . $val }}</a></li>
			</ul>
			@endforeach

		</aside>
		<!-- End Single Widget -->


	</div>
</div>
