<div class="flex max-w-xl p-8 mx-auto my-6 bg-white rounded-lg">
    <div class="flex flex-col w-full text-center space-y-6">
        <div class="space-y-4">
            <h1>@lang('fortify::auth.verify.page_header')</h1>

            <p>@lang('fortify::auth.verify.link_description')</p>
        </div>

        <img class="mb-5 mx-12" src="/images/auth/verify-email.svg" />

        <form wire:click.prevent="resend">
            <p class="text-sm text-theme-secondary-600 lg:no-wrap-span-children">
                <span>@lang('fortify::auth.verify.line_1')</span>
                <span>@lang('fortify::auth.verify.line_2')</span>
                <span wire:poll.visible="checkRateLimit" @if($limitReached) data-tippy-content="@lang('fortify::messages.resend_email_verification_limit')" @endif>
                    <button @if($limitReached) disabled @endif wire:loading.attr="disabled" type="submit" class="link">
                        @lang('fortify::actions.resend_email_verification')
                    </button>
                </span>
            </p>
        </form>
    </div>
</div>
