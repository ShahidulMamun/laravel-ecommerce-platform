<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::latest()->get();
        return view('admin.couriers.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.couriers.create');
    }

    public function store(Request $request)
    {
        $validated = $this->baseValidated($request);

        $validated = array_merge($validated, $this->credentialFields($request));

        if ($validated['is_default']) {
            Courier::query()->update(['is_default' => false]);
        }

        Courier::create($validated);

        return redirect()->route('admin.couriers.index')->with('status', 'কুরিয়ার অ্যাকাউন্ট যোগ করা হয়েছে');
    }

    public function edit(Courier $courier)
    {
        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, Courier $courier)
    {
        $validated = $this->baseValidated($request);

        
        foreach ($this->credentialFields($request) as $field => $value) {
            if ($value !== null && $value !== '') {
                $validated[$field] = $value;
            }
        }

        if ($validated['is_default']) {
            Courier::where('id', '!=', $courier->id)->update(['is_default' => false]);
        }

        $courier->update($validated);

        return redirect()->route('admin.couriers.index')->with('status', 'কুরিয়ার অ্যাকাউন্ট আপডেট হয়েছে');
    }

    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('admin.couriers.index')->with('status', 'কুরিয়ার অ্যাকাউন্ট ডিলিট হয়েছে');
    }

    private function baseValidated(Request $request): array
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'provider' => ['required', Rule::in(Courier::PROVIDERS)],
            'api_url'  => ['nullable', 'url', 'max:255'],
            'notes'    => ['nullable', 'string', 'max:1000'],
        ]);

        return [
            'name'       => $validated['name'],
            'provider'   => $validated['provider'],
            'api_url'    => $validated['api_url'] ?? null,
            'notes'      => $validated['notes'] ?? null,
            'is_active'  => $request->boolean('is_active', true),
            'is_default' => $request->boolean('is_default'),
        ];
    }

    private function credentialFields(Request $request): array
    {
        $validated = $request->validate([
            'api_key'       => ['nullable', 'string', 'max:500'],
            'secret_key'    => ['nullable', 'string', 'max:500'],
            'client_id'     => ['nullable', 'string', 'max:500'],
            'client_secret' => ['nullable', 'string', 'max:500'],
            'username'      => ['nullable', 'string', 'max:500'],
            'password'      => ['nullable', 'string', 'max:500'],
        ]);

        return [
            'api_key'       => $validated['api_key'] ?? null,
            'secret_key'    => $validated['secret_key'] ?? null,
            'client_id'     => $validated['client_id'] ?? null,
            'client_secret' => $validated['client_secret'] ?? null,
            'username'      => $validated['username'] ?? null,
            'password'      => $validated['password'] ?? null,
        ];
    }
}