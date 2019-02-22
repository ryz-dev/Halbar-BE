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
      <textarea name="{{$keyWrapper."[$keySegment][$key]"}}" class="editor form-control" rows="8" cols="80">{{$value}}</textarea>
    </div>
  @endforeach
  @else
  <div class="form-group">
    <label><i><strong>{{$dataSegment['title']}}</strong></i></label>
    <textarea name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]]"}}" class="editor form-control" rows="8" cols="80"></textarea>
  </div>
@endif
