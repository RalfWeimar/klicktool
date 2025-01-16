<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoxStoreRequest;
use App\Http\Requests\BoxUpdateRequest;
use App\Models\Box;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BoxController extends Controller
{
    public function index(Request $request): View
    {
        $boxes = Box::all();

        return view('box.index', compact('boxes'));
    }

    public function create(Request $request): View
    {
        return view('box.create');
    }

    public function store(BoxStoreRequest $request): RedirectResponse
    {
        $box = Box::create($request->validated());

        $request->session()->flash('box.id', $box->id);

        return redirect()->route('boxes.index');
    }

    public function show(Request $request, Box $box): View
    {
        return view('box.show', compact('box'));
    }

    public function edit(Request $request, Box $box): View
    {
        return view('box.edit', compact('box'));
    }

    public function update(BoxUpdateRequest $request, Box $box): RedirectResponse
    {
        $box->update($request->validated());

        $request->session()->flash('box.id', $box->id);

        return redirect()->route('boxes.index');
    }

    public function destroy(Request $request, Box $box): RedirectResponse
    {
        $box->delete();

        return redirect()->route('boxes.index');
    }
}
