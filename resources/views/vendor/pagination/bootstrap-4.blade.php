@if ($paginator->hasPages())
    <nav class="flex items-center justify-center mt-10">
        <ul class="flex items-center space-x-2 bg-white p-2 rounded-full shadow-sm border border-[#EAE5DE]">
            @if ($paginator->onFirstPage())
                <li class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span class="text-lg">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $paginator->previousPageUrl() }}" rel="prev">
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
                            <li class="w-10 h-10 flex items-center justify-center rounded-full bg-[#2A1E17] text-white font-bold shadow-md" aria-current="page">
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $url }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a class="w-10 h-10 flex items-center justify-center rounded-full text-[#8C7B70] hover:bg-[#FDFBF7] hover:text-[#3E2C22] transition duration-300" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span class="text-lg">&rsaquo;</span>
                    </a>
                </li>
            @else
                <li class="w-10 h-10 flex items-center justify-center text-[#C4B5A5] cursor-not-allowed" aria-disabled="true">
                    <span class="text-lg">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
