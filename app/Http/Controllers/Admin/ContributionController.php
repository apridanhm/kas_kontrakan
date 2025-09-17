<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contribution;
use App\Models\IncomeCategory;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $categoryId = $request->query('category_id');

        $cats = IncomeCategory::where('active', true)->orderBy('name')->get();

        $base = Contribution::with(['member','category'])
            ->where('month_year', $month)
            ->when($categoryId, fn($q) => $q->where('income_category_id', $categoryId));

        // order by nama member (tanpa orderByJoin)
        $contribs = (clone $base)
            ->join('members','members.id','=','contributions.member_id')
            ->select('contributions.*')
            ->orderBy('members.name')
            ->paginate(25)
            ->withQueryString();

        $total = (clone $base)->sum('amount');

        return view('admin.contributions.index', compact('contribs','month','cats','categoryId','total'));
    }

    public function create(Request $request)
    {
        $month = $request->query('month', now()->format('Y-m'));
        $categoryId = $request->query('category_id');

        $cats = IncomeCategory::where('active', true)->orderBy('name')->get();
        $selected = $categoryId ? $cats->firstWhere('id', (int)$categoryId) : null;

        // Tampilkan semua anggota (boleh bayar berkali-kali)
        $members = Member::where('active', true)->orderBy('name')->get();

        return view('admin.contributions.create', compact('month','cats','selected','members'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'member_id'          => ['required', Rule::exists('members','id')],
            'income_category_id' => ['required', Rule::exists('income_categories','id')],
            'month_year'         => ['required','regex:/^\d{4}-\d{2}$/'],
            'amount'             => ['required','integer','min:0'],
            'paid_at'            => ['nullable','date'],
            'note'               => ['nullable','string','max:255'],
        ]);
        $data['paid_at'] = $data['paid_at'] ?? now()->toDateString();

        Contribution::create($data);

        return redirect()->route('contributions.index', [
            'month' => $data['month_year'],
            'category_id' => $data['income_category_id']
        ])->with('ok','Pemasukan dicatat.');
    }

    public function destroy(Contribution $contribution)
    {
        $month = $contribution->month_year;
        $category = $contribution->income_category_id;
        $contribution->delete();

        return redirect()->route('contributions.index', [
            'month' => $month,
            'category_id' => $category,
        ])->with('ok','Pemasukan dihapus.');
    }
}
