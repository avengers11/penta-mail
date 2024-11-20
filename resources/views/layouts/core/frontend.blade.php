<!DOCTYPE html>
<html lang="en">
<head>
	@include('layouts.core._head')

	@include('layouts.core._script_vars')

	@yield('head')

	@if (getThemeMode(Auth::user()->customer->theme_mode, request()->session()->get('customer-auto-theme-mode')) == 'dark')
		<meta name="theme-color" content="{{ getThemeColor(
			Auth::user()->customer->getColorScheme()) }}">
	@elseif (Auth::user()->customer->getMenuLayout() == 'left')
		<meta name="theme-color" content="#eff3f5">
	@endif

	<script>
		@if (Auth::user()->customer->theme_mode == 'auto')
			var ECHARTS_THEME = isDarkMode() ? 'dark' : null

			// auto detect dark-mode
			$(function() {
				autoDetechDarkMode('{{ action('AccountController@saveAutoThemeMode') }}');
			});
		@else
			var ECHARTS_THEME = '{{ Auth::user()->customer->theme_mode == 'dark' ? 'dark' : null }}';
		@endif
	</script>

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="{{ AppUrl::asset('core/css/theme/'.Auth::user()->customer->getColorScheme().'.css') }}">
	<link rel="stylesheet" href="{{ asset("pentaforce/dashboard.css") }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="theme-{{ Auth::user()->customer->getColorScheme() }} {{ Auth::user()->customer->getMenuLayout() }}bar
	{{ Auth::user()->customer->getMenuLayout() }}bar-{{ request()->session()->get('customer-leftbar-state') }} state-{{ request()->session()->get('customer-leftbar-state') }}
	fullscreen-search-box
	mode-{{ getThemeMode(Auth::user()->customer->theme_mode, request()->session()->get('customer-auto-theme-mode'))  }}
