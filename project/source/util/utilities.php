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
            $res = $prepared_stmt->get_result();
            $prepared_stmt->close();
            return $res;
        }

        public static function run_statement_no_params($stmt)
        {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $mysqli = new mysqli("miniproject", "root", "", "restaurant_review_data");
            $prepared_stmt = $mysqli->prepare($stmt);
            $prepared_stmt->execute();
            $res = $prepared_stmt->get_result();
            $prepared_stmt->close();
            return $res;
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

        // Returns the email error if there is one, otherwise false
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

        public static function email_exists($email)
        {
            $stmt = "SELECT email FROM user WHERE email = ?";
            $duplicate_email = Database::run_statement($stmt, [$email]);
            return $duplicate_email->num_rows > 0;
        }

        public static function verify_user($email, $password)
        {
            $stmt = "SELECT encrypted_password FROM user WHERE email = ?";
            $user_password = Database::run_statement($stmt, [$email]);
            if (!$user_password) {
                return false;
            }
            $encrypted_password = $user_password->fetch_row()[0];
            return password_verify($password, $encrypted_password);
        }
    }
?>