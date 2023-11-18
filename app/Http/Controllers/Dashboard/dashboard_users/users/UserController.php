<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Users\StoreUserRequest;
use App\Mail\mailclient;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\fund_account;
use App\Models\imageuser;
use App\Models\invoice;
use App\Models\paymentaccount;
use App\Models\paymentgateway;
use App\Models\receipt_account;
use App\Models\receiptdocument;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\banktransferntf;
use App\Notifications\confirmpyinvoice;
use App\Notifications\montaryinvoice;
use App\Notifications\paymentgateways;
use App\Notifications\postpaidbillinvoice;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //* Page Show Users (Except the user who is logged in) & (Except for the Super Admin)
    public function index(Request $request)
    {
        $users = User::orderBy('id','DESC')->whereNot('id', '1')->whereNot('id', auth()->user()->id)->paginate(5);
        return view('Dashboard/dashboard_user/users.show_users',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    //* Create New User
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('Dashboard/dashboard_user/users.Add_user',compact('roles'));
    }

    //* Store User
    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
                $user = User::create([
                    'name' => ['en' => $request->nameen, 'ar' => $request->namear],
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'Status' => $request->Status,
                    'password' => Hash::make($request->password)
                ]);
                $user->assignRole($request->input('roles_name'));
            DB::commit();
            toastr()->success(__('Dashboard/messages.add'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.create');
        }
    }

    //* Show One User
    public function show($id)
    {
        $user = User::find($id);
        return view('Dashboard/dashboard_user/users.show',compact('user'));
    }

    //* Page Edit User
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('Dashboard/dashboard_user/users.edit',compact('user','roles','userRole'));
    }

    //* Update User
    public function update(Request $request, $id)
    {
        // Validation
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'name_'.app()->getLocale() => 'required',
            ],[
                'email.required' =>__('Dashboard/users.emailrequired'),
                'email.unique' =>__('Dashboard/users.emailunique'),
                'password.required' =>__('Dashboard/users.passwordrequired'),
                'password.same' =>__('Dashboard/users.passwordsame'),
                'roles.required' =>__('Dashboard/users.rolesnamerequired'),
                'name.required' => __('Dashboard/users.namerequired')
            ]);
        try{
            DB::beginTransaction();

                $user = User::find($id);
                $password = $user->password;

                if(App::isLocale('en')){
                    if(!empty($input['password'])){
                        $user->update([
                            'name' => $request->name_en,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $user->update([
                            'name' => $request->name_en,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => $password,
                        ]);
                    }
                }
                elseif(App::isLocale('ar')){
                    if(!empty($input['password'])){
                        $user->update([
                            'name' => $request->name_ar,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => Hash::make($request->password),
                        ]);
                    }else{
                        $user->update([
                            'name' => $request->name_ar,
                            'phone' => $request->phone,
                            'email' => $request->email,
                            'Status' => $request->Status,
                            'password' => $password,
                        ]);
                    }
                }

                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $user->assignRole($request->input('roles'));

            DB::commit();
            toastr()->success(__('Dashboard/messages.edit'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.update');
        }
    }

    public function destroy(Request $request)
    {
        //! Delete One Request
        if($request->page_id==1){
            try{
                $id = $request->user_id;
                $tableimageuser = imageuser::where('user_id',$id)->first();
                if(!empty($tableimageuser)){
                    $image = $tableimageuser->image;

                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
                DB::beginTransaction();
                    User::find($id)->delete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('users.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('users.index');
            }
        }
        //! Delete One SoftDelete
        if($request->page_id==3){
            try{
                $id = $request->user_id;
                $tableimageuser = imageuser::where('user_id',$id)->first();
                if(!empty($tableimageuser)){
                    $image = $tableimageuser->image;

                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
                DB::beginTransaction();
                    invoice::onlyTrashed()->find($request->id)->forcedelete();
                DB::commit();
                toastr()->success(__('Dashboard/messages.delete'));
                return redirect()->route('users.softdeleteusers');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('users.softdeleteusers');
            }
        }
        //! Delete Group SoftDelete
        if($request->page_id==2){
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                $tableimageuser = imageuser::where('user_id',$delete_select_id)->first();
                if(!empty($tableimageuser)){
                    $image = $tableimageuser->image;

                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
                DB::beginTransaction();
                foreach($delete_select_id as $dl){
                    User::where('id', $dl)->withTrashed()->forceDelete();
                }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('Users.softdeleteusers');
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Users.softdeleteusers');
            }
        }
        //! Delete Group Request
        else{
            try{
                $delete_select_id = explode(",", $request->delete_select_id);
                $tableimageuser = imageuser::where('user_id',$delete_select_id)->first();
                if(!empty($tableimageuser)){
                    $image = $tableimageuser->image;

                    if(!$image) abort(404);
                    unlink(public_path('storage/'.$image));
                }
                DB::beginTransaction();
                    User::destroy($delete_select_id);
                DB::commit();
                toastr()->success(trans('Dashboard/messages.delete'));
                return redirect()->route('users.index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(__('Dashboard/messages.error'));
                return redirect()->route('users.index');
            }
        }
    }

    //* Restore One User
    public function restoreusers($id){
        try{
            DB::beginTransaction();
                User::withTrashed()->where('id', $id)->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    //* Restore All Users
    public function restoreallusers()
    {
        try{
            DB::beginTransaction();
                User::withTrashed()->restore();
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    //* Restore All Select Users
    public function restoreallselectusers(Request $request)
    {
        try{
            $restore_select_id = explode(",", $request->restore_select_id);
            DB::beginTransaction();
                foreach($restore_select_id as $rs){
                    User::withTrashed()->where('id', $rs)->restore();
                }
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('Users.softdeleteusers');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('Users.softdeleteusers');
        }
    }

    //* Active Login User
    public function editstatusactive($id)
    {
        try{
            $User = User::findorFail($id);
            DB::beginTransaction();
            $User->update([
                'Status' => 1,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('users.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('users.index');
        }
    }

    //* Déactive Login User
    public function editstatusdéactive($id)
    {
        try{
            $User = User::findorFail($id);
            DB::beginTransaction();
            $User->update([
                'Status' => 0,
            ]);
            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->route('users.index');
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->route('users.index');
        }
    }

    public function clienttouser($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $receiptdocument = receiptdocument::where('invoice_id', $id)->where('client_id', $invoice->client_id)->with('Client')->with('Invoice')->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\clienttouser')->first();
        DB::table('notifications')->where('id', $getID->id)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_user.Printinvoice.Paidinvoice',compact('invoice', 'receiptdocument'));
    }

    public function clienttouserinvoice($id)
    {
        $invoice = invoice::where('id', $id)->first();
        $receiptdocument = receiptdocument::where('invoice_id', $id)->where('client_id', $invoice->client_id)->with('Client')->with('Invoice')->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\clienttouserinvoice')->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_user.Printinvoice.Paidinvoice',compact('invoice', 'receiptdocument'));
    }

    public function confirmpayment(Request $request){
        $confirmpyinvoice = invoice::findorFail($request->invoice_id);

        try{
            DB::beginTransaction();

                if($confirmpyinvoice->type == 1){
                    $fund_account = fund_account::whereNotNull('receipt_id')->where('invoice_id', $confirmpyinvoice->id)->first();
                    $receipt = receipt_account::findorfail($fund_account->receipt_id);
                    $receipt->update([
                        'descriptiontoclient' => $request->descriptiontoclient
                    ]);

                    $client = Client::findorFail($confirmpyinvoice->client_id);
                    $user_create_id = $confirmpyinvoice->user_id;
                    $invoice_id = $confirmpyinvoice->id;
                    $message = __('Dashboard/main-header_trans.confirmpyinvoice');
                    Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

                    // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
                    // $nameclient = $mailclient->name;
                    // $url = url('en/Invoices/print/'.$invoice_id);
                    // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                if($confirmpyinvoice->type == 2){
                    $fund_account = fund_account::whereNotNull('Payment_id')->where('invoice_id', $confirmpyinvoice->id)->first();
                    $postpaid = paymentaccount::findorfail($fund_account->Payment_id);
                    $postpaid->update([
                        'descriptiontoclient' => $request->descriptiontoclient
                    ]);

                    $client = Client::findorFail($confirmpyinvoice->client_id);
                    $user_create_id = $confirmpyinvoice->user_id;
                    $invoice_id = $confirmpyinvoice->id;
                    $message = __('Dashboard/main-header_trans.confirmpyinvoice');
                    Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

                    // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
                    // $nameclient = $mailclient->name;
                    // $url = url('en/Invoices/print/'.$invoice_id);
                    // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                if($confirmpyinvoice->type == 3){
                    $fund_account = fund_account::whereNotNull('bank_id')->where('invoice_id', $confirmpyinvoice->id)->first();
                    $postpaid = banktransfer::findorfail($fund_account->bank_id);
                    $postpaid->update([
                        'descriptiontoclient' => $request->descriptiontoclient
                    ]);

                    $client = Client::findorFail($confirmpyinvoice->client_id);
                    $user_create_id = $confirmpyinvoice->user_id;
                    $invoice_id = $confirmpyinvoice->id;
                    $message = __('Dashboard/main-header_trans.confirmpyinvoice');
                    Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

                    // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
                    // $nameclient = $mailclient->name;
                    // $url = url('en/Invoices/print/'.$invoice_id);
                    // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                if($confirmpyinvoice->type == 4){
                    $fund_account = fund_account::whereNotNull('Gateway_id')->where('invoice_id', $confirmpyinvoice->id)->first();
                    $postpaid = paymentgateway::findorfail($fund_account->Gateway_id);
                    $postpaid->update([
                        'descriptiontoclient' => $request->descriptiontoclient
                    ]);

                    $client = Client::findorFail($confirmpyinvoice->client_id);
                    $user_create_id = $confirmpyinvoice->user_id;
                    $invoice_id = $confirmpyinvoice->id;
                    $message = __('Dashboard/main-header_trans.confirmpyinvoice');
                    Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

                    // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
                    // $nameclient = $mailclient->name;
                    // $url = url('en/Invoices/print/'.$invoice_id);
                    // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                $confirmpyinvoice->update([
                    'invoice_status' => '4',
                    'invoice_type' => '2',
                ]);

            DB::commit();
            toastr()->success(trans('Dashboard/messages.add'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('message.error'));
            return redirect()->back();
        }
    }

    public function refusedpayment(Request $request){
        $confirmpyinvoice = invoice::findorFail($request->invoice_id);
        if($confirmpyinvoice->type == 1){
            $fund_account = fund_account::whereNotNull('receipt_id')->where('invoice_id', $confirmpyinvoice->id)->first();
            $receipt = receipt_account::findorfail($fund_account->receipt_id);
            $receipt->update([
                'descriptiontoclient' => $request->descriptiontoclient
            ]);

            $client = Client::findorFail($confirmpyinvoice->client_id);
            $user_create_id = $confirmpyinvoice->user_id;
            $invoice_id = $confirmpyinvoice->id;
            $message = __('Dashboard/main-header_trans.refusedpyinvoice');
            Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

            // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
            // $nameclient = $mailclient->name;
            // $url = url('en/Invoices/print/'.$invoice_id);
            // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
        }
        if($confirmpyinvoice->type == 2){
            $fund_account = fund_account::whereNotNull('Payment_id')->where('invoice_id', $confirmpyinvoice->id)->first();
            $postpaid = paymentaccount::findorfail($fund_account->Payment_id);
            $postpaid->update([
                'descriptiontoclient' => $request->descriptiontoclient
            ]);

            $client = Client::findorFail($confirmpyinvoice->client_id);
            $user_create_id = $confirmpyinvoice->user_id;
            $invoice_id = $confirmpyinvoice->id;
            $message = __('Dashboard/main-header_trans.refusedpyinvoice');
            Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

            // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
            // $nameclient = $mailclient->name;
            // $url = url('en/Invoices/print/'.$invoice_id);
            // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
        }
        if($confirmpyinvoice->type == 3){
            $fund_account = fund_account::whereNotNull('bank_id')->where('invoice_id', $confirmpyinvoice->id)->first();
            $postpaid = banktransfer::findorfail($fund_account->bank_id);
            $postpaid->update([
                'descriptiontoclient' => $request->descriptiontoclient
            ]);

            $client = Client::findorFail($confirmpyinvoice->client_id);
            $user_create_id = $confirmpyinvoice->user_id;
            $invoice_id = $confirmpyinvoice->id;
            $message = __('Dashboard/main-header_trans.refusedpyinvoice');
            Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

            // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
            // $nameclient = $mailclient->name;
            // $url = url('en/Invoices/print/'.$invoice_id);
            // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
        }
        if($confirmpyinvoice->type == 3){
            $fund_account = fund_account::whereNotNull('Gateway_id')->where('invoice_id', $confirmpyinvoice->id)->first();
            $postpaid = paymentgateway::findorfail($fund_account->Gateway_id);
            $postpaid->update([
                'descriptiontoclient' => $request->descriptiontoclient
            ]);

            $client = Client::findorFail($confirmpyinvoice->client_id);
            $user_create_id = $confirmpyinvoice->user_id;
            $invoice_id = $confirmpyinvoice->id;
            $message = __('Dashboard/main-header_trans.refusedpyinvoice');
            Notification::send($client, new confirmpyinvoice($user_create_id, $invoice_id, $message));

            // $mailclient = Client::findorFail($confirmpyinvoice->client_id);
            // $nameclient = $mailclient->name;
            // $url = url('en/Invoices/print/'.$invoice_id);
            // Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
        }
        $confirmpyinvoice->update([
            'invoice_status' => '4',
            'invoice_type' => '3',
        ]);
    }

    public function softusers(Request $request)
    {
        $users = User::onlyTrashed()->latest()->whereNot('id', '1')->whereNot('id', auth()->user()->id)->paginate(5);
        return view('Dashboard/dashboard_user/users.softdeletesusers',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    //* Delete All Users (Except the user who is logged in) & (Except for the Super Admin)
    public function deleteallusers(){
        DB::table('users')->whereNull('deleted_at')->whereNot('id', '1')->whereNot('id', auth()->user()->id)->delete();
        return redirect()->route('Users.index');
    }

    //* Delete All Users Sofdelete (Except the user who is logged in) & (Except for the Super Admin)
    public function deletealluserssoftdelete(){
        DB::table('users')->whereNotNull('deleted_at')->whereNot('id', '1')->whereNot('id', auth()->user()->id)->delete();
        return redirect()->route('Users.softdeleteusers');
    }
}
