@extends('admin.layout')
@section('title', 'কুরিয়ার অ্যাকাউন্ট')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="m-0">কুরিয়ার অ্যাকাউন্ট</h4>
  <a href="{{ route('admin.couriers.create') }}" class="btn btn-admin-primary">
    <i class="bi bi-plus-lg"></i> নতুন কুরিয়ার অ্যাকাউন্ট
  </a>
</div>

@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif

@php
  $providerLabels = ['steadfast' => 'Steadfast', 'pathao' => 'Pathao', 'redx' => 'RedX', 'ecourier' => 'eCourier'];
  $providerReady  = ['steadfast' => true, 'pathao' => false, 'redx' => false, 'ecourier' => false];
@endphp

<div class="admin-card">
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>নাম</th>
          <th>প্রোভাইডার</th>
          <th>স্ট্যাটাস</th>
          <th>ইন্টিগ্রেশন</th>
          <th class="text-end">অ্যাকশন</th>
        </tr>
      </thead>
      <tbody>
        @forelse($couriers as $c)
        <tr>
          <td>
            {{ $c->name }}
            @if($c->is_default) <span class="badge bg-warning text-dark">ডিফল্ট</span> @endif
          </td>
          <td>{{ $providerLabels[$c->provider] ?? $c->provider }}</td>
          <td>
            @if($c->is_active)
              <span class="badge bg-success">অ্যাক্টিভ</span>
            @else
              <span class="badge bg-secondary">ইনঅ্যাক্টিভ</span>
            @endif
          </td>
          <td>
            @if($providerReady[$c->provider] ?? false)
              <span class="badge bg-info text-dark"><i class="bi bi-check-circle"></i> রেডি</span>
            @else
              <span class="badge bg-warning text-dark" title="এই প্রোভাইডারের বুকিং API এখনো implement করা হয়নি">
                <i class="bi bi-tools"></i> শুধু ক্রেডেনশিয়াল সেভ
              </span>
            @endif
          </td>
          <td class="text-end">
            <a href="{{ route('admin.couriers.edit', $c) }}" class="btn btn-sm btn-outline-secondary">
              <i class="bi bi-pencil"></i>
            </a>
            <form action="{{ route('admin.couriers.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('ডিলিট করবে?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted py-4">কোনো কুরিয়ার অ্যাকাউন্ট যোগ করা হয়নি</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<div class="alert alert-light border mt-3 small">
  <i class="bi bi-info-circle"></i>
  বর্তমানে শুধু <strong>Steadfast</strong> এর বুকিং API সম্পূর্ণভাবে কানেক্টেড। Pathao/RedX/eCourier
  এর ক্রেডেনশিয়াল এখানে সেভ রাখা যাবে, কিন্তু অর্ডার পেজ থেকে সরাসরি বুক করার ফিচারটা
  ডেভেলপার তাদের merchant API ডকুমেন্টেশন কনফার্ম করার পর চালু হবে।
</div>
@endsection