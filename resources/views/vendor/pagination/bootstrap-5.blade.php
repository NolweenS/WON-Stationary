@if ($paginator->hasPages())
    <nav class="flex items-center justify-between mt-10">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#C4B5A5] bg-white border border-[#EAE5DE] cursor-default rounded-full">
                    @lang('pagination.previous')
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#8C7B70] bg-white border border-[#EAE5DE] rounded-full hover:bg-[#FDFBF7] transition duration-300">
                    @lang('pagination.previous')
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-[#8C7B70] bg-white border border-[#EAE5DE] rounded-full hover:bg-[#FDFBF7] transition duration-300">
                    @lang('pagination.next')
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-[#C4B5A5] bg-white border border-[#EAE5DE] cursor-default rounded-full">
                    @lang('pagination.next')
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-[#8C7B70]">
                    {!! __('Showing') !!}
                    <span class="font-bold text-[#3E2C22]">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-bold text-[#3E2C22]">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-bold text-[#3E2C22]">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="flex items-center space-x-1 bg-white p-1 rounded-full border border-[#EAE5DE]">
                    @if ($paginator->onFirstPage())
                        <li class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                            <span class="text-lg">&lsaquo;</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] transition duration-300" rel="prev">
                                <span class="text-lg">&lsaquo;</span>
                            </a>
                        </li>
                    @endif

                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="text-[#C4B5A5] px-2" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="w-10 h-10 flex items-center justify-center rounded-full bg-[#2A1E17] text-white font-bold shadow-sm" aria-current="page">
                                        <span>{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] transition duration-300">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] transition duration-300" rel="next">
                                <span class="text-lg">&rsaquo;</span>
                            </a>
                        </li>
                    @else
                        <li class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                            <span class="text-lg">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
