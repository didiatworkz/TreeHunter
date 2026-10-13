<?php

use App\Models\User;
use Illuminate\Auth\Events\Login;
use function Laravel\Folio\{middleware, name};
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

middleware(['guest']);
name('login');

new class extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $remember = false;

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        event(new Login(auth()->guard('web'), User::where('email', $this->email)->first(), $this->remember));

        return redirect()->intended('/');
    }
};

?>

<x-layouts.main>

    <div class="flex flex-col items-stretch justify-center w-screen min-h-screen py-10 sm:items-center">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-ui.link href="{{ route('home') }}">
                <x-ui.logo class="w-auto h-10 mx-auto text-gray-700 fill-current dark:text-gray-100" />
            </x-ui.link>

            <h2 class="mt-5 text-2xl font-extrabold leading-9 text-center text-gray-800 dark:text-gray-200">{{ __('ui.sign_in_account') }}</h2>
            @if(config('treehunter.registration_enabled'))
                <div class="text-sm leading-5 text-center text-gray-600 dark:text-gray-400 space-x-0.5">
                    <span>{{ __('ui.or') }}</span>
                    <x-ui.text-link href="{{ route('register') }}">{{ __('ui.create_new_account') }}</x-ui.text-link>
                </div>
            @endif
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-10 py-0 sm:py-8 sm:shadow-sm sm:bg-white dark:sm:bg-gray-950/50 dark:border-gray-200/10 sm:border sm:rounded-lg border-gray-200/60">
                @volt('auth.login')
                <form wire:submit="authenticate" class="space-y-6">

                    <x-ui.input :label="__('ui.email_address')" type="email" id="email" name="email" wire:model="email" />
                    <x-ui.input :label="__('ui.password')" type="password" id="password" name="password" wire:model="password" />

                    <div class="flex items-center justify-between mt-6 text-sm leading-5">
                        <x-ui.checkbox :label="__('ui.remember_me')" id="remember" name="remember" wire:model="remember" />
                        <x-ui.text-link href="{{ route('password.request') }}">{{ __('ui.forgot_password') }}</x-ui.text-link>
                    </div>

                    <x-ui.button type="primary" rounded="md" submit="true">{{ __('ui.sign_in') }}</x-ui.button>
                </form>
                @endvolt
            </div>
        </div>

    </div>

</x-layouts.main>
