<?php
//====================================//
/**
 * For any database that uses sql
 *
 * @version 1.0
 */
class Database
{
    //====================================//
    // mysql
    public readonly ?string $pdo_dsn;
    public readonly ?string $pdo_user;
    public readonly ?string $pdo_pass;
    public readonly ?string $pdo_opts;
    // connection
    private ?PDO $conn = null;
    //====================================//
    /**
     * Create an database instance
     * 
     * @return Database
     */
    public function __construct(
        string $pdo_dsn = null,
        string $pdo_user = null,
        string $pdo_pass = null,
        string $pdo_opts = null
    ) {
        $this->pdo_dsn = $pdo_dsn;
        $this->pdo_user = $pdo_user;
        $this->pdo_pass = $pdo_pass;
        $this->pdo_opts = $pdo_opts;
    }
    //====================================//
    /**
     * Create an mysql database instance
     * 
     * @return Database
     */
    public static function createMySQL(
        string $db_host,
        int $db_port,
        string $db_name,
        string $db_user,
        string $db_pass
    ): Database {
        return new Database(
            "mysql:host={$db_host};db_name={$db_name};charset=UTF8" . (!is_null($db_port) ? ";port={$db_port}" : ""),
            $db_user,
            $db_pass
        );
    }
    /**
     * Create an oracle database instance
     * 
     * @return Database
     */
    public static function createOracle(
        string $db_host,
        int $db_port,
        string $db_name,
        string $db_user,
        string $db_pass
    ): Database {
        return new Database(
            "oci:dbname=//{$db_host}:{$db_port}/{$db_name}",
            $db_user,
            $db_pass
        );
    }
    //====================================//
    /**
     * Create a connection to database
     * 
     * @return bool
     * 
     * @throws Throwable [db_funcitonality_not_enabled]
     */
    public function connect(): bool
    {
        try {
            // check DB funcitonality enabled
            if (!class_exists('PDO')) {
                throw new CompileError("db_funcitonality_not_enabled");
            }
            // connect by type
            $this->conn = new PDO(
                $this->pdo_dsn,
                $this->pdo_user,
                $this->pdo_pass,
                $this->pdo_opts
            );
            // options
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->conn->exec("SET names utf8");
            $this->conn->exec("SET time_zone='" . self::getTimezoneOffset() . "';");
            // return
            return $this->beginTransaction();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    static private function getTimezoneOffset(string $timezone = null): string
    {
        if (empty($timezone)) $timezone = date_default_timezone_get();
        return (new DateTime('', new DateTimeZone($timezone)))->format('p');
    }
    //====================================//
    /**
     * Begin transaction
     * 
     * @return bool
     */
    public function beginTransaction(): bool
    {
        try {
            return $this->conn->beginTransaction();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Check if is in a transaction
     * 
     * @return bool
     */
    public function inTransaction(): bool
    {
        try {
            return $this->conn->inTransaction();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Rollback transaction
     * 
     * @return bool
     */
    public function rollbackTransaction(): bool
    {
        try {
            $this->conn->rollBack();
            return $this->beginTransaction();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Commit transaction
     * 
     * @return bool
     */
    public function commitTransaction(): bool
    {
        try {
            $this->conn->commit();
            return $this->beginTransaction();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    //====================================//
    /**
     * Select statement
     * 
     * @param string $table main table name
     * @param string|array $columns select columns
     * @param string $where
     * @param array $binds
     * @param string|array $joins
     * @param string|array $group_by
     * @param string|array $order_by
     * @param int $limit
     * @param int $offset
     * 
     * @return array|false
     */
    public function select(
        string $table,
        string|array $columns = "*",
        string $where = "0",
        array $binds = null,
        string|array $joins = null,
        string|array $group_by = null,
        string|array $order_by = null,
        int $limit = null,
        int $offset = null
    ): array|false {
        try {
            // check empty
            if (empty($columns)) $columns = "*";
            if (empty($joins)) $joins = "";
            // manipulate shit
            if (is_array($columns)) $columns = implode(",", $columns);
            if (is_array($joins)) $joins = implode(" ", $joins);
            if (is_array($group_by)) $group_by = implode(",", $group_by);
            if (is_array($order_by)) $order_by = implode(",", $order_by);
            // create query
            $query = "SELECT {$columns} FROM {$table} {$joins} WHERE ({$where})";
            if (!empty($group_by)) $query .= ' GROUP BY ' . $group_by;
            if (!empty($having)) $query += ' HAVING ' . $having;
            if (!empty($order_by)) $query .= ' ORDER BY ' . $order_by;
            if (!empty($limit)) $query .= ' LIMIT ' . $limit;
            if (!empty($offset)) $query .= ' OFFSET ' . $offset;
            // stmt
            $stmt = $this->conn->prepare("$query;");
            // binds
            if (!empty($binds)) {
                $i = 0;
                foreach ($binds as $i => $v) {
                    if (is_numeric($i)) $i++;
                    $stmt->bindValue($i, $v);
                }
            }
            // excute and return
            $stmt->execute();
            return $stmt->fetchall(PDO::FETCH_ASSOC);
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Select single record statement
     * 
     * @param string $table main table name
     * @param string|array $columns select columns
     * @param string $where
     * @param array $binds
     * @param string|array $joins
     * @param string|array $group_by
     * @param string|array $order_by
     * @param int $limit
     * @param int $offset
     * 
     * @return array|false
     */
    public function selectSingle(
        string $table,
        string|array $columns = "*",
        string $where = "0",
        array $binds = null,
        string|array $joins = null,
        string|array $group_by = null,
        string|array $order_by = null,
        int $limit = null,
        int $offset = null
    ): array|false {
        try {
            $rows = $this->select(
                table: $table,
                columns: $columns,
                where: $where,
                binds: $binds,
                joins: $joins,
                group_by: $group_by,
                order_by: $order_by,
                limit: $limit,
                offset: $offset
            );
            if (count($rows) > 1) throw new RangeException("select_not_unique");
            return $rows[0];
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Insert statement
     * 
     * @param string $table
     * @param array $data if value is !! its put as is '!!NOW()'
     * @param bool $duplicate_update
     * @param bool $ignore_null
     * 
     * @return int|false
     * int: last insert id
     */
    public function insert(
        string $table,
        array $data,
        bool $duplicate_update = false,
        bool $ignore_null = false
    ): int|false {
        try {
            // process
            $binds = [];
            $cols = [];
            $vals = [];
            foreach ($data as $k => $v) {
                if ($ignore_null == false || ($ignore_null == true && !is_null($v))) {
                    array_push($cols, "`$k`");
                    if (strpos($v, "!!") == 0) {
                        array_push($vals, ltrim($v, '!!'));
                    } else {
                        array_push($vals, "?");
                        $binds[] = $v;
                    }
                }
            }
            // manipulate shit
            $columns = implode(",", $cols);
            $values = implode(",", $vals);
            // create query
            $query = "INSERT INTO `{$table}` ({$columns}) VALUES ({$values})";
            // on update
            if ($duplicate_update) {
                $query .= " ON DUPLICATE KEY UPDATE ";
                $update = [];
                foreach ($cols as $i => $k) {
                    $update[] = "$k=" . $vals[$i];
                }
                $binds = [...$binds, ...$binds];
                $query .= implode(", ", $update);
            }
            // stmt
            $stmt = $this->conn->prepare("$query;");
            // binds
            if (!empty($binds)) {
                $i = 0;
                foreach ($binds as $i => $v) {
                    if (is_numeric($i)) $i++;
                    $stmt->bindValue($i, $v);
                }
            }
            // excute and return
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Update statement
     * 
     * @param string $table
     * @param array $data if value is !! its put as is '!!NOW()'
     * @param string $where
     * @param array $binds
     * @param bool $ignore_null
     * 
     * @return int|false
     * int: affected rows
     */
    public function update(
        string $table,
        array $data,
        string $where = "0",
        array $binds = null,
        bool $ignore_null = false
    ): int|false {
        try {
            // process
            $binds = [];
            $cols = [];
            foreach ($data as $k => $v) {
                if ($ignore_null == false || ($ignore_null == true && !is_null($v))) {
                    if (strpos($v, "!!") == 0) {
                        $val = ltrim($v, '!!');
                    } else {
                        $val = "?";
                        $binds[] = $v;
                    }
                    $cols[] = "`$k`=$val";
                }
            }
            // manipulate shit
            $columns = implode(",", $cols);
            // create query
            $query = "Update `{$table}` SET {$columns} WHERE ({$where})";
            // stmt
            $stmt = $this->conn->prepare("$query;");
            // binds
            if (!empty($binds)) {
                $i = 0;
                foreach ($binds as $i => $v) {
                    if (is_numeric($i)) $i++;
                    $stmt->bindValue($i, $v);
                }
            }
            // excute and return
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Update statement, but check if records exist first
     * 
     * @param string $table
     * @param array $data if value is !! its put as is '!!NOW()'
     * @param string $where
     * @param array $binds
     * @param bool $ignore_null
     * 
     * @return int|false
     * int: affected rows
     */
    public function updateCheck(
        string $table,
        array $data,
        string $where = "0",
        array $binds = null,
        bool $ignore_null = false
    ): int|false {
        try {
            // select first
            $r = $this->select($table, "*", where: $where, binds: $binds);
            if (empty($r)) throw new RangeException("records_does_not_exist");
            return $this->update($table, $data, where: $where, binds: $binds, ignore_null: $ignore_null);
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Update statement, but check if single record exists first
     * 
     * @param string $table
     * @param array $data if value is !! its put as is '!!NOW()'
     * @param string $where
     * @param array $binds
     * @param bool $ignore_null
     * 
     * @return int|false
     * int: affected rows
     */
    public function updateCheckSingle(
        string $table,
        array $data,
        string $where = "0",
        array $binds = null,
        bool $ignore_null = false
    ): int|false {
        try {
            // select first
            $r = $this->selectSingle($table, "*", where: $where, binds: $binds);
            if (empty($r)) throw new RangeException("record_does_not_exist");
            return $this->update($table, $data, where: $where, binds: $binds, ignore_null: $ignore_null);
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Delete statement
     * 
     * @param string $table
     * @param string $where
     * @param array $binds
     * 
     * @return int|false
     * int: affected rows
     */
    public function delete(
        string $table,
        string $where = "0",
        array $binds = null
    ): int {
        try {
            // create query
            $query = "DELETE FROM {$table} WHERE ({$where})";
            // stmt
            $stmt = $this->conn->prepare("$query;");
            // binds
            if (!empty($binds)) {
                $i = 0;
                foreach ($binds as $i => $v) {
                    if (is_numeric($i)) $i++;
                    $stmt->bindValue($i, $v);
                }
            }
            // excute and return
            $stmt->execute();
            return $stmt->rowCount();
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Delete statement, but check if records exist first
     * 
     * @param string $table
     * @param string $where
     * @param array $binds
     * 
     * @return int|false
     * int: affected rows
     */
    public function deleteCheck(
        string $table,
        string $where = "0",
        array $binds = null
    ): int|false {
        try {
            // select first
            $r = $this->select($table, "*", where: $where, binds: $binds);
            if (empty($r)) throw new RangeException("records_does_not_exist");
            return $this->delete($table, where: $where, binds: $binds);
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    /**
     * Delete statement, but check if single record exists first
     * 
     * @param string $table
     * @param array $data if value is !! its put as is '!!NOW()'
     * @param string $where
     * @param array $binds
     * 
     * @return int|false
     * int: affected rows
     */
    public function deleteCheckSingle(
        string $table,
        string $where = "0",
        array $binds = null
    ): int|false {
        try {
            // select first
            $r = $this->selectSingle($table, "*", where: $where, binds: $binds);
            if (empty($r)) throw new RangeException("record_does_not_exist");
            return $this->delete($table, where: $where, binds: $binds);
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
    //====================================//
    /**
     * Execute statement
     * 
     * @param string $query
     * @param array $binds
     * @return array|false
     * array: [affected_rows, last_insert_id, results]
     */
    public function execute(string $query, array $binds = null): array|false
    {
        try {
            // stmt
            $stmt = $this->conn->prepare($query);
            // binds
            if (!empty($binds)) {
                $i = 0;
                foreach ($binds as $i => $v) {
                    if (is_numeric($i)) $i++;
                    $stmt->bindValue($i, $v);
                }
            }
            // excute and return
            $stmt->execute();
            return [
                'affected_rows' => @$stmt->rowCount(),
                'last_insert_id' => (@$this->conn->lastInsertId() ?? null),
                'results' => @$stmt->fetchall(PDO::FETCH_ASSOC),
            ];
        } catch (Throwable $t) {
            throw $t;
            return false;
        }
    }
}
