<?php


class Excel_XML
{

    private $header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?\>
		<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
		xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
		xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
		xmlns:html=\"http://www.w3.org/TR/REC-html40\">";


    private $footer = "</Workbook>";

	private $lines = array ();

    private $worksheet_title = "Table1";

    private function addRow ($array)
    {

        // initialize all cells for this row
        $cells = "";

        // foreach key -> write value into cells
        foreach ($array as $k => $v):

            $cells .= "<Cell><Data ss:Type=\"String\">" . utf8_encode($v) . "</Data></Cell>\n"; 

        endforeach;

        // transform $cells content into one row
        $this->lines[] = "<Row>\n" . $cells . "</Row>\n";

    }

    public function addArray ($array)
    {

        // run through the array and add them into rows
        foreach ($array as $k => $v):
            $this->addRow ($v);
        endforeach;

    }

    
    public function setWorksheetTitle ($title)
    {

        // strip out special chars first
        $title = preg_replace ("/[\\\|:|\/|\?|\*|\[|\]]/", "", $title);

        // now cut it to the allowed length
        $title = substr ($title, 0, 31);

        // set title
        $this->worksheet_title = $title;

    }

    function generateXML ($filename)
    {

        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".xls\"");

        echo stripslashes ($this->header);
        echo "\n<Worksheet ss:Name=\"" . $this->worksheet_title . "\">\n<Table>\n";
        echo "<Column ss:Index=\"2\" ss:AutoFitWidth=\"0\" ss:Width=\"120\"/>\n";
        echo implode ("\n", $this->lines);
        echo "</Table>\n</Worksheet>\n";
        echo $this->footer;
    }

}
?>