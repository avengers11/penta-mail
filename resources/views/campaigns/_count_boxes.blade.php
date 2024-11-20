<div class="row mt-5 pt-5">
    <div class="col-md-3">
        <div class="bg-color1 p-3 shadow rounded-3 text-white">
            <div class="text-center">
                <h2 class="text-light mb-1 mt-0">{{ $campaign->uniqueOpenCount() }}</h2>
                <div class="text-light text-white">{{ trans('messages.opened') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-color2 p-3 shadow rounded-3 text-white">
            <div class="text-center">
                <h2 class="text-light mb-1 mt-0">{{ $campaign->clickCount() }}</h2>
                <div class="text-light">{{ trans('messages.clicked') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-color4 bg-secondary p-3 shadow rounded-3 text-white">
            <div class="text-center">
                <h2 class="text-light mb-1 mt-0">{{ $campaign->bounceCount() }}</h2>
                <div class="text-light">{{ trans('messages.bounced') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="bg-color3 bg-secondary p-3 shadow rounded-3 text-white">
            <div class="text-center">
                <h2 class="text-light mb-1 mt-0">{{ $campaign->unsubscribeCount() }}</h2>
                <div class="text-light">{{ trans('messages.unsubscribed') }}</div>
            </div>
        </div>
    </div>
</div>