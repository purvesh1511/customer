<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('customers.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::select(['id', 'name', 'email', 'created_at']);

            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return $row->user_status ? 'Active' : 'Inactive';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('customers.edit', $row->id) . '" class="btn btn-sm btn-primary editBtn" data-id="'.$row->id.'">Edit</a>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['user_status'] = $request->boolean('user_status');
        $data['email_verified_at'] = now();
        Customer::create($data);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $validated = $request->validate();
        $customer = Customer::findOrFail($customer->id);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer = Customer::findOrFail($customer->id);
        $customer->delete();
        return response()->json(['success' => true, 'message' => 'Customer deleted successfully']);
    }
}
