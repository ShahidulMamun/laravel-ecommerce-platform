@extends('admin.layout')
@section('title', 'কুরিয়ার অ্যাকাউন্ট এডিট')

@section('content')
<h4 class="mb-4">কুরিয়ার অ্যাকাউন্ট এডিট করো</h4>

<div class="admin-card" style="max-width:640px">
  <form action="{{ route('admin.couriers.update', $courier) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
      <label class="form-label">অ্যাকাউন্টের নাম *</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $courier->name) }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">কুরিয়ার প্রোভাইডার *</label>
      <select name="provider" class="form-select" required>
        <option value="steadfast" {{ $courier->provider === 'steadfast' ? 'selected' : '' }}>Steadfast</option>
        <option value="pathao" {{ $courier->provider === 'pathao' ? 'selected' : '' }}>Pathao</option>
        <option value="redx" {{ $courier->provider === 'redx' ? 'selected' : '' }}>RedX</option>
        <option value="ecourier" {{ $courier->provider === 'ecourier' ? 'selected' : '' }}>eCourier</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">API URL</label>
      <input type="url" name="api_url" class="form-control" value="{{ old('api_url', $courier->api_url) }}">
    </div>

    <hr>
    <h6 class="mb-3">API ক্রেডেনশিয়াল</h6>
    <p class="text-muted small">
      নিরাপত্তার জন্য বিদ্যমান ভ্যালু কখনো ফিরিয়ে দেখানো হয় না (শুধু সেট করা আছে কিনা বোঝানো হয়)।
      বদলাতে চাইলে নতুন ভ্যালু লেখো, নাহলে খালি রাখলে আগেরটাই থেকে যাবে।
    </p>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label">API Key @if($courier->api_key)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="text" name="api_key" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
      <div class="col-md-6">
        <label class="form-label">Secret Key @if($courier->secret_key)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="text" name="secret_key" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
      <div class="col-md-6">
        <label class="form-label">Client ID @if($courier->client_id)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="text" name="client_id" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
      <div class="col-md-6">
        <label class="form-label">Client Secret @if($courier->client_secret)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="text" name="client_secret" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
      <div class="col-md-6">
        <label class="form-label">Username @if($courier->username)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="text" name="username" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
      <div class="col-md-6">
        <label class="form-label">Password @if($courier->password)<span class="badge bg-light text-dark border">সেট করা আছে</span>@endif</label>
        <input type="password" name="password" class="form-control" placeholder="বদলাতে চাইলে নতুন ভ্যালু লেখো">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">নোট</label>
      <textarea name="notes" class="form-control" rows="2">{{ old('notes', $courier->notes) }}</textarea>
    </div>

    <div class="form-check form-switch mb-2">
      <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" {{ $courier->is_active ? 'checked' : '' }}>
      <label class="form-check-label" for="isActive">অ্যাক্টিভ</label>
    </div>
    <div class="form-check form-switch mb-4">
      <input type="checkbox" name="is_default" class="form-check-input" id="isDefault" value="1" {{ $courier->is_default ? 'checked' : '' }}>
      <label class="form-check-label" for="isDefault">ডিফল্ট কুরিয়ার</label>
    </div>

    <button type="submit" class="btn btn-admin-primary">আপডেট করো</button>
    <a href="{{ route('admin.couriers.index') }}" class="btn btn-outline-secondary">বাতিল</a>
  </form>
</div>
@endsection