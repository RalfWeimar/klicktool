<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailboxStoreRequest;
use App\Http\Requests\MailboxUpdateRequest;
use App\Models\Mailbox;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MailboxController extends Controller
{
    public function index(Request $request): View
    {
        $mailboxes = Mailbox::all();

        return view('mailbox.index', compact('mailboxes'));
    }

    public function create(Request $request): View
    {
        return view('mailbox.create');
    }

    public function store(MailboxStoreRequest $request): RedirectResponse
    {
        $mailbox = Mailbox::create($request->validated());

        $request->session()->flash('mailbox.id', $mailbox->id);

        return redirect()->route('mailboxes.index');
    }

    public function show(Request $request, Mailbox $mailbox): View
    {
        return view('mailbox.show', compact('mailbox'));
    }

    public function edit(Request $request, Mailbox $mailbox): View
    {
        return view('mailbox.edit', compact('mailbox'));
    }

    public function update(MailboxUpdateRequest $request, Mailbox $mailbox): RedirectResponse
    {
        $mailbox->update($request->validated());

        $request->session()->flash('mailbox.id', $mailbox->id);

        return redirect()->route('mailboxes.index');
    }

    public function destroy(Request $request, Mailbox $mailbox): RedirectResponse
    {
        $mailbox->delete();

        return redirect()->route('mailboxes.index');
    }
}
