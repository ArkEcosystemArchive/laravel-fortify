@props(['passwordRules', 'isTyping'])
<div {{ $attributes }}>
    <div class="flex flex-1">
        {{ $slot }}
    </div>

    <div class="flex flex-col text-sm mb-8">
            <span x-show="!isTyping">@lang('fortify::forms.update-password.requirements_notice')</span>

            <div x-show="isTyping">
                @foreach($passwordRules as $ruleName => $ruleIsValid)
                    <div class="flex items-center w-full mt-4 space-x-2">
                        @if ($ruleIsValid)
                            <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 rounded-full bg-theme-success-200">
                                @svg('checkmark', 'text-theme-success-500 h-2 w-2')
                        @elseif(! $ruleIsValid)
                            <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 rounded-full border-2 border-theme-secondary-700">
                        @else
                            <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 rounded-full bg-theme-danger-200">
                                @svg('exclamation', 'text-theme-danger-500 h-5 w-5')
                        @endif
                            </div>
                        <span class="text-theme-secondary-900">@lang('fortify::forms.password-rules.' .Str::snake($ruleName))</span>
                    </div>
                @endforeach
            </div>
    </div>
</div>
