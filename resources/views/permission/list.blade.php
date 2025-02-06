<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permission') }}
            </h2>
            <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">Id</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Created</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($permissions as $permission)
                    <tr class="border-b">
                        <td class="px-6 py-3 text-left">{{$permission->id}}</td>
                        <td class="px-6 py-3 text-left">{{$permission->name}}</td>
                        <td class="px-6 py-3 text-left">{{ $permission->created_at->toFormattedDateString() }}</td>
                        <td class="px-6 py-3 text-center">
                        @can('edit permissions')
                        <a href="{{ route('permissions.edit', $permission->id ) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Edit</a>
                        @endcan
                        @can('delete permissions')
                        <a href="javascript:void(0)" onclick='deletePermission({{$permission->id}})' class="bg-red-700 text-sm rounded-md text-white px-3 py-2">Delete</a>  
                        @endcan
                        </td>
                    </tr>
                    @endforeach

                    
                </tbody>
            </table>
            <div class="my-4">
                {{ $permissions ->links() }}

            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id){
                if(confirm('Are you sure you want to delete')){
                    $.ajax({
                        url: "{{ route('permissions.destroy') }}",
                        type: 'delete',
                        data: {id:id},
                        datatype: 'json',
                        headers: {
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href = '{{ route('permissions.index') }}';
                        }
                    })
                }
            }
        </script>

    </x-slot>


   
</x-app-layout>
