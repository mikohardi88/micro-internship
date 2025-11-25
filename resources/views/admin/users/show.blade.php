<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900">Users</a> / {{ $user->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Edit
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Name</h3>
                            <p class="text-gray-700">{{ $user->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Email</h3>
                            <p class="text-gray-700">{{ $user->email }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Roles</h3>
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->roles as $role)
                                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800">{{ $role->name }}</span>
                                @empty
                                    <span class="text-gray-500">No roles assigned</span>
                                @endforelse
                            </div>
                        </div>

                        @if($user->companies->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Companies</h3>
                                <div class="space-y-2">
                                    @foreach($user->companies as $company)
                                        <div class="bg-gray-50 p-3 rounded">
                                            <p class="font-medium text-gray-900">{{ $company->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $company->industry ?? 'N/A' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($user->applications->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Applications</h3>
                                <p class="text-gray-500">{{ $user->applications->count() }} applications</p>
                            </div>
                        @endif

                        @if($user->placements->count() > 0)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Placements</h3>
                                <p class="text-gray-500">{{ $user->placements->count() }} placements</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

