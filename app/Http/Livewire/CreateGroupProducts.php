<?php

namespace App\Http\Livewire;

use App\Models\groupprodcut;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateGroupProducts extends Component
{
    public $GroupsItems = [];
    public $allProducts = [];
    public $discount_value = 0;
    public $taxes = 17;
    public $name_group_en;
    public $name_group_ar;
    public $notes_en;
    public $notes_ar;
    public $ServiceSaved = false;
    public $ServiceUpdated = false;
    public $show_table = true;
    public $updateMode = false;
    public $groupprodcut_id;

    public function mount()
    {
        $this->allProducts = product::all();
    }

    public function render()
    {
        $total = 0;
        foreach ($this->GroupsItems as $groupItem) {
            if ($groupItem['is_saved'] && $groupItem['price'] && $groupItem['quantity']) {
                $total += $groupItem['price'] * $groupItem['quantity'];
            }
        }
        return view('livewire.GroupProducts.create-group-products', [
            'groups'=>groupprodcut::latest()->get(),
            'subtotal' => $Total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'total' => $Total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100)
        ]);
    }

    public function addService()
    {
        foreach ($this->GroupsItems as $key => $groupItem) {
            if (!$groupItem['is_saved']) {
                $this->addError('GroupsItems.' . $key, __('Dashboard/products.savenewservice'));
                return;
            }
        }

        $this->GroupsItems[] = [
            'id' => '',
            'quantity' => 1,
            'is_saved' => false,
            'name' => '',
            'price' => 0
        ];

        $this->ServiceSaved = false;
    }

    public function editService($index)
    {
        foreach ($this->GroupsItems as $key => $groupItem) {
            if (!$groupItem['is_saved']) {
                $this->addError('GroupsItems.' . $key, 'This line must be saved before editing another.');
                return;
            }
        }
        $this->GroupsItems[$index]['is_saved'] = false;
    }

    public function saveService($index)
    {
        $this->resetErrorBag();
        $product = $this->allProducts->find($this->GroupsItems[$index]['id']);
        $this->GroupsItems[$index]['name'] = $product->name;
        $this->GroupsItems[$index]['price'] = $product->price;
        $this->GroupsItems[$index]['is_saved'] = true;
    }

    public function removeService($index)
    {
        unset($this->GroupsItems[$index]);
        $this->GroupsItems = array_values($this->GroupsItems);
    }

    public function saveGroup()
    {
        // update
        if($this->updateMode){
            $Groups = groupprodcut::find($this->groupprodcut_id);
            $total = 0;
            foreach ($this->GroupsItems as $groupItem) {
                if ($groupItem['is_saved'] && $groupItem['price'] && $groupItem['quantity']) {
                    // الاجمالي قبل الخصم
                    $total += $groupItem['price'] * $groupItem['quantity'];
                }
            }
            //الاجمالي قبل الخصم
            $Groups->total_before_discount = $total;
            // قيمة الخصم
            $Groups->discount_value = $this->discount_value;
            // الاجمالي بعد الخصم
            $Groups->total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
            //  نسبة الضريبة
            $Groups->tax_rate = $this->taxes;
            // الاجمالي + الضريبة
            $Groups->total_with_tax = $Groups->total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);

            // حفظ الترجمة
            $Groups->name= ['en' => $this->name_group_en, 'ar' => $this->name_group_ar];
            $Groups->notes= ['en' => $this->notes_en, 'ar' => $this->notes_ar];
            $Groups->save();
            // حفظ العلاقة
            $Groups->product_groups()->detach();
            foreach ($this->GroupsItems as $GroupsItem) {
                $Groups->product_groups()->attach($GroupsItem['id'],['quantity' => $GroupsItem['quantity']]);
            }
            $this->ServiceSaved = false;
            $this->ServiceUpdated = true;
        }
        else{
            // insert
            $Groups = new groupprodcut();
            $total = 0;

            foreach ($this->GroupsItems as $groupItem) {
                if ($groupItem['is_saved'] && $groupItem['price'] && $groupItem['quantity']) {
                    // الاجمالي قبل الخصم
                    $total += $groupItem['price'] * $groupItem['quantity'];
                }
            }

            //الاجمالي قبل الخصم
            $Groups->Total_before_discount = $total;
            // قيمة الخصم
            $Groups->discount_value = $this->discount_value;
            // الاجمالي بعد الخصم
            $Groups->Total_after_discount = $total - ((is_numeric($this->discount_value) ? $this->discount_value : 0));
            //  نسبة الضريبة
            $Groups->tax_rate = $this->taxes;
            // الاجمالي + الضريبة
            $Groups->Total_with_tax = $Groups->Total_after_discount * (1 + (is_numeric($this->taxes) ? $this->taxes : 0) / 100);

            // حفظ الترجمة
            $Groups->name= ['en' => $this->name_group_en, 'ar' => $this->name_group_ar];
            $Groups->notes= ['en' => $this->notes_en, 'ar' => $this->notes_ar];
            $Groups->user_id = auth()->user()->id;
            $Groups->save();

            // حفظ العلاقة
            foreach ($this->GroupsItems as $GroupsItem) {
                $Groups->product_groups()->attach($GroupsItem['id'],['quantity' => $GroupsItem['quantity']]);
            }

            $this->reset('GroupsItems', 'name_group_en', 'name_group_ar', 'notes_en', 'notes_ar');
            $this->discount_value = 0;
            $this->ServiceSaved = true;

        }
    }

    public function show_form_add(){
        $this->show_table = false;
    }

    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $group = groupprodcut::where('id',$id)->first();
        $this->groupprodcut_id = $id;

        $this->reset('GroupsItems', 'name_group_en', 'name_group_ar', 'notes_en', 'notes_ar');
        $this->name_group_en=$group->name;
        $this->notes_en=$group->notes;

        $this->discount_value = intval($group->discount_value);
        $this->ServiceSaved = false;

        foreach ($group->product_group as $serviceGroup)
        {
            $this->GroupsItems[] = [
                'id' => $serviceGroup->id,
                'quantity' => $serviceGroup->pivot->quantity,
                'is_saved' => true,
                'name' => $serviceGroup->name,
                'price' => $serviceGroup->price
            ];
        }
    }

    public function delete($id){
        groupprodcut::destroy($id);
        return redirect()->to('/Add_GroupProducts');
    }

    public function deleteall()
    {
        DB::table('groupprodcuts')->whereNull('deleted_at')->delete();
        return redirect()->to('/Add_GroupProducts');
    }
}
