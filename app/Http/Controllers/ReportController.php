<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  public function transaction(Request $request){
    $pagination = $request->query('pagination', 5);
        $search = $request->query('search', '');

        $transactionQuery = Transaction::query();

        // Apply search filter
        if ($search) {
            $transactionQuery->where(function ($query) use ($search) {
                $query->where('transactions.member->name', 'like', '%' . $search . '%')
                    ->orWhere('transactions.id', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and append query parameters
        $transactions = $transactionQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
        ]);

        return view('report.transaction', compact('transactions'));
  }

  public function member (Request $request){
    $pagination = $request->query('pagination', 5);
        $search = $request->query('search', '');

        $memberQuery = Member::query();

        // Apply search filter
        if ($search) {
            $memberQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and append query parameters
        $members = $memberQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
        ]);

        return view('report.member', compact('members'));
  }
}
