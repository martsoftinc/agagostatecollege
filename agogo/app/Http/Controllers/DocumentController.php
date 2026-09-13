<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $documents = Document::with('author')
            ->accessibleBy($request->user()->id)
            ->latest()
            ->paginate(15);

        return view('lesson-plans.index', compact('documents'));
    }

    public function create(): View
    {
        return view('documents.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,webp,gif|max:20480', // 20MB
            'visibility'  => 'required|in:private,public',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents/' . $request->user()->id, 'public');

        $document = $request->user()->documents()->create([
            'title'         => $validated['title'],
            'description'   => $validated['description'] ?? null,
            'original_name' => $file->getClientOriginalName(),
            'file_path'     => $path,
            'mime_type'     => $file->getMimeType(),
            'extension'     => strtolower($file->getClientOriginalExtension()),
            'file_size'     => $file->getSize(),
            'disk'          => 'public',
            'visibility'    => $validated['visibility'],
        ]);

        return redirect()->route('documents.show', $document)
            ->with('success', 'Document uploaded successfully.');
    }

    public function show(Document $document): View
    {
        $this->authorize('view', $document);

        $document->load(['author', 'sharedWithUsers']);

        $availableTeachers = auth()->id() === $document->user_id
            ? User::where('id', '!=', auth()->id())
                ->where('role', 'teacher')
                ->select('id', 'name', 'email')
                ->orderBy('name')
                ->get()
            : collect();

        return view('documents.show', compact('document', 'availableTeachers'));
    }

    public function edit(Document $document): View
    {
        $this->authorize('update', $document);

        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility'  => 'required|in:private,public',
        ]);

        $document->update($validated);

        return redirect()->route('documents.show', $document)
            ->with('success', 'Document updated successfully.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        Storage::disk($document->disk)->delete($document->file_path);
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully.');
    }

    public function download(Document $document)
    {
        $this->authorize('download', $document);

        return Storage::disk($document->disk)
            ->download($document->file_path, $document->original_name);
    }

    public function share(Request $request, Document $document): RedirectResponse
    {
        if ($request->user()->id !== $document->user_id) {
            abort(403, 'Only the owner can share this document.');
        }

        $validated = $request->validate([
            'users'                 => 'nullable|array',
            'users.*.user_id'       => 'required|exists:users,id',
            'users.*.permission'    => 'required|in:view,download',
        ]);

        $syncData = [];
        if (!empty($validated['users'])) {
            foreach ($validated['users'] as $entry) {
                if (!empty($entry['user_id'])) {
                    $syncData[$entry['user_id']] = [
                        'permission' => $entry['permission'] ?? 'download',
                    ];
                }
            }
        }

        $document->sharedWithUsers()->sync($syncData);

        return back()->with('success', 'Sharing permissions updated successfully.');
    }
}