@if (!empty($customizer['setup']))
  @foreach ($dataSegment as $key => $value)
    <div class="form-group">
      @foreach ($customizer['default'] as $defaultWrapper)
        @foreach ($defaultWrapper['data'] as $defaultSegment)
          @if ($defaultSegment['id'] == $key)
            <label><i><strong>{{$defaultSegment['title']}}</strong></i></label>
          @endif
        @endforeach
      @endforeach
      <input type="text" name="{{$keyWrapper."[$keySegment][$key]"}}" class="form-control" placeholder="Your text" value="{{$value}}">
    </div>
  @endforeach
  @else
  <div class="form-group">
    <label><i><strong>{{$dataSegment['title']}}</strong></i></label>
    <input type="text" name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]]"}}" class="form-control" placeholder="Your text">
  </div>
@endif
