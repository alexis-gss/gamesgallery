<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Update the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rating       $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Rating $rating): \Illuminate\Http\JsonResponse
    {
        return DB::transaction(function () use ($request, $rating) {
            $fields    = array_merge($request->all(), ['ip_address' => $request->ip()]);
            $validator = Validator::make($fields, [
                'ip_address' => 'required|unique:ratings,ip_address,NULL,id,picture_id,' . $request->picture_id,
                'picture_id' => 'required|numeric|exists:pictures,id|distinct',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }
            if ($request->ajax()) {
                $rating->fill($validator->validated());
                if ($rating->saveOrFail()) {
                    return response()->json($validator->validated()['picture_id']);
                }
            }
        });
    }
}
