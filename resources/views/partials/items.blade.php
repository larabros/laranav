@foreach($items as $item)
<li class="{{ $item->hasChildren() ? 'dropdown' : '' }}">
  <a href="{!! $item->url() !!}">{!! $item->title !!} </a>
  @if($item->hasChildren())
  <ul class="dropdown-menu">
    {{-- @include('custom-menu-items', array('items' => $item->children())) --}}
  </ul>
  @endif
</li>
@endforeach
