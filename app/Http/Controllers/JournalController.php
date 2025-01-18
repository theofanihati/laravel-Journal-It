<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $journals = Journal::where('user_id', Auth::id())->latest()->get();
        return view('journals.index', compact('journals'));
    }

    public function delete(Request $request)
    {
        $journal = Journal::findOrFail($request->input('journal-id'));
        $journal->delete();

        return redirect()->route('dashboard')->with('message', 'Journal Deleted');
    }

    public function home()
    {
        $user = auth()->user();
        $journals = Journal::where('user_id', Auth::id())->latest()->get();
        $journalCount = Journal::where('user_id', $user->id)->count();
        return view('dashboard', compact('journalCount', 'journals'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'images' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $validatedData['user_id'] = auth()->id();
        $journal = Journal::create($validatedData);

        if ($request->hasFile('images')) {
            $path = $request->file('images')->store('uploads', 'public');
            $journal->image = $path;
            $journal->save();
        }

        return redirect()->route('dashboard')->with('success', 'Journal created successfully!');
    }

    public function editJournal($id_journal)
    {
        $journal = Journal::findOrFail($id_journal);
        return view('edit-journal', compact('journal'));
    }
    
    public function updateJournal(Request $request, $id_journal)
    {
        $journal = Journal::findOrFail($id_journal);
    
        $journal->title = $request->input('title');
        $journal->description = $request->input('description');
        $journal->date = $request->input('date');
    
        if ($request->hasFile('images')) {
            $path = $request->file('images')->store('uploads', 'public');
            $journal->image = $path;
            $journal->save();
        }
    
        $journal->save();
    
        return redirect()->route('edit-journal', ['id_journal' => $journal->id])
            ->with('updated', true);
    }
    
}