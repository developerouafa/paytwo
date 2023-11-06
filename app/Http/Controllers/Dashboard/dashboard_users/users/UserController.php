<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Users\StoreUserRequest;
use App\Models\fund_account;
use App\Models\imageuser;
use App\Models\invoice;
use App\Models\receipt_account;
use App\Models\receiptdocument;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id','DESC')->whereNot('id', '1')->whereNot('id', auth()->user()->id)->paginate(5);
        return view('Dashboard/dashboard_user/users.show_users',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('Dashboard/dashboard_user/users.Add_user',compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try{
            DB::beginTransaction();
                $user = User::create([
                    'name' => ['en' => $request->nameen, 'ar' => $request->namear],
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                $user->assignRole($request->input('roles_name'));

            DB::commit();
            toastr()->success(__('Dashboard/messages.add'));
            return redirect()->route('users.index');
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(__('Dashboard/messages.error'));
            return redirect()->route('users.index');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('Dashboard/dashboard_user/users.show',compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('Dashboard/dashboard_user/users.edit',compact('user','roles','userRole'));
    }

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
            return redirect()->route('users.index');
        }
    }

    public function destroy(Request $request)
    {
        // Delete One Request
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
        // Delete Group Request
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
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type->App\Notifications\clienttouser')->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_user.Printinvoice.invoicePrint',compact('invoice'));
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
        $completepyinvoice = invoice::findorFail($request->invoice_id);
        if($completepyinvoice->type == 1){
            $fund_account = fund_account::whereNotNull('receipt_id')->where('invoice_id', $completepyinvoice->id)->first();
            $receipt = receipt_account::findorfail($fund_account->receipt_id);
            $receipt->update([
                'descriptiontoclient' => $request->descriptiontoclient
            ]);
        }
        if($completepyinvoice->type == 2){
            return '2';

        }
        if($completepyinvoice->type == 3){
            $fund_account = fund_account::whereNotNull('receipt_id')->where('invoice_id', $completepyinvoice->id)->first();
            dd($fund_account);
        }
        if($completepyinvoice->type == 3){
            return '4';
        }
        $completepyinvoice->update([
            'invoice_status' => '3',
            'invoice_type' => '2',
        ]);
    }

    public function refusedpayment(Request $request){
        return $request;
        // $completepyinvoice = invoice::findorFail($request->invoice_id);
        // $completepyinvoice->update([
        //     'invoice_status' => '3',
        //     'invoice_type' => '3',
        // ]);
    }
}
