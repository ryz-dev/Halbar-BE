<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pricing;
use App\PricingItem;
use Carbon;
use GlobalClass;

class PricingController extends Controller
{
    public function index(Request $request)
    {
        /* Data pricing */
        $emailBlast = Pricing::where('category', 'EmailBlast')
        ->orderBy('id', 'DESC')
        ->get();
        $docoBilling = Pricing::where('category', 'DocoBilling')
        ->orderBy('id', 'DESC')
        ->get();

        foreach ($emailBlast as $key => $value) {
            $pricing['response']['emailBlast'][] = [
                'name' => $value->name,
                'items' => $this->specItems($value->items, $request)
            ];
        }

        foreach ($docoBilling as $key => $value) {
            $pricing['response']['docoBilling'][] = [
                'name' => $value->name,
                'items' => $this->specItems($value->items, $request)
            ];
        }

        if (isset($pricing['response'])) {
            $pricing['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($pricing, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 200
            ]
        ], 200);
    }

    public function specItems($value, $request)
    {
        $items = array();
        if ($request->has('bestseller')) {
            foreach ($value->where('bestseller', '1') as $item) {
                $items[] = [
                    'id' => $item->id,
                    'name' => $item->name_paket,
                    'email' => $item->total_email,
                    'price' => $item->total_harga,
                    'template_total' => $item->template_total,
                    'domain' => boolval($item->domain),
                    'sender' => boolval($item->sender),
                    'slicing' => boolval($item->slicing),
                    'template' => boolval($item->template),
                    'bestseller' => boolval($item->bestseller),
                    'url' => $item->url,
                    'max_attach' => $item->price_email
                ];
            }
        } else {
            foreach ($value as $item) {
                $items[] = [
              'id' => $item->id,
              'name' => $item->name_paket,
              'email' => $item->total_email,
              'price' => $item->total_harga,
              'template_total' => $item->template_total,
              'domain' => boolval($item->domain),
              'sender' => boolval($item->sender),
              'slicing' => boolval($item->slicing),
              'template' => boolval($item->template),
              'bestseller' => boolval($item->bestseller),
              'url' => $item->url,
              'max_attach' => $item->price_email
            ];
            }
        }
        return $items;
    }

    public function detail(Request $request)
    {
        $items = PricingItem::findOrfail($request->id);
        $item['response'] = [
            'id' => $items->id,
            'name' => $items->name_paket,
            'email' => $items->total_email,
            'price' => $items->total_harga,
            'template_total' => $items->template_total,
            'domain' => boolval($items->domain),
            'sender' => boolval($items->sender),
            'slicing' => boolval($items->slicing),
            'template' => boolval($items->template),
            'bestseller' => boolval($items->bestseller),
            'url' => $items->url,
        ];
        if ($item) {
            $item['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($item, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 200
            ]
        ], 200);
    }
}
