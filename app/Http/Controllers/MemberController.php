<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view("members.index", [
            'members' => Member::latest()->filter(request(['search']))->paginate(12)
        ]);
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
    public function store(StoreMemberRequest $request)
    {
        //
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
            'username' => 'required',
            'email' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'jaminan' => 'required',
            'keterangan' => 'nullable',
            'status' => 'required',
        ]);

        $validation['photo'] = $file;
        //dd($validation);

        // if ($request->file('photo')) {
        //     $validation['photo'] = $request->file('photo')->store('img-sourece');
        // }


        Member::create($validation);

        return redirect()->route('member.index')
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
    public function update(UpdateMemberRequest $request, Member $member)
    {

        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'jaminan' => 'required',
            'keterangan' => 'nullable',
            // 'status' => 'required',
        ]);

        //dd($validated);

        if ($request->file('photo')) {
            if ($request->oldImg) {
                Storage::delete($request->oldImg);
            }
            $validated['photo'] = $request->file('photo')->store('img-source');
        }

        Member::where('id', $member->id)->update($validated);

        return redirect('member')->with('success', 'Data Member has been Updated..!');
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
        return  redirect()->route('member.index')->with('success', 'Item deleted successfully');
    }
}
