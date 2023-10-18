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
        try{
            DB::beginTransaction();

                // store receipt_accounts
                $receipt_accounts = new receipt_account();
                $receipt_accounts->date =date('y-m-d');
                $receipt_accounts->client_id = $request->client_id;
                $receipt_accounts->amount = $request->Debit;
                $receipt_accounts->description = $request->description;
                $receipt_accounts->user_id = auth()->user()->id;
                $receipt_accounts->save();

                // store fund_accounts
                $fund_accounts = new fund_account();
                $fund_accounts->date =date('y-m-d');
                $fund_accounts->receipt_id = $receipt_accounts->id;
                $fund_accounts->Debit = $request->Debit;
                $fund_accounts->user_id = auth()->user()->id;
                $fund_accounts->credit = 0.00;
                $fund_accounts->save();

                // store client_accounts
                $client_accounts = new client_account();
                $client_accounts->date =date('y-m-d');
                $client_accounts->client_id = $request->client_id;
                $client_accounts->receipt_id = $receipt_accounts->id;
                $client_accounts->user_id = auth()->user()->id;
                $client_accounts->Debit = 0.00;
                $client_accounts->credit =$request->Debit;
                $client_accounts->save();

            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Receipt.index');
        }
        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Receipt.create');
        }

    }


    public function edit($id)
    {
        $receipt_accounts = receipt_account::findorfail($id);
        $Clients = Client::all();
        return view('Dashboard.dashboard_user.Receipt.edit',compact('receipt_accounts','Clients'));
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();
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
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Receipt.index');
        }

        catch (\Exception $exception) {
            DB::rollback();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Receipt.edit');
        }
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    receipt_account::findorFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.index');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    receipt_account::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Receipt.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Receipt.index');
            }
        }
    }

    public function deletetruncate()
    {
        DB::table('receipt_accounts')->delete();
        return redirect()->route('Receipt.index');
    }
}
