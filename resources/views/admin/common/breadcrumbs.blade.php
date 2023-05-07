<div class="m-subheader">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title {{(isset($breadcrumbs) && count($breadcrumbs) > 0) ? 'm-subheader__title--separator' :''}}">{{--{!! dd($currentRouteName) !!}--}}
                {{--@if($currentRouteName == "admin.site-settings.index" || $currentRouteName == "admin.languages.index" || $currentRouteName == "admin.languages.translations.index" || $currentRouteName == "admin.languages.translations.edit")
                    {!! $breadcrumbTitle !!}
                @else
                {{strtoupper($pageType)}}
                @endif--}}
                {!! $breadcrumbTitle !!}
            </h3>
            @if (isset($breadcrumbs) && count($breadcrumbs) > 0)
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline" style="height: fit-content">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{!! route('admin.home.index') !!}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    @foreach($breadcrumbs as $url => $bc)
                        <li class="m-nav__item">
                            <a href="{!! $url !!}" class="m-nav__link">
                        <span class="m-nav__link-text">
                            {!! $bc['title'] !!}
                        </span>
                            </a>
                        </li>
                        @if(!$loop->last)
                            <li class="m-nav__separator">
                                -
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

{{--@if (isset($breadcrumbs))--}}
{{--<ol class="breadcrumb">--}}
    {{--@foreach($breadcrumbs as $url => $bc)--}}
    {{--<li>--}}
        {{--<a href="{!! $url !!}" class="{!! ($url=='javascript:{};') ? 'active':'' !!}">--}}
            {{--<i class="{!! $bc['icon'] !!}"></i> {!! $bc['title'] !!}--}}
        {{--</a>--}}
    {{--</li>--}}
    {{--@endforeach --}}
{{--</ol>--}}
{{--@endif--}}