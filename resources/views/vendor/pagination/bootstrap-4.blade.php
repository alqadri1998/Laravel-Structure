
        @if ($paginator->hasPages())
            <div class="col-12 text-right mt-1">
                <div class="pagination-ctm d-inline-block">
            <ul class="my-pagination d-inline-block">
                {{-- if on the first page show arrow icon otherwise its upto you --}}
                @if ($paginator->onFirstPage())
                    <li class="item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-arow-l"><i
                                    class="fas fa-angle-left"></i></a>
                    </li>
                @else
                    <li class="item">
                        <a href="{{ $paginator->previousPageUrl() }}" class="page-arow-l"><i
                                    class="fas fa-angle-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="item"><a href="javascript:void(0)" class="link">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="item"><a href="#" class="link active">{{ $page }}</a></li>
                            @else
                                <li class="item"><a href="{{ $url }}" class="link">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="item">
                        <a href="{{ $paginator->nextPageUrl() }}" class="page-arow-l"><i class="fas fa-angle-right"></i></a>
                    </li>
                @else

                @endif
            </ul>
                </div>
            </div>
        @endif
