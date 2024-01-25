<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandCollection extends ResourceCollection
{
    //command
    // php artisan make:resource BrandCollection --collection



    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            // 'data' =>
            // $this->collection->map(function ($brand) {
            //     return [
            //         'id' => $brand->id,
            //         'name_english' => $brand->name_english,
            //         'name_bangla' => $brand->name_bangla,
            //         'status' => $brand->status,
            //         'description' => $brand->description,
            //     ];
            // }),
            'data' => $this->chunk(500, function ($brandChunk) use (&$brands) {
                $brandsChunk = $brandChunk->map(function ($brand) {
                    return [
                        'id' => $brand->id,
                        'name_english' => $brand->name_english,
                        'name_bangla' => $brand->name_bangla,
                        'status' => $brand->status,
                        'description' => $brand->description,
                    ];
                });
                $brands[] = $brandsChunk->toArray();
            }),
            'message' => 'Data processing completed',
        ];

        // return [
        //     'data' => $this->collection,
        //     'links' => [
        //         'self' => 'link-value',
        //     ],
        // ];

        // return ['data' => $this->collection];
    }



    public function with(Request $request): array
    {
        return [
            'meta' => [
                'key' => 'value',
            ],
        ];

        // return (new BrandCollection(Brand::all()->load('status')))
        //     ->additional(['meta' => [
        //         'key' => 'value',
        //     ]]);
    }



    /**
     * Customize the outgoing response for the resource.
     */
    // public function withResponse(Request $request, JsonResponse $response): void
    // {
    //     $response->header('X-Value', 'True');
    // }
}
