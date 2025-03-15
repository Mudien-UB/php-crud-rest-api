<?php
    namespace Config;
    
    use mysqli;
    use Exception;

    class Database {
        
        private static ?mysqli $conn = null;
    
        public static function connect() {
            self::$conn = new mysqli("127.0.0.1", "root", "root", "products_crud");
            if (self::$conn->connect_error) {
                throw new Exception("Connection Failed: " . self::$conn->connect_error);
            }
            return self::$conn;
        }
    
        public static function close(): void {
            if (self::$conn !== null) {
                self::$conn->close();
                self::$conn = null;
            }
        }
    }
    