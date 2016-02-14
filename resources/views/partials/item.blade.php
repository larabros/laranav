<li class="{{ $item->getClasses() }}">
  <a href="{!! $item->getUrl() !!}">{!! $item->getTitle() !!} </a>
  @if($item->hasChildren())
  <ul class="dropdown-menu">
    @each('laranav::partials.item', $item->getChildren(), 'item')
  </ul>
  @endif
</li>
