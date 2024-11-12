@if (SocialService::hasAnyProviderEnable() && request()->is('register'))
    <div class="login-options">
        <br>
        @if (request()->is('register'))
        <div class="col-8 form-group mx-auto">
            <a href="{{ route('public.account.login') }}" class="px-5 py-3 rounded-2 w-100 text-light " style="background-color: #F9A620">{{ __('Sign In') }}</a>
        </div>
        @elseif(request()->is('register2'))
        <div class="col-8 form-group mx-auto">
            <a href="#" class="p-3 rounded-2 w-100 text-light " style="background-color: #0879EA">{{ __('Sign In') }}</a>
        </div>
        @else
        <div class="col-8 form-group mx-auto">
            <a href="#" class="p-3 rounded-2 w-100 text-light " style="background-color: #94A5B6">{{ __('Sign In') }}</a>
        </div>
        @endif
        <p style="font-size: 14px">{{ __('or') }}</p>
        <ul class="social-icons">
            @foreach (SocialService::getProviderKeys() as $item)
                @if (SocialService::getProviderEnabled($item))
                    <div class="col-8 social-icon-item border rounded-3 p-2 mb-2 mx-auto">
                        <div class="d-flex">
                            <div class="inline-block d-flex">
                                <li>
                                    <a class="social-icon-color {{ $item }} rounded-5" data-bs-toggle="tooltip" data-bs-original-title="{{ $item }}"
                                    href="{{ route('auth.social', isset($params) ? array_merge([$item], $params) : $item) }}"></a>
                                </li>
                                <span class="text-dark" style="margin-left: 20px;">Continue with {{ ucfirst($item) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </ul>
    </div>
@endif
