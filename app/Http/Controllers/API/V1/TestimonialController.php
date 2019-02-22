<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Testimonials;
use Carbon;
use GlobalClass;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        /* Data Master */
        $dataTestimonial = Testimonials::orderBy('id', 'DESC')->get();

        /* Data Testimonial */
        foreach ($dataTestimonial as $key => $value) {
            $Testimonial['response'][] = [
                'id' => $value->id,
                'name' => $value->name,
                'position' => $value->position,
                'message' => $value->message,
                'image' => asset('uploaded/media/' . $value->image),
                'created_at' => Carbon\Carbon::parse($value->create_at)->format('d F Y')
            ];
        }
        if (isset($Testimonial['response'])) {
            $Testimonial['diagnostic'] = [
                'code' => 200,
                'status' => 'ok'
            ];
            return response($Testimonial, 200);
        }
        return response([
            'diagnostic' => [
                'status' => 'NOT_FOUND',
                'code' => 404
            ]
        ], 404);
    }
}
