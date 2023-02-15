<a class="{{$class}}" 
   href="{{ isset($href) ? $href : '#' }}">
    @isset($icon)
    <i class="{{$icon}}"></i>
    @endisset
    @isset($title)
    {{$title}}
    @endisset
</a>
<!--
<a class="{{$class}}" 
   href="@isset($href){{$href}}@endisset"
>
    <i 
        class="@isset($icon){{$icon}}@endisset"
    >{{$title}}</i>
</a>
-->