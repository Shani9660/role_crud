<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Article / Edit
            </h2>
            <a href="{{ route('articals.index') }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articals.update',$articles->id) }}" method="POST">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Title</label>
                            <div my-3>
                                 <input value="{{ old('title',$articles->title) }}" name="title" placeholder="Enter Title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg ">
                                 @error('title')
                                     <p class="text-red-400 font-medium">{{$message}}</p>
                                 @enderror
                            </div><br>

                            <label for="" class="text-lg font-medium">Contant</label>
                            <div my-3>
                                <textarea placeholder="Contant" name="text" id="text" cols="30" rows="10" class="border-gray-300 shadow-sm w-1/2 rounded-lg ">{{ old('text',$articles->text) }}</textarea>
                            </div><br>

                            <label for="" class="text-lg font-medium">Author</label>
                            <div my-3>
                                 <input value="{{ old('author',$articles->author) }}" name="author" placeholder="Enter author" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg ">
                                 @error('author')
                                     <p class="text-red-400 font-medium">{{$message}}</p>
                                 @enderror
                            </div><br>

                            <button class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
