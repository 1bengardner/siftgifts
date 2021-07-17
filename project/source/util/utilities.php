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

    abstract class Message
    {
        const EmailInvalid = "Please enter a valid e-mail address.";
        const EmailTooLong = "Your e-mail must be under 320 characters.";
        const PasswordTooLong = "Your password must be under 255 characters.";
        const NotLoggedIn = "Please log in to access this page.";
        const InvalidUser = "Incorrect e-mail or password.";
        const FieldsCannotBeEmpty = "Mandatory fields must be filled out.";
        const EmailExists = "This e-mail address is already registered with Dineline.";
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

        public static function keys_missing($keys)
        {
            if (Validation::get_missing_keys($keys)) {
                return Message::FieldsCannotBeEmpty;
            }
            return false;
        }

        // Returns the email error if there is one, otherwise false
        public static function email_login_error($email)
        {
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return Message::EmailInvalid;
            }
            // Validate email length - this is included within the FILTER_VALIDATE_EMAIL filter, but also here as secondary defense for the database
            if (strlen($email) > 320) {
                return Message::EmailTooLong;
            }
            return false;
        }

        public static function password_error($password)
        {
            if (strlen($password) > 255) {
                return Message::PasswordTooLong;
            }
            return false;
        }

        public static function email_exists($email)
        {
            $stmt = "SELECT email FROM user WHERE email = ?";
            $duplicate_email = Database::run_statement($stmt, [$email]);
            return $duplicate_email->num_rows > 0;
        }

        public static function email_registration_error($email)
        {
            if (Validation::email_exists($email)) {
                return Message::EmailExists;
            }
            return false;
        }

        public static function login_error($email, $password)
        {
            $stmt = "SELECT encrypted_password FROM user WHERE email = ?";
            $user_password = Database::run_statement($stmt, [$email]);
            if (!$user_password) {
                return false;
            }
            $encrypted_password = $user_password->fetch_row()[0];
            $res = password_verify($password, $encrypted_password);
            return $res ? $res : Message::InvalidUser;
        }
    }
?>