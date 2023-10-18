<?php
namespace App\Repository\dashboard_user\Clients;

use App\Interfaces\dashboard_user\Clients\ClientRepositoryInterface;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{

    public function index()
    {
      $clients = Client::query()->clientselect()->clientwith()->get();
      return view('Dashboard/dashboard_user/clients.clients',compact('clients'));
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
                'user_id' => auth()->user()->id,
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
                $Client->update([
                    'name' => $request->name,
                    'phone' => $request->phone
                ]);
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
                return redirect()->route('Children_index');
            }catch(\Exception $execption){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Children_index');
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

    public function editstatusdéactive($id)
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

    public function editstatusactive($id)
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

    public function deletetruncate()
    {
        DB::table('clients')->delete();
        return redirect()->route('Clients.index');
    }
}
