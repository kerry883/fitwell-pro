<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ClientNote;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ClientNoteController extends Controller
{
    /**
     * Store a newly created note for a client.
     */
    public function store(Request $request, $clientId): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,progress,concern,achievement',
            'is_private' => 'boolean'
        ]);

        $trainer = Auth::user();

        // Verify trainer has access to this client
        $clientProfile = ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $note = ClientNote::create([
            'client_id' => $clientId,
            'trainer_id' => $trainer->id,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'is_private' => $request->is_private ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note added successfully',
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'type' => $note->type_label,
                'created_at' => $note->created_at->format('M j, Y g:i A'),
                'trainer' => $trainer->name,
            ]
        ]);
    }

    /**
     * Update the specified note.
     */
    public function update(Request $request, $clientId, $noteId): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,progress,concern,achievement',
            'is_private' => 'boolean'
        ]);

        $trainer = Auth::user();

        $note = ClientNote::where('id', $noteId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'is_private' => $request->is_private ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'type' => $note->type_label,
                'created_at' => $note->created_at->format('M j, Y g:i A'),
                'trainer' => $trainer->name,
            ]
        ]);
    }

    /**
     * Remove the specified note.
     */
    public function destroy($clientId, $noteId): JsonResponse
    {
        $trainer = Auth::user();

        $note = ClientNote::where('id', $noteId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ]);
    }

    /**
     * Get notes for a specific client (AJAX endpoint).
     */
    public function getClientNotes($clientId): JsonResponse
    {
        $trainer = Auth::user();

        // Verify trainer has access to this client
        ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $notes = ClientNote::where('client_id', $clientId)
            ->with('trainer')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($note) {
                return [
                    'id' => $note->id,
                    'title' => $note->title,
                    'content' => $note->content,
                    'type' => $note->type_label,
                    'created_at' => $note->created_at->format('M j, Y g:i A'),
                    'trainer' => $note->trainer->name ?? 'Unknown',
                ];
            });

        return response()->json(['notes' => $notes]);
    }
}
