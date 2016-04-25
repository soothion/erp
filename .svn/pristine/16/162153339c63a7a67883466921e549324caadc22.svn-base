@extends('layouts.master')

@section('title')
	{{ trans('image') }} @parent
@stop

@section('content')

<div class="span12">

	<div class="widget stacked">
		<div class="widget-header">
			<i class="icon-th-large"></i>
			<h3>{{ trans('images') }}</h3>
		</div>

		<div class="widget-content">
			<ul class="gallery-container">
				@foreach($images as $image)
				<li>
					<a href="/img/l/{{ $image->id }}" class="lightbox"><img src="/img/s/{{ $image->id }}" alt="{{ $image->desc }}"></a>

					<a href="/img/l/{{ $image->id }}" class="preview" alt=""></a>
					@if(Sentry::getUser()->hasAccess('core.item.image.destory'))
						{{ Form::open(array('url' => route('core.item.image.destroy', $image->id), 'method' => 'DELETE', 'class' => 'form-inline')) }}
						<a href="" class="btn">{{ trans('replace') }}</a>
						<button type="submit" class="btn">{{ trans('delete') }}</button>
						{{ Form::close() }}
					@endif
				</li>
				@endforeach
			</ul>

			<form id="upload-form">
				<div id="uploader">
					<p></p>
				</div>
			</form>
		</div>
	</div>

</div>

@stop

@section('css')
	@parent
	<style type="text/css">@import url({{ asset('packages/bluebanner/ui/js/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css') }});</style>
@stop

@section('script')
	@parent
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/jquery.hoverIntent.minified.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/jquery.lightbox.min.js') }}"></script>

	<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/plupload/plupload.full.js') }}"></script>
	<script type="text/javascript" src="{{ asset('packages/bluebanner/ui/js/plupload/jquery.plupload.queue/jquery.plupload.queue.js') }}"></script>
	<script type="text/javascript">
	// Convert divs to queue widgets when the DOM is ready
	$(function() {

		$('.gallery-container > li').hoverIntent({
			over: showPreview,
		     timeout: 500,
		     out: hidePreview,
		     sensitivity: 4
		});
		
		function showPreview () {
			$(this).find ('.preview').fadeIn ();
		}
		
		function hidePreview () {
			$(this).find ('.preview').fadeOut ();
		}
		
		setTimeout (function () {
			$('.gallery-container > li').each (function () {
				var preview, img, width, height;
				
				preview = $(this).find ('.preview');
				img = $(this).find ('img');
				
				width = img.width ();
				height = img.height ();
				
				preview.css ({ width: width });
				preview.css ({ height: height });
				
				preview.addClass ('ui-lightbox');
			});
		}, 500);


		$("#uploader").pluploadQueue({
			// General settings
			// runtimes : 'gears,flash,silverlight,browserplus,html5',
			runtimes: 'html5',
			url : '{{ route('core.item.image.store') }}',
			multipart_params: {id: {{ $id }} },
			max_file_size : '10mb',
			// chunk_size : '1mb',
			unique_names : true,

			// Resize images on clientside if we can
			// resize : {width : 320, height : 240, quality : 90},

			// Specify what files to browse for
			filters : [
				{title : "Image files", extensions : "jpg,gif,png"}
			],

			// Flash settings
			flash_swf_url : '{{ asset('packages/bluebanner/ui/img/plupload.flash.swf') }}',

			// Silverlight settings
			silverlight_xap_url : '/plupload/js/plupload.silverlight.xap'
		});

		// Client side form validation
		$('#upload-form').submit(function(e) {
	        var uploader = $('#uploader').pluploadQueue();

	        // Files in queue upload them first
	        if (uploader.files.length > 0) {
	            // When all files are uploaded submit form
	            uploader.bind('StateChanged', function() {
	                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
	                    $('#upload-form').submit();
	                }
	            });
	                
	            uploader.start();
	        } else {
	            alert('You must queue at least one file.');
	        }

	        return false;
	    });
	});
	</script>
@stop