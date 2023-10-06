<?php

namespace App\DB\DataLayer;

use App\DB\DB;
use App\SRC\Classes\MyIterator;
use IteratorAggregate;
use PDOException;

class DataLayer implements IteratorAggregate
{
	protected $table;

	protected $timestamps = true;

	private string $class;

	private DB $DB;

	private array $data = array();

	private $columns;

	private string $where;

	private $group;

	private $order;

	private string $limit;

	private string $offset;

	private string $having;

	private string $sql = '';

	private $error;

	private array $items = array(); // colletion

	public function __construct()
	{
		$class = explode('\\', get_class($this)); // pega o nome da classe que herda

		$this->class = end($class);

		if (!$this->table) {
			$this->table = $this->studlyToSnakeCase($this->class) . 's';
		}

		$this->DB = new DB;
	}

	/**
	 * @param string $string
	 * 
	 * @return string
	 */
	public function quote(string $string): string {
		return $this->DB->getConexao()->quote($string);
	}

	// Required definition of interface IteratorAggregate
	public function getIterator(): MyIterator
	{
		return new MyIterator($this->items);
	}

	private function studlyToSnakeCase(string $string): string
	{
		return trim(strtolower(preg_replace('([A-Z])',  '_$0', $string)), '_');
	}

	public function findById(int $id): ?DataLayer
	{
		$this->resetElementesSql();

		return $this->where("id = {$id}")->get();
	}


	public function all(): ?DataLayer
	{
		$order = $this->order;

		$this->resetElementesSql();

		$this->order = $order;

		return $this->get();
	}

	public function first(): ?DataLayer
	{
		$this->resetElementesSql();

		return $this->order('id ASC')->limit(1)->get();
	}

	public function last(): ?DataLayer
	{
		$this->resetElementesSql();

		return $this->order('id DESC')->limit(1)->get();
	}

	public function offset(int $offset): ?DataLayer
	{
		$this->offset = " OFFSET {$offset}";
		return $this;
	}

	public function limit(int $limit): ?DataLayer
	{
		$this->limit = " LIMIT {$limit}";
		return $this;
	}

	public function having(string $columnHaving): ?DataLayer
	{
		$this->having = " HAVING {$columnHaving}";
		return $this;
	}

	public function order($columns): ?DataLayer
	{
		$columns = is_array($columns) ? implode(', ', $columns) : $columns;

		$this->order = " ORDER BY {$columns}";
		return $this;
	}

	public function group($columns): ?DataLayer
	{
		$columns = is_array($columns) ? implode(', ', $columns) : $columns;

		$this->group = " GROUP BY {$columns}";
		return $this;
	}

	public function where(string $terms): ?DataLayer
	{
		$this->where = " WHERE {$terms}";
		return $this;
	}

	public function andWhere(string $terms): ?DataLayer
	{
		$this->where .= " and {$terms}";
		return $this;
	}

	public function columns($columns): ?DataLayer
	{
		$this->columns = is_array($columns) ? implode(', ', $columns) : $columns;
		return $this;
	}

	public function count(): int
	{
		$bd = $this->DB->getConexao();

		$sql = $this->constructQuery();

		try {
			$stmt = $bd->prepare($sql);

			$stmt->execute();

			return $stmt->rowCount();
		} catch (\PDOException $exception) {
			$this->error = $exception;
			//print_r($this->error->errorInfo);
		}

		return 0;
	}

	private function constructQuery(): string
	{
		$columns = $this->columns ?? '*';
		$where = $this->where ?? '';
		$group = $this->group ?? '';
		$order = $this->order ?? '';
		$having = $this->having ?? '';
		$limit = $this->limit ?? '';
		$offset = $this->offset ?? '';

		return "SELECT {$columns} FROM {$this->table} {$where} {$group} {$having} {$order} {$limit} {$offset};";
	}

	public function get(): DataLayer
	{
		$bd = $this->DB->getConexao();

		$this->sql = $this->constructQuery();

		try {

			$stmt = $bd->prepare($this->sql);

			$stmt->execute();

			$this->resetElementesSql();

			$count = $stmt->rowCount();

			if ($count) {
				$datas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

				foreach ($datas as $key => $value) {
					$this->data = $value;
					$clone = clone $this;
					$clone->items = array();
					$this->items[] = $clone;
				}
			} else {
				$this->data =[];
			}
		} catch (\PDOException $exception) {
			$this->data =[];
			$this->error = $exception;
			////print_r(array_merge($this->error->errorInfo, $this->error->getTrace()[1]));
		}

		return $this;
	}

