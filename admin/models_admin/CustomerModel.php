<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    class CustomerModel {

        public function select_users($role = null) {
            $sql = "SELECT username, full_name, email, phone, password, address, image FROM users" . ($role !== null ? " WHERE role = ?" : "");

            return pdo_query($sql, $role);
        }

        public function select_all_users() {
            $sql = "SELECT * FROM users ORDER BY user_id DESC";

            return pdo_query($sql);
        }

        public function user_insert($username, $password, $full_name, $image, $email, $phone, $address, $role) {
            $sql = "INSERT INTO users(username, password, full_name, image, email, phone, address, role) VALUES(?,?,?,?,?,?,?,?)";

            pdo_execute($sql, $username, $password, $full_name, $image, $email, $phone, $address, $role);
        }


        public function get_user_admin($username) {
            $sql = "SELECT * FROM users WHERE username = ?";

            return pdo_query($sql, $username);
        }

        public function user_update($username, $full_name, $email, $phone, $address, $password) {
            $sql = "UPDATE users SET full_name = ?, email = ?, phone = ?, address = ?, password = ? WHERE username = ?";
            pdo_execute($sql, $full_name, $email, $phone, $address, $password, $username);
        }

    }

    $CustomerModel = new CustomerModel();
?>