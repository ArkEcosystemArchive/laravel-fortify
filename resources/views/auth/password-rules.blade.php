<div {{ $attributes }}>
    <div class="flex flex-1">
        {{ $slot }}
    </div>
    
    <div class="flex flex-wrap -mx-4 text-sm">
        @foreach($passwordRules as $ruleName => $ruleIsValid)
        <div class="flex items-center w-1/2 px-4 my-1 @if($ruleIsValid) text-theme-secondary-600 @else text-theme-secondary-500 @endif">
            <span class="block w-2 h-2 mr-2 rounded-full @if($ruleIsValid) bg-theme-primary-500 @else bg-theme-secondary-400 @endif"></span>

            <span>
                @lang('fortify::forms.password_rules.' . Str::snake($ruleName))
            </span>
        </div>
        @endforeach
    </div>
</div>
