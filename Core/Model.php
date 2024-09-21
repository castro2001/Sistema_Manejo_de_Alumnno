<?php
namespace Core;

use InvalidArgumentException;
use PDO;
use PDOException;
use RuntimeException;

abstract class Model {
    // Propiedades comunes
    private $host;
    private $username;
    private $password;
    private $dbname;
    protected $pdo;
    protected $action;
    protected $table; // Nombre de la tabla
    protected $mensaje;
    protected $condition = '';
    protected $columns = ['*'];
    protected $joins = [];
    protected $limit = '';
    protected $distinct='';
    protected $orderBy='';

    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_DATABASE'];
    }

    // Métodos abstractos que las clases hijas deben implementar
    // abstract public function save($action);
    // abstract public function delete($id);
    // abstract public function find($id);
    // abstract public function all();

    // Método para conectar a la base de datos
    protected function open_connection() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname;
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            throw new RuntimeException("Error en la conexión: " . $e->getMessage());
        }
    }

    // Método para desconectar de la base de datos
    protected function close_connection() {
        $this->pdo = null;
    }

    // Ejecutar una consulta SQL
    protected function query(array $params = []) {
        try {
            $this->open_connection();
    
            // Seleccionar columnas
            $columnsString = implode(", ", $this->columns);
    
            // Construir cláusula JOIN
            $joinsString = implode(" ", $this->joins);
    
            // Construir consulta SQL
                $sql = "SELECT {$this->distinct} {$columnsString} FROM {$this->table} {$joinsString}";

            // Agregar condiciones
            if ($this->condition) {
                $sql .= " WHERE {$this->condition}";
            }
            // Agregar ORDER BY si está configurado
            if ($this->orderBy) {
                $sql .= " ORDER BY  {$this->orderBy}";
            }
            // Agregar LIMIT
            if ($this->limit) {
                $sql .= " LIMIT {$this->limit}";
            }
    
            // Preparar y ejecutar la consulta
            $stmt = $this->pdo->prepare($sql);
    
            // Vincular parámetros
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    
        } catch (PDOException $e) {
            $this->mensaje = 'Error en la consulta: ' . $e->getMessage();
            throw new RuntimeException($this->mensaje);
        } finally {
            $this->close_connection();
        }
    }
    


    protected function prepare(array $data=[], string $condition = '') {
        try {
            $this->open_connection();

            if ($this->action === 'insert') {
                $columns = implode(", ", array_keys($data));
                $placeholders = ":" . implode(", :", array_keys($data));
                $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            } elseif ($this->action === 'update') {
                $setClause = implode(", ", array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
                $query = "UPDATE {$this->table} SET {$setClause} WHERE {$this->condition}";
            } elseif ($this->action === 'delete') {
                $query = "DELETE FROM {$this->table} WHERE {$this->condition}";
            } else {
                throw new \InvalidArgumentException("Acción no establecida o desconocida");
            }

            $statement = $this->pdo->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":{$key}", $value);
            }

            $statement->execute();
            return $statement->rowCount() > 0;
        } catch (PDOException $e) {
         
             throw new RuntimeException($e->getMessage());
       
        } finally {
            $this->close_connection();
        }
    }

    //Verificar ssi ese registro ya se creo 
    public function exists($value)
    {
        try {
            $this->open_connection();
            $sql = "SELECT 1 FROM {$this->table} WHERE {$this->columns} = :value ";
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':value', $value);
            $statement->execute();
            return $statement->fetch() !== false; // Retorna true si existe, false si no
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage());
        } finally {
            $this->close_connection();
        }
    }
    public function exists2($idAlumno, $diaSemana, $horaInicio, $horaFin)
    {
        try {
            $this->open_connection();
            $sql = "SELECT count(*) FROM {$this->table} 
                    WHERE id_alumno = :idAlumno
                    AND dia_semana = :diaSemana
                    AND (
                        (hora_inicio <= :horaFin AND hora_fin >= :horaInicio)
                    )";
            
            $statement = $this->pdo->prepare($sql);
            $statement->bindParam(':idAlumno', $idAlumno);
            $statement->bindParam(':diaSemana', $diaSemana);
            $statement->bindParam(':horaInicio', $horaInicio);
            $statement->bindParam(':horaFin', $horaFin);
            
            $statement->execute();
            return $statement->fetchColumn() > 0; // Retorna true si existe al menos un registro
        } catch (\Throwable $e) {
            throw new RuntimeException($e->getMessage());
        } finally {
            $this->close_connection();
        }
    }
    
    
    

    // Establecer la acción SQL
    protected function set_action(string $action) {
        $allowed_actions = ['insert', 'update', 'delete'];
        if (!in_array($action, $allowed_actions)) {
            throw new \InvalidArgumentException("Acción desconocida: {$action}");
        }
        $this->action = $action;
    }

    // Método para establecer la condición
    public function set_condition(string $condition) {
        $this->condition = $condition;
    }

    // Método para establecer el límite
    public function set_limit(string $limit) {
        $this->limit = $limit;
    }

    public function set_distinct(bool $distinct) {
        $this->distinct = $distinct ? 'DISTINCT' : '';
    }
    
    // Método para agregar JOINs
    public function add_joins(array $joins) {
        $this->joins = $joins;
    }

    public function set_order_by(string $orderBy) {
        $this->orderBy = $orderBy;
    }
    
}
