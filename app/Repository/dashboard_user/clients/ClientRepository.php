<?php
namespace App\Repository\dashboard_user\Clients;

use App\Interfaces\dashboard_user\Clients\ClientRepositoryInterface;
use App\Mail\newaccountclient;
use App\Models\Client;
use App\Models\invoice;
use App\Models\receipt_account;
use App\Models\receiptdocument;
use App\Notifications\newaccountclientnotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use function Symfony\Component\String\b;

class ClientRepository implements ClientRepositoryInterface
{

    public function index()
    {
      $clients = Client::latest()->clientselect()->clientwith()->get();
      return view('Dashboard/dashboard_user/clients.clients',compact('clients'));
    }

    public function softdelete()
    {
        $clients = Client::onlyTrashed()->latest()->clientselect()->clientwith()->get();
        return view('Dashboard/dashboard_user/clients.softdelete',compact('clients'));
    }

    public function create()
    {
      return view('Dashboard/dashboard_user/clients.create');
    }

    public function createclient(){
        return view('Dashboard/dashboard_user/clients.newaccountclient');
    }

    public function store($request)
    {
        try{
            DB::beginTransaction();
            $client = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_id' => auth()->user()->id,
                'password' => Hash::make($request->password)
            ]);
                $basic  = new \Vonage\Client\Credentials\Basic("886051ab", "uQ1pGoon8OSzTCyd");
                $client = new \Vonage\Client($basic);
                $messagenewaccount = __('Dashboard/clients_trans.mssgntfnewaccount').'...'.
                                    __('Dashboard/users.phone'). ': ' .$request->phone. ': '.
                                    __('Dashboard/auth.password').': ' . $request->password;

                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($request->pays.$request->phone, 'TikTik', $messagenewaccount)
                );
                $message = $response->current();
                if ($message->getStatus() == 0) {
                    echo "The message was sent successfully\n";
                } else {
                    echo "The message failed with status: " . $message->getStatus() . "\n";
                }

                $client_id = Client::latest()->first()->id;

                //* Notification Email
                $mailclient = Client::findorFail($client_id);
                $nameclient = $mailclient->name;
                $url = url('en/login');
                Mail::to($mailclient->email)->send(new newaccountclient($messagenewaccount, $nameclient, $url));

            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->route('Clients.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Clients.index');
        }
    }

    public function update($request)
    {
        try{
            DB::beginTransaction();
            $Client = Client::findOrFail($request->id);
            $password = $Client->password;

            if(!empty($input['password'])){
                $Client->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $Client->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => $password,
                ]);
            }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Clients.index');
        }
        catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->route('Clients.index');
        }
    }

    public function destroy($request)
    {
        // Delete One Request
        if($request->page_id==1){
            try{
                DB::beginTransaction();
                    Client::findOrFail($request->id)->delete();
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Clients.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Clients.index');
            }
        }
        // Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                DB::beginTransaction();
                    Client::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Clients.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Clients.index');
            }
        }
    }

    public function showinvoice($id)
    {
        $client = Client::findOrFail($id);
        $invoices = invoice::where('client_id', $client->id)->get();

        $invoicesnomethodpay = invoice::where('client_id', $client->id)->where('type', 0)->get();
        $invoicescatchpayment = invoice::where('client_id', $client->id)->where('type', 1)->get();
        $invoicespostpaid = invoice::where('client_id', $client->id)->where('type', 2)->get();
        $invoicesbanktransfer = invoice::where('client_id', $client->id)->where('type', 3)->get();
        $invoicescard = invoice::where('client_id', $client->id)->where('type', 4)->get();

        // $invoices_statusNew = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 1)->get();
        // $invoices_statusSent = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 2)->get();
        // $invoices_statusUnderreview = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 3)->get();
        // $invoices_statusComplete = invoice::latest()->where('invoice_classify',1)->where('invoice_status', 3)->get();

        // $invoices_typeDraft = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 1)->get();
        // $invoices_typePaid = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 2)->get();
        // $invoices_typeCanceled = invoice::latest()->where('invoice_classify',1)->where('invoice_type', 3)->get();
        return view('Dashboard/dashboard_user/clients.invoices',compact('client', 'invoices', 'invoicesnomethodpay', 'invoicescatchpayment', 'invoicespostpaid', 'invoicesbanktransfer', 'invoicescard'));
    }

    public function clientinvoice($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $receiptdocument = receiptdocument::where('invoice_id', $id)->where('client_id', $invoice->client_id)->with('Client')->with('Invoice')->first();
        return view('Dashboard.dashboard_user.Printinvoice.Paidinvoice',compact('invoice', 'receiptdocument'));
    }

    public function editstatusactive($id)
    {
        try{
            $Client = Client::findorFail($id);
            DB::beginTransaction();
            $Client->update([
                'Status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Clients.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Clients.index');
        }
    }

    public function editstatusdéactive($id)
    {
        try{
            $Client = Client::findorFail($id);
            DB::beginTransaction();
            $Client->update([
                'Status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Clients.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Clients.index');
        }
    }

    public function deleteall()
    {
        DB::table('clients')->delete();
        return redirect()->route('Clients.index');
    }

    public function restore($id)
    {
        try{
            DB::beginTransaction();
                Client::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Clients.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Clients.softdelete');
        }
    }

    public function forcedelete($id)
    {
        try{
            DB::beginTransaction();
                Client::onlyTrashed()->find($id)->forcedelete();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.delete'));
            return redirect()->route('Clients.softdelete');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Clients.softdelete');
        }
    }
}
