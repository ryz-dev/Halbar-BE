@extends('admin.layouts.main')

@section('title', 'Pricing Edit')

@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">Pricing Edit</h1>
	</div>
	<div class="wrapper-md">
		@if (count($errors) > 0)
			<div class="alert-top alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<div class="panel">
			<div class="panel-body">
				<form action="{{ route('item_pricing_update', [ 'id' => $pricing->id ]) }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="idgroup" value="{{$pricing->pricing}}">
					<input type="hidden" name="_method" value="PUT">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="name_paket" class="form-control input-lg" placeholder="Name Item" value="{!! $pricing->name_paket !!}">
							</div>
							<div class="form-group">
								<input type="number" name="total_email" class="form-control input-lg" placeholder="Total Email" value="{!! $pricing->total_email !!}">
							</div>
							<div class="form-group">
								<input type="number" name="total_harga" class="form-control input-lg" placeholder="Price" value="{!! $pricing->total_harga !!}">
							</div>
							<div class="form-group">
								<input type="number" name="template_total" class="form-control input-lg" placeholder="Total Template" value="{!! $pricing->template_total !!}">
							</div>
							<div class="form-group">
								<input type="text" name="url" class="form-control input-lg" placeholder="URL Detail" value="{!! $pricing->url !!}">
							</div>							
							@if (GlobalClass::checkPricing($pricing->pricing))
								<div class="form-group">
									<input type="number" name="price_email" class="form-control input-lg" placeholder="Max" value="{!! $pricing->price_email !!}">
								</div>
							@endif
						</div>
						<div class="col-md-3">
							<strong><p>Layanan</p></strong>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="domain" {{$pricing->domain==true?'checked':'false'}}>
								<label class="form-check-label">Domain</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="sender" {{$pricing->sender==true?'checked':'false'}}>
								<label class="form-check-label">Sender</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="slicing" {{$pricing->slicing==true?'checked':'false'}}>
								<label class="form-check-label">Slicing</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="template" {{$pricing->template==true?'checked':'false'}}>
								<label class="form-check-label">Template</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="bestseller" {{$pricing->bestseller==true?'checked':'false'}}>
								<label class="form-check-label">Best seller</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<div class="btn-group dropup">
									<button name="status" value="publish" class="btn btn-primary">Save pricing</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
