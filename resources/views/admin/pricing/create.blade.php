@extends('admin.layouts.main')
@section('title', 'Pricing Item Create')
@section('contents')
	<div class="bg-light lter b-b wrapper-md">
		<h1 class="m-n font-thin h3">New Pricing</h1>
		<small class="text-muted">With pricing, users will feel closer to your business.</small>
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
		<div class="panel direktori">
			<div class="panel-body">
				<form action="{{ route('item_pricing_store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="idgroup" value="{{Request::segment(5)}}">
					<div class="row">
						<div class="col-md-9">
							<div class="form-group">
								<input type="text" name="name_paket" class="form-control input-lg" placeholder="Name Item" value="{!! old('name_paket') !!}">
							</div>
							<div class="form-group">
								<input type="number" name="total_email" class="form-control input-lg" placeholder="Total Email" value="{!! old('total_email') !!}">
							</div>
							<div class="form-group">
								<input type="number" name="total_harga" class="form-control input-lg" placeholder="Price" value="{!! old('total_harga') !!}">
							</div>
							<div class="form-group">
								<input type="number" name="template_total" class="form-control input-lg" placeholder="Total Template" value="{!! old('template_total') !!}">
							</div>
							<div class="form-group">
								<input type="text" name="url" class="form-control input-lg" placeholder="URL Detail" value="{!! old('url') !!}">
							</div>
							@if (GlobalClass::checkPricing(Request::segment(5)))
								<div class="form-group">
									<input type="number" name="price_email" class="form-control input-lg" placeholder="Max" value="{!! old('price_email') !!}">
								</div>
							@endif
						</div>
						<div class="col-md-3">
							<strong><p>Layanan</p></strong>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="domain">
								<label class="form-check-label">Domain</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="sender">
								<label class="form-check-label">Sender</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="slicing">
								<label class="form-check-label">Slicing</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="template">
								<label class="form-check-label">Template</label>
							</div>
							<div class="form-group">
								<input type="checkbox" class="form-check-input" name="bestseller">
								<label class="form-check-label">Best seller</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							<div class="col-md-12 text-right">
								<div class="btn-group dropup">
									<button name="status" value="publish" class="btn btn-primary">Add new pricing</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
