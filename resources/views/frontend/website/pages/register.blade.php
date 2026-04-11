<x-everest::layouts.main>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-6">
            <x-everest::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" class="text-sm text-gray-600" />
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center mb-6">
                <h1 class="text-xl font-semibold text-gray-900 min-w-fit pr-4">{{ $this->getTitle() }}</h1>
                <div class="flex-grow h-px bg-gray-200"></div>
            </div>

            @if (!$registerComplete)
                @if ($allowRegistration)
                    <form wire:submit='register' class="space-y-6">
                        @error('throttle')
                            <div class="p-3 bg-red-50 text-red-700 text-sm rounded border border-red-100">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="grid gap-6 sm:grid-cols-6">
                            <!-- Personal Information -->
                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.given_name') }}
                                    @if($requiredFields['given_name'])<span class="text-red-500">*</span>@endif
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model="given_name" @if($requiredFields['given_name']) required @endif />
                                @error('given_name')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.family_name') }}
                                    @if($requiredFields['family_name'])<span class="text-red-500">*</span>@endif
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model="family_name" @if($requiredFields['family_name']) required @endif />
                                @error('family_name')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.public_name') }}
                                    @if($requiredFields['public_name'])<span class="text-red-500">*</span>@endif
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model="public_name" @if($requiredFields['public_name']) required @endif />
                                @error('public_name')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-gray-500">{{ __('general.public_name_helper') }}</p>
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.affiliation') }} 
                                    @if($requiredFields['affiliation'])<span class="text-red-500">*</span>@endif
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model="affiliation" @if($requiredFields['affiliation']) required @endif />
                                @error('affiliation')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.country') }} 
                                    @if($requiredFields['country'])<span class="text-red-500">*</span>@endif
                                </label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model='country' @if($requiredFields['country']) required @endif>
                                    <option value="none" selected disabled>{{ __('general.select_country') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->flag . ' ' . $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.phone') }} 
                                    @if($requiredFields['phone'])<span class="text-red-500">*</span>@endif
                                </label>
                                <input type="tel"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400"
                                    wire:model="phone" @if($requiredFields['phone']) required @endif />
                                @error('phone')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">{{ __('general.phone_format_international') }}</p>
                            </div>

                            <!-- Account Information -->
                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.email') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400" wire:model="email" required />
                                @error('email')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.password') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400" wire:model="password" required />
                                @error('password')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('general.password_confirmation') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-primary-200 focus:border-primary-400" wire:model="password_confirmation" required />
                                @error('password_confirmation')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Conference Roles -->
                            @if (isset($scheduledConference) && $scheduledConference && !empty($roles))
                            <div class="sm:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3 ">
                                    {{ __('general.register_as') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    @foreach ($roles as $role)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                                wire:model='selfAssignRoles' value="{{ $role }}" />
                                            <span class="text-sm text-gray-700">{{ $role }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selfAssignRoles')
                                    <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif


                            <!-- Multiple Conferences -->
                            @if (isset($scheduledConference) && !$scheduledConference)
                                <div class="sm:col-span-6 space-y-6">
                                    <p class="text-sm font-medium text-gray-700">{{ __('general.which_conference_interested_for') }}</p>
                                    @foreach ($conferences as $conference)
                                        <div class="space-y-3 p-4 bg-gray-50 rounded-lg">
                                            <h3 class="font-medium text-gray-900">{{ $conference->name }}</h3>
                                            <div class="space-y-2">
                                                @foreach ($roles as $role)
                                                    <label class="inline-flex items-center gap-2 cursor-pointer">
                                                        <input type="checkbox"
                                                            class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                                            wire:model='selfAssignRoles.{{ $conference->id }}.{{ $role }}'
                                                            value="{{ $role }}" />
                                                        <span class="text-sm text-gray-700">{{ $role }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Privacy Statement -->
                            <div class="sm:col-span-6">
                                <label class="inline-flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                        wire:model="privacy_statement_agree" required />
                                    <span class="text-sm text-gray-700">
                                        {!! __('general.privacy_statement_agree', ['url' => $privacyStatementUrl]) !!}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit"  class="px-4 py-2 button-banner submit border border-gray-300 text-gray-700 rounded-md  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"  wire:loading.attr="disabled">
                                <span class="loading loading-spinner loading-xs" wire:loading></span>
                                {{ __('general.register') }}
                            </button>
                            <x-everest::link class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" :href="$loginUrl">
                                {{ __('general.login') }}
                            </x-everest::link>
                        </div>
                    </form>
                @else
                    <p class="text-gray-700">{{ __('general.registration_closed') }}</p>
                @endif
            @else
                <div class="space-y-4">
                    <p class="text-gray-700">{{ __('general.registration_complete_message') }}</p>
                    <ul class="space-y-2 list-disc list-inside text-gray-700">
                        <li>
                            <x-everest::link class="text-primary-600 hover:text-blue-600" href="{{ route('filament.scheduledConference.pages.profile') }}">
                                {{ __('general.edit_my_profile') }}
                            </x-everest::link>
                        </li>
                        <li>
                            <x-everest::link class="text-primary-600 hover:text-blue-600" href="{{ $homeUrl }}">
                                {{ __('general.continue_browsing') }}
                            </x-everest::link>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-everest::layouts.main>
