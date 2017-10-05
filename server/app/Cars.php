<?php

//include('libs/CarInfoSql.php');

class Cars
{

    protected $carSql;

    public function __construct()
    {
        $this->carSql = new CarInfoSql();
    }

    public function getCars($returnFormat, $params = false)
    {
        //var_dump($params);
        if ($params === false) {
            $result = $this->carSql->getCarMarkAndModel();
            //var_dump($this->carSql->getCarMarkAndModel());
        }

        if (is_array($params)) {
            $result = $this->carSql->getCarsInfoByParams($params);
        }
        if (is_string($params) || is_integer($params)) {
            $result = $this->carSql->getModelYearAmountColorSpeedPrice($params);
        }
        //var_dump($result);
        //var_dump($returnFormat);
        $format = 'format' . strtoupper($returnFormat);
        //var_dump($format);
        //
        if (method_exists($this, $format)) {
            $formatResult = $this->$format($result);
        } else {
            return 'unsupported format'; 
        }

        return $formatResult;

    }


    private function formatJSON($data)
    {
        return json_encode($data);
        //        var_dump(json_encode($this->carSql->getCarMarkAndModel()));
    }

    private function formatXML($data)
    {
        //        var_dump($data);
        //        $data = $this->carSql->getCarMarkAndModel();
        //        var_dump($data);
        $xml = '';
        foreach ($data as $carInfo) {
            $xml .= '<car>' . "\r\n";
            foreach ($carInfo as $key => $param) {
                $xml .= "<$key>" . $param . "</$key>" . "\r\n";
            }
            $xml .= '</car>' . "\r\n";
        }
        return $xml;
    }

    private function formatHTML($data)
    {
        //                $data = $this->carSql->getCarsInfoByParams();
        //        var_dump($data);
        $html = '<!DOCTYPE html>
            <html>
            <head></head>
            <body>
            ';
        foreach ($data as $carInfo) {
            $html .= '<div>' . "\r\n";
            foreach ($carInfo as $key => $param) {
                $html .= "<p>" . $key .': '.$param . "</p>" . "\r\n";
            }
            $html .= '</div>' . "\r\n";
        }

        $html .= '</body>
            </html>';
        var_dump($html);
        return $html;
    }

    private function formatTXT($data)
    {
        //                        $data = $this->carSql->getCarMarkAndModel();
        //        var_dump($data);
        $txt = '';
        foreach ($data as $key => $carInfo) {
            $txt .= 'car: ' . "$key\r\n";
            foreach ($carInfo as $key => $param) {
                $txt .= "$key: " . $param . "\r\n";
            }
            //            $txt .= '</div>'."\r\n";
        }

        //        var_dump($txt);
        return $txt;
    }

    //return var_dump($data) . '<br>Hello!?!?!?!? ';


}

//$c = new Cars();
//$c->formData('sa');
