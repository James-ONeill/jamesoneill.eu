<div class="panel panel-{{ $type or 'default'}}">
    @if(isset($heading))
        <div class="panel-heading">{{ $heading }}</div>
    @endif

    {{ $slot }}

    @if(isset($footer))
        <div class="panel-footer clearfix">{{ $footer }}</div>
    @endif
</div>
