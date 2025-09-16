<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;


class MemberController extends Controller
{
public function index()
{
$members = Member::orderBy('name')->paginate(15);
return view('admin.members.index', compact('members'));
}


public function create()
{
return view('admin.members.create');
}


public function store(Request $request)
{
$data = $request->validate([
'name' => 'required|string|max:100',
'phone' => 'nullable|string|max:30',
'active' => 'nullable|boolean',
]);
$data['active'] = $request->boolean('active', true);
Member::create($data);
return redirect()->route('members.index')->with('ok', 'Anggota ditambahkan.');
}


public function edit(Member $member)
{
return view('admin.members.edit', compact('member'));
}


public function update(Request $request, Member $member)
{
$data = $request->validate([
'name' => 'required|string|max:100',
'phone' => 'nullable|string|max:30',
'active' => 'nullable|boolean',
]);
$data['active'] = $request->boolean('active', true);
$member->update($data);
return redirect()->route('members.index')->with('ok', 'Anggota diubah.');
}


public function destroy(Member $member)
{
$member->delete();
return back()->with('ok', 'Anggota dihapus.');
}
}