">
	<main class="container page-container px-3">
		<div class="nav-top-options">
			<div class="part1">
				<div class="items-wrapper">
					<a class="items {{ $menu == 'dashboard' ? 'active' : '' }}" href="{{ action('HomeController@index') }}">
						<i class="fa-solid fa-house"></i>
						<p>{{"Dashboard"}}</p>
					</a>
			
					<a class="items {{ $menu == 'campaign' ? 'active' : '' }}" href="{{ action('CampaignController@index') }}">
						<i class="fa-solid fa-paper-plane"></i>
						<p>{{"Campaigns"}}</p>
					</a>
			
					<a class="items {{ $menu == 'automation' ? 'active' : '' }}" href="{{ action('Automation2Controller@index') }}">
						<i class="fa-solid fa-wand-magic-sparkles"></i>
						<p>{{"Automations"}}</p>
					</a>
			
					<a class="items {{ in_array($menu, ['overview','list','subscriber','segment','form']) ? 'active' : '' }}" href="{{ action('AudienceController@overview') }}">
						<i class="fa-solid fa-list"></i>
						<p>{{"Lists"}}</p>
					</a>
			
					<a class="items {{ $menu == 'template' ? 'active' : '' }}" href="{{ action('TemplateController@index') }}">
						<i class="fa-solid fa-file"></i>
						<p>{{"Templates"}}</p>
					</a>
					
					@if (
						Auth::user()->customer->can("read", new Acelle\Model\SendingServer()) ||					
						Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->useOwnEmailVerificationServer() ||
						Auth::user()->customer->can("read", new Acelle\Model\Blacklist()) ||
						true
					)
						<a class="items {{ in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']) ? 'active' : '' }}" href="{{ action('SendingServerController@index') }}">
							<i class="fa-solid fa-square-share-nodes"></i>
							<p>{{"Sending"}}</p>
						</a>
					@endif

					<a class="items" href="{{ action('SubscriptionController@index') }}">
						<i class="fa-solid fa-box-open"></i>
						<p>{{"Subscription"}}</p>
					</a>
				</div>
			
				<img class="blog-sub-angle d-none" src="{{asset('web/icons/blog-sub-shep.png')}}" alt="">
			</div>

			{{--Lists--}}
			@if(in_array($menu, ['overview','list','subscriber','segment','form']))
				<div class="sub-items-wrapper overview">
					<h2>Lists</h2>
					<div class="items">
						<div class="item {{ $menu == 'overview' ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ action('AudienceController@overview') }}">
                                <p>{{ trans('messages.audience.overview') }}</p>
                            </a>
                        </div>
                        <div class="item {{ $menu == 'list' ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ action('MailListController@index') }}">
                                <p>{{ trans('messages.lists') }}</p>
                            </a>
                        </div>
                        @if (Auth::user()->customer->mailLists()->count())
                            <div class="item {{ $menu == 'subscriber' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ action('SubscriberController@index', [
                                    'list_uid' => Auth::user()->customer->mailLists()->first() ? Auth::user()->customer->mailLists()->first()->uid : null,
                                ]) }}">
                                    <p>{{ trans('messages.contacts') }}</p>
                                </a>
                            </div>
                            @if (Auth::user()->customer->can("list", new Acelle\Model\Segment()))
                                <div class="item {{ $menu == 'segment' ? 'active' : '' }}">
                                    <a class="d-flex align-items-center" href="{{ action('SegmentController@index', [
                                        'list_uid' => Auth::user()->customer->mailLists()->first() ? Auth::user()->customer->mailLists()->first()->uid : null,
                                    ]) }}">
                                        <p>{{ trans('messages.segments') }}</p>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="item {{ $menu == 'subscriber' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ action('SubscriberController@noList') }}">
                                    <p>{{ trans('messages.contacts') }}</p>
                                </a>
                            </div>
                            @if (Auth::user()->customer->can("list", new Acelle\Model\Segment()))
                                <div class="item {{ $menu == 'segment' ? 'active' : '' }}">
                                    <a class="d-flex align-items-center" href="{{ action('SegmentController@noList') }}">
                                        <p>{{ trans('messages.segments') }}</p>
                                    </a>
                                </div>
                            @endif
                        @endif
                        @if (Auth::user()->customer->can("list", new Acelle\Model\Form()))
                            <div class="item {{ $menu == 'form' ? 'active' : '' }}">
                                <a class="d-flex align-items-center" href="{{ action('FormController@index') }}">
                                    <p>{{ trans('messages.forms') }}</p>
                                </a>
                            </div>
                        @endif
					</div>
				</div>
			@endif

			{{--Sendning--}}
			@if(in_array($menu, ['sending_server','sending_domain','sender','tracking_domain','email_verification','blacklist']))
				<div class="sub-items-wrapper categories">
					<h2>Sending</h2>
					<div class="items">
						@if (Auth::user()->customer->can("read", new Acelle\Model\SendingServer()))
							<div class="item {{ $menu == 'sending_server' ? 'active' : '' }}">
								<a href="{{ action('SendingServerController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.sending_servers') }}</p>
								</a>
							</div>
						@endif

						@if (Auth::user()->customer->allowVerifyingOwnDomains())
							<div class="item {{ $menu == 'sending_domain' ? 'active' : '' }}" rel1="SendingDomainController">
								<a href="{{ action('SendingDomainController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.sending_domains') }}</p>
								</a>
							</div>
						@endif

						@if (Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->allowSenderVerification())
							<div class="item {{ $menu == 'sender' ? 'active' : '' }}">
								<a href="{{ action('SenderController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.verified_senders') }}</p>
								</a>
							</div>
						@endif

						@if (\Acelle\Model\Setting::isYes('campaign.tracking_domain'))

							<div class="item {{ $menu == 'tracking_domain' ? 'active' : '' }}">
								<a href="{{ action('TrackingDomainController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.tracking_domains') }}</p>
								</a>
							</div>

						@endif

						@if (Auth::user()->customer->getCurrentActiveGeneralSubscription()->planGeneral->useOwnEmailVerificationServer())
							<div class="item {{ $menu == 'email_verification' ? 'active' : '' }}">
								<a href="{{ action('EmailVerificationServerController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.email_verification_servers') }}</p>
								</a>
							</div>
						@endif
						@if (Auth::user()->customer->can("read", new Acelle\Model\Blacklist()))
							<div class="item {{ $menu == 'blacklist' ? 'active' : '' }}">
								<a href="{{ action('BlacklistController@index') }}" class="dropdown-item d-flex align-items-center">
									<p>{{ trans('messages.blacklist') }}</p>
								</a>
							</div>
						@endif
					</div>
				</div>
			@endif
		</div>
		
		<!-- main inner content -->
		<div id="page-content-wrapper">
			@yield('page_header')
			<!-- display flash message -->
			@include('layouts.core._errors')
			@yield('content')
		</div>

	</main>

	<!-- Admin area -->
	@include('layouts.core._admin_area')

	@if (!config('config.saas'))
		<!-- Admin area -->
		@include('layouts.core._loginas_area')
	@endif

	<!-- Notification -->
	@include('layouts.core._notify')
	@include('layouts.core._notify_frontend')

	<!-- display flash message -->
	@include('layouts.core._flash')

	<script>
		var wizardUserPopup;

		$(function() {
			// auto detect dark mode


			// Customer color scheme | menu layout wizard
			@if (false)
				$(function() {
					wizardUserPopup = new Popup({
						url: '{{ action('AccountController@wizardColorScheme') }}',
					});
					wizardUserPopup.load();
				});
			@endif
			
			@if (null !== Session::get('orig_admin_id') && Auth::user()->admin)
				notify({
					type: 'warning',
					message: `{!! trans('messages.current_login_as', ["name" => Auth::user()->customer->displayName()]) !!}<br>{!! trans('messages.click_to_return_to_origin_user', ["link" => action("Admin\AdminController@loginBack")]) !!}`,
					timeout: false,
				});
			@endif
		
			@if (null !== Session::get('orig_admin_id') && Auth::user()->admin)
				notify({
					type: 'warning',
					message: `{!! trans('messages.site_is_offline') !!}`,
					timeout: false,
				});
			@endif
		})
			
	</script>

	{!! \Acelle\Model\Setting::get('custom_script') !!}
</body>
</html>