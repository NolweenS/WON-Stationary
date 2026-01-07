@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center mt-10 gap-4">

        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-6 py-2 text-sm font-medium text-[#C4B5A5] bg-white border border-[#EAE5DE] cursor-not-allowed leading-5 rounded-full">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-6 py-2 text-sm font-medium text-[#8C7B70] bg-white border border-[#EAE5DE] leading-5 rounded-full hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-6 py-2 text-sm font-medium text-[#8C7B70] bg-white border border-[#EAE5DE] leading-5 rounded-full hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="inline-flex items-center px-6 py-2 text-sm font-medium text-[#C4B5A5] bg-white border border-[#EAE5DE] cursor-not-allowed leading-5 rounded-full">
                {!! __('pagination.next') !!}
            </span>
        @endif

    </nav>
@endif
