<?php

namespace App\Services;

use App\Traits\Files;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CsvExportService
{
    /**
     * Export data to CSV and return file URL
     */
    public function export(array $headers, array $data, ?string $filename = null): mixed
    {
        // Generate filename if not provided
        $filename = $filename ?? 'export_' . now()->format('Ymd_His') . '.csv';

        // Create CSV content
        $csv = $this->createCsv($headers, $data);
        $folder = 'Exports';
        if (!File::exists(public_path($folder))) {
            File::makeDirectory(public_path($folder), 0755, true);
        }

        // Save file
        $filePath = public_path($folder . '/' . $filename);
        File::put($filePath, $csv);

        // Return file info
        return $filename;
    }

    /**
     * Create CSV string from data
     */
    private function createCsv(array $headers, array $data): string
    {
        // Start with UTF-8 BOM for Excel
        $csv = "\xEF\xBB\xBF";

        // Add headers
        $csv .= $this->formatRow($headers) . "\n";

        // Add data rows
        foreach ($data as $row) {
            $csv .= $this->formatRow($row) . "\n";
        }

        return $csv;
    }

    /**
     * Format a single CSV row
     */
    private function formatRow(array $row): string
    {
        $formatted = [];

        foreach ($row as $value) {
            // Convert to string and escape quotes
            $value = str_replace('"', '""', (string) $value);

            // Add quotes if needed
            if (strpos($value, ',') !== false || strpos($value, '"') !== false) {
                $value = '"' . $value . '"';
            }

            $formatted[] = $value;
        }

        return implode(',', $formatted);
    }
}
