<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-2">
                            <label>Mobile No</label>
                            <input type="text" name="user_mobile_no" maxlength="12" pattern="\d*" inputmode="numeric" class="form-control" value="{{ old('user_mobile_no') }}">
                        </div>
                        <div class="mb-2">
                            <label>User Type</label>
                            <select name="user_type" class="form-control">
                                <option value="admin">Admin</option>
                                <option value="user" selected>User</option>
                            </select>
                        </div>
                        <div class="mb-2 form-check">
                            <input type="hidden" name="user_status" value="0">
                            <input type="checkbox" class="form-check-input" name="user_status" id="user_status" checked>
                            <label class="form-check-label" for="user_status">Active</label>
                        </div>
                        <div class="mb-2">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button class="btn btn-primary">Save</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
