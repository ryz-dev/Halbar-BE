@if (!empty($customizer['setup']))
  @foreach ($dataSegment as $key => $dataWrapper)
    {{-- <button class="btn-block btn btn-danger addField" data-class='{{'box_repeater_'.$key}}'>Tambah Field</button> --}}
    @foreach ($customizer['default'] as $defaultWrapper)
      @foreach ($defaultWrapper['data'] as $defaultSegment)
        @if ($defaultSegment['id'] == $key)
          <label style="margin-top:10px;"><i><strong>{{$defaultSegment['title']}}</strong></i></label>
        @endif
      @endforeach
    @endforeach
    @foreach ($dataWrapper as $num => $value)
      <div class="{{'box_repeater_'.$key}}">
        <input type="text" name="{{$keyWrapper."[$keySegment][$key][$num][text]"}}" class="_desc form-control" value="{{$value->text}}" placeholder="Title" style="margin:10px 0px!important;" maxlength="35">
        <input type="text" name="{{$keyWrapper."[$keySegment][$key][$num][subtext]"}}" class="_subtext form-control" value="{{$value->subtext}}" placeholder="Sub Title" style="margin:10px 0px!important;" maxlength="35">
        <input type="text" name="{{$keyWrapper."[$keySegment][$key][$num][link]"}}" placeholder='Link redirect' class="_link form-control" value="{{$value->link}}" style="margin:10px 0px!important;">
        <input type="text" name="{{$keyWrapper."[$keySegment][$key][$num][image]"}}" placeholder='Click for open media' class="_images open_media form-control" id="{{'image_'.$num.'_'.$key}}" data-toggle="modal" data-target="#modal-galleries" style="margin:10px 0px!important;" value="{{$value->image}}">
        @if ($num > 1)
          <a href="#" class="badge badge-primary remove_field" style="margin:10px 0px;"></i> Hapus</a>
        @endif
      </div>
    @endforeach
  @endforeach
  @else
  <div class="{{'box_repeater_'.$dataSegment['id']}}">
    <label style="margin-top:10px;"><i><strong>{{$dataSegment['title']}}</strong></i></label>
    <input type="text" name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]][1][text]"}}" class="_desc form-control" placeholder="Title" style="margin:10px 0px!important;" maxlength="35">
    <input type="text" name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]][1][subtext]"}}" class="_subtext form-control" placeholder="Sub Title" style="margin:10px 0px!important;" maxlength="35">
    <input type="text" name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]][1][link]"}}"  placeholder='Link redirect' class="_link form-control" style="margin:10px 0px!important;">
    <input type="text" name="{{$dataWrapper['id']."[$dataSegment[type]][$dataSegment[id]][1][image]"}}" placeholder='Click for open media' class="_images open_media form-control" id="{{'image_1_'.$dataSegment['id']}}" data-toggle="modal" data-target="#modal-galleries" style="margin:10px 0px!important;">
  </div>
@endif
