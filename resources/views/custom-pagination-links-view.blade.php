<div class="nk-pagination nk-pagination-center">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a href="#" class="nk-pagination-prev disabled">
            <span class="ion-ios-arrow-back"></span>
        </a>
    @else
        <a href="#" class="nk-pagination-prev" wire:click.prevent="previousPage('{{ $paginator->getPageName() }}')">
            <span class="ion-ios-arrow-back"></span>
        </a>
    @endif

    {{-- Pagination Elements --}}
    <nav>
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="nk-pagination-current">{{ $page }}</a>
                    @else
                        <a href="#" wire:click.prevent="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </nav>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="#" class="nk-pagination-next" wire:click.prevent="nextPage('{{ $paginator->getPageName() }}')">
            <span class="ion-ios-arrow-forward"></span>
        </a>
    @else
        <a href="#" class="nk-pagination-next disabled">
            <span class="ion-ios-arrow-forward"></span>
        </a>
    @endif
</div>
