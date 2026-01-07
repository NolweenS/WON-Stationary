@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-10" role="navigation">
        <div class="flex items-center space-x-2 bg-white p-2 rounded-full shadow-sm border border-[#EAE5DE]">
            @if ($paginator->onFirstPage())
                <span class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span class="text-lg">&lsaquo;</span>
                </span>
            @else
                <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <span class="text-lg">&lsaquo;</span>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="text-[#C4B5A5] px-2" aria-disabled="true">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <a class="w-10 h-10 flex items-center justify-center rounded-full bg-[#2A1E17] text-white font-bold shadow-md" href="{{ $url }}" aria-current="page">
                                {{ $page }}
                            </a>
                        @else
                            <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $url }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <span class="text-lg">&rsaquo;</span>
                </a>
            @else
                <span class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span class="text-lg">&rsaquo;</span>
                </span>
            @endif
        </div>
    </nav>
@endif
