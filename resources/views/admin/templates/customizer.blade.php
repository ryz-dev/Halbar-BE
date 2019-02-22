@extends('admin.layouts.main')
@section('title', 'Templates Setup')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Customizer</h1>
	</div>
	<div class="wrapper-md">
    @if ( Session::has('success') )
      <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        {{ session('success') }}
      </div>
    @endif
    <div class="panel-group form-customizer" id="accordion">
        {{ Form::open(array('route' => 'templates_customizer_setup')) }}
        @if (!empty($customizer['setup']))

            {{-- Show all registery function setup --}}
            @foreach ($customizer['setup'] as $keyWrapper => $dataWrapper)
              <div class="panel panel-default">
              @foreach ($customizer['default'] as $defaultWrapper)
                @if ($defaultWrapper['id'] == $keyWrapper)
                  <div class="panel-heading">
                     <h4
                      class="panel-title"
                      data-toggle="collapse"
                      data-target="#{{$defaultWrapper['id']}}">
                       {{$defaultWrapper['name']}}
                     </h4>
                  </div>
                  <div id="{{$defaultWrapper['id']}}" class="panel-collapse collapse">
                    <div class="panel-body">
                      @foreach ($dataWrapper as $keySegment => $dataSegment)
                        @include('admin.customizer.'.$keySegment)
                      @endforeach
                    </div>
                  </div>
                @endif
              @endforeach
            </div>
            @endforeach
          @else

          {{-- Show all registery function default --}}
          @foreach ($customizer['default'] as $key => $dataWrapper)
            <div class="panel panel-default">
              <div class="panel-heading">
                 <h4
                   class="panel-title"
                   data-toggle="collapse"
                   data-target="#{{$dataWrapper['id']}}">
                   {{$dataWrapper['name']}}
                 </h4>
              </div>
              <div id="{{$dataWrapper['id']}}" class="panel-collapse collapse">
                <div class="panel-body">
                  @foreach ($dataWrapper['data'] as $dataSegment)
                    @include('admin.customizer.'.$dataSegment['type'])
                  @endforeach
                </div>
              </div>
            </div>
          @endforeach

        @endif
        <button type="submit" class="new-btn" title="Save"><i class="fa fa-save"></i></button>
        {{ Form::close() }}
    </div>
    @include('admin.images.modals')
  </div>
@endsection
