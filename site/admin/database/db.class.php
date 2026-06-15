<?php

class db
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $port = '3306';
    private $dbname = 'db_pweb1_discos';

    private $table_name;
    private $conn;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->conn = $this->connect();
    }

    // conecta no banco
    private function connect()
    {
        try {
            $pdo = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=utf8",
                $this->user,
                $this->password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    // pega tudo
    public function all()
    {
        $sql = "SELECT * FROM $this->table_name";
        $st = $this->conn->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    // busca pelo id
    public function find($id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$id]);
        return $st->fetchObject();
    }

    // busca por campo
    public function findBy($campo, $valor)
    {
        $sql = "SELECT * FROM $this->table_name WHERE $campo = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$valor]);
        return $st->fetchObject();
    }

    // salva
    public function store($dados)
    {
        $campos = '';
        $marcadores = '';
        $vetorData = [];
        $sep = '';

        foreach ($dados as $campo => $valor) {
            $campos .= $sep . $campo;
            $marcadores .= $sep . '?';
            $vetorData[] = $valor;
            $sep = ',';
        }

        $sql = "INSERT INTO $this->table_name ($campos) VALUES ($marcadores)";
        $st = $this->conn->prepare($sql);
        $st->execute($vetorData);
    }

    // atualiza
    public function update($dados)
    {
        $campos = '';
        $vetorData = [];
        $sep = '';

        foreach ($dados as $campo => $valor) {
            if ($campo != 'id') {
                $campos .= $sep . "$campo = ?";
                $vetorData[] = $valor;
                $sep = ',';
            }
        }

        $vetorData[] = $dados['id'];

        $sql = "UPDATE $this->table_name SET $campos WHERE id = ?";
        $st = $this->conn->prepare($sql);
        $st->execute($vetorData);
    }

    // deleta
    public function destroy($id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        $st = $this->conn->prepare($sql);
        $st->execute([$id]);
    }

    // pesquisa
    public function search($dados)
    {
        $campo = $dados['tipo'];
        $valor = $dados['valor'];

        $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";
        $st = $this->conn->prepare($sql);
        $st->execute(["%$valor%"]);
        return $st->fetchAll(PDO::FETCH_OBJ);
    }
}
