<?php
    class Database
    {
        public static function run_statement($stmt, $args)
        {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqli = new mysqli("miniproject", "root", "", "restaurant_review_data");
            $prepared_stmt = $mysqli->prepare($stmt);
            $prepared_stmt->bind_param(str_repeat("s", count($args)), ...$args);
            $prepared_stmt->execute();
            return $prepared_stmt;
        }
    }

    abstract class ValidationErrorMessage
    {
        const EmailInvalid = "invalid email";
        const EmailTooLong = "email must be under 320 characters";
    }
    class Validation
    {
        // Returns list of keys missing from POST
        public static function get_missing_keys($keys)
        {
            $missing_keys = [];
            foreach ($keys as $key) {
                if (empty($_POST[$key])) {
                    $missing_keys[] = $key;
                }
            }
            return $missing_keys;
        }

        public static function email_error($email)
        {
            // Validate email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                return ValidationErrorMessage::EmailInvalid;
            }
            // Validate email length
            if (strlen($_POST['email']) > 320) {
                return ValidationErrorMessage::EmailTooLong;
            }
            return false;
        }
    }
?>