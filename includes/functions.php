    <?php
    include "includes/config.php";

    function check_identifiers($string, $type = "")
    {
        switch ($type) {
            case 'username':
                // // only characters and numbers, spaces forbidden 
                $pattern = "/^[a-zA-Z0-9]+$/";
                break;

            case 'email':
                // one @, at least 2 or 3 characters after ".", spaces forbidden
                $pattern = "/^[^\s@]+@[a-z0-9]+(\.[a-z]{2,3}){1,2}$/";
                break;

            case 'password':
                // spaces forbidden
                $pattern = "/^\S*$/";
                break;
        }

        if (!preg_match($pattern, $string)) {
            return false;
        } else {
            return true;
        }
    }

    function clean_string($string)
    {
        $string = htmlspecialchars(preg_replace('/\s/', '', $string));
        return $string;
    }

    function parse_error($error_code)
    {
        switch ($error_code) {
            case 'Wrong_identifer_or_password':
                return $error_code;
                break;

            case 'invalid_username/password':
                return $error_code;
                break;

            case 'invalid_username':
                return $error_code;
                break;

            case 'invalid_email':
                return $error_code;
                break;

            case 'invalid_password':
                return $error_code;
                break;

            case 'invalid_gender':
                return $error_code;
                break;

            case 'more_than_3_movies selected':
                return $error_code;
                break;

            case 'email_already_in_use':
                return $error_code;
                break;

            default:
                return "unknow_error";
                break;
        }
    }

    function guidv4($data = null)
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
