@extends('layouts.app')

@section('title', 'Notifikasi - CV. Agung')
@section('page-title', 'Notifikasi')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Notifikasi</h5>
    </div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            @forelse($notifications as $notification)
                <div class="list-group-item list-group-item-action py-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ $notification->title }}</h6>
                            <p class="mb-1">{{ $notification->message }}</p>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-check me-1"></i> Tandai Sudah Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>
    @if($notifications->hasPages())
        <div class="card-footer">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection