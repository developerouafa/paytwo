<?php


namespace App\Repository\Finance;

use App\Interfaces\dashboard_user\Finance\PaymentRepositoryInterface;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\PaymentAccount;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function index()
    {
        $payments =  PaymentAccount::all();
        return view('Dashboard.dashboard_user.Payment.index',compact('payments'));
    }

    public function create()
    {
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Payment.add',compact('Clients'));
    }

    public function show($id)
    {
        $payment_account = PaymentAccount::findorfail($id);
        return view('Dashboard.dashboard_user.Payment.print',compact('payment_account'));
    }

    public function store($request)
    {
        DB::beginTransaction();

        try {

            // store Payment_accounts
            $payment_accounts = new PaymentAccount();
            $payment_accounts->date =date('y-m-d');
            $payment_accounts->client_id = $request->client_id;
            $payment_accounts->amount = $request->credit;
            $payment_accounts->description = $request->description;
            $payment_accounts->save();

            // store fund_accounts
            $fund_accounts = new fund_account();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->credit = $request->credit;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // store client_accounts
            $client_accounts = new client_account();
            $client_accounts->date =date('y-m-d');
            $client_accounts->cient_id = $request->cient_id;
            $client_accounts->Payment_id = $payment_accounts->id;
            $client_accounts->Debit = $request->credit;
            $client_accounts->credit = 0.00;
            $client_accounts->save();

            DB::commit();
            session()->flash('add');
            return redirect()->route('Payment.create');

        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $payment_accounts = PaymentAccount::findorfail($id);
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Payment.edit',compact('payment_accounts','Clients'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            // update Payment_accounts
            $payment_accounts = PaymentAccount::findorfail($request->id);
            $payment_accounts->date =date('y-m-d');
            $payment_accounts->client_id = $request->client_id;
            $payment_accounts->amount = $request->credit;
            $payment_accounts->description = $request->description;
            $payment_accounts->save();

            // update fund_accounts
            $fund_accounts = fund_account::where('Payment_id',$payment_accounts->id)->first();
            $fund_accounts->date =date('y-m-d');
            $fund_accounts->Payment_id = $payment_accounts->id;
            $fund_accounts->credit = $request->credit;
            $fund_accounts->Debit = 0.00;
            $fund_accounts->save();

            // update client_accounts
            $client_accounts = client_account::where('Payment_id',$payment_accounts->id)->first();
            $client_accounts->date =date('y-m-d');
            $client_accounts->client_id = $request->client_id;
            $client_accounts->Payment_id = $payment_accounts->id;
            $client_accounts->Debit = $request->credit;
            $client_accounts->credit = 0.00;
            $client_accounts->save();

            DB::commit();
            session()->flash('edit');
            return redirect()->route('Payment.index');

        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            PaymentAccount ::destroy($request->id);
            session()->flash('delete');
            return redirect()->back();
        }
        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
