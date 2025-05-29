{{-- resources/views/vendor/pagination/bootstrap-5.blade.php --}}
@if ($paginator->hasPages())
    <nav class="pagination-wrapper my-4">
        <ul class="pagination justify-content-center">

            {{-- Previous --}}
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() ?? '#' }}" aria-label="Previous" rel="prev">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </li>

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                {{-- Three dots --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>

                    {{-- Array of links --}}
                @elseif (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() ?? '#' }}" aria-label="Next" rel="next">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </li>

        </ul>

        {{-- range text: “Showing 1-15 of 30 results” --}}
        <p class="text-muted small text-center mt-2 mb-0">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }}
            of {{ $paginator->total() }} results
        </p>
    </nav>
@endif
