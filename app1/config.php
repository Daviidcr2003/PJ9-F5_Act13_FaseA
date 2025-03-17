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
    $vlan2_name = htmlspecialchars($_POST['vlan2_name']);
    $vlan2_start = intval($_POST['vlan2_start']);
    $vlan2_end = intval($_POST['vlan2_end']);
    
    $gateway = "192.168.1.1";

    echo "<!DOCTYPE html>";
    echo "<html lang='ca'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Configuració Cisco 2960</title>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "</head>";
    echo "<body>";
    echo "<h2>Configuració Generada per Cisco 2960</h2>";
    echo "<div class='config-container'>";
    echo "<pre>";

    // Configuració de VLAN 1
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

    // Configuració de VLAN 2
    echo "vlan 2\n";
    echo "name $vlan2_name\n";
    echo "exit\n";

    echo "interface vlan 2\n";
    echo "ip address 192.168.2.2 255.255.255.0\n";
    echo "no shutdown\n";
    echo "exit\n";

    echo "interface range fastEthernet 0/$vlan2_start - 0/$vlan2_end\n";
    echo "switchport mode access\n";
    echo "switchport access vlan 2\n";
    echo "no shutdown\n";
    echo "exit\n";

    echo "exit\n";
    echo "copy running-config startup-config\n";

    echo "</pre>";
    echo "</div>";
    echo "<button class='btn' onclick='window.history.back()'>Tornar</button>";
    echo "</body>";
    echo "</html>";
}
?>