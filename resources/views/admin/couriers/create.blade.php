@extends('admin.layout')

@section('content')

<div class="card">

    <div class="card-header">
        <h5 class="mb-0">Add Courier</h5>
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('admin.couriers.store') }}">

            @csrf

            <div class="mb-3">
                <label class="form-label">
                    Courier Name
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Steadfast"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Slug
                </label>

                <input type="text"
                       name="slug"
                       class="form-control"
                       value="{{ old('slug') }}"
                       placeholder="steadfast"
                       required>

                <small class="text-muted">
                    Only letters, numbers, dash and underscore.
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    API URL
                </label>

                <input type="url"
                       name="api_url"
                       class="form-control"
                       value="{{ old('api_url') }}"
                       placeholder="https://example.com/api">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    API Key
                </label>

                <input type="password"
                       name="api_key"
                       class="form-control"
                       autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Secret Key
                </label>

                <input type="password"
                       name="secret_key"
                       class="form-control"
                       autocomplete="new-password">
            </div>

            <div class="form-check mb-4">

                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="form-check-input"
                       id="is_active">

                <label class="form-check-label"
                       for="is_active">
                    Active
                </label>

            </div>

            <button type="submit"
                    class="btn btn-primary">
                Save Courier
            </button>

            <a href="{{ route('admin.couriers.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection