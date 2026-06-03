<?php

namespace App\Http\Traits;

trait BackendApiTrait
{
    protected $POST = 'POST';
    protected $GET  = 'GET';
    protected $CONTENT_TYPE_JSON =  'application/json';
    protected $CONTENT_TYPE_JS =  'application/javascript';
    protected $CONTENT_MULTI_FORM_DATA = 'multipart/form-data';
    protected $CONTENT_FORM_URLENCODED = 'application/x-www-form-urlencoded';
    
    public function apiBase($url,$method,$postData,$content_type){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,   // CURLOPT_TIMEOUT => 30 (Image upload may need)
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type:'.$content_type,
                'Access-Control-Allow-Origin: *',
                'token:' . session('store.token'),
            ),
            // CURLOPT_SSL_VERIFYPEER => false, // Image upload may need
        ));

        $response = curl_exec($curl);
        // if (curl_errno($curl)) {
        //     $error_msg = curl_error($curl);
        //     dd(curl_error($curl));
        // }
        curl_close($curl);        
        return $response;
    }

    public function api_get_url($url) {
        try {
            $response = $this->apiBase($url, $this->GET, null, $this->CONTENT_TYPE_JSON);
            $res = json_decode($response);            
            return $res->personal ?? null;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),

            ]);
        }
    }

    public function api_post_url($url){        
        $response = $this->apiBase($url, $this->POST, null, $this->CONTENT_TYPE_JSON);
        return $response;
    }
    
}
