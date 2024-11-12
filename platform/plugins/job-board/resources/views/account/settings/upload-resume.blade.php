<div class="form-group">
    <label for="resume">{{ trans('plugins/job-board::dashboard.resume') }}</label><br>
    @if ($user->resume)
        <small>{{ __('Drag and drop a new file to here to replace existed one.') }}</small>
    @endif
    {!! Form::hidden('resume', $user->resume) !!}
    <div id="file-upload" class="dropzone needsclick">
        <div class="dz-message needsclick">
            {{ __('Drop files here or click to upload.') }}<br>
        </div>
    </div>
</div>

<div id="preview-template" style="display: none;">
    <div class="dz-preview dz-file-preview">
        <div class="dz-image"><img data-dz-thumbnail="" /></div>
        <div class="dz-details">
            <div class="dz-size"><SPAN data-dz-size=""></SPAN></div>
            <div class="dz-filename"><SPAN data-dz-name=""></SPAN></div></div>
        <div class="dz-progress"><SPAN class="dz-upload"
                                       data-dz-uploadprogress=""></SPAN></div>
        <div class="dz-error-message"><SPAN data-dz-errormessage=""></SPAN></div>
        <div class="dz-success-mark">
            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                <title>Check</title>
                <defs></defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                    <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                </g>
            </svg>
        </div>
        <div class="dz-error-mark">
            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                <title>error</title>
                <defs></defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                    <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                    </g>
                </g>
            </svg>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Dropzone.autoDiscover = false;

        $(document).ready(function () {
            var dropzone = new Dropzone('#file-upload', {
                previewTemplate: document.querySelector('#preview-template').innerHTML,
                parallelUploads: 1,
                thumbnailHeight: 120,
                thumbnailWidth: 120,
                maxFilesize: 2,
                uploadMultiple: false,
                filesizeBase: 1000,
                acceptedFiles: 'application/pdf,.doc,.docx',
                paramName: 'file',
                url: '{{ route('public.account.upload') }}',
                init: function() {
                    this.hiddenFileInput.removeAttribute('multiple');
                    this.on('maxfilesexceeded', function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                },
                sending: function(file, xhr, formData) {
                    formData.append('_token', '{{ csrf_token() }}');
                },
                thumbnail: function(file, dataUrl) {
                    if (file.previewElement) {
                        file.previewElement.classList.remove('dz-file-preview');
                        var images = file.previewElement.querySelectorAll('[data-dz-thumbnail]');
                        for (var i = 0; i < images.length; i++) {
                            var thumbnailElement = images[i];
                            thumbnailElement.alt = file.name;
                            thumbnailElement.src = dataUrl;
                        }
                        setTimeout(function() { file.previewElement.classList.add('dz-image-preview'); }, 1);
                    }
                },
                success: function (file, response) {
                    $('input[name=resume]').val(response.data.url);
                },
                removedfile: function(file) {
                    dropzone.options.maxFiles = dropzone.options.maxFiles + 1;
                    $('.dz-message.needsclick').hide();
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            });

            @if ($user->resume)
                var file = ({name: '{{ File::name($user->resume) }}', size: '{{ Storage::exists($user->resume) ? Storage::size($user->resume) : 0 }}', 'url': '{{ $user->resume }}', 'full_url': '{{ RvMedia::url($user->resume) }}'});
                dropzone.options.addedfile.call(dropzone, file);
                dropzone.options.maxFiles = 0;
            @endif
        });
    </script>
    <style>
        .dropzone {
            border-radius: 5px;
            border: 1px dashed rgb(0, 135, 247);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .dropzone .dz-preview:not(.dz-processing) .dz-progress {
            display: none;
        }
    </style>
@endpush
