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
                'ip_address' => 'required|string|ip',
                'picture_id' => 'required|numeric|exists:pictures,id|distinct',
            ]);

            // Return all errors.
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // Check if the rating already exist.
            $ratingExist = Rating::query()
                ->where('ip_address', $validator->validated()['ip_address'])
                ->where('picture_id', $validator->validated()['picture_id'])
                ->first();
            if ($ratingExist) {
                $ratingExist->delete();
                return response()->json([
                    'rating_exist' => true,
                    'picture_id'   => $validator->validated()['picture_id']
                ]);
            }

            // Save the rating.
            $rating->fill($validator->validated());
            if ($rating->saveOrFail()) {
                return response()->json([
                    'rating_exist' => false,
                    'picture_id'   => $validator->validated()['picture_id']
                ]);
            }
        });
    }
}
