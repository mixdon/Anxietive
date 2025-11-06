<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HelperModel extends Model
{

    private $URL     = "https://storage.anxietive.com/api/post-image";
    private $X_AUTH  = "Anxietive2O25";

    public function insertImg($file = null, $class = null)
    {
        $response = Http::withHeaders([
            'X-Auth' => $this->X_AUTH
        ])->attach(
            'file',      
            file_get_contents($file->getRealPath()),
            $file->getClientOriginalName()
        )->post($this->URL);

        $status = $response->status();

        if($status == 200){
            $data = $response->json();
            return $data['file_name'];
        } else {
            // insert ke tabel log api
            $data = $response->json();
            $error = $data["error"] ?? "Error tidak diketahui"; 
            DB::table("tb_log_api")->insert([
                "class_function" => $class,
                "status_code" => $status,
                "msg" => $error,
                "insert_at" => date("Y-m-d H:i:s")
            ]);

            return null;
        }

        
    }
}
