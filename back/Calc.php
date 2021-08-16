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
				$this->listCurrency[] = [
					$currencyItem->NumCode,
					$currencyItem->Name
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
}