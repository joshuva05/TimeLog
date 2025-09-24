<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Project Name:</h3>
                    <p class="mt-1 text-gray-600">{{ $project->name }}</p>
                    <h3 class="text-lg font-medium text-gray-900 mt-4">Project Description:</h3>
                    <p class="mt-1 text-gray-600">{{ $project->description }}</p>
                    {{-- timeLogs listed here --}}
                    <h3 class="text-lg font-medium text-gray-900 mt-4">Time Logs:</h3>
                    @if($project->timeLogs->isEmpty())
                        <p class="mt-1 text-gray-600">No time logs available for this project.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 mt-2">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">S.No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Spent</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($project->timeLogs as $index => $timeLog)
                                    <tr style="text-align: center;">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $timeLog->task_description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $timeLog->date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $timeLog->hours_spent }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Projects</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
