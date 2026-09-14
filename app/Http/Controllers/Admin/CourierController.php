<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::latest()->paginate(15);

        return view('admin.couriers.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.couriers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                'unique:couriers,slug',
            ],
            'api_url' => ['nullable', 'url', 'max:500'],
            'api_key' => ['nullable', 'string', 'max:500'],
            'secret_key' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Courier::create($validated);

        return redirect()
            ->route('admin.couriers.index')
            ->with('success', 'Courier added successfully.');
    }

    public function edit(Courier $courier)
    {
        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('couriers', 'slug')->ignore($courier->id),
            ],
            'api_url' => ['nullable', 'url', 'max:500'],
            'api_key' => ['nullable', 'string', 'max:500'],
            'secret_key' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        /*
        |--------------------------------------------------------------------------
        | Don't overwrite credentials with empty fields
        |--------------------------------------------------------------------------
        */

        if (blank($validated['api_key'] ?? null)) {
            unset($validated['api_key']);
        }

        if (blank($validated['secret_key'] ?? null)) {
            unset($validated['secret_key']);
        }

        $courier->update($validated);

        return redirect()
            ->route('admin.couriers.index')
            ->with('success', 'Courier updated successfully.');
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()
            ->route('admin.couriers.index')
            ->with('success', 'Courier deleted successfully.');
    }
}