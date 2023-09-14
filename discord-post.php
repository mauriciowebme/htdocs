<?PHP
    function discordmsg($msg, $webhook) {
        if($webhook != "") {
            $ch = curl_init( $webhook );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $msg);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec( $ch );
            // If you need to debug, or find out why you can't send message uncomment line below, and execute script.
            echo $response;
            curl_close( $ch );
        }
    }

    // URL FROM DISCORD WEBHOOK SETUP
    
    $webhook = "https://discord.com/api/webhooks/1151034318643273788/HfdmZ4KYDFmYJN-8TahQSz-Fkah6yHa3bvL90tJRhITmDFdkSjjdg3kPBUesUPH_qK6P"; 
    $timestamp = date("c", strtotime("now"));
    $msg = json_encode([
    // Message
    //"content" => "Poder Judiciário",

    // Username
    "username" => "Tribunal de Justiça",

    // Avatar URL.
    // Uncomment to use custom avatar instead of bot's pic
    "avatar_url" => "https://cdn.discordapp.com/attachments/1151381245461274664/1151388885872553984/poder_judiciario_logo.png?size=500",

    // text-to-speech
    "tts" => false,

    // file_upload
    // "file" => "",

    // Embeds Array
    "embeds" => [
        [
            // Title
            "title" => "Cadastro Nacional de Advogados",

            // Embed Type, do not change.
            "type" => "rich",

            // Description
            "description" => "Este documento tem fé publica e foi assinado digitalmente pela autoridade judiciária",

            // Link in title
           // "url" => "",

            // Timestamp, only ISO8601
            "timestamp" => $timestamp,

            // Left border color, in HEX
            "color" => hexdec( "3366ff" ),

            // Footer text
            "footer" => [
                "text" => "Via Tribunal de Justiça por ".$_SESSION["name"],
                "icon_url" => "https://cdn.discordapp.com/attachments/1151381245461274664/1151388885872553984/poder_judiciario_logo.png?size=375"
            ],

            // Embed image
            "image" => [
                //"url" => "https://ru.gravatar.com/userimage/28503754/1168e2bddca84fec2a63addb348c571d.jpg?size=600"
            ],

            // thumbnail
            "thumbnail" => [
                "url" => "https://cdn.discordapp.com/attachments/1151381245461274664/1151394761945657374/icon.png?size=400"
            ],

            // Author name & url
            "author" => [
                "name" => "Ordem dos Advogados",
                //"url" => "https://krasin.space/"
            ],

            // Custom fields
            "fields" => [
                // Field 1
                [
                    "name" => "Nome:",
                    "value" => $param_name,
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Passaporte:",
                    "value" => $param_passaporte,
                    "inline" => false
                ]
                // etc
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

    discordmsg($msg, $webhook); // SENDS MESSAGE TO DISCORD
?>