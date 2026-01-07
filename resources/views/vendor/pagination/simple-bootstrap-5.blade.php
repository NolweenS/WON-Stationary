@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-10" role="navigation" aria-label="{!! __('Pagination Navigation') !!}">
        <ul class="flex items-center space-x-4 bg-white p-2 rounded-full shadow-sm border border-[#EAE5DE]">
            @if ($paginator->onFirstPage())
                <li class="px-4 py-2 text-sm font-medium text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span>{!! __('pagination.previous') !!}</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300 rounded-full" rel="prev">
                        {!! __('pagination.previous') !!}
                    </a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300 rounded-full" rel="next">
                        {!! __('pagination.next') !!}
                    </a>
                </li>
            @else
                <li class="px-4 py-2 text-sm font-medium text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span>{!! __('pagination.next') !!}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
