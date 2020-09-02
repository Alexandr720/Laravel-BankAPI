<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Deposit extends Model {
    
    public static function deposit($data) {
        $id = DB::table('deposit')->insertGetId($data);

        if($id) {
            $ballance = DB::table('user')->where('id', $data['user_id'])->select('ballance')->first();
            $ballance = $ballance->ballance + ($data['deposit_amount'] + 0.0);

            DB::table('user')->where('id', $data['user_id'])->update(['ballance' => $ballance]);
            return $id;
        } else {
            return null;
        }
    }
}