	public function save(): int
	{
		$id = 0;

		try {

			/** Update */
			if (!empty($this->data['id'])) {
				$id = $this->data['id'];
				$this->update($this->data);
			}

			/** Create */
			if (empty($this->data['id'])) {
				$id = $this->create($this->data);
				$this->data['id'] = $id;
			}

			return $id;
		} catch (\Exception $exception) {
			$this->error = $exception;
			//print_r(array_merge($this->error->errorInfo, $this->error->getTrace()[2]));
			////print_r($this->error->xdebug_message);
			return 0;
		}
	}

	public function create(array $data): ?int
	{
		$bd = $this->DB->getConexao();

		if ($this->timestamps) {
			$data["created_at"] = (new \DateTime("now"))->format("Y-m-d H:i:s");
			$data["updated_at"] = $data["created_at"];
		}

		try {
			$columns = implode(", ", array_keys($data));
			$values = ":" . implode(", :", array_keys($data));

			$this->sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

			$stmt = $bd->prepare($this->sql);
			$stmt->execute($this->filter($data));

			$id = (int) $bd->lastInsertId();

			$this->data = $data;
			$this->data['id'] = $id;

			return $id;
		} catch (\PDOException $exception) {
			$this->error = $exception;
			////print_r($this->error->errorInfo);
			return 0;
		}
	}

	public function update(array $data): ?int
	{
		$bd = $this->DB->getConexao();

		if ($this->timestamps) {
			$data["updated_at"] = (new \DateTime("now"))->format("Y-m-d H:i:s");
		}

		try {
			$dateSet = [];

			foreach ($data as $bind => $value) {
				if ($bind != 'id')
					$dateSet[] = "{$bind} = :{$bind}";
			}

			$dateSet = implode(", ", $dateSet);

			$this->sql = "UPDATE {$this->table} SET {$dateSet} WHERE id = :id";

			$stmt = $bd->prepare($this->sql);

			$stmt->execute($this->filter($data));

			$id = $stmt->rowCount() ? $data['id'] : 0;

			$this->data = $data;

			return $id;
		} catch (PDOException $exception) {
			$this->error = $exception;
			//print_r($this->error->errorInfo);
			return 0;
		}
	}

	public function delete(string $terms = ''): bool
	{
		if (!(isset($this->data['id']) and $terms)) {
			return false;
		}

		$bd = $this->DB->getConexao();

		try {

			$terms = $terms ? $terms : 'id = ' . $this->data['id'];

			$this->sql = "DELETE FROM {$this->table} WHERE {$terms}";

			$stmt = $bd->prepare($this->sql);

			$stmt->execute();

			return true;
		} catch (PDOException $exception) {
			$this->error = $exception;
			//print_r($this->error->errorInfo);
			return false;
		}
	}

	private function filter(array $data): ?array
	{
		foreach ($data as $key => &$value) {
			$value = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
		}
		return $data;
	}

	private function resetElementesSql()
	{
		$this->columns = '*';
		$this->where = '';
		$this->group = '';
		$this->order = '';
		$this->having = '';
		$this->limit = '';
		$this->offset = '';
	}

	public function showSql()
	{
		return $this->sql;
	}

	public function error()
	{
		return $this->error;
	}

	public function __set($name, $value)
	{
		//echo "Setting '$name' to '$value'\n";
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		//echo "Getting '$name'\n";
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}

		$trace = debug_backtrace();

		trigger_error(
			'Undefined property via __get(): ' . $name .
				' in ' . $trace[0]['file'] .
				' on line ' . $trace[0]['line'],
			E_USER_NOTICE
		);

		return null;
	}

	public function __isset($name)
	{
		//echo "Is '$name' set?\n";
		return isset($this->data[$name]);
	}

	public function toJson(): string
	{
		return json_encode($this->toArray());
	}

	public function toArray(): array
	{
		if (count($this->items)) {
			return array_map(function ($item) {
				return $item->toArray();
			}, $this->items);
		}

		return $this->data;
	}

	public function __toString(): string
	{
		return $this->toJson();
	}

	public function __debugInfo(): array
	{
		return $this->toArray();
	}

	public function hasResult()
	{
		return !empty($this->data);
	}
}
