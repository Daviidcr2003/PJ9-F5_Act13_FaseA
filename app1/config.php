<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostname = htmlspecialchars($_POST['hostname']);
    $enable_secret = htmlspecialchars($_POST['enable_secret']);
    $telnet_pass = htmlspecialchars($_POST['telnet_pass']);
    $console_pass = htmlspecialchars($_POST['console_pass']);
    $banner = htmlspecialchars($_POST['banner']);
    $datetime = htmlspecialchars($_POST['datetime']);
    $vlan_ip = htmlspecialchars($_POST['vlan_ip']);
    $vlan_mask = htmlspecialchars($_POST['vlan_mask']);

    $gateway = "192.168.1.1";

    // Inici del HTML amb CSS integrat
    echo "<!DOCTYPE html>
    <html lang='ca'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Configuració Cisco 2960</title>
        <style>
            body {
                background-color: #0d1b2a;
                color: #e0e1dd;
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 20px;
            }
            h2 {
                color: #1b6ca8;
            }
            .config-container {
                background-color: #1b263b;
                border: 1px solid #415a77;
                padding: 15px;
                border-radius: 10px;
                width: 80%;
                margin: auto;
                text-align: left;
                box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.3);
            }
            pre {
                background-color: #0d1b2a;
                padding: 10px;
                border-radius: 5px;
                overflow-x: auto;
                white-space: pre-wrap;
                word-wrap: break-word;
                font-size: 14px;
                color: #00aaff;
            }
            .btn {
                margin-top: 15px;
                padding: 10px 20px;
                background-color: #1b6ca8;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            .btn:hover {
                background-color: #144a74;
            }
        </style>
    </head>
    <body>
        <h2>Configuració Generada per Cisco 2960</h2>
        <div class='config-container'>
            <pre>";
    
    // Generació de les ordres Cisco
    echo "enable\n";
    echo "configure terminal\n";
    echo "hostname $hostname\n";
    echo "enable secret $enable_secret\n";
    echo "service password-encryption\n";
    echo "banner motd # $banner #\n";

    echo "line console 0\n";
    echo "password $console_pass\n";
    echo "login\n";
    echo "exit\n";

    echo "line vty 0 4\n";
    echo "password $telnet_pass\n";
    echo "login\n";
    echo "exit\n";

    echo "clock set " . date("H:i:s d M Y", strtotime($datetime)) . "\n";

    echo "interface vlan 1\n";
    echo "ip address $vlan_ip $vlan_mask\n";
    echo "no shutdown\n";
    echo "exit\n";

    echo "interface range fastEthernet 0/1 - 24\n";
    echo "no shutdown\n";
    echo "exit\n";

    echo "ip default-gateway $gateway\n";

    echo "exit\n";
    echo "copy running-config startup-config\n";

    echo "</pre>
        </div>
        <button class='btn' onclick='window.history.back()'>Tornar</button>
    </body>
    </html>";
}
?>