<div class="row-fluid">
	<div class="tabbable tabs-left">
		<ul class="nav nav-tabs">
			@foreach($languages as $key => $lang)
				<li class="{{ $key != 0 ?: 'active' }}"><a href="#lang{{$lang->id}}" data-toggle="tab">{{ $lang->name }}</a></li>
			@endforeach
		</ul>
		<div class="tab-content">
			@foreach($languages as $key => $lang)
			<div class="tab-pane fade in {{ $key != 0 ?: 'active' }}" id="lang{{$lang->id}}">
				@foreach ($attributes[$lang->id] as $k => $attr)
				<div class="control-group">
					{{ Form::label('attributes.'.$lang->id. '.'. $k, $attr['label'], array('class' => 'control-label')) }}
					<div class="controls">
						{{ Form::text('attributes.'.$lang->id. '.'. $k, Input::old('attributes.'.$lang->id. '.'. $k) ?: $attr['value'], array('class' => '')) }}
					</div>
				</div>
				@endforeach
			</div>
			@endforeach
		</div>
	</div>
</div>