<?php

if (!($fp=fopen("list.csv","r"))){
   echo "fail to open the list file";
}
// $data=fgetcsv($fp);
$n=0;
$tablines = array();
$outlines = array();
while($data=fgetcsv($fp)){

        $obj =$data[0];
        $rra1=$data[1];
        $dec1=$data[2];
        $zlen=$data[3];
        $zsrc=$data[4];
        $zlphot=$data[5];
        $zsphot=$data[6];
        $rein=$data[7];
        $lmag=$data[8];     
        $smag=$data[9];     
        $samp=$data[10];
        $ltype=$data[11];
        $disc=$data[12];     
        $grade=$data[13];
        $sfollowup=$data[14];
        $pfollowup=$data[15];
        $ref=$data[16];     
        $comment=$data[17];

        $foo = True;

        if (($grade=="A")&&($_POST['gradea']!="ok")) {
            $foo = False; }

        if (($grade=="B")&&($_POST['gradeb']!="ok")) {
            $foo = False; }

        if (($grade=="C")&&($_POST['gradec']!="ok")) {
            $foo = False; }

        if (($ltype[0]=="G")&&($_POST['galaxy']!="ok")) {
            $foo = False; }

        if (($ltype[0]=="C")&&($_POST['group']!="ok")) {
            $foo = False; }

        if (($ltype[1]=="G")&&($_POST['gsource']!="ok")) {
            $foo = False; }

        if (($ltype[1]=="Q")&&($_POST['qsource']!="ok")) {
            $foo = False; }

        if (($_POST['selsamp']=="grades")&&((($_POST['gradec']!="ok")&&($grade==1))||(($_POST['gradeb']!="ok")&&($grade==2))||(($_POST['gradea']!="ok")&&($grade==3)))) {
            $foo = False; }

        if (($_POST['ysspecz']!="ok")&&($zsrc > 0.)) {
            $foo = False; }

        if (($_POST['nsspecz']!="ok")&&($zsrc < 0.)) {
            $foo = False; }

        if (($_POST['ylspecz']!="ok")&&($zlen > 0.)) {
            $foo = False; }

        if (($_POST['nlspecz']!="ok")&&($zlen < 0.)) {
            $foo = False; }

        if ($_POST['position']=="box") {
            $ramin=floatval($_POST['ramin']);
            $ramax=floatval($_POST['ramax']);
            $decmin=floatval($_POST['decmin']);
            $decmax=floatval($_POST['decmax']);
            if (($rra1 < $ramin)||($rra1 > $ramax)||($dec1 < $decmin)||($dec1 > $decmax)) {
                $foo = False; }
            }

        if ($_POST['position']=="radial") {
            $ra0=floatval($_POST['ra0']);
            $dec0=floatval($_POST['dec0']);
            $radius=floatval($_POST['radius']);
            /*
            $dist=pow((($rra1 - $ra0)**2 * (cos($dec0/180.*pi))**2 + ($dec1 - $dec0)**2), 0.5) * 60.;
            */
            $dist=pow(pow($rra1 - $ra0, 2) * pow(cos($dec0/180.*pi()), 2) + pow($dec1 - $dec0, 2), 0.5) * 60.;
            if ($dist > $radius) {
                $foo = False; }
            }

        if($foo==True) {

          $n++;

          $outlines[] = $data;

/////////////////////////////////////
          $ra11=intval($rra1/15.0);
          $ra12=intval(60.0*($rra1-(15.0*$ra11))/15.0);
          $ra13=60.0*($rra1-(15.0*$ra11)-(0.25*$ra12))/0.25;
      
          if($dec1>0.0){
              $dec10="+";
              $ddec1=$dec1;
          } else {
             $dec10="-";
             $ddec1=$dec1*(-1.0);
          }
          $dec11=intval($ddec1);
          $dec12=intval(60.0*($ddec1-$dec11));
          $dec13=3600.0*($ddec1-$dec11-($dec12/60.0));
      
          if(!($rra2 === '-')){
            $ra21=intval($rra2/15.0);
            $ra22=intval(60.0*($rra2-(15.0*$ra21))/15.0);
            $ra23=60.0*($rra2-(15.0*$ra21)-(0.25*$ra22))/0.25;
      
            if($dec2>0.0){
                $dec20="+";
                $ddec2=$dec2;
            } else {
                $dec20="-";
                $ddec2=$dec2*(-1.0);
            }
            $dec21=intval($ddec2);
            $dec22=intval(60.0*($ddec2-$dec21));
            $dec23=3600.0*($ddec2-$dec21-($dec22/60.0));
          }

	  $ara=$rra1*pi()/180.0;
	  $adec=$dec1*pi()/180.0;

	  $tobj=trim($obj);
	  
/////////////////////////////////////

          $tablines[] = "<tr align=\"center\">\n";

          $radecline = "";

          if ($_POST['showimg']=="ok") {
              $tablines[] = "<td style=\"max-width:130px\"><img src=\"figs/{$tobj}.png\" height=\"61\"></a></td>\n"; }

          if ($_POST['showname']=="ok") {
              $tablines[] = "<td style=\"max-width:100px\"><a href=https://hscdata.mtk.nao.ac.jp/hsc_ssp/dr2/s18a/hscMap/app/#/?_=%7B%22view%22%3A%7B%22a%22%3A${ara},%22d%22%3A${adec},%22fovy%22%3A0.00021034451944310735,%22roll%22%3A0%7D,%22sspParams%22%3A%7B%22type%22%3A%22SDSS_TRUE_COLOR%22,%22filter%22%3A%5B%22HSC-I%22,%22HSC-R%22,%22HSC-G%22%5D,%22simpleRgb%22%3A%7B%22beta%22%3A22026.465794806718,%22a%22%3A1,%22bias%22%3A0.05,%22b0%22%3A0%7D,%22sdssTrueColor%22%3A%7B%22beta%22%3A22026.465794806718,%22a%22%3A1,%22bias%22%3A0.05,%22b0%22%3A0%7D%7D%7D>HSCJ{$tobj}</a></td>\n"; }

          if ($_POST['showra']=="ok") {
              $radecline = sprintf("<td>%02d:%02d:%05.2f</td>",$ra11,$ra12,$ra13); }
          if ($_POST['showdec']=="ok") {
              $radecline .= sprintf("<td>%s%02d:%02d:%04.1f</td>",$dec10,$dec11,$dec12,$dec13); }

          if ($_POST['showzl']=="ok") {
              $radecline .= sprintf("<td><a href=http://skyserver.sdss3.org/dr12/en/tools/explore/summary.aspx?ra=%f&dec=%f>%4.3f</a></td>",$rra1,$dec1,$zlen); }

          if ($_POST['showzs']=="ok") {
              $radecline .= sprintf("<td>%4.3f</td>",$zsrc); }

          if ($_POST['showzlphot']=="ok") {
              $radecline .= sprintf("<td>%3.2f</td>",$zlphot); }

          if ($_POST['showzsphot']=="ok") {
              $radecline .= sprintf("<td>%3.2f</td>",$zsphot); }

          if ($_POST['showrein']=="ok") {
              $radecline .= sprintf("<td>%3.2f</td>",$rein); }

          if ($_POST['showlmagi']=="ok") {
              $radecline .= sprintf("<td>%3.2f</td>",$lmag); }

          if ($_POST['showsmagi']=="ok") {
              $radecline .= sprintf("<td>%3.2f</td>",$smag); }

          if ($_POST['showsample']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$samp); }

          if ($_POST['showtype']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$ltype); }

          if ($_POST['showdisc']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$disc); }

          if ($_POST['showgrade']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$grade); }

          if ($_POST['showspecf']=="ok") {
              $radecline .= sprintf("<td style=\"max-width:100px\">%s</td>",$sfollowup); }

          if ($_POST['showphotf']=="ok") {
              $radecline .= sprintf("<td style=\"max-width:100px\">%s</td>",$pfollowup); }

          if ($_POST['showref']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$ref); }

          if ($_POST['showcomment']=="ok") {
              $radecline .= sprintf("<td>%s</td>",$comment); }

          /* not sure what this was for.
          $radecline .="<td align=\"left\"></td>\n";
          */

          $tablines[] = $radecline;
          $tablines[] = "</tr>\n\n";

          }

}

