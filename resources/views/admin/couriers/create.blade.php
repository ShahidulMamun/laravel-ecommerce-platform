@extends('admin.layout')
@section('title', 'নতুন কুরিয়ার অ্যাকাউন্ট')

@section('content')
<h4 class="mb-4">নতুন কুরিয়ার অ্যাকাউন্ট যোগ করো</h4>

<div class="admin-card" style="max-width:640px">
  <form action="{{ route('admin.couriers.store') }}" method="POST">
    @csrf

    <div class="mb-3">
      <label class="form-label">অ্যাকাউন্টের নাম *</label>
      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="যেমন: Steadfast (Main Account)">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">কুরিয়ার প্রোভাইডার *</label>
      <select name="provider" id="providerSelect" class="form-select @error('provider') is-invalid @enderror" required>
        <option value="">বাছাই করো</option>
        <option value="steadfast" {{ old('provider') === 'steadfast' ? 'selected' : '' }}>Steadfast</option>
        <option value="pathao" {{ old('provider') === 'pathao' ? 'selected' : '' }}>Pathao</option>
        <option value="redx" {{ old('provider') === 'redx' ? 'selected' : '' }}>RedX</option>
        <option value="ecourier" {{ old('provider') === 'ecourier' ? 'selected' : '' }}>eCourier</option>
      </select>
      @error('provider') <div class="invalid-feedback">{{ $message }}</div> @enderror
      <div class="form-text" id="providerNote"></div>
    </div>

    <div class="mb-3">
      <label class="form-label">Base URL (ঐচ্ছিক — খালি রাখলে ডিফল্ট ব্যবহার হবে)</label>
      <input type="url" name="api_url" class="form-control" value="{{ old('api_url') }}" placeholder="https://portal.packzy.com/api/v1">
    </div>

    <hr>
    <h6 class="mb-3">API ক্রেডেনশিয়াল</h6>
    <p class="text-muted small">যে ফিল্ডগুলো লাগবে না সেগুলো খালি রেখে দাও — সবগুলো এনক্রিপ্টেড অবস্থায় সেভ হবে।</p>

    <div class="row g-3 mb-3">
      <div class="col-md-6">
        <label class="form-label">API Key</label>
        <input type="text" name="api_key" class="form-control" value="{{ old('api_key') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Secret Key</label>
        <input type="text" name="secret_key" class="form-control" value="{{ old('secret_key') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Client ID</label>
        <input type="text" name="client_id" class="form-control" value="{{ old('client_id') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Client Secret</label>
        <input type="text" name="client_secret" class="form-control" value="{{ old('client_secret') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" value="{{ old('password') }}">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">নোট (ঐচ্ছিক)</label>
      <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
    </div>

    <div class="form-check form-switch mb-2">
      <input type="checkbox" name="is_active" class="form-check-input" id="isActive" value="1" checked>
      <label class="form-check-label" for="isActive">অ্যাক্টিভ</label>
    </div>
    <div class="form-check form-switch mb-4">
      <input type="checkbox" name="is_default" class="form-check-input" id="isDefault" value="1">
      <label class="form-check-label" for="isDefault">ডিফল্ট কুরিয়ার হিসেবে সেট করো (অর্ডার পেজে "বুক করো" বাটনে এইটা ব্যবহার হবে)</label>
    </div>

    <button type="submit" class="btn btn-admin-primary">সেভ করো</button>
    <a href="{{ route('admin.couriers.index') }}" class="btn btn-outline-secondary">বাতিল</a>
  </form>
</div>

<script>
document.getElementById('providerSelect').addEventListener('change', function () {
  const notes = {
    steadfast: '✅ পুরোপুরি কানেক্টেড — এখানে Api Key ও Secret Key দাও।',
    pathao: '⚠️ শুধু ক্রেডেনশিয়াল সেভ হবে, বুকিং এখনো implement করা হয়নি (OAuth2 flow লাগে)।',
    redx: '⚠️ শুধু ক্রেডেনশিয়াল সেভ হবে, বুকিং এখনো implement করা হয়নি।',
    ecourier: '⚠️ শুধু ক্রেডেনশিয়াল সেভ হবে, বুকিং এখনো implement করা হয়নি।',
  };
  document.getElementById('providerNote').textContent = notes[this.value] || '';
});
</script>
@endsection