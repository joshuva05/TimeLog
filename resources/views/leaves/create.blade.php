<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leaves') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 font-medium text-sm text-red-600">
                            {{ __('Whoops! Something went wrong.') }}
                        </div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form method="POST" action="{{ route('leaves.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="type" :value="__('Leave Type')" />
                            <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" :value="old('type')" required autofocus />
                            <x-input-error :messages="$errors->first('type')" for="type" class="mt-2"  />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="reason" :value="__('Leave Reason')" />
                            <textarea id="reason" name="reason" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4">{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->first('reason')" for="reason" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="start_date" :value="__('Start Date')" />
                            <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" :value="old('start_date')" required />
                            <x-input-error :messages="$errors->first('start_date')" for="start_date" class="mt-2"  />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="end_date" :value="__('End Date')" />
                            <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" :value="old('end_date')" required />
                            <x-input-error :messages="$errors->first('end_date')" for="end_date" class="mt-2"  />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Create Leave') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
