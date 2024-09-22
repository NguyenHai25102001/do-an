@if ($paginator->hasPages())
    <!-- Pagination -->
    <nav aria-label="Page navigation example">
        <ul class="pagination d-flex mt-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled mb-0">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" style="border-radius: 50%;margin-right: 8px">
                        <span aria-hidden="false">«</span>
                    </a>
                </li>
            @else
                <li class="page-item mb-0">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" style="border-radius: 50%;margin-right: 8px">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active mb-0"><span class="page-link" style="border-radius: 50%;margin-right: 8px">{{ $page }}</span></li>
                        @else
                            <li class="page-item mb-0"><a class="page-link" href="{{ $url }}" style="border-radius: 50%;margin-right: 8px">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item mb-0">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next" style="border-radius: 50%">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            @else
                <li class="page-item mb-0">
                    <button class="page-link" aria-label="Next" style="border-radius: 50%">
                        <span aria-hidden="false">»</span>
                    </button>
                </li>
            @endif
        </ul>
    </nav>
    <!-- Pagination -->
@endif
