<div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="avatar-form" method="post" action="{{ $url }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="avatar-modal-label"><i class="til_img"></i><strong>{{ __('plugins/job-board::dashboard.change_profile_image') }}</strong></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="avatar-body">

                        <!-- Upload image and data -->
                        <div class="pt-4 avatar-upload">
                            <input class="avatar-src" name="avatar_src" type="hidden">
                            <input class="avatar-data" name="avatar_data" type="hidden">
                            {!! csrf_field() !!}
                            <label for="avatarInput">{{ __('plugins/job-board::dashboard.new_image') }}</label>
                            <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                        </div>

                        <div class="loading" tabindex="-1" role="img" aria-label="{{ __('plugins/job-board::dashboard.loading') }}"></div>

                        <!-- Crop and preview -->
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-2">
                                <div class="avatar-wrapper"></div>
                            </div>
                            <div class="md:col-span-1 avatar-preview-wrapper">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out" type="button" data-dismiss="modal">{{ __('plugins/job-board::dashboard.close') }}</button>
                    <button class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-600 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-green-600 transition duration-150 ease-in-out avatar-save" type="submit">{{ __('plugins/job-board::dashboard.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->
