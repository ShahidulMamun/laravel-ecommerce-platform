@extends('admin.layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Couriers</h4>

    <a href="{{ route('admin.couriers.create') }}"
       class="btn btn-primary">
        Add Courier
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>API URL</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($couriers as $courier)

                    <tr>
                        <td>{{ $courier->id }}</td>

                        <td>
                            {{ $courier->name }}
                        </td>

                        <td>
                            <code>{{ $courier->slug }}</code>
                        </td>

                        <td>
                            {{ $courier->api_url ?: '—' }}
                        </td>

                        <td>
                            @if($courier->is_active)
                                <span class="badge bg-success">
                                    Active
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('admin.couriers.edit', $courier) }}"
                               class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('admin.couriers.destroy', $courier) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this courier?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger">
                                    Delete
                                </button>

                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            No courier found.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        {{ $couriers->links() }}

    </div>
</div>

@endsection