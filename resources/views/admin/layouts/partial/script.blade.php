<script src="{{ asset('assets') }}/admin/libs/jquery/jquery/dist/jquery.js"></script>
<script src="{{ asset('assets') }}/admin/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-load.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-jp.config.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-jp.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-nav.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-toggle.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-client.js"></script>
<script src="{{ asset('assets') }}/admin/js/ui-client.js"></script>
<!--Froala Editor-->
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/froala_editor.min.js" ></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/align.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/char_counter.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/code_beautifier.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/code_view.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/colors.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/draggable.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/entities.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/font_size.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/fullscreen.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/image.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/image_manager.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/line_breaker.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/link.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/lists.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/paragraph_format.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/quote.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/table.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/save.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/url.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/admin/libs/jquery/froala/js/plugins/video.min.js"></script>
<script src="{{ asset('assets') }}/admin/libs/dropzone/dropzone.js"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.4.1/js/swiper.min.js"></script>

<!-- Fancybox -->
<script src="{{ asset('assets') }}/admin/libs/fancybox/jquery.fancybox.min.js"></script>

<!--Nestable-->
<script src="{{ asset('assets') }}/admin/libs/jquery/nestable/jquery.nestable.js"></script>

<!--ColorPicker-->
<script src="{{ asset('assets') }}/admin/libs/colorpicker/js/bootstrap-colorpicker.js"></script>


<!--Component-->
<script src="{{ asset('assets') }}/admin/js/component-script.js"></script>
<script src="{{ asset('assets') }}/admin/js/component-jquery.js"></script>
<script src="{{ asset('assets') }}/admin/js/jquery.twbsPagination.min.js"></script>

<!--Sticky-->
<script src="{{ asset('assets') }}/admin/libs/sticky/dist/theia-sticky-sidebar.min.js"></script>
<script src="{{ asset('assets') }}/admin/libs/sticky/dist/ResizeSensor.min.js"></script>

<script type="text/javascript">
  $(function() {
    $('.chosen-select').chosen();
    $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
  });
  $(document).ready(function(){    
    $('.loader').hide();
    $('#aside').theiaStickySidebar({
      additionalMarginTop: 30
    });
    $.ajax({
       url: '{{ route('list_menu') }}',
       type: 'GET',
       dataType: 'JSON',
       success: function (data) {
         $(".editor").froalaEditor({
           height: 200,
           linkList: data,
           theme: "custom",
           imageMaxSize: 1024 * 1024 * 3,
           imageUploadURL: "{{route('upload_image')}}",
           imageUploadParams: 'file_name',
           imageUploadMethod: 'POST',
           imageUploadParams: {
             froala: 'true',
             _token: "{{ csrf_token() }}"
           },
           imageManagerPreloader: "/assets/admin/img/load.gif",
           imageManagerLoadURL: '{{route('list_image')}}',
           imageManagerLoadMethod: "GET",
           imageManagerPageSize: 20,
           imageManagerScrollOffset: 10
         });
       }
    });

  });

</script>
