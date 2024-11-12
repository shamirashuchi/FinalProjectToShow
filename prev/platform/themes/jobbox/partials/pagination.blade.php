@if ($paginator->hasPages())
    <div class="paginations">
        <ul class="pager">
            @if ($paginator->onFirstPage())
                <li>
                    <a class="pager-prev pagination-button"  href="javascript:void(0)" tabindex="-1"></a>
                </li>
            @else
                <li>
                    <a class="pager-prev pagination-button" data-page="{{ $paginator->currentPage() - 1 }}" href="#"></a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                        <li><a class="pager-number disabled" href="javascript:void(0)">{{ $element }}</a></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a class="pager-number active" href="javascript:void(0)">{{ $page }}</a></li>
                        @else
                            <li><a class="pager-number pagination-button" data-page="{{ $page }}" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="pager-next pagination-button" data-page="{{ $paginator->currentPage() + 1 }}"  href="#"></a></li>
            @else
                <li><a class="pager-next" href="javascript:void(0)" tabindex="-1"></a></li>
            @endif
        </ul>
    </div>
@endif
