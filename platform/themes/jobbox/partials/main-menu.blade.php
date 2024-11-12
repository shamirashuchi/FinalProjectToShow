<ul {!! BaseHelper::clean($options) !!}>

    @php
        $account = auth('account')->user();
    @endphp

    @if (isset($account))
        @if ($account->type == "job-seeker")
            @foreach ($menu_nodes->loadMissing('metadata') as $key => $row)
                @if ($row->title !== 'Talent Search' && $row->title !== 'Post A Job')
                    <li class="@if ($row->has_child) has-children @endif {{ $row->css_class }}">
                        <a href="{{ $row->url }}">
                            @if ($iconImage = $row->getMetadata('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" class="menu-icon-image" />
                            @elseif ($row->icon_font)
                                <i class="{{ trim($row->icon_font) }}"></i>
                            @endif
                            {{ $row->title }}
                            @if ($row->has_child)
                                <div class="arrow-down"></div>
                            @endif
                        </a>
                        @if ($row->has_child)
                            {!! Menu::generateMenu([
                                'menu'       => $menu,
                                'menu_nodes' => $row->child,
                                'view'       => 'main-menu',
                                'options'    => ['class' => 'sub-menu'],
                            ]) !!}
                        @endif
                    </li>
                @endif
            @endforeach

        @elseif ($account->type == "consultant")
            @foreach ($menu_nodes->loadMissing('metadata') as $key => $row)
                @if ($row->title !== 'Post A Job')
                    <li class="@if ($row->has_child) has-children @endif {{ $row->css_class }}">
                        <a href="{{ $row->url }}">
                            @if ($iconImage = $row->getMetadata('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" class="menu-icon-image" />
                            @elseif ($row->icon_font)
                                <i class="{{ trim($row->icon_font) }}"></i>
                            @endif
                            {{ $row->title }}
                            @if ($row->has_child)
                                <div class="arrow-down"></div>
                            @endif
                        </a>
                        @if ($row->has_child)
                            {!! Menu::generateMenu([
                                'menu'       => $menu,
                                'menu_nodes' => $row->child,
                                'view'       => 'main-menu',
                                'options'    => ['class' => 'sub-menu'],
                            ]) !!}
                        @endif
                    </li>
                @endif
            @endforeach

        @elseif ($account->type == "employer")
            @foreach ($menu_nodes->loadMissing('metadata') as $key => $row)
                @if ($row->title !== 'Talent Search')
                    <li class="@if ($row->has_child) has-children @endif {{ $row->css_class }}">
                        <a href="{{ $row->url }}">
                            @if ($iconImage = $row->getMetadata('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" class="menu-icon-image" />
                            @elseif ($row->icon_font)
                                <i class="{{ trim($row->icon_font) }}"></i>
                            @endif
                            {{ $row->title }}
                            @if ($row->has_child)
                                <div class="arrow-down"></div>
                            @endif
                        </a>
                        @if ($row->has_child)
                            {!! Menu::generateMenu([
                                'menu'       => $menu,
                                'menu_nodes' => $row->child,
                                'view'       => 'main-menu',
                                'options'    => ['class' => 'sub-menu'],
                            ]) !!}
                        @endif
                    </li>
                @endif
            @endforeach

        @endif
    @else
        @foreach ($menu_nodes->loadMissing('metadata') as $key => $row)
            <li class="@if ($row->has_child) has-children @endif {{ $row->css_class }}">
                <a href="{{ $row->url }}">
                    @if ($iconImage = $row->getMetadata('icon_image', true))
                        <img src="{{ RvMedia::getImageUrl($iconImage) }}" alt="icon image" class="menu-icon-image" />
                    @elseif ($row->icon_font)
                        <i class="{{ trim($row->icon_font) }}"></i>
                    @endif
                    {{ $row->title }}
                    @if ($row->has_child)
                        <div class="arrow-down"></div>
                    @endif
                </a>
                @if ($row->has_child)
                    {!! Menu::generateMenu([
                        'menu'       => $menu,
                        'menu_nodes' => $row->child,
                        'view'       => 'main-menu',
                        'options'    => ['class' => 'sub-menu'],
                    ]) !!}
                @endif
            </li>
        @endforeach
    @endif

</ul>
