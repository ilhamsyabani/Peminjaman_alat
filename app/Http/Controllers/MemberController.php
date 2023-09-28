<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $pagination = $request->query('pagination', 5);
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
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $img = $request->photo;
        $folderPath = "uploads/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        $validation = $request->validate([
            //'photo' => 'image|file|max:1024',
            'name' => 'required',
            'identity_number' => 'required',
            'email' => 'required',
            'hp' => 'required',
            'address' => 'required',
            'info' => 'nullable',
            'status' => 'required',
        ]);

        $validation['photo'] = $file;

        Member::create($validation);

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
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required',
            'identity_number' => 'required',
            'email' => 'required',
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
        if ($member->photo) {
            Storage::delete($member->photo);
        }

        Member::destroy($member->id);
        return  redirect()->route('members.index')->with('success', 'Item deleted successfully');
    }
}
