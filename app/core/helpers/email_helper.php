<?php

if (!function_exists('checkIsValidEmail')) {
    /**
     * Email cím helyességét ellenőrző eljárás
     * A PHP beépített validálásán túl vizsgálat alá esik az e-mail címben szereplő domain helyessége is
     * @param string $email A vizsgálandó e-mail cím
     * @return bool True ha valid, false ha nem
     */
    function checkIsValidEmail($email): bool {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $email_array = explode('@', $email);
        $domain = array_pop($email_array);
        $tests = array('A', 'MX', 'NS', 'SOA', 'PTR', 'CNAME', 'AAAA', 'A6', 'SRV', 'NAPTR', 'TXT', 'ANY');
        foreach ($tests as $type) {
            if (checkdnsrr($domain, $type)) {
                return true;
            }
        }
        return false;
    }
}
