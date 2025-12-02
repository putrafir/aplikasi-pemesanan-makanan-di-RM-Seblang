<x-guest-layout>

    <div class="flex flex-col flex-1 w-full lg:w-1/2">
        <div
            class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto"
          >
            <div class="mb-5 sm:mb-8">
                <h1
                  class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md"
                >
                  Sign In
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  Enter your email and password to sign in!
                </p>
            </div>
            
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    
   

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                

                
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                
                        </div>

                    <x-primary-button class="mt-4 w-full">
                        {{ __('Log in') }}
                    </x-primary-button>
                
            </form>
        </div>
        
    </div>


    <div
          class="relative items-center hidden w-full h-full bg-blue-900 dark:bg-white/5 lg:grid lg:w-1/2"
        >
          <div class="flex items-center justify-center z-1">
            <!-- ===== Common Grid Shape Start ===== -->
            <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]">
  <img src="src/images/shape/grid-01.svg" alt="grid" />
</div>
<div
  class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]"
>
  <img src="src/images/shape/grid-01.svg" alt="grid" />
</div>

            <div class="flex flex-col items-center max-w-xs">
              {{-- <a href="#" class="block mb-4">
                <img src="src/images/logo/auth-logo.svg" alt="Logo" />
              </a> --}}
              <h1 class="text-center text-white">Halo, Selamat Datang!</h1>
              <p class="text-center text-gray-400 dark:text-white/60">
                Ayo masuk dan mulai mengelola pesanan di Warung Seblang.
              </p>
            </div>
          </div>
        </div>
</x-guest-layout>
