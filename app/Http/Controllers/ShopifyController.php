<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\ApiCredential;
use App\Models\HanronProduct;
use App\Models\HanronProduct2;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ShopifyController extends Controller
{
    public function fetchAndSaveProducts($apiName)
    {
        $apiCredentials = ApiCredential::where('api_name', $apiName)->first();

        if (!$apiCredentials) {
            return response()->json(['error' => 'API credentials not found for ' . $apiName], 404);
        }

        $username = $apiCredentials->username;
        $password = $apiCredentials->password;

        // Create a new Guzzle client and a cookie jar to handle cookies
        $client = new Client();
        $cookieJar = new CookieJar();

        try {
            $response = $client->get('https://hanronjewellery.com/site/api3.php?m=products-xml-1', [
                'cookies' => $cookieJar,
                'query' => [
                    'username' => $username,
                    'password' => $password,
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $fileContent = $response->getBody()->getContents();

                // Save the response body (CSV file) to the local storage
                $filename = 'api_data_' . time() . '.csv';
                $filePath = storage_path('app/' . $filename);
                file_put_contents($filePath, $fileContent);

                $this->saveProducts();

                return response()->json([
                    'success' => true,
                    'message' => 'Data saved successfully',
                    'file' => $filename,
                ]);
            } else {
                Log::error('Failed to fetch data', [
                    'status_code' => $response->getStatusCode(),
                    'url' => 'https://hanronjewellery.com/site/api3.php?m=products-xml-1',
                    'username' => $username,
                ]);

                return response()->json([
                    'error' => 'Failed to fetch data',
                    'status_code' => $response->getStatusCode(),
                ], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching data', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveProducts()
    {
        // Array of CSV file paths
        $csvFiles = [
            storage_path('app/products3.csv'),
            storage_path('app/products4.csv')
        ];

        foreach ($csvFiles as $csvFile) {
            if (!file_exists($csvFile)) {
                return response()->json(['message' => 'CSV file not found: ' . $csvFile], 404);
            }

            if (($handle = fopen($csvFile, 'r')) !== false) {
                // Skip the header row
                fgetcsv($handle);

                // Process each row in the CSV file
                while (($data = fgetcsv($handle)) !== false) {
                    list(
                        $product_code,
                        $parent_code,
                        $description,
                        $product_name,
                        $image,
                        $option,
                        $stock,
                        $trade_price,
                        $average_weight
                    ) = $data;

                    // Save or update data in the HanronProduct table
                    HanronProduct::updateOrCreate(
                        ['product_code' => $product_code],
                        [
                            'parent_code' => $parent_code,
                            'description' => $description,
                            'product_name' => $product_name,
                            'image_url' => $image,
                            'option' => $option,
                            'stock' => $stock,
                            'trade_price' => $trade_price,
                            'average_weight' => $average_weight,
                        ]
                    );
                }

                fclose($handle);
            } else {
                return response()->json(['message' => 'Failed to open the CSV file: ' . $csvFile], 500);
            }
        }

        return redirect()->route('custom')->with('success', 'Products data has been saved successfully.');
    }

    // public function fetchAndSaveProducts1()
    // {
    //     $csvFile = storage_path('app/products3.csv');
    //     if (!file_exists($csvFile)) {
    //         return response()->json(['message' => 'CSV file not found.'], 404);
    //     }
    //     if (($handle = fopen($csvFile, 'r')) !== false) {
    //         fgetcsv($handle);
    //         while (($data = fgetcsv($handle)) !== false) {
    //             list(
    //                 $product_code,
    //                 $parent_code,
    //                 $description,
    //                 $product_name,
    //                 $image,
    //                 $option,
    //                 $stock,
    //                 $trade_price,
    //                 $average_weight
    //             ) = $data;

    //             HanronProduct::updateOrCreate(
    //                 ['product_code' => $product_code],
    //                 [
    //                     'parent_code' => $parent_code,
    //                     'description' => $description,
    //                     'product_name' => $product_name,
    //                     'image_url' => $image,
    //                     'option' => $option,
    //                     'stock' => $stock,
    //                     'trade_price' => $trade_price,
    //                     'average_weight' => $average_weight,
    //                 ]
    //             );
    //         }
    //         fclose($handle);
    //     } else {
    //         return response()->json(['message' => 'Failed to open the CSV file.'], 500);
    //     }
    //     return redirect()->route('custom')->with('success', 'Products data has been saved successfully.');
    // }

    // public function fetchAndSaveProducts2()
    // {
    //     $csvFile = storage_path('app/products4.csv');
    //     if (!file_exists($csvFile)) {
    //         return response()->json(['message' => 'CSV file not found.'], 404);
    //     }
    //     if (($handle = fopen($csvFile, 'r')) !== false) {
    //         fgetcsv($handle);
    //         while (($data = fgetcsv($handle)) !== false) {
    //             list(
    //                 $product_code,
    //                 $parent_code,
    //                 $description,
    //                 $product_name,
    //                 $image,
    //                 $option,
    //                 $stock,
    //                 $trade_price,
    //                 $average_weight
    //             ) = $data;

    //             HanronProduct2::updateOrCreate(
    //                 ['product_code' => $product_code],
    //                 [
    //                     'parent_code' => $parent_code,
    //                     'description' => $description,
    //                     'product_name' => $product_name,
    //                     'image_url' => $image,
    //                     'option' => $option,
    //                     'stock' => $stock,
    //                     'trade_price' => $trade_price,
    //                     'average_weight' => $average_weight,
    //                 ]
    //             );
    //         }
    //         fclose($handle);
    //     } else {
    //         return response()->json(['message' => 'Failed to open the CSV file.'], 500);
    //     }
    //     return redirect()->route('custom')->with('success', 'Products data has been saved successfully.');
    // }

    public function getProductsXml1()
    {
        try {
            $client = new Client();
            $url = 'https://www.hanronjewellery.com/site/api_csv_full.php?m=products-xml-1';

            $response = $client->get($url);
            $xmlContent = $response->getBody()->getContents();

            // Debugging
            dd($xmlContent);
            Log::info('Products XML:', ['content' => $xmlContent]);
        } catch (\Exception $e) {
            Log::error('Error fetching products XML: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch products XML 1'], 500);
        }
    }

    public function getProductsXml2()
    {
        try {
            $client = new Client();
            $url = 'https://www.hanronjewellery.com/site/api2.php?m=products-xml-1&json=1';

            $response = $client->get($url);
            $xmlContent = $response->getBody()->getContents();

            // Debugging
            dd($xmlContent);
            Log::info('Products XML:', ['content' => $xmlContent]);
        } catch (\Exception $e) {
            Log::error('Error fetching products XML: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch products XML 2'], 500);
        }
    }
}
