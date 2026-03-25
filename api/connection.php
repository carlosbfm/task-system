<?php
    $envPath = __DIR__ ."/../.env";

    if(!file_exists($envPath)){
        die("❌ Erro fatal: O arquivo .env não foi encontrado na pasta: " . __DIR__);
    }

    $linhas = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];

    foreach($linhas as $line){
        if(strpos(trim($line),"#") === 0) continue;
        
        if (strpos($line, '=') !== false) {
            list($chave, $valor) = explode("=", $line, 2);
            $env[trim($chave)] = trim($valor);
        }
    }

    $host = $env['DB_HOST'] ?? die("❌ Faltou o DB_HOST no .env");
    $porta = $env['DB_PORT'] ?? die("❌ Faltou o DB_PORT no .env");
    $banco = $env['DB_NAME'] ?? die("❌ Faltou o DB_NAME no .env");
    $usuario = $env['DB_USER'] ?? die("❌ Faltou o DB_USER no .env");
    $senha = $env['DB_PASS'] ?? die("❌ Faltou o DB_PASS no .env");

    try{
        $dsn = "pgsql:host=$host;port=$porta;dbname=$banco";
        $pdo = new PDO($dsn, $usuario, $senha);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo"DEU CERTO!";
    }
    catch(PDOException $e){
        die("❌ Erro de conexão com banco: " . $e->getMessage());
    }

?>