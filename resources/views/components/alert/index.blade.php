@if( Session::get('success'))
@php
    $type = 'success';
    $icon = 'icon fas fa-check';
    $title = 'Success';
@endphp
@elseif( Session::get('danger'))
@php
    $type = 'danger';
    $icon = 'icon fas fa-ban';
    $title = 'Danger';
@endphp
@elseifif( Session::get('info'))
@php
    $type = 'info';
    $icon = 'icon fas fa-info';
    $title = 'Info';
@endphp
@elseif( Session::get('warning'))
@php
    $type = 'warning';
    $icon = 'icon fas fa-exclamation-triangle';
    $title = 'Warning';
@endphp
@endif

@isset($type)
@php
    $message = Session::get($type);
@endphp

    <div class="alert alert-{{$type}} alert-dismissible">
        <button type="button" 
                class="close" 
                data-dismiss="alert" 
                aria-hidden="true"
        >&times;</button>
        <h5>
            <i class="{{$icon}}"></i>&nbsp;{{ $title }}!
        </h5>
        {{ $message }}
    </div>
@endif