<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles / Create
            </h2>
            <a href="{{ route('permissions.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div my-3>
                                 <input value="{{ old('name') }}" name="name" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg ">
                                 @error('name')
                                     <p class="text-red-400 font-medium">{{$message}}</p>
                                 @enderror
                            </div>

                            <div class="grid grid-cols-4">
                                @foreach ($permission as $permissions)
                                <div class="mt-3">
                                    <input type="checkbox" class="rounded" name="permission[]" value="{{$permissions->name}}" id="permission-{{$permissions->id}}">
                                    <label for="permission-{{$permissions->id}}">{{ $permissions->name }}</label>
                                </div>
                                    
                                @endforeach
                            </div>
                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
