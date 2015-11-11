<?php
error_reporting(E_ALL ^ E_NOTICE); 
$url1 = "http://query.yahooapis.com/v1/public/yql?q=Select%20Name%2C%20Symbol%2C%20LastTradePriceOnly%2C%20Change%2C%20ChangeinPercent%2C%20PreviousClose%2C%20DaysLow%2C%20DaysHigh%2C%20Open%2C%20YearLow%2C%20YearHigh%2C%20Bid%2C%20Ask%2C%20AverageDailyVolume%2C%20OneyrTargetPrice%2C%20MarketCapitalization%2C%20Volume%2C%20Open%2C%20YearLow%20from%20yahoo.finance.quotes%20where%20symbol%3D%22".$_GET['symbol']."%22&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
$url2 = "http://feeds.finance.yahoo.com/rss/2.0/headline?s=".$_GET['symbol']."&region=US&lang=en-US";
$xml1 = simplexml_load_file($url1);
$xml2 = simplexml_load_file($url2);


$fo=$xml1->results[0]->quote[0];


header("content-Type:text/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<result>";
echo "<Name>".$fo->Name[0]."</Name>";
echo "<Symbol>".$fo->Symbol[0]."</Symbol>";
echo "<Quote>";
echo "<ChangeType>".substr($fo->Change[0],0,1)."</ChangeType>";
echo "<Change>".number_format((double)substr($fo->Change[0],1),2,".",",")."</Change>";
echo "<ChangeInPercent>".number_format((double)substr($fo->ChangeinPercent[0],1),2,".",",")."</ChangeInPercent>";
echo "<LastTradePriceOnly>".number_format((double)$fo->LastTradePriceOnly[0],2,".",",")."</LastTradePriceOnly>";
echo "<PreviousClose>".number_format((double)$fo->PreviousClose[0],2,".",",")."</PreviousClose>";
echo "<DaysLow>".number_format((double)$fo->DaysLow[0],2,".",",")."</DaysLow>";
echo "<DaysHigh>".number_format((double)$fo->DaysHigh[0],2,".",",")."</DaysHigh>";
echo "<Open>".number_format((double)$fo->Open[0],2,".",",")."</Open>";
echo "<YearLow>".number_format((double)$fo->YearLow[0],2,".",",")."</YearLow>";
echo "<YearHigh>".number_format((double)$fo->YearHigh[0],2,".",",")."</YearHigh>";
echo "<Bid>".number_format((double)$fo->Bid[0],2,".",",")."</Bid>";
echo "<Volume>".number_format((double)$fo->Volume[0],0,".",",")."</Volume>";
echo "<Ask>".number_format((double)$fo->Ask[0],2,".",",")."</Ask>";
echo "<AverageDailyVolume>".number_format((double)$fo->AverageDailyVolume[0],0,".",",")."</AverageDailyVolume>";
echo "<OneYearTargetPrice>".number_format((double)$fo->OneyrTargetPrice[0],2,".",",")."</OneYearTargetPrice>";
echo "<MarketCapitalization>".$fo->MarketCapitalization[0]."</MarketCapitalization>";
echo "</Quote>";
echo "<News>";

$news=$xml2->channel[0];
if($news)
{
foreach($news->children() as $snews)
{
if( $snews->getName()== "item")
{
$a=$snews->title[0];
$b=$snews->link[0];
echo "<Item>";
echo "<Title>".str_replace("&","&amp;",$a)."</Title>";
echo "<Link>".str_replace("&","&amp;",$b)."</Link>";
echo "</Item>";
}
}
}
echo "</News>";

echo "<StockChartImageURL>";
echo "http://chart.finance.yahoo.com/t?s=".$_GET['symbol']."&amp;lang=en-US&amp;width=300&amp;height=180";
echo "</StockChartImageURL>";
echo "</result>";


?>