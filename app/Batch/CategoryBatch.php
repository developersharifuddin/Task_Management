<?php
// app/Batch/CategoryBatch.php

namespace App\Batch;

use App\Models\Size;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryBatch
{
    protected $batchSize;
    protected $totalRecords;

    public function __construct($batchSize, $totalRecords)
    {
        $this->batchSize = $batchSize;
        $this->totalRecords = $totalRecords;
    }

    public function insertFakeCategories()
    {
        echo "Inserting fake categories...\n";

        $batchSize = $this->batchSize;
        $totalRecords = $this->totalRecords;

        $chunks = ceil($totalRecords / $batchSize);

        for ($i = 1; $i <= $chunks; $i++) {
            echo "Inserting chunk data {$i} of {$chunks} inserted.\n";
            DB::beginTransaction();

            try {
                Category::factory()->count($batchSize)->create();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                echo "Error occurred while inserting records: " . $e->getMessage() . "\n";
            }
        }

        echo "Fake categories inserted successfully.\n";
    }
}