if ($_POST['outfmt']=="html") {

    printf("<html> <head>");
    printf("<meta http-equiv=\"Content-Type\"");
    printf("content=\"text/html\">");
    printf("<title>Lens Candidates</title>");
    printf("</head>");
    printf("<body>");
    printf("<h3>Lens Candidates</h3>");
    printf("%d objects found<br>\n",$n);
    printf("<br>");
    printf("<table border style=\"width:2000px;\">");
    printf("<thead>\n");
    printf("<tr>\n");

    if ($_POST['showimg']=="ok") {printf("<th>Cutout</th>");}
    if ($_POST['showname']=="ok") {printf("<th>Name</th>");}
    if ($_POST['showra']=="ok") {printf("<th>RA</th>");}
    if ($_POST['showdec']=="ok") {printf("<th>Dec</th>");}
    if ($_POST['showzl']=="ok") {printf("<th>z<sub>lens</sub></th>");}
    if ($_POST['showzs']=="ok") {printf("<th>z<sub>source</sub></th>");}
    if ($_POST['showzlphot']=="ok") {printf("<th>z<sub>l,phot</sub></th>");}
    if ($_POST['showzsphot']=="ok") {printf("<th>z<sub>s,phot</sub></th>");}
    if ($_POST['showrein']=="ok") {printf("<th style=\"max-width:40px\">R<sub>Ein</sub> (arcsec)</th>");}
    if ($_POST['showlmagi']=="ok") {printf("<th>mag<sub>lens,i</sub></th>");}
    if ($_POST['showsmagi']=="ok") {printf("<th>mag<sub>source,i</sub></th>");}
    if ($_POST['showsample']=="ok") {printf("<th>Sample</th>");}
    if ($_POST['showtype']=="ok") {printf("<th style=\"max-width:60px\">Lens type (GG: galaxy-galaxy; GQ: galaxy-quasar; CG: Cluster/group-galaxy; CQ: Cluster/group-quasar)</th>");}
    if ($_POST['showdisc']=="ok") {printf("<th style=\"max-width:60px\">Discovery (V: visual inspection; Y: YattaLens; C: Chitah; E: emission line; K: known; S: serendipitous)</th>");}
    if ($_POST['showgrade']=="ok") {printf("<th style=\"max-width:60px\">Grade (A: definite lens; B: probable lens; C: possible lens)</th>");}
    if ($_POST['showspecf']=="ok") {printf("<th style=\"max-width:100px\">Spec. follow-up (P: proposed; Q: in queue; X: executed)</th>");}
    if ($_POST['showphotf']=="ok") {printf("<th style=\"max-width:100px\">Phot. follow-up</th>");}
    if ($_POST['showref']=="ok") {printf("<th>Reference</th>");}
    if ($_POST['showcomment']=="ok") {printf("<th>comment</th>");}
    printf("</tr>");
    printf("</thead>");
    
    foreach ($tablines as $v) {
        printf("%s",$v);
        }
    printf("</table>");
    printf("<address>");
    printf("Alessandro Sonnenfeld (alessandro.sonnenfeld@ipmu.jp)<br>");
    printf("</address>");

    printf("</body> </html>");

    } else {

    $csvfilename="foo/iodir/query.csv";
    $outputfile=fopen($csvfilename,"w");
    $line0="#name,ra,dec,z_lens,z_source,zl_phot,zs_phot,Rein,lens_mag_i,source_mag_i,sample,type,discovery,grade,spec_followup,phot_followup,Reference,comment\n";
    fwrite($outputfile, $line0);
    foreach ($outlines as $line) {
        fputcsv($outputfile,$line);
        }
    fclose($outputfile);
    fclose($fp);

    // Process download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($csvfilename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($csvfilename));
    flush(); // Flush system output buffer
    readfile($csvfilename);
    unlink($csvfilename);
    }

?>

