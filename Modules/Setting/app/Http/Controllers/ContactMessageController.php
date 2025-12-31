<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\ContactMessage; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('setting::contact-messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting::contact-messages.create');
    }

    /**
     * Display the specified message.
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        // Mark as read if needed
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('setting::contact-messages.show', compact('message'));
    }

    /**
     * Remove the specified message.
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        
        return redirect()->route('setting.contact-messages.index')
            ->with('success', 'Message deleted successfully.');
    }

    /**
     * Bulk delete messages
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_messages,id'
        ]);
        
        ContactMessage::whereIn('id', $request->ids)->delete();
        
        return redirect()->route('setting.contact-messages.index')
            ->with('success', count($request->ids) . ' messages deleted successfully.');
    }

    /**
     * Mark message as read/unread
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        
        return redirect()->back()->with('success', 'Message marked as read.');
    }

    /**
     * Export messages (optional)
     */
    public function export(Request $request)
    {
        $messages = ContactMessage::latest()->get();
        
        // You can implement CSV/Excel export here
        return response()->json($messages);
    }
}