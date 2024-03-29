<?php
    function sessionClear(){
        unset($_SESSION['last_name']);
        unset($_SESSION['family_name']);
        unset($_SESSION['last_name_kana']);
        unset($_SESSION['family_name_kana']);
        unset($_SESSION['mail']);
        unset($_SESSION['password']);
        unset($_SESSION['gender']);
        unset($_SESSION['postal_code']);
        unset($_SESSION['prefecture']);
        unset($_SESSION['address_1']);
        unset($_SESSION['address_2']);
        unset($_SESSION['authority']);
    }
?>