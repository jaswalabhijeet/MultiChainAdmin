<?php

class MultiChain {

    private $channel;
    private $cliPath;

    /**
     * コンストラクタ
     * @param $channel  チャンネル
     * @param $cliPath  multichain-cliコマンドへの絶対パス
     */
    public function __construct($channel, $cliPath) {
        $this->channel = $channel;
        $this->cliPath = $cliPath;
    }

    /**
     * 現在のノードとブロックチェーンの情報を取得する
     * MultiChainのgetinfoを実行する
     * @return mixed
     */
    public function getInfo() {
        return $this->getinfo();
    }


    /**
     * アドレスを作成する
     * MultiChainのgetgetnewaddressを実行する
     * @param string $address
     * @return mixed アドレス
     */
    public function getNewAddress($address = '') {
        return $this->getnewaddress($address);
    }


    /**
     * Assetを作成する
     * MultiChainのissueを実行する
     * @param $address
     * @param $assetName
     * @param $quantity
     * @param int $unit
     * @param int $nativeAmount
     * @param array $customField
     * @return mixed
     */
    public function issue($address, $assetName, $quantity, $unit = 1, $nativeAmount = 0, $customField = array()) {
        return $this->issue($address, $assetName, $quantity, $unit, $nativeAmount, json_encode($customField));
    }


    /**
     * 通貨を送る
     * MultiChainのsendtoaddressを実行する
     * @param $address
     * @param $amount
     * @param string $comment
     * @param string $commentTo
     * @return mixed
     */
    public function sendToAddress($address, $amount, $comment = '', $commentTo = '') {
        return $this->sendToAddress($address, $amount, $comment, $commentTo);
    }


    /**
     * 通貨を送る(送信元アドレスを指定)
     * MultiChainのsendfromaddressを実行する
     * @param $address
     * @param $amount
     * @param string $comment
     * @param string $commentTo
     * @return mixed
     */
    public function sendFromAddress($fromAddress, $toAddress, $amount, $comment = '', $commentTo = '') {
        return $this->sendFromAddress($fromAddress, $toAddress, $amount, $comment, $commentTo);
    }


    /**
     * MultiChainのメソッドを実行
     * @param $method
     * @param array $param
     * @return mixed|null
     */
    public function __call($method, $param = array()) {

        $command = $this->cliPath . $this->channel . ' ' . $method;
        foreach ($param as $p) {
            $command.= ' ' . $p;
        }

        exec($command, $lines);

        if (count($lines) < 3) {
            return null;
        }


        $ret = '';
        for ($i = 2; $i < count($lines); $i++) {
            $ret .= $lines[$i] . "\n";
        }

        $ret = trim($ret);

        if(strpos($ret, 'error') === false) {
            $json = json_decode($ret, true);
            return $json[0];
        } else {
            return json_decode($ret, true);
        }

    }
}