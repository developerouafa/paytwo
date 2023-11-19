<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\profileclient;
use App\Traits\GeneralTraitt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    use GeneralTraitt;

    public function InvoicesSent(){
        $invoices = invoice::latest()->where('type', '0')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $invoicesmonetary = invoice::latest()->where('type', '1')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $invoicespostpaid = invoice::latest()->where('type', '2')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();
        $invoicesbanktransfer = invoice::latest()->where('type', '3')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $invoicescard = invoice::latest()->where('type', '4')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();

        return $this->returnMultipData('invoices', $invoices, 'invoicesmonetary', $invoicesmonetary, 'fund_accountreceipt', $fund_accountreceipt, 'invoicespostpaid', $invoicespostpaid, 'fund_accountpostpaid', $fund_accountpostpaid, 'invoicesbanktransfer', $invoicesbanktransfer, 'invoicescard', $invoicescard);

    }

    public function showinvoicereceipt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        return $this->returnData('fund_accounts', $fund_accounts);
    }

    public function showinvoicereceiptPostpaid($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        return $this->returnData('fund_accounts', $fund_accounts);
    }

    public function showinvoice($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnData('invoice', $invoice);
    }

    public function Complete(Request $request){
        // validation
        try{
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', Rule::unique(Client::class)->ignore($this->user()->id)],
                'clienType' => ['required'],
                'nationalIdNumber' => ['required'],
                'address' => ['required'],
                'city' => ['required', 'string', 'max:255'],
                'postalcode' => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

        try{
            $id = $request -> header('profileclientid');
            $client_id = $request -> header('client_id');
            $client = Client::findOrFail($client_id);
            $profileclient = profileclient::findOrFail($id);
                DB::beginTransaction();
                    $client->update([
                        'name' =>  $request -> header('name'),
                        'email' => $request -> header('email'),
                        'phone' => $client->phone
                    ]);
                    if($request -> header('clienType') == '1'){
                        if($request -> header('nothavetax') == '0'){
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => $request -> header('taxNumber'),
                            ]);
                        }
                    }
                    if($request -> header('clienType') == '0'){
                        if($request -> header('nothavetax') == '0'){
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => $request -> header('commercialRegistrationNumber'),
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'commercialRegistrationNumber' => $request -> header('commercialRegistrationNumber'),
                                'taxNumber' => $request -> header('taxNumber'),
                            ]);
                        }
                    }
                DB::commit();
                return redirect()->route('Continue', $request -> header('invoice_id'));
                // return $this->returnSuccessMessage('Logged out successfully');
        }catch(\Exception $execption){
            DB::rollBack();
            return  $this -> returnError('','some thing went wrongs');
        }
    }

    public function Continue($id)
    {
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->first();
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnTreeData('invoice' , $invoice, 'fund_accountreceipt' , $fund_accountreceipt, 'fund_accountpostpaid' , $fund_accountpostpaid);
    }
}
