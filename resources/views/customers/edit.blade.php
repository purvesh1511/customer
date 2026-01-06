<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $customer->name) }}">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" readonly name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2">
                            <label>Mobile No</label>
                            <input type="text" name="user_mobile_no" maxlength="12" pattern="\d*" inputmode="numeric" class="form-control" value="{{ old('user_mobile_no', $customer->user_mobile_no) }}">
                            @error('user_mobile_no') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2">
                            <label>User Type</label>
                            <select name="user_type" class="form-control">
                                <option value="admin" {{ $customer->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $customer->user_type == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                            @error('user_type') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-2 form-check">
                            <input type="checkbox" class="form-check-input" name="user_status" id="user_status" {{ $customer->user_status == "1" ? 'checked' : '' }}>
                            <label class="form-check-label" for="user_status">Active</label>
                        </div>

                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
