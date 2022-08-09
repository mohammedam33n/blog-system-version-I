<body class="antialiased">
    <div id="app">
        <div id="app">
            <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
                <hello-world />
            </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>






























{{-- @section('content')



    <div class="col-lg-9 col-12">
        <h3>Edit Post ({{ $post->title }})</h3>
        {!! Form::model($post, ['route' => ['post.update', $post->id], 'method' => 'put', 'files' => true]) !!}

        <div class="row pt-4">
            <div class="col-12">
                <div class="file-loading">
                    {!! Form::file('images[]', ['id' => 'post-images', 'multiple' => 'multiple']) !!}
                </div>
            </div>
        </div>

        <div class="form-group pt-4">
            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>

    <div class="file-loading">
        <input id="file-5" name="file-5[]" type="file" multiple>
    </div>
@endsection --}}


<!-- http://127.0.0.1:8000/test/1000/edit  -->
<!-- https://plugins.krajee.com/file-plugin-methods-demo  -->
{{-- @section('script')
    <script>
        $(function() {

            $('#post-images').fileinput({
                theme: "fa",
                maxFileCount: 5,
                allowedFileTypes: ['image'],
                showCancel: true,
                showRemove: false,
                showUpload: false,
                overwriteInitial: false,
                initialPreview: [
                    @if ($post->media->count() > 0)
                        @foreach ($post->media as $media)
                            "{{ asset('assets/posts/' . $media->file_name) }}",
                        @endforeach
                    @endif
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                initialPreviewConfig: [


                ],

            });

        });
    </script> --}}



{{-- <script>
        $(document).ready(function() {
            var krajeeGetCount = function(id) {
                var cnt = $('#' + id).fileinput('getFilesCount');
                return cnt === 0 ? 'You have no files remaining.' :
                    'You have ' + cnt + ' file' + (cnt > 1 ? 's' : '') + ' remaining.';
            };
            $('#file-5').fileinput({
                overwriteInitial: false,
                validateInitialCount: true,
                initialPreview: [
                    "<img class='kv-preview-data file-preview-image' src='https://picsum.photos/id/260/1920/1080'>",
                    "<img class='kv-preview-data file-preview-image' src='https://picsum.photos/id/261/1920/1080'>",
                ],
                initialPreviewConfig: [

                    {
                        caption: "Nature-1.jpg",
                        width: "120px",
                        url: "/site/file-delete",
                        key: 1
                    },
                    {
                        caption: "Nature-2.jpg",
                        width: "120px",
                        url: "{{ route('test.destroy',10)}}",
                        key: 2
                    }
                ],
            }).on('filebeforedelete', function() {
                var aborted = !window.confirm('Are you sure you want to delete this file?');
                if (aborted) {
                    window.alert('File deletion was aborted! ' + krajeeGetCount('file-5'));
                };
                return aborted;
            }).on('filedeleted', function() {
                setTimeout(function() {
                    window.alert('File deletion was successful! ' + krajeeGetCount('file-5'));
                }, 900);
            });
        });
    </script> --}}
{{-- @endsection --}}
