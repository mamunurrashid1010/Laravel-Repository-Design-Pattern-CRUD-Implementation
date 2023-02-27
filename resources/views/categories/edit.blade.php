@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <p>Update Category Info</p>
                            <form method="POST" action="{{ route('category.update',$category->id) }}">
                                @csrf
                                <div class="mb-6">
                                    <label class="block">
                                        <span class="text-gray-700">Category Name</span>
                                        <input type="text" name="name"
                                               class="block w-full @error('name') border-red-500 @enderror mt-1 rounded-md"
                                               placeholder="" value="{{old('name',$category->name)}}" style="border: 1px solid gray" />
                                    </label>
                                    @error('name')
                                    <div class="text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit"
                                        class="text-white bg-blue-600  rounded text-sm px-5 py-2.5">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

@endsection
