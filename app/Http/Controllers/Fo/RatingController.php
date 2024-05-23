<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Picture;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            // Check if there is an existing universally unique identifier in the cache,
            // if not in case, create it and store it in the cache.
            if (is_null(Cache::get('rating-uuid'))) {
                Cache::put('rating-uuid', Str::uuid()->toString());
            }

            // Validate the request.
            $validator = Validator::make(
                array_merge($request->all(), ['uuid' => Cache::get('rating-uuid')]),
                [
                    'uuid'       => 'required|uuid|string',
                    'picture_id' => 'required|numeric|exists:pictures,id|distinct',
                ]
            );

            // Return all errors.
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            // Check if the rating already exist.
            $ratingExist = Rating::query()->where([
                ['uuid', $validator->validated()['uuid']],
                ['picture_id', $validator->validated()['picture_id']]
            ])->first();

            // Update rating.
            ($ratingExist) ? $ratingExist->delete() : $rating->fill($validator->validated())->saveOrFail();

            /** @var string $toastId Toast message uuid */
            $toastId = Str::uuid()->toString();

            return response()->json([
                'view' => view('front.partials.toast-template', [
                    'gameName'     => Picture::query()
                        ->where('id', $validator->validated()['picture_id'])
                        ->first()->game->name,
                    'picturePlace' => $request->picture_place,
                    'toastId'      => $toastId,
                    'likeStatus'   => ($ratingExist) ? false : true,
                ])->render(),
                'toastId'   => $toastId,
                'pictureId' => $validator->validated()['picture_id'],
            ]);
        });
    }
}
