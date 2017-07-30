<?php

namespace App\Http\Controllers\Sync;

use App\Models\Member;
use App\Models\TcgGameRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TcgService;
use App\Models\GameList;
class SyncController extends Controller
{

    public function getPtGameList($type)
    {
        $o = new TcgService();

        $res = json_decode($o->gameList(3,$type), TRUE);

        if ($res['status'] == 0)
        {
            GameList::where('gameType', $type)->where('id', '>', 1)->delete();
            $data = $res['games'];

            foreach ($data as $value) {
                GameList::create([
                    'displayStatus' => $value['displayStatus'],
                    'gameType' => $value['gameType'],
                    'gameName' => $value['gameName'],
                    'tcgGameCode' => $value['tcgGameCode'],
                    'productCode' => $value['productCode'],
                    'productType' => $value['productType'],
                    'platform' => $value['platform'],
                ]);
            }
            echo '成功';
        } else {
            echo '错误代码 '.$res['status'];
        }
    }

    public function getTcgGameRecord(Request $request)
    {
        set_time_limit(0);

        //foreach (range(0000, 2345))
        $time_data= [];
            for ($i = 0000;$i <= 2345; $i+=15)
            {
                $i = (string)$i;
                if (strlen($i) < 4)
                {
                    $zero = '';
                    for ($j=0; $j<(4 - strlen($i));$j++)
                    {
                        $zero.='0';
                    }

                    $i = $zero.$i;
                }
                $time_data[] = date("Ymd$i", strtotime('-1 day'));
                //echo $i.'<br>';
            }
            //exit;
//        $time_data[0] = date('Ymd0000');
//        $time_data[1] = date('YmdH15');
//        $time_data[2] = date('YmdH30');
//        $time_data[3] = date('YmdH45');

        $date_str = implode(',', $time_data);
        //var_dump($date_str);exit;
        $page = 1;
        $o = new TcgService();
        $jl_json = json_decode($o->record($date_str, $page), TRUE);
        //dd();exit;
        if ($jl_json['status'] == 0)
        {
            foreach ($jl_json['details'] as $item)
            {
                $name = substr($item['username'], 3);
                $mod = Member::where('name', $name)->first();
                $member_id = $mod?$mod->id:0;
                $item['member_id'] = $member_id;
                TcgGameRecord::create($item);
            }
            echo '成功';


        } else {
            echo '调用接口失败，错误代码'.$jl_json['status'];exit;
        }


    }
}
