<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $pagination = $request->integer('pagination', 5);
        $pagination = $pagination > 0 ? min($pagination, 100) : 5;
        $search = $request->query('search', '');

        $membersQuery = Member::query();

        // Apply search filter
        if ($search) {
            $membersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('identity_number', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and append query parameters
        $members = $membersQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
        ]);

        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("members.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('status') === 'belum meminjam') {
            $request->merge(['status' => 'tidak_ada']);
        }

        $validation = $request->validate([
            'photo' => 'required|string',
            'name' => 'required|string|max:255',
            'identity_number' => 'required|string|max:255|unique:members,identity_number',
            'email' => 'required|email|max:255',
            'hp' => 'required|string|max:255',
            'address' => 'required|string',
            'info' => 'nullable|string',
            'status' => 'required|in:tidak_ada,process,meminjam',
        ]);

        if (! preg_match('/^data:image\/(png|jpeg|jpg);base64,([A-Za-z0-9+\/=]+)$/', $validation['photo'], $matches)) {
            throw ValidationException::withMessages(['photo' => 'Format foto tidak valid.']);
        }
        $image = base64_decode($matches[2], true);
        if ($image === false) {
            throw ValidationException::withMessages(['photo' => 'Format foto tidak valid.']);
        }

        $file = 'uploads/'.Str::random(40).'.png';
        Storage::put($file, $image);
        $validation['photo'] = $file;
        try {
            Member::create($validation);
        } catch (\Throwable $exception) {
            Storage::delete($file);
            throw $exception;
        }

        return redirect()->route('members.index')
            ->with('success', 'Items created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
        return view("members.view", compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
        return view("members.edit", compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        if (! $request->has('info') && $request->has('keterangan')) {
            $request->merge(['info' => $request->input('keterangan')]);
        }

        $validated = $request->validate([
            'name' => 'required',
            'identity_number' => ['required', 'string', Rule::unique('members', 'identity_number')->ignore($member->id)],
            'email' => 'required|email',
            'hp' => 'required',
            'address' => 'required',
            'info' => 'nullable',
        ]);

        //dd($validated);

        if ($request->file('photo')) {
            if ($request->oldImg) {
                Storage::delete($request->oldImg);
            }
            $validated['photo'] = $request->file('photo')->store('img-source');
        }

        Member::where('id', $member->id)->update($validated);

        return redirect('members')->with('success', 'Data Member has been Updated..!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if ($member->transaction()->exists()) {
            return back()->withErrors(['member' => 'Member yang tercatat dalam transaksi tidak dapat dihapus.']);
        }

        if ($member->photo) {
            Storage::delete($member->photo);
        }

        Member::destroy($member->id);
        return  redirect()->route('members.index')->with('success', 'Item deleted successfully');
    }
}
