<button type="{{$type}}" class="{{$class}}">
    @isset($icon)
    <i class="{{$icon}}"></i>
    @endisset
    @isset($title)
    {{$title}}
    @endisset
</button>