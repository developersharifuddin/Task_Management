<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            $file = fopen(Storage::path($this->filePath), 'r');
            $header = fgetcsv($file);

            $data = [];
            while (($row = fgetcsv($file)) !== false) {
                $rowData = array_combine($header, $row);
                $data[] = $rowData;
            }
            fclose($file);

            foreach ($data as &$product) {
                // Assuming 'parent_id' might be coming as a string 'NULL'
                if ($product['discount_type'] === 'NULL') {
                    $product['discount_type'] = null; // Convert string 'NULL' to actual null
                }

                if ($product['name'] === true) {
                    $product['name'] = $product['name'] . rand(100000); // Convert string 'NULL' to actual null
                    $product['slug'] = $product['slug'] . rand(100000); // Convert string 'NULL' to actual null
                }
            }
            // Adjust the data array to exclude the 'id' column
            $filteredData = collect($data)->map(function ($item) {
                unset($item['id']);
                return $item;
            })->values()->all();

            // Chunk the data and perform the insert in smaller sets
            $chunkedData = array_chunk($filteredData, 500);

            // Use a transaction to ensure data integrity
            DB::beginTransaction();
            foreach ($chunkedData as $chunk) {
                Product::insertOrIgnore($chunk);
            }
            // Set a success flash message
            $successMessage = 'CSV file has been successfully imported.';
            Session::flash('success', $successMessage);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error processing CSV job: " . $e->getMessage());
            throw $e;
        }
    }
}
