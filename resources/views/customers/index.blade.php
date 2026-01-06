<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="p-6 text-gray-900">
                    <a href="{{ route('customers.create') }}" class="btn btn-success mb-3">+ Create User</a>
                    <table class="table table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        let table = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('customers.list') }}",
            columns: [
                {data: 'id'}, 
                {data: 'name'}, 
                {data: 'email'},
                { data: 'status', name: 'user_status' },
                { data: 'created_at' },
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        
        // Delete with confirmation
        $(document).on('click', '.deleteBtn', function() {
            let id = $(this).data('id');
            if (confirm("Are you sure you want to delete this customer?")) {
                $.ajax({
                    url: `/customers/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        $('#usersTable').DataTable().ajax.reload();
                    }
                });
            }
        });
    });
    </script>
</x-app-layout>
