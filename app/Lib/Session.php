<?php

namespace App\Lib;

use App\Models\User;
use PDO;
use PDOException;
use SessionHandlerInterface;


/**
 *  Session Class
 */
class Session implements SessionHandlerInterface
{
    private bool|User $user = false;
    private static $dbConnection;


    public function __construct() {
        session_set_save_handler($this , true);
        session_start();
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }
    }

    public function __destruct() {
        session_write_close();

    }

    public function isLoggedIn() {
        return $this->user;
    }

    public function getUser() {
        return $this->user;
    }

    /**
     * Registers a logged-in user object
     * @param User $userObj
     * @return bool
     */
    public function login(User $userObj) : bool{
        $this->user = $userObj;
        $_SESSION['user'] = $userObj;
        return true;
    }

    /**
     * Destroys the session and logs out the user
     * @return bool
     */
    public function logout() : bool {
        $this->user = false;
        $_SESSION['user'] = [];
        session_destroy();
        return true;
    }

    /**
     * Creates a new db connection using pdo and stores it in $dbConnection
     * @param string $path
     * @param string $name
     * @return bool
     */
    public function open(string $path, string $name): bool
    {
        try {
            self::$dbConnection = new PDO("mysql:host=" . DB_HOST .
                ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not create DB connection: ", ['exception' => $e]);
            die();
        }
        if (isset(self::$dbConnection)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Closes db connection
     * @return bool
     */
    public function close(): bool
    {
       self::$dbConnection = null;
       return true;
    }

    /**
     * Retrieves data from sessions table which corresponds to param id
     * @param string $id
     * @return string|false
     */
    public function read(string $id): string|false
    {
        try {
            $sql = "SELECT data FROM `sessions` WHERE id = :id";
            $statement = self::$dbConnection->prepare($sql);
            $statement->execute(compact("id"));
            if ($statement->rowCount() == 1) {
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                return $result['data'];
            } else {
                return "";
            }
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not execute query: ", ['exception' => $e]);
            die();
        }
    }


    /**
     * Writes session data to the session table
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write(string $id, string $data): bool
    {
        try {
            $sql = "REPLACE INTO `sessions` (id,data)
                    VALUES ( :id, :data )";
            $statement = self::$dbConnection->prepare($sql);
            $result = $statement->execute(compact("id", "data"));
            return $result;
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not execute query: ", ['exception' => $e]);
            die();
        }
    }


    /**
     * Delete session data from session table by param id
     * @param string $id
     * @return bool
     */
    public function destroy(string $id): bool
    {
        try {
            $sql = "DELETE FROM `sessions` WHERE id = :id";
            $statement = self::$dbConnection->prepare($sql);
            $result = $statement->execute(compact("id"));
            return $result;
        } catch (PDOException $e) {
            Logger::getLogger()->critical("could not execute query: ", ['exception' => $e]);
            die();
        }
    }


    /**
     * Cleans up old session data from session table
     * @param int $max_lifetime
     * @return int|false
     */
    public function gc(int $max_lifetime): int|false
    {
        try {
            $sql = "DELETE FROM `sessions` WHERE DATE_ADD(last_accessed, INTERVAL $max_lifetime SECOND)<NOW()";
            $statement = self::$dbConnection->prepare($sql);
            $result = $statement->execute();
            return $result ? $statement->rowCount() : false;
        } catch (PDOException $e) {
            Logger::getLogger()->error("could not execute query: ", ['exception' => $e]);
            die();
        }
    }


}