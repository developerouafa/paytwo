<?php


namespace App\Repository\dashboard_user\Finances;

use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\receipt_account;
use Illuminate\Support\Facades\DB;

class ReceiptRepository implements ReceiptRepositoryInterface
{

    public function index()
    {
        $receipts =  receipt_account::all();
        return view('Dashboard.dashboard_user.Receipt.index',compact('receipts'));
    }

    public function create()
    {
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Receipt.add',compact('Clients'));
    }

    public function show($id)
    {
        $receipt = receipt_account::findorfail($id);
        return view('Dashboard.dashboard_user.Receipt.print',compact('receipt'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try{
            // store receipt_accounts
            $receipt_accounts = new receipt_account();
            $receipt_accounts->date =date('y-m-d');
            $receipt_accounts->client_id = $request->client_id;
            $receipt_accounts->amount = $request->Debit;
            $receipt_accounts->description = $request->description;
            $receipt_accounts->save();
            // store fund_accounts
            $fund_accounts = new fund_account();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->receipt_id = $receipt_accounts->id;
            $fund_accounts->Debit = $request->Debit;
            $fund_accounts->credit = 0.00;
            $fund_accounts->save();
            // store client_accounts
            $client_accounts = new client_account();
            $client_accounts->date =date('y-m-d');
            $client_accounts->client_id = $request->client_id;
            $client_accounts->receipt_id = $receipt_accounts->id;
            $client_accounts->Debit = 0.00;
            $client_accounts->credit =$request->Debit;
            $client_accounts->save();

            DB::commit();
            session()->flash('add');
            return redirect()->route('Receipt.create');
        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }


    public function edit($id)
    {
        $receipt_accounts = receipt_account::findorfail($id);
        $Clients = client_account::all();
        return view('Dashboard.Receipt.edit',compact('receipt_accounts','Clients'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try{
            // store receipt_accounts
            $receipt_accounts = receipt_account::findorfail($request->id);
            $receipt_accounts->date =date('y-m-d');
            $receipt_accounts->client_id = $request->client_id;
            $receipt_accounts->amount = $request->Debit;
            $receipt_accounts->description = $request->description;
            $receipt_accounts->save();
            // store fund_accounts
            $fund_accounts = fund_account::where('receipt_id',$request->id)->first();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->receipt_id = $receipt_accounts->id;
            $fund_accounts->Debit = $request->Debit;
            $fund_accounts->credit = 0.00;
            $fund_accounts->save();
            // store client_accounts
            $client_accounts = client_account::where('receipt_id',$request->id)->first();
            $client_accounts->date =date('y-m-d');
            $client_accounts->client_id = $request->client_id;
            $client_accounts->receipt_id = $receipt_accounts->id;
            $client_accounts->Debit = 0.00;
            $client_accounts->credit =$request->Debit;
            $client_accounts->save();


            DB::commit();
            session()->flash('edit');
            return redirect()->route('Receipt.index');
        }

        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            receipt_account ::destroy($request->id);
            session()->flash('delete');
            return redirect()->back();
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
