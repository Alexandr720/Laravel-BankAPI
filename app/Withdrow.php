<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Withdrow extends Model {

    public static function withdrow($data) {
        $withdrow_amount = $data['withdrow_amount'];
        $withdrow_amount += 0.0;

        $ballance = DB::table('user')->where('id', $data['user_id'])->select('ballance')->first();

        if($withdrow_amount > $ballance->ballance) {
            return '0';
        } else {
            $date = date('Y-m-d H:i:s');
            $data = array(
                'withdrow_amount' => $data['withdrow_amount'],
                'created_at' => $date,
                'user_id' => $data['user_id']
            );
            $with_id = DB::table('withdrow')->insertGetId($data);
    
            if($with_id) {
                $ballance = $ballance->ballance - $withdrow_amount;
                DB::table('user')->where('id', $data['user_id'])->update(['ballance' => $ballance]);

                return $with_id;
            } else {
                return null;
            }
        }
    }
}
