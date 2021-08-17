<?php

class Calc
{
	private $listCurrency;
	private $db;

	/**
	 * @param $listCurrency
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getListCurrency()
	{
		if ($this->listCurrency === null) {
			$url = 'https://www.cbr-xml-daily.ru/daily_json.js';
			$filename = __DIR__ . '/upload/' . date('Y-m-d');
			$rawList = json_decode($this->getListFromFile($filename) ?? $this->getListFromUrl($filename, $url));
			foreach ($rawList->Valute as $currencyItem) {
				$this->listCurrency[$currencyItem->NumCode] = [
					$currencyItem->NumCode,
					$currencyItem->Name,
					$currencyItem->Value
				];
			}
		}
		return $this->listCurrency;
	}

	public function getListFromFile($filename)
	{
		return !file_exists($filename) ? null : file_get_contents($filename);
	}

	public function getListFromUrl($filename, $url)
	{
		file_put_contents($filename, file_get_contents($url));
		return $this->getListFromFile($filename);
	}

	public function calculate($fromCurrency, $toCurrency, $amount, $id = 0)
	{
		$list = $this->getListCurrency();
		$course = $list[$fromCurrency][2] / $list[$toCurrency][2];
		$result = round(($course * $amount), 2);
		$saveData = [
			'from_currency' => $fromCurrency,
			'to_currency' => $toCurrency,
			'amount' => $amount,
			'course' => round($course, 2),
			'converted' => $result,
			'id' => $id
		];
		$id = $this->db->save($saveData);
		return ['id' => $id,
			'converted' => $result];
	}

	public function verifyInsert($data)
	{
		return $data->amount > 0 ? ['success' => 0,
			'message' => empty($data) ? 'пустой запрос' : 'Отрицательная сумма'
		] : null;
	}

	public function insert($fromCurrency, $toCurrency, $amount)
	{

		$result = $this->calculate($fromCurrency, $toCurrency, $amount);
		return [
			'success' => 1,
			'id' => (int)$result['id'],
			'from_currency' => $fromCurrency,
			'to_currency' => $toCurrency,
			'amount' => $amount,
			'converted' => $result['converted'],
			'date_added' => (new DateTime('NOW'))->format('Y-m-d H:i:s.u')
		];
	}

	public function update($id, $fromCurrency, $toCurrency, $amount)
	{
		$result = $this->calculate($fromCurrency, $toCurrency, $amount, $id);
		return [
			'id' => $id,
			'from_currency' => $fromCurrency,
			'to_currency' => $toCurrency,
			'converted' => $result['converted']
		];
	}

	public function delete($id)
	{
		$saveData = ['date_deleted' => (new DateTime('NOW'))->format('Y-m-d H:i:s.u'), 'id' => $id];
		if (count($this->db->select(['id'], ['date_deleted is not null', 'id =' . $id])) > 0) return false;
		$this->db->save($saveData);
	}

	public function getList()
	{
		return $this->db->select(['id', 'from_currency', 'to_currency', 'amount', 'course', 'converted', 'date_added'],['date_deleted is null']);
	}

}