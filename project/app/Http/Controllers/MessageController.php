<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $partnerIds = Message::query()
            ->where('sender_id', $user->id)
            ->pluck('receiver_id')
            ->merge(
                Message::query()->where('receiver_id', $user->id)->pluck('sender_id')
            )
            ->unique()
            ->filter(fn ($id) => (int) $id !== $user->id);

        $partners = User::query()
            ->whereIn('id', $partnerIds)
            ->orderBy('name')
            ->get();

        $otherUsers = User::query()
            ->where('id', '!=', $user->id)
            ->orderBy('name')
            ->limit(50)
            ->get();

        return view('messages.index', compact('partners', 'otherUsers'));
    }

    public function show(Request $request, User $user): View
    {
        if ($user->id === $request->user()->id) {
            abort(403);
        }

        Message::query()
            ->where('sender_id', $user->id)
            ->where('receiver_id', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::query()
            ->where(function ($q) use ($request, $user) {
                $q->where(function ($q2) use ($request, $user) {
                    $q2->where('sender_id', $request->user()->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q2) use ($request, $user) {
                    $q2->where('sender_id', $user->id)->where('receiver_id', $request->user()->id);
                });
            })
            ->orderBy('created_at')
            ->with(['sender', 'receiver'])
            ->get();

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            abort(403);
        }

        $data = $request->validate([
            'body' => 'required|string|min:1|max:5000',
        ]);

        Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $user->id,
            'body' => $data['body'],
        ]);

        return redirect()->route('messages.show', $user)->with('success', 'Message envoyé.');
    }
}
