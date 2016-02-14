<li class="{{ $item->getClasses() }}">
  <a href="{!! $item->getUrl() !!}">{!! $item->getTitle() !!} </a>
  @if($item->hasChildren())
  <ul class="dropdown-menu">
    @foreach($item->getChildren() as $child)
      <li><a href="{!! $child->getUrl() !!}">{!! $child->getTitle() !!} </a></li>
    @endforeach
  </ul>
  @endif
</li>
