<?php

class virustotalapi
{
    public $APIKEY;

    public function __construct($api)
    {
        $this->APIKEY = $api;
    }


    public function CURL($prams)
    {
        /*
       $prams = [
            "URL" => "",
            "METHOD" => "POST",
            "POSTFIELDS" => []
        ];
       */
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $prams["URL"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($prams["METHOD"] == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            if (is_array($prams["POSTFIELDS"])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $prams["POSTFIELDS"]);
            }
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        }


        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: multipart/form-data';
        $headers[] = 'X-Apikey: ' . $this->APIKEY;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = 'ERROR';
        }

        curl_close($ch);
        return $result;
    }

    public function fileScan($File)
    {
        return $this->CURL([
            "URL" => "https://www.virustotal.com/api/v3/files",
            "METHOD" => "POST",
            "POSTFIELDS" => [
                'file' => new CURLFile($File),
            ]
        ]);
    }

    public function fileReport($ID)
    {
        return $this->CURL([
            "URL" => "https://www.virustotal.com/api/v3/analyses/" . $ID,
            "METHOD" => "GET"
        ]);
    }
}


?>
