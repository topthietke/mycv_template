<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use Helpers;
    public function __construct(){

    }

    private function get_data_candidate($candidate_id) {
        $url      = config('app.url') . '/api/candidate/' .  $candidate_id;
        $response = $this->data_get($url);
        $data     = json_decode($response, true);
        $candidate = $data['data'];
        $candidate['birthday'] = !empty($candidate['birthday']) ? Carbon::parse($candidate['birthday'])->format('d/m/Y') : '';
        return $candidate;
    }
    public function index()
    {        
        $user_id   = Auth::user()->id;        
        $candidate = $this->get_data_candidate($user_id);
        $data = [
            "candidate" => $candidate
        ];
        
        return view('pages.index', $data);
    }
}
