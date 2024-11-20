<div class="row">
	<div class="col-md-6">
		<p>{{ trans('messages.sender.new.wording') }}</p>
			
		<div class="sub_section">
			@include('helpers.form_control', [
				'type' => 'text',
				'name' => 'name',
				'value' => $sender->name,
				'help_class' => 'sender',
				'rules' => $sender->rules()
			])

			@include('helpers.form_control', [
				'type' => 'text',
				'disabled' => isset($sender->id),
				'name' => 'email',
				'value' => $sender->email,
				'help_class' => 'sender',
				'rules' => $sender->rules()
			])

		</div>
		<div class="d-flex gap-2">
			<button class="btn btn-secondary add-btn">
				<i class="fa-solid fa-plus"></i>
                <p>{{ trans('messages.save') }}</p>
			</button>
			<a href="{{ action("SenderController@index") }}" class="btn btn-secondary delete-btn">
				<i class="fa-solid fa-xmark"></i>
                <p>{{ trans('messages.cancel') }}</p>
			</a>
		</div>
	</div>
</div>
