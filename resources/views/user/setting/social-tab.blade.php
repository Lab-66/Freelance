<div class="row">

    @foreach(app('App\Social\SocialManager')->getProviders() as $providerKey => $provider)
    <div class="col-md-12">
        <legend>{{ $provider->getRequiredSettings()['title'] }}</legend>
        <div class="col-md-6">
            @foreach($provider->getRequiredSettings()['settings'] as $setting)
            <div class="form-group required {{ $errors->has($setting['id']) ? 'has-error' : '' }}">
                {!! Form::label($setting['id'], $setting['title'], array('class' => 'control-label')) !!}
                <div class="controls">
                    {!! Form::text($setting['id'], old($setting['id'], Settings::get($setting['id'])), array('class' => 'form-control')) !!}
                    <span class="help-block">{{ $errors->first($setting['id'], ':message') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-6">
        @if($provider->isInitialized())
                @if(!$provider->isLoggedIn())
                    <a href="{{ $provider->getLoginUrl() }}">{{trans('social.login.admin', ['social' => $providerKey])}}</a>
                @else
                    <a href="{{ route('social.logout', [$providerKey]) }}">Logout of {{$providerKey}}</a>
                    @if(view()->exists('user.setting.social.'.$providerKey))
                        @include('user.setting.social.'.$providerKey)
                    @endif
                @endif
        @endif
        </div>
    </div>
    @endforeach

</div>
