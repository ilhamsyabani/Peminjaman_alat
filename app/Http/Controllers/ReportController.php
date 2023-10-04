<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use App\Models\TransactionItem;
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

  public function memberdetail(Member $member){

    return view('report.member_transaction',compact('member'));

  }

  public function product(Request $request){
    $pagination = $request->query('pagination', 5);
        $search = $request->query('search', '');

        $itemQuery = TransactionItem::query();

        // Apply search filter
        if ($search) {
            $itemQuery->where(function ($query) use ($search) {
                $query->whereHas('product', function ($subquery) use ($search) {
                    $subquery->where('name', 'like', '%' . $search . '%');
                })->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results and append query parameters
        $items = $itemQuery->paginate($pagination)->appends([
            'pagination' => $pagination,
            'search' => $search,
        ]);

        return view('report.product', compact('items'));
  }
}
