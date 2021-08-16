<?php

class Calc
{
	private $listCurrency;

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

	public function calculate($fromCurrency, $toCurrency, $amount)
	{
		$list = $this->getListCurrency();
		$result = $list[$fromCurrency][2] / $list[$toCurrency][2] * $amount;
		return [
			'success' => 1,
			'id' => 1,
			'from_currency' => $fromCurrency,
			'to_currency' => $toCurrency,
			'amount' => $amount,
			'converted' => $result,
			'date_added' => date('Y-m-d H:i:s.u')
		];
	}
}