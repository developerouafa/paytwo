<?php
namespace App\Repository\dashboard_user\Clients;

use App\Interfaces\dashboard_user\Clients\ClientRepositoryInterface;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function store($request)
    {
        try{
            DB::beginTransaction();
            Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'user_id' => auth()->user()->id,
                'password' => Hash::make($request->password)
            ]);
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
                    'password' => Hash::make($request->password),
                ]);
            }else{
                $Client->update([
                    'name' => $request->name,
                    'phone' => $request->phone,
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

    public function showsection($id)
    {
        // $section = Section::findOrFail($id);
        // $products = product::where('section_id', $id)->get();
        // return view('Dashboard/Sections.showproduct',compact('section', 'products'));
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
