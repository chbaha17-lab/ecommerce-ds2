@extends('layouts.store')

@section('content')

<div class="container py-4">
    <h2 class="mb-4" style="color:#6b4f4f;">Messages</h2>

    <p class="text-muted">Discutez avec d’autres utilisateurs.</p>

    @if($partners->isNotEmpty())
        <h5 class="mt-4">Conversations</h5>
        <ul class="list-group mb-4">
            @foreach($partners as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $p->name }}</span>
                    <a href="{{ route('messages.show', $p) }}" class="btn btn-sm btn-beige">Ouvrir</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h5 class="mt-4">Nouveau message à…</h5>
    <ul class="list-group">
        @foreach($otherUsers as $u)
            @if($u->id === auth()->id()) @continue @endif
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ $u->name }} <small class="text-muted">({{ $u->email }})</small></span>
                <a href="{{ route('messages.show', $u) }}" class="btn btn-sm btn-outline-dark">Chatter</a>
            </li>
        @endforeach
    </ul>
</div>

@endsection
