<?php

class Cars
{

    protected $carSql;

    public function __construct()
    {
        $this->carSql = new CarInfoSql();
    }

    public function getCars($returnFormat, $params = false)
    {
        if ($params === false) {
            $result = $this->carSql->getCarMarkAndModel();
        }

        if (is_array($params)) {
            $result = $this->carSql->getCarsInfoByParams($params);
        }
        if (is_string($params) || is_integer($params)) {
            $result = $this->carSql->getModelYearAmountColorSpeedPrice($params);
        }

        $format = 'format' . strtoupper($returnFormat);

        if (method_exists($this, $format)) {
            $formatResult = $this->$format($result);
        } else {
            return 'unsupported format';
        }

        return $formatResult;

    }


    private function formatJSON($data)
    {
        header("Content-type: application/json");
        return json_encode($data);
    }

    private function formatXML($data)
    {
        header("Content-type: text/xml");
        $xml = '<?xml version="1.0" encoding="ISO-8859-1"?>
<cars>';
        foreach ($data as $carInfo) {
            $xml .= '<car>' . "\r\n";
            foreach ($carInfo as $key => $param) {
                $xml .= "<$key>" . $param . "</$key>" . "\r\n";
            }
            $xml .= '</car>' . "\r\n";
        }
        $xml .= '</cars>';

        return $xml;
    }

    private function formatHTML($data)
    {
        header("Content-type: text/html");
        $html = '<!DOCTYPE html>
            <html>
            <head></head>
            <body>
            <pre>
            ';
        foreach ($data as $carInfo) {
            $html .= '<div>' . "\r\n";
            foreach ($carInfo as $key => $param) {
                $html .= "<p>" . $key . ': ' . $param . "</p>" . "\r\n";
            }
            $html .= '</div>' . "\r\n";
        }

        $html .= '</pre></body>
            </html>';

        return $html;
    }

    private function formatTXT($data)
    {
        header("Content-type: text/plain");
        $txt = '';
        foreach ($data as $key => $carInfo) {
            $txt .= 'car: ' . "$key\r\n";
            foreach ($carInfo as $key => $param) {
                $txt .= "$key: " . $param . "\r\n";
            }
        }

        return $txt;
    }

}
