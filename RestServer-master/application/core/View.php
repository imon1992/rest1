<?php
namespace application\core;
/**
 * Base class of view includes files of template
 * 	
 */

class View
{
    public function formatOutput($formatStr, $data)
    {
       $dataArr = explode('.',$formatStr);
       if(count($dataArr)> 1)
       {
        $format = $dataArr[1];
       } 
       else
       {
        $format = DEF_FORMAT;
       }

       switch($format)
       {
        case 'txt':
            $this->dataFilterToText($data);
            break;
        case 'html':
            $this->dataFilterToHtml($data);
            break;
        case 'xml':
            $this->dataFilterToXml($data);
            break;
        default:
            $this->dataFilterToJson($data);
       }
    }

    public function dataFilterToJson($data)
    {
            print_r(json_encode($data));
    }

    public function dataFilterToHtml($data)
    {
            $data = '<pre>' .  $data . '</pre>';
            print_r($data); 
    }

    public function dataFilterToXml($data)
    {
      $data = json_encode($data);
            $xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<data>
 $data
</data>
XML;
    $xml = new \SimpleXMLElement($xmlstr);
    print_r($xml->asXML());
    }

    public function dataFilterToText($data)
    {
            print_r($data);
    }

}
