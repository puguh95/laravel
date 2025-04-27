<?php

namespace App\Etc;

use Illuminate\Database\Eloquent\Builder;

class Utils
{
    /**
     * Handles pagination of data based on the current page and items per page.
     *
     * @param Illuminate\Database\Eloquent\Builder $model The Eloquent model to paginate.
     * @param int $data_per_page The number of items per page.
     * @param int $page The current page number.
     * @return array An array containing pagination data and the paginated result.
     */
    public static function paginate(Builder $model, int $data_per_page, int $page): array
    {
        // Total count of items in the model
        $total_data = $model->count();

        // Calculate the maximum number of pages
        $max_page = ceil($total_data / $data_per_page);

        // Calculate the starting point for the data on the current page
        $start_from = $data_per_page * ($page - 1);

        // Initialize the result array with pagination information
        $result = [
            'total_data' => $total_data,
            'current_page' => $page,
            'data_per_page' => $data_per_page,
            'max_page' => $max_page,
            'from' => $start_from + 1, // Starting index (1-based)
            // Generate URLs for the next, previous, first, and last pages
            'next_page' => request()->fullUrlWithQuery(['page' => $page + 1 < $max_page ? $page + 1 : $max_page]),
            'previous_page' => request()->fullUrlWithQuery(['page' => $page - 1 < 1 ? 1 : $page - 1]),
            'first_page' => request()->fullUrlWithQuery(['page' => 1]),
            'last_page' => request()->fullUrlWithQuery(['page' => $max_page]),
            'result_text' => '', // Placeholder for result text
            'links' => [], // Links for pagination (page numbers)
            // Fetch the actual data for the current page
            'data' => $model->skip($start_from)->take($data_per_page)->get()
        ];

        // Generate page number links for pagination
        for ($i = $page - 2; $i < $page + 3; $i++) {
            // Ensure page numbers are within valid range
            if ($i < 1) {
                $i = 1;
            }
            if ($i > $max_page) break;

            // Add pagination links for each page number
            array_push($result['links'], [
                'selected' => $i == $page, // Mark the current page as selected
                'page' => $i,
                'url' => request()->fullUrlWithQuery(['page' => $i])
            ]);
        }

        // Update result text to display the range of displayed items
        $result['result_text'] = 'Hasil: ' . ($start_from + 1) . '-' . ($start_from + count($result['data'])) . ' dari ' . $result['total_data'];

        return $result;
    }
}
