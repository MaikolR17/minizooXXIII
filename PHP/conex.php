<?php 
class ConexionDB {
    public $conex;
    private $host = "sql206.infinityfree.com";
    private $usr = "if0_38870682";
    private $pass = "dEYrzydMpKXPrIT";
    private $bdatos = "if0_38870682_minizooxxiii";
    private $port = "3306";
    private $error;
    private $conectado = false;

    /**
     * Intenta conectar a la base de datos
     * @return bool true si conecta correctamente, false si falla
     */
    public function conectar() {
        $this->conex = new mysqli($this->host, $this->usr, $this->pass, $this->bdatos, $this->port);

        if ($this->conex->connect_error) {
            $this->error = "Conexión fallida: " . $this->conex->connect_error;
            $this->conectado = false;
            return false;
        }

        // Establecer el charset a UTF-8
        if (!$this->conex->set_charset("utf8")) {
            $this->error = "Error al configurar charset UTF-8: " . $this->conex->error;
            $this->conectado = false;
            return false;
        }

        $this->conectado = true;
        return true;
    }

    /**
     * Devuelve la conexión activa
     * @return mysqli|null
     */
    public function getConexion() {
        return $this->conectado ? $this->conex : null;
    }

    /**
     * Cierra la conexión si está activa
     */
    public function cerrar() {
        if ($this->conectado && $this->conex) {
            $this->conex->close();
            $this->conectado = false;
        }
    }

    /**
     * Devuelve el último error registrado
     * @return string|null
     */
    public function getError() {
        return $this->error ?? null;
    }

    /**
     * Verifica si hay una conexión activa
     * @return bool
     */
    public function estaConectado() {
        return $this->conectado;
    }
}
?>
