@extends('layouts.popup.small')

@section('content')
    <div class="mc_section">
        <form id="sendingLimitForm" action="{{ action('SendingServerController@sendingLimit', ['uid' => ($server->uid ? $server->uid : 0)]) }}" method="POST">
            {{ csrf_field() }}
        
            <h2 class="text-semibold">{{ trans('messages.sending_quota') }}</h2>
            
            <p>{!! trans('messages.options.wording') !!}</p>
                
            <div class="row boxing">
                <div class="col-md-4">
                    @include('helpers.form_control', [
                        'type' => 'text',
                        'class' => 'numeric',
                        'name' => 'quota_value',
                        'value' => $server->quota_value,
                        'help_class' => 'sending_server',
                        'default_value' => '1000',
                    ])
                </div>
                <div class="col-md-4">
                    @include('helpers.form_control', [
                        'type' => 'text',
                        'class' => 'numeric',
                        'name' => 'quota_base',
                        'value' => $server->quota_base,
                        'help_class' => 'sending_server',
                        'default_value' => '1',
                    ])
                </div>
                <div class="col-md-4">
                    @include('helpers.form_control', ['type' => 'select',
                        'name' => 'quota_unit',
                        'value' => $server->quota_unit,
                        'label' => trans('messages.quota_time_unit'),
                        'options' => Acelle\Model\PlanGeneral::quotaTimeUnitOptions(),
                        'include_blank' => trans('messages.choose'),
                        'help_class' => 'sending_server',
                    ])
                </div>
            </div>
            <hr>
            <div class="d-flex gap-2">
                <button class="btn btn-secondary add-btn">
                    <i class="fa-solid fa-xmark"></i>
                    <p>{{ trans('messages.save') }}</p>
                </button>
                <a href="{{ action('SendingServerController@index') }}" role="button" class="btn delete-btn" style="width: 80px">
                    <i class="fa-solid fa-xmark"></i>
                    <p>{{ trans('messages.cancel') }}</p>
                </a>
            </div>
        </form>
    </div>

    <script>
        $(function() {
            // trigger modal form submit
            $("#sendingLimitForm").submit(function( event ) {
                event.preventDefault();

                $.ajax({
                    url: $(this).prop('action'),
                    type: $(this).prop('method'),
                    dataType: 'html',
                    data: $(this).serialize(),
                }).done(function(response) {
                    SendingLimit.getSendingLimitPopup().hide();
                    $('.sendind-limit-select-custom').html(response);                    
                    initJs($('.sendind-limit-select-custom'));                    
                });
            });
        });
    </script>
@endsection