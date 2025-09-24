<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Time Logs') }}
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
                    <form method="POST" action="{{ route('time-logs.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="project" :value="__('Project')" />
                            <select id="project" name="project_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->first('project_id')" for="project_id" class="mt-2"  />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                            <x-input-error :messages="$errors->first('date')" for="date" class="mt-2"  />
                        </div>

                        <table style="width: 100%;" class="mt-4">
                            <thead>
                                <tr>
                                    <th>Task Description</th>
                                    <th>Time Spent (HH:MM)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <x-text-input id="task_description" name="task_description[]" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  required />
                                    </td>
                                    <td>
                                        <x-text-input id="time_spent" name="hours_spent[]" type="text" class="time_spent mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="e.g., 02:30" required />
                                    </td>
                                    <td>
                                        <button type="button" id="add_row" class="bg-blue-500  px-3 py-1 rounded">Add</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Create Time Log') }}
                                </x-primary-button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>

// Add and Remove rows dynamically
$(document).ready(function(){

    initializeTimePicker();

    $('#add_row').on('click', function() {
        var newRow = `<tr>
            <td>
                <x-text-input name="task_description[]" type="text"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="4" required />

            </td>
            <td>
                <x-text-input  name="hours_spent[]" type="text"
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 time_spent" placeholder="e.g., 02:30" required />
            </td>
            <td>
                <button type="button" class="bg-red-500  px-3 py-1 rounded remove_row">Remove</button>
            </td>
        </tr>`;
        $('table tbody').append(newRow);

        initializeTimePicker();

        });
    });


    $(document).on('click', '.remove_row', function() {
        $(this).closest('tr').remove();
    });

    function initializeTimePicker() {
        $('.time_spent').timepicker({
            timeFormat: 'HH:mm',
            interval: 30,  // 30 min steps
            dynamic: true,
            dropdown: true,
            scrollbar: true,
            maxTime: "10:00"
        });
    }
</script>
