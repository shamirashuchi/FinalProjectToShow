@if (request()->segment(1) != 'account' && request()->segment(2) != 'settings')

    {!! dynamic_sidebar('pre_footer_sidebar') !!}
    </main>
    <footer class="footer mt-50">
        <div class="container">
            <div class="row">
                {!! dynamic_sidebar('footer_sidebar') !!}
            </div>
            <div class="footer-bottom mt-50">
                <div class="row">
                    <div class="col-md-6 nav">
                        <span
                            class="font-primary font-xs color-text-paragraph align-items-center d-flex justify-content-center">
                            {!! BaseHelper::clean(theme_option('copyright')) !!}
                        </span>
                    </div>
                    <div class="col-md-6 text-md-end text-start">
                        <div class="footer-social">
                            {!! Menu::renderMenuLocation('footer-menu', [
                                'options' => ['class' => 'footer_menu'],
                                'view' => 'support-menu',
                            ]) !!}
                        </div>
                        <div class="nav float-right language-switcher-footer">
                            @if (is_plugin_active('language'))
                                @include(JobBoardHelper::viewPath('dashboard.partials.language-switcher'))
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {!! Theme::footer() !!}

    @if (session()->has('status') ||
            session()->has('success_msg') ||
            session()->has('error_msg') ||
            (isset($errors) && $errors->count() > 0) ||
            isset($error_msg))
        <script type="text/javascript">
            'use strict';
            window.onload = function() {
                @if (session()->has('success_msg'))
                    window.showAlert('alert-success', "{!! addslashes(session('success_msg')) !!}");
                @endif
                @if (session()->has('status'))
                    window.showAlert('alert-success', "{!! addslashes(session('status')) !!}");
                @endif
                @if (session()->has('error_msg'))
                    window.showAlert('alert-danger', "{!! addslashes(session('error_msg')) !!}");
                @endif
                @if (isset($error_msg))
                    window.showAlert('alert-danger', "{!! addslashes($error_msg) !!}");
                @endif
                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        window.showAlert('alert-danger', "{!! addslashes($error) !!}");
                    @endforeach
                @endif
            };
        </script>
    @endif

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/65c96e4d0ff6374032cbd97c/1hmdddovb';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script>
        $('form[id^="ratingForm"]').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            var rating = $('input[name="rating"]:checked').val(); // Get the selected rating value
            var note = $('textarea[name="note"]').val(); // Get the note value

            if (!rating) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Rating Selected',
                    text: 'Please select a rating before submitting.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            // Create a FormData object and append the rating value
            let formData = new FormData();
            formData.append('rating', rating);
            formData.append('note', note);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // Add CSRF token if required

            $.ajax({
                url: $(this).attr('action'), // Get the form's action attribute
                method: $(this).attr('method'), // Get the form's method attribute
                data: formData,
                processData: false, // Don't process the data (since it's FormData)
                contentType: false, // Don't set any content type header (since it's FormData)
                success: function(response) {
                    // Handle success (e.g., display a success message)
                    Swal.fire({
                        icon: 'success',
                        title: 'Rating Submitted',
                        text: response.message || 'Rating submitted successfully!',
                        confirmButtonColor: '#3085d6',
                    });
                },
                error: function(xhr) {
                    // Handle error
                    if (xhr.status === 422) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Errors',
                            html: '<ul>' + Object.values(errors).map(e => `<li>${e}</li>`).join(
                                '') + '</ul>',
                            confirmButtonColor: '#d33',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'An Error Occurred',
                            text: xhr.statusText,
                            confirmButtonColor: '#d33',
                        });
                    }
                }
            });
        });
    </script>


    </body>

    </html>
@endif
