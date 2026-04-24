@extends('layouts.store')

@section('content')

<div class="container py-4" style="max-width:720px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 style="color:#6b4f4f;">{{ $user->name }}</h4>
        <a href="{{ route('messages.index') }}" class="btn btn-sm btn-outline-secondary">← Retour</a>
    </div>

    <div class="card p-3 mb-3" style="max-height:420px; overflow-y:auto; background:#fffaf6;">
        @forelse($messages as $m)
            @php $mine = $m->sender_id === auth()->id(); @endphp
            <div class="mb-2 {{ $mine ? 'text-end' : '' }}">
                <div class="d-inline-block p-2 rounded-3 {{ $mine ? 'bg-dark text-white' : 'bg-white border' }}" style="max-width:85%; text-align:left;">
                    {{ $m->body }}
                </div>
                <div class="small text-muted">{{ $m->created_at->format('H:i d/m') }}</div>
            </div>
        @empty
            <p class="text-muted small">Aucun message encore — dites bonjour !</p>
        @endforelse
    </div>

    <form method="POST" action="{{ route('messages.store', $user) }}">
        @csrf
        <div class="mb-2">
            <textarea name="body" class="form-control" rows="3" required placeholder="Votre message…">{{ old('body') }}</textarea>
            @error('body')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-beige">Envoyer</button>
    </form>
</div>

@endsection
