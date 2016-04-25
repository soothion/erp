<div class="row-fluid">
	<div class="span6">
		<fieldset>
			<div class="control-group">											
				{{ Form::label('is_drop', trans('item.dropship'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::checkbox('is_drop', '1', Input::old('is_drop') ?: $item->is_drop, array('class' => '')) }}
				</div>
			</div>

			<div class="control-group">
				{{ Form::label('is_virtual', trans('item.virtual'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::checkbox('is_virtual', '1', Input::old('is_virtual') ?: $item->is_virtual, array('class' => '')) }}
				</div>
			</div>

			<div class="control-group">											
				{{ Form::label('length', trans('item.length'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('length', Input::old('length') ?: $item->length, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('width', trans('item.width'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('width', Input::old('width') ?: $item->width, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('height', trans('item.height'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('height', Input::old('height') ?: $item->height, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('weight', trans('item.weight'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('weight', Input::old('weight') ?: $item->weight, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('reserve_qty', trans('item.reserve_qty'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('reserve_qty', Input::old('reserve_qty') ?: $item->reserve_qty, array('class' => '')) }}
				</div>
			</div>


		</fieldset>
	</div>

	<div class="span6">
		<fieldset>
			<div class="control-group">											
				{{ Form::label('active', trans('item.active'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::checkbox('active', '1', Input::old('active') ?: $item->active, array('class' => '')) }}
				</div>
			</div>

			<div class="control-group">
				{{ Form::label('is_hold_inv', trans('item.hold_inv'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::checkbox('is_hold_inv', '1', Input::old('is_hold_inv') ?: $item->is_hold_inv, array('class' => '')) }}
				</div>
			</div>

			<div class="control-group">											
				{{ Form::label('length', trans('item.length'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('length', Input::old('length') ?: $item->length, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('width', trans('item.width'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('width', Input::old('width') ?: $item->width, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('height', trans('item.height'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('height', Input::old('height') ?: $item->height, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('weight', trans('item.weight'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('weight', Input::old('weight') ?: $item->weight, array('class' => '')) }}
				</div>
			</div>
			
			<div class="control-group">											
				{{ Form::label('reserve_day', trans('item.reserve_day'), array('class' => 'control-label')) }}
				<div class="controls">
					{{ Form::number('reserve_day', Input::old('reserve_day') ?: $item->reserve_day, array('class' => '')) }}
				</div>
			</div>

		</fieldset>
	</div>


</div>