<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Withdrow;

class WithdrowController extends Controller {
    public function viewWithdrow() {
        return view('main.withdrow');
    }
    
    public function withdrow(Request $request) {
        $data = array(
            'user_id' => $request->user_id,
            'withdrow_amount' => $request->withdrow_amount
        );
        
        $with_id = Withdrow::withdrow($data);

        if($with_id) {
            if($with_id == '0'){
                $res = array(
                    'state' => 'warning',
                    'message' => "Withdrow amount must be less than ballance!"
                );
            } else {
                $TranCont = new TransactionController;
                $type = "withdrow";
                $amount = $request->withdrow_amount;
                $user_id = $request->user_id;

                $tran_id = $TranCont->createTransaction($type, $amount, $user_id, $with_id);
                if($tran_id) {
                    $res = array(
                        'state' => 'success',
                        'message' => "Withdrow successfully!"
                    );
                } else {
                    $res = array(
                        'state' => 'error',
                        'message' => "Something went wrong!"
                    );
                }
            }
            $res = array(
                'state' => 'success',
                'message' => "Withdrow successfully!"
            );
        } else {
            $res = array(
                'state' => 'error',
                'message' => "Something went wrong!"
            );
        }

        $res = json_encode($res);
        echo $res;
    }
}
