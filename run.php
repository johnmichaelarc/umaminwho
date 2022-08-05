<?php

class Main
{

    private $message;
    private $umaminUser;

    public function __construct($umaminUser, $message)
    {
        $this->umaminUser = $umaminUser;
        $this->message = $message;
    }

    public function send()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://umamin.link/api/graphql',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{"query":"mutation sendMessage($input: SendMessageInput!) {\\n  sendMessage(input: $input)\\n}\\n","variables":{"input":{"receiverUsername":"' . $this->umaminUser . '","content":"' . $this->message . '","receiverMsg":"Confess something."}},"operationName":"sendMessage"}',
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function run($thread = 1)
    {
        for ($i = 1; $i <= $thread; $i++) {
            self::send();
        }
    }
}


echo <<<EOL
                        _            _        
  _  _ _ __  __ _ _ __ (_)_ ___ __ _| |_  ___ 
 | || | '  \/ _` | '  \| | ' \ V  V / ' \/ _ \
  \_,_|_|_|_\__,_|_|_|_|_|_||_\_/\_/|_||_\___/
                                              
[+] Author: Chael Aracosta
[-] Github: https://github.com/johnmichaelarc

EOL;
PHP_EOL;
echo '[+] Umamin Username (ex:csnntrt): ';
$umaminUser = trim(fgets(STDIN, 1024));
echo '[+] Message:';
$message = trim(fgets(STDIN, 1024));
echo '[+] Thread:';
$thread = trim(fgets(STDIN, 1024));

$umamin = new Main($umaminUser, $message);
$umamin->run($thread);
