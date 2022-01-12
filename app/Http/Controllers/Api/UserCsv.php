<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class UserCsv 
{
    const USER_CSV_PATH = 'UserCsv.csv';

    private $file_path = '';

    private $rows = [];

    private $error = [
        'error' => false
    ];

    /**
     * Generate the csv file
     * @param array $orders
     * @return Response file
     */
    public function generateCsv($users = []) {
        abort_if(
            !Storage::disk('private')->exists(self::USER_CSV_PATH),
            404,
            "The file doesn't exist. Check the path."
        );
        $this->file_path = storage_path('app/private/' . self::USER_CSV_PATH);
        $this->pushToCsv($users);
        if (isset($this->error['message'])) {
            $this->error['error'] = true;
            return $this->error;
        }
        return Response::download($this->file_path);
    }
    /**
     * put rows in csv file
     * @param array $row
     */
    private function pushToCsv($users = []) {
        $this->prepareRows($users);
        if (count($users) > 0) {
            $this->clearCsv();
            if (count($this->rows) > 0) {
                foreach ($this->rows as $row) {
                    $file = fopen( $this->file_path, 'a' );
                    fputcsv($file, $row);
                    fclose($file);
                }
            } else {
                $this->error['message'] = 'No rows prepared.';
            }
        } else {
            $this->error['message'] = 'No rows prepared. 0 orders';
        }
    }

    /**
     * fill all rows
     * @param array $orders
     */
    private function prepareRows($users) {
        foreach ($users as $user) {

            {
                $this->rows[] = [
                    'USER ID' => $user->id,
                    'LASTNAME' => $user->lastname,
                    'FIRSTNAME' => $user->firstname,
                    'EMAIL' => $user->email,
                ];
            }
        }
    }

    /**
     * Clear the existing csv
     */
    private function clearCsv() {
        $fp = fopen($this->file_path, "w");
        fputcsv($fp, array_keys($this->rows[0]));
        fclose($fp);
    }

}