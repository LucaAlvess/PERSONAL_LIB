<?php

namespace App\Lib\Models;

use Exception;
use PDO;
use App\Lib\Connection\Transaction;

/**
 * Classe que contém os métodos comuns de persistência para as classes de negócio
 */
abstract class Model
{
    /** Propriedade que armazena os atributos da classe de negócio @var array $data */
    private array $data;

    /**
     * Construtor da classe, recebe opcionalmente um id para consulta
     * e armazena na propriedade da classe
     * @param integer|null $id
     * @throws Exception
     */
    public function __construct(int $id = null)
    {
        if ($id) {
            $data = $this->searchById($id);
            if ($data) {
                $this->storeDataFromArray($data->getDataToArray());
            }
        }
    }

    /**
     * Método responsável por buscar os dados da base de dados a partir
     * de um id
     * @param integer|string $id
     * @param string $column coluna a ser retornada
     * @return mixed objeto da entidade
     * @throws Exception
     */
    public function searchById(int|string $id, string $column = '*'): mixed
    {
        $sql = "SELECT {$column} FROM {$this->getEntity()} WHERE id = :id";

        if ($conn = Transaction::get()) {
            Transaction::log($sql);

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bindValue(':id', $id);
                $stmt->execute();
                return $stmt->fetchObject(get_class($this));
            }
        } else {
            throw new Exception('Não há uma transação ativa');
        }
    }

    /**
     * Método responsável por inserir os dados na base de dados
     * @return boolean
     * @throws Exception
     */
    public function saveData(): bool
    {
        if (!isset($this->data['id']) || (!$this->searchById($this->data['id']))) {
            $sql = "INSERT INTO {$this->getEntity()} (" . implode(', ', array_keys($this->data)) . ')'
                . ' VALUES (' . implode(',', $this->prepared($this->data)) . ')';

            if ($conn = Transaction::get()) {
                Transaction::log($sql);
                $stmt = $conn->prepare($sql);

                foreach ($this->data as $column => $value) {
                    $stmt->bindValue(":$column", $value);
                }
                return $stmt->execute();
            } else {
                throw new Exception('Não há trnsação ativa');
                return false;
            }
        }
    }

    /**
     * Método responsável por atualizar os dadods da base de dados
     * @param integer|string $id
     * @return boolean
     * @throws Exception
     */
    public function updateData(): bool
    {
        if (!empty($this->data['id'] || ($this->searchById($this->data['id'])))) {
            $dataToUpdate = [];

            foreach ($this->data as $column => $value) {
                $dataToUpdate[] = "$column = :$column";
            }

            $sql = "UPDATE {$this->getEntity()} SET " . implode(', ', $dataToUpdate)
                . ' WHERE id = :id ';

            if ($conn = Transaction::get()) {
                Transaction::log($sql);

                $stmt = $conn->prepare($sql);

                foreach ($this->data as $column => $value) {
                    $stmt->bindValue(":$column", $value);
                }
                return $stmt->execute();
            }

        }
        throw new Exception('Não há transação ativa');
        return false;
    }

    /**
     * Método responsável por delete dados da base de dados
     * a partir do id
     * @param integer|string $id
     * @return bool
     * @throws Exception
     */
    public function deleteData(int|string $id): bool
    {
        $sql = "DELETE FROM {$this->getEntity()} WHERE id = :id";

        if ($this->data['id']) {
            if ($conn = Transaction::get()) {
                Transaction::log($sql);
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':id', $this->data['id']);
                return $stmt->execute();
            } else {
                throw new Exception('Não há transação ativa');
                return false;
            }
        }
    }

    /**
     * Método responsável por preparar os valores a serem inseridos com stmt
     * @param array $data
     * @return array
     */
    private function prepared(array $data): array
    {
        $arrMap = array_map(function ($item) {
            return ":{$item}";
        }, array_keys($data));

        return array_values($arrMap);
    }

    /**
     * Método responsável por armazenar os dados do formulário
     * @param array $data
     * @return void
     */
    public function storeDataFromArray(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Método responsável por retornar os dados armazenados do formulário
     * @return array
     */
    public function getDataToArray(): array
    {
        return $this->data;
    }

    /**
     * Método responsável por o nome da constante(da classe filha)
     * Contendo o nome da tabela
     * @return string
     */
    private function getEntity(): string
    {
        $class = get_class($this);
        return constant("{$class}::TABLENAME");
    }

    /**
     * @param string $props
     * @param mixed $value
     */
    public function __set(string $props, mixed $value)
    {
        if ($value == null) {
            unset($this->data[$props]);
        }
        $this->data[$props] = $value;
    }

    /**
     * @param string $props
     * @return mixed
     */
    public function __get(string $props): mixed
    {
        return isset($this->data[$props]);
    }

    public function __clone(): void
    {
        unset($this->data['id']);
    }
}