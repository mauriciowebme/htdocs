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
    $webhook = "link do webhook"; 
    $timestamp = date("c", strtotime("now"));
    $msg = json_encode([
    // Message
    "content" => "Conteúdo em mensagem",

    // Username
    "username" => "nome do usuário que enviou mensagem",

    // Avatar URL.
    // Uncomment to use custom avatar instead of bot's pic
    //"avatar_url" => "link da imagem do perfil (preferência pegar do discord)",

    // text-to-speech
    "tts" => false,

    // file_upload
    // "file" => "",

    // Embeds Array
    "embeds" => [
        [
            // Title
            "title" => "Título da mensagem",

            // Embed Type, do not change.
            "type" => "rich",

            // Description
            "description" => "Descrição",

            // Link in title
            "url" => " ",

            // Timestamp, only ISO8601
            "timestamp" => $timestamp,

            // Left border color, in HEX
            "color" => hexdec( "3366ff" ),

            // Footer text
            "footer" => [
                "text" => "texto do footer",
                "icon_url" => "ícone pequeno do footer"
            ],

            // Embed image
            "image" => [
                "url" => " "
            ],

            // thumbnail
            //"thumbnail" => [
            //    "url" => "thumb de canto"
            //],

            // Author name & url
            "author" => [
                "name" => "autor",
                "url" => "link se houver"
            ],

            // Custom fields
            "fields" => [
                // Field 1
                [
                    "name" => "Field #1",
                    "value" => "Value #1",
                    "inline" => false
                ],
                // Field 2
                [
                    "name" => "Field #2",
                    "value" => "Value #2",
                    "inline" => true
                ]
                // etc
            ]
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

    discordmsg($msg, $webhook); // SENDS MESSAGE TO DISCORD
    echo "sent?";
?>