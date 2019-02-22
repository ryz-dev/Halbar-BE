<div class="modal fade" id="modal-galleries" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="container-fluid">
					<div class="dropzone dz-clickable" id="uploadImages">
						<div class="dz-message">
							<h3>Drop files here or click to upload.</h3>
							<p>Pilih gambar dengan format PNG, JPG & JPEG - Ukuran Maks 5 Mb</p>
						</div>
					</div>
					<p id="notif"></p>
					<div class="media" id='boxGalleries'>
						<div class="row" id='boxImages'></div>
						<div class="box-pagination">
							<ul class="pagination" id="pagination"></ul>
						</div>						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default closeModal" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@section('registerscript')
	<script type="text/javascript">
		var page = 0;
		Dropzone.autoDiscover = false;
		$('#uploadImages').dropzone({
			url: "{{ route('images_store') }}",
			autoProcessQueue: true,
			method:"post",
			acceptedFiles:"image/*",
			paramName:"filename",
			maxFilesize: 10,
			addRemoveLinks:true,
			sending: function(file, xhr, formData) {
				formData.append("_token", "{{ csrf_token() }}");
			},
			init: function() {
				this.on("success",function(file, done){
					$('#pagination').twbsPagination('destroy');
					$.ajax({
						url:'{{route('images_list')}}',
						type:'GET',
						dataType:'JSON',
						success: function(data) {
							$('#pagination').twbsPagination({
								totalPages: data.paging.last_page,
								visiblePages: 5,
								onPageClick: function (event, page) {
									dataImg(page);
								}
							});
						}
					});							
					this.removeFile(file);
				});
				this.on("error", function(file, done) { 
					$('.dz-error-message span').text('This image rejected by server');
				});				
			}
		});

		$('.closeModal').click(function() {
			Dropzone.forElement("#uploadImages").removeAllFiles(true);
		});

	  	$('#modal-delete').on('show.bs.modal', function (e) {
			var id = $(e.relatedTarget).data('id');
			$(this).find('input[name="id"]').val(id);
		});

		var dataImg = function(page) {
			$.ajax({
				url:'{{route('images_list')}}?page='+page,
				type:'GET',
				dataType:'JSON',
				beforeSend: function() {
					$('.loader').show();
				},
				success: function(data) {
					var html = "";
					for (let i = 0; i < data.data.length; i++) {
						var img = data.data[i].url;
						var tag = data.data[i].tag;
						html += `<div class="col-md-2 item"><button type="button" onclick="selectImg('`+img+`','`+tag+`')" data-value="`+tag+`" class='selectCustomizer btn btn-success delete'>Select</button><div class='media-item' style='background-image:url(`+img+`);'></div></div>`;
					}						
					$('.loader').hide();
					$('#boxImages').html(html);
				}
			})
		};

		$('#pagination').twbsPagination('destroy');
		$.ajax({
			url:'{{route('images_list')}}',
			type:'GET',
			dataType:'JSON',
			success: function(data) {
				$('#pagination').twbsPagination({
					totalPages: data.paging.last_page,
					visiblePages: 5,
					onPageClick: function (event, page) {
						dataImg(page);
					}
				});
			}
		});			
		
		$(document).ready(function(){
			$('.form-group>.btn-default').click(function(){
				dataImg(page);
			});
		});
	</script>
@endsection
