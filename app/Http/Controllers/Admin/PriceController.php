<?php

namespace App\Http\Controllers\Admin;

use App\PricingItem;
use App\Pricing;
use App\Images;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* List All Function Group */

    public function index(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }

        $data['price'] = Pricing::where('name', 'like', '%' . $key . '%')->paginate(20);
        return view('admin.pricinggroup.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service']);
        $data['category'] = Category::get();
        return view('admin.pricinggroup.create', $data);
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        /*Validation Store*/
        $this->validate($r, [
            'name' => 'required',
            'category' => 'required'
        ]);

        $pricingGroup = new Pricing();
        $pricingGroup->category = $r->category;
        $pricingGroup->name = $r->name;
        $pricingGroup->save();

        /*Success Message*/
        $r->session()->flash('success', 'Service Successfully Added');
        return redirect(route('pricing'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $pricingGroup = Pricing::findOrFail($id);
            $data['pricing'] = $pricingGroup;
            $data['category'] = Category::get();
            return view('admin.pricinggroup.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pricing');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Validation Update*/
        $this->validate($r, [
            'name' => 'required',
            'category' => 'required'
        ]);

        /* Save DB */
        $pricingGroup = Pricing::find($id);
        $pricingGroup->category = $r->category;
        $pricingGroup->name = $r->name;
        $pricingGroup->save();

        /*Success Message*/
        $r->session()->flash('success', 'Service Successfully Modified');
        return redirect(route('pricing'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        $count = PricingItem::where('pricing', $r->id)->count();
        if ($count == 0) {
            /*Delete Data*/
            Pricing::where('id', $r->id)->delete();
            /*Success Message*/
            $r->session()->flash('success', 'Service Successfully Deleted');
        } else {
            /*Failed Message*/
            $r->session()->flash('success', 'Please remove your items price');
        }
        return redirect(route('pricing'));
    }


    /* List All Function items */

    public function itemPricing(Request $r, $groupID)
    {
        GlobalClass::Roleback(['Customer Service']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }
        $count = Pricing::find($groupID);
        if ($count) {
            $data['pricing'] = PricingItem::where('pricing', $groupID)
                ->where('name_paket', 'like', '%' . $key . '%')
                ->paginate(20);
            return view('admin.pricing.index', $data);
        }
        return redirect(route('pricing'));
    }

    public function itemCreate(Request $r, $groupID)
    {
        $count = Pricing::find($groupID);
        if ($count) {
            GlobalClass::Roleback(['Customer Service']);
            return view('admin.pricing.create');
        }
        return redirect(route('pricing'));
    }

    public function itemStore(Request $r)
    {
        $count = Pricing::find($r->idgroup);
        if ($count) {
            GlobalClass::Roleback(['Customer Service']);

            /*Validation Store*/
            $this->validate($r, [
                'name_paket' => 'required',
                'url' => 'required',
                'total_email' => 'numeric|required',
                'total_harga' => 'numeric|required'
            ]);

            /* Save DB */

            $pricing = new PricingItem();
            if ($r->has('bestseller')) {
                $freshPricing = PricingItem::where('pricing', $r->idgroup)->update(['bestseller'=>false]);
                $pricing->bestseller = $r->bestseller==''?false:true;
            }
            if ($r->has('price_email')) {
                $pricing->price_email = $r->price_email;
            }
            $pricing->name_paket = $r->name_paket;
            $pricing->total_email = $r->total_email;
            $pricing->total_harga = $r->total_harga;
            $pricing->template_total = $r->template_total;
            $pricing->domain = $r->domain==''?false:true;
            $pricing->sender = $r->sender==''?false:true;
            $pricing->slicing = $r->slicing==''?false:true;
            $pricing->template = $r->template==''?false:true;
            $pricing->pricing = $r->idgroup;
            $pricing->url = $r->url;
            $pricing->save();

            /*Success Message*/
            $r->session()->flash('success', 'Pricing Successfully Added');
            return redirect(route('item_pricing', ['id' => $r->idgroup]));
        }
        return redirect(route('pricing'));
    }

    public function itemEdit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $pricing = PricingItem::findOrFail($id);
            $data['pricing'] = $pricing;
            return view('admin.pricing.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pricing');
        }
    }

    public function itemUpdate($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        $pricing = PricingItem::find($id);

        /*Validation Store*/
        $this->validate($r, [
            'name_paket' => 'required',
            'url' => 'required',
            'total_email' => 'numeric|required',
            'total_harga' => 'numeric|required'
        ]);

        /* Save DB */
        $freshPricing = PricingItem::where('pricing', $r->idgroup)->update(['bestseller'=>false]);
        if ($freshPricing) {
            $pricing->bestseller = $r->bestseller==''?false:true;
        }
        $pricing->price_email = $r->price_email;
        $pricing->name_paket = $r->name_paket;
        $pricing->total_email = $r->total_email;
        $pricing->total_harga = $r->total_harga;
        $pricing->template_total = $r->template_total;
        $pricing->domain = $r->domain==''?false:true;
        $pricing->sender = $r->sender==''?false:true;
        $pricing->slicing = $r->slicing==''?false:true;
        $pricing->template = $r->template==''?false:true;
        $pricing->url = $r->url;
        $pricing->update();

        /*Success Message*/
        $r->session()->flash('success', 'Pricing Successfully Added');
        return redirect(route('item_pricing', ['id' => $r->idgroup]));
    }

    public function itemDelete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Delete Data*/
        PricingItem::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Pricing Successfully Deleted');
        return redirect()->back();
    }
}
