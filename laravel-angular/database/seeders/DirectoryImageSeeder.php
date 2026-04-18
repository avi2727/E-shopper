<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DirectoryImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseDir = 'c:/xampp/htdocs';
        $foldersToScan = ['WOMEN', 'jeansbaby', 'jenaswomen', 'shirtbaby'];

        // Ensure Supercategory 1 exists to satisfy constraints (as used in previous seeder)
        $superCategoryId = 1;

        foreach ($foldersToScan as $topFolder) {
            $topFolderPath = $baseDir . '/' . $topFolder;

            if (!is_dir($topFolderPath)) {
                continue;
            }

            // Create or get top-level category
            $categoryName = ucfirst($topFolder);
            $category = DB::table('category')->where('name', $categoryName)->first();
            if (!$category) {
                $categoryId = DB::table('category')->insertGetId([
                    'name' => $categoryName,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                $categoryId = $category->id;
            }

            // Determine supercategory based on top folder (1: Men, 2: Women, 3: Baby)
            $superCategoryId = 1;
            if (in_array($topFolder, ['WOMEN', 'jenaswomen'])) {
                $superCategoryId = 2;
            } elseif (in_array($topFolder, ['jeansbaby', 'shirtbaby'])) {
                $superCategoryId = 3;
            }

            // Check if top folder has images directly
            $this->processImagesInDir($topFolderPath, $topFolder, $categoryId, null, $superCategoryId);

            // Check subdirectories
            $subdirs = glob($topFolderPath . '/*', GLOB_ONLYDIR);
            foreach ($subdirs as $subdir) {
                $subdirName = basename($subdir);
                
                // Determine supercategory based on top folder (1: Men, 2: Women, 3: Baby)
                $superCategoryId = 1;
                if (in_array($topFolder, ['WOMEN', 'jenaswomen'])) {
                    $superCategoryId = 2;
                } elseif (in_array($topFolder, ['jeansbaby', 'shirtbaby'])) {
                    $superCategoryId = 3;
                }
                
                // Create or get subcategory
                $subcatName = ucfirst($subdirName);
                $subcategory = DB::table('subcategory')->where('name', $subcatName)->first();
                if (!$subcategory) {
                    $subcategoryId = DB::table('subcategory')->insertGetId([
                        'name' => $subcatName,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    $subcategoryId = $subcategory->id;
                }

                $this->processImagesInDir($subdir, $topFolder . '/' . $subdirName, $categoryId, $subcategoryId, $superCategoryId);
            }
        }
    }

    private function processImagesInDir($dirPath, $relativePath, $categoryId, $subcategoryId, $superCategoryId)
    {
        $images = glob($dirPath . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        if (!$images) return;

        foreach ($images as $image) {
            $filename = basename($image);
            $productName = ucfirst(str_replace(['-', '_'], ' ', pathinfo($filename, PATHINFO_FILENAME)));
            
            // Clean up name by removing trailing numbers
            $cleanName = preg_replace('/[0-9]+$/', '', $productName);
            $cleanName = trim($cleanName);

            // We generate a relative URL assuming the frontend prepends its own URL
            $imageUrl = $relativePath . '/' . $filename;

            // Optional: avoid duplicate insertions by filename
            $exists = DB::table('product')->where('product_image', $imageUrl)->exists();
            if ($exists) {
                continue;
            }

            DB::table('product')->insert([
                'name' => $cleanName ?: $productName,
                'description' => 'Beautiful ' . ($cleanName ?: $productName) . ' from our standard collection.',
                'price' => rand(19, 99) + 0.99,
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId,
                'location' => 'Main Warehouse',
                'information' => 'Standard sizing. Comfortable fit.',
                'size' => collect(['S', 'M', 'L', 'XL'])->random(),
                'color' => 'Standard',
                'quantity' => rand(10, 100),
                'product_image' => $imageUrl, // e.g. /WOMEN/Blazers/img.jpg
                'Supercategory_id' => $superCategoryId,
                'availability' => 1,
                'trandy' => rand(0, 1),
                'justArrived' => rand(0, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
