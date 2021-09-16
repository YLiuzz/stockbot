<?php
    define('BOT_TOKEN', 'xxxx');
    define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
    
    // read incoming info and grab the chatID
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    $chatID = $update["message"]["chat"]["id"];
    $got_message = $update["message"]["text"];

    // compose reply
    
    $stocknum_t = 'tse_'. $got_message .'.tw';
    $url = 'https://mis.twse.com.tw/stock/api/getStockInfo.jsp';
    $url = 'https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch='.$stocknum_t;
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    $stock_info = json_decode($result);

    
    $c = $stock_info->msgArray[0]->c;
    $cp_name = $stock_info->msgArray[0]-> n;
    $price = $stock_info->msgArray[0]->z;
        // $c = $stock_info->msgArray[0]->tv;
        // $c = $stock_info->msgArray[0]->v;
    $todayopen = $stock_info->msgArray[0]->o;
        // $c = $stock_info->msgArray[0]->h;
        // $c = $stock_info->msgArray[0]->l;
        // $c = $stock_info->msgArray[0]->y;
    $upordown = $price - $todayopen;
    $msg =  "股票代號：".$c ."公司名：".$cp_name." 目前股價：".$price." 今日漲跌幅：" . $upordown ;
    $urlmsg = urlencode($msg);
    // send reply
    $sendto =API_URL."sendmessage?chat_id=".$chatID."&text=".$urlmsg;
    file_get_contents($sendto);

    // function sendMessage($chatID, $messaggio, $token) {
    //     echo "sending message to " . $chatID . "\n";
    
    //     $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    //     $url = $url . "&text=" . urlencode($messaggio);
    //     $ch = curl_init();
    //     $optArray = array(
    //             CURLOPT_URL => $url,
    //             CURLOPT_RETURNTRANSFER => true
    //     );
    //     curl_setopt_array($ch, $optArray);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     print_r($result);
    //     return $result;
    // }



    
    
    // function stockshow($stocknum)
    // {
    //     $stocknum_t = 'tse_'. $stocknum .'.tw';
    //     $url = 'https://mis.twse.com.tw/stock/api/getStockInfo.jsp';
    //     $url = 'https://mis.twse.com.tw/stock/api/getStockInfo.jsp?ex_ch='.$stocknum_t;
    //     $ch = curl_init();
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true
    //     );
    //     curl_setopt_array($ch, $optArray);
    //     $result = curl_exec($ch);
    //     curl_close($ch);
    //     $stock_info = json_decode($result);

    
    //     $c = $stock_info->msgArray[0]->c;
    //     $cp_name = $stock_info->msgArray[0]-> n;
    //     $price = $stock_info->msgArray[0]->z;
    //     // $c = $stock_info->msgArray[0]->tv;
    //     // $c = $stock_info->msgArray[0]->v;
    //     $todayopen = $stock_info->msgArray[0]->o;
    //     // $c = $stock_info->msgArray[0]->h;
    //     // $c = $stock_info->msgArray[0]->l;
    //     // $c = $stock_info->msgArray[0]->y;
    //     $upordown = $price - $todayopen;

    //     $stock_true_data = [
    //             'cpnum' => $c,
    //             'cpname'=> $cp_name,
    //             'price' => $price,
    //             'upanddown' => $upordown
    //     ];

    //     // var_dump($stock_true_data);
    //     $token = "1966244158:AAHrwSb2Q-hUKX6z4IW3GvcYnOF4NX6koC4";
    //     $chatid = "@TestApiii"; //1486002104
    //     sendMessage($chatid, "股票代號：".$c ."公司名：".$cp_name." 目前股價：".$price." 今日漲跌幅：" . $upordown, $token);
        
    // }
    // stockshow(1101);
    
?>



