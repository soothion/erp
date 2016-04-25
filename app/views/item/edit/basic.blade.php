<fieldset>
	<div class="control-group">											
		{{ Form::label('sku', trans('item.sku'), array('class' => 'control-label')) }}
		<div class="controls">
			<span class="uneditable-input">{{ $item->sku }}</span>
			<p class="help-block">{{ trans('SKU is required and uniqued.') }}</p>
		</div>
	</div>

	<div class="control-group">
		{{ Form::label('category_id', trans('item.category'), array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::select('category_id', $categories, Input::old('category_id') ?: $item->category_id, array('class' => '')) }}
		</div>
	</div>

	<div class="control-group">											
		{{ Form::label('line_state', trans('item.state'), array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::select('line_state', $status, Input::old('line_state') ?: $item->line_state, array('class' => '')) }}
		</div>
	</div>

	<div class="control-group">
		{{ Form::label('description', trans('item.description'), array('class' => 'control-label')) }}
		<div class="controls">
			{{ Form::textarea('description', Input::old('description') ?: $item->description, array('class' => '')) }}
		</div>
	</div>
</fieldset>