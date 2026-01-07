@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between mt-10">
        <div class="flex justify-between flex-1 sm:hidden">
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
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-[#8C7B70]">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-bold text-[#3E2C22]">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-bold text-[#3E2C22]">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-bold text-[#3E2C22]">{{ $paginator->count() }}</span>
                    @endif
                    {!! __('of') !!}
                    <span class="font-bold text-[#3E2C22]">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="inline-flex bg-white p-1 rounded-full border border-[#EAE5DE] space-x-1">
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span class="text-[#C4B5A5] px-2 flex items-center" aria-disabled="true">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#2A1E17] text-white font-bold shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
