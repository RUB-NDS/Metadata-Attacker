<?php
// Safe way to download or alternatively show the image
header("X-Download-Options: noopen");
header("Content-Disposition: attachment; filename=".time().".jpg");
header("Content-type: image/jpeg");

// Be sure that there will be always shown a new image
header("Cache-Control: no-store,no-cache,max-age=0,must-revalidate");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Pragma: no-cache");

// Load malicious code for XSS tests
$html5sec = file_get_contents("html5sec.txt", "r");
$xsscheatsheet = file_get_contents("xsscheatsheet.txt", "r");

// Payloads
$pBig = $html5sec.$xsscheatsheet;
$pTiny = $_POST['tiny-payload'];

// Generate variables with payloads
(!isset($_POST['IPTC004']) || $_POST['IPTC004'] === '0') ? $IPTC004 = $pTiny : $IPTC004 = $pBig;
(!isset($_POST['IPTC005']) || $_POST['IPTC005'] === '0') ? $IPTC005 = $pTiny : $IPTC005 = $pBig;
(!isset($_POST['IPTC007']) || $_POST['IPTC007'] === '0') ? $IPTC007 = $pTiny : $IPTC007 = $pBig;
(!isset($_POST['IPTC010']) || $_POST['IPTC010'] === '0') ? $IPTC010 = $pTiny : $IPTC010 = $pBig;
(!isset($_POST['IPTC012']) || $_POST['IPTC012'] === '0') ? $IPTC012 = $pTiny : $IPTC012 = $pBig;
(!isset($_POST['IPTC015']) || $_POST['IPTC015'] === '0') ? $IPTC015 = $pTiny : $IPTC015 = $pBig;
(!isset($_POST['IPTC020']) || $_POST['IPTC020'] === '0') ? $IPTC020 = $pTiny : $IPTC020 = $pBig;
(!isset($_POST['IPTC022']) || $_POST['IPTC022'] === '0') ? $IPTC022 = $pTiny : $IPTC022 = $pBig;
(!isset($_POST['IPTC025']) || $_POST['IPTC025'] === '0') ? $IPTC025 = $pTiny : $IPTC025 = $pBig;
(!isset($_POST['IPTC030']) || $_POST['IPTC030'] === '0') ? $IPTC030 = $pTiny : $IPTC030 = $pBig;
(!isset($_POST['IPTC035']) || $_POST['IPTC035'] === '0') ? $IPTC035 = $pTiny : $IPTC035 = $pBig;
(!isset($_POST['IPTC040']) || $_POST['IPTC040'] === '0') ? $IPTC040 = $pTiny : $IPTC040 = $pBig;
(!isset($_POST['IPTC045']) || $_POST['IPTC045'] === '0') ? $IPTC045 = $pTiny : $IPTC045 = $pBig;
(!isset($_POST['IPTC047']) || $_POST['IPTC047'] === '0') ? $IPTC047 = $pTiny : $IPTC047 = $pBig;
(!isset($_POST['IPTC050']) || $_POST['IPTC050'] === '0') ? $IPTC050 = $pTiny : $IPTC050 = $pBig;
(!isset($_POST['IPTC055']) || $_POST['IPTC055'] === '0') ? $IPTC055 = $pTiny : $IPTC055 = $pBig;
(!isset($_POST['IPTC060']) || $_POST['IPTC060'] === '0') ? $IPTC060 = $pTiny : $IPTC060 = $pBig;
(!isset($_POST['IPTC065']) || $_POST['IPTC065'] === '0') ? $IPTC065 = $pTiny : $IPTC065 = $pBig;
(!isset($_POST['IPTC070']) || $_POST['IPTC070'] === '0') ? $IPTC070 = $pTiny : $IPTC070 = $pBig;
(!isset($_POST['IPTC075']) || $_POST['IPTC075'] === '0') ? $IPTC075 = $pTiny : $IPTC075 = $pBig;
(!isset($_POST['IPTC080']) || $_POST['IPTC080'] === '0') ? $IPTC080 = $pTiny : $IPTC080 = $pBig;
(!isset($_POST['IPTC085']) || $_POST['IPTC085'] === '0') ? $IPTC085 = $pTiny : $IPTC085 = $pBig;
(!isset($_POST['IPTC090']) || $_POST['IPTC090'] === '0') ? $IPTC090 = $pTiny : $IPTC090 = $pBig;
(!isset($_POST['IPTC092']) || $_POST['IPTC092'] === '0') ? $IPTC092 = $pTiny : $IPTC092 = $pBig;
(!isset($_POST['IPTC095']) || $_POST['IPTC095'] === '0') ? $IPTC095 = $pTiny : $IPTC095 = $pBig;
(!isset($_POST['IPTC100']) || $_POST['IPTC100'] === '0') ? $IPTC100 = $pTiny : $IPTC100 = $pBig;
(!isset($_POST['IPTC101']) || $_POST['IPTC101'] === '0') ? $IPTC101 = $pTiny : $IPTC101 = $pBig;
(!isset($_POST['IPTC103']) || $_POST['IPTC103'] === '0') ? $IPTC103 = $pTiny : $IPTC103 = $pBig;
(!isset($_POST['IPTC105']) || $_POST['IPTC105'] === '0') ? $IPTC105 = $pTiny : $IPTC105 = $pBig;
(!isset($_POST['IPTC110']) || $_POST['IPTC110'] === '0') ? $IPTC110 = $pTiny : $IPTC110 = $pBig;
(!isset($_POST['IPTC115']) || $_POST['IPTC115'] === '0') ? $IPTC115 = $pTiny : $IPTC115 = $pBig;
(!isset($_POST['IPTC116']) || $_POST['IPTC116'] === '0') ? $IPTC116 = $pTiny : $IPTC116 = $pBig;
(!isset($_POST['IPTC118']) || $_POST['IPTC118'] === '0') ? $IPTC118 = $pTiny : $IPTC118 = $pBig;
(!isset($_POST['IPTC120']) || $_POST['IPTC120'] === '0') ? $IPTC120 = $pTiny : $IPTC120 = $pBig;
(!isset($_POST['IPTC121']) || $_POST['IPTC121'] === '0') ? $IPTC121 = $pTiny : $IPTC121 = $pBig;
(!isset($_POST['IPTC122']) || $_POST['IPTC122'] === '0') ? $IPTC122 = $pTiny : $IPTC122 = $pBig;

// iptc_make_tag() function by Thies C. Arntzen
function iptc_make_tag($rec, $data, $value) {
    $length = strlen($value);
    $retval = chr(0x1C).chr($rec).chr($data);
    if($length < 0x8000) {
        $retval .= chr($length >> 8).chr($length & 0xFF);
    } else {
        $retval .= chr(0x80).
                   chr(0x04).
                   chr(($length >> 24) & 0xFF).
                   chr(($length >> 16) & 0xFF).
                   chr(($length >> 8) & 0xFF).
                   chr($length & 0xFF);
    }
    return $retval . $value;
}

// Path to a jpeg file without IPTC data
$path = './test.jpg';

// Check if the source image has IPTC metadata
$image = getimagesize($path, $info);
if(isset($info['APP13'])) {
    die('Error: Source image has IPTC metadata.');
}

// Set the IPTC tags
$iptc = array(
    '2#004' => "IPTC 004: ".$IPTC004, // IPTC_OBJECT_ATTRIBUTE_REFERENCE
    '2#005' => "IPTC 005: ".$IPTC005, // IPTC_OBJECT_NAME
    '2#007' => "IPTC 007: ".$IPTC007, // IPTC_EDIT_STATUS
    '2#010' => "IPTC 010: ".$IPTC010, // IPTC_PRIORITY
    '2#012' => "IPTC 012: ".$IPTC012, // IPTC_SUBJECT_REFERENCE
    '2#015' => "IPTC 015: ".$IPTC015, // IPTC_CATEGORY
    '2#020' => "IPTC 020: ".$IPTC020, // IPTC_SUPPLEMENTAL_CATEGORY
    '2#022' => "IPTC 022: ".$IPTC022, // IPTC_FIXTURE_IDENTIFIER
    '2#025' => "IPTC 025: ".$IPTC025, // IPTC_KEYWORDS
    '2#030' => "IPTC 030: ".$IPTC030, // IPTC_RELEASE_DATE
    '2#035' => "IPTC 035: ".$IPTC035, // IPTC_RELEASE_TIME
    '2#040' => "IPTC 040: ".$IPTC040, // IPTC_SPECIAL_INSTRUCTIONS
    '2#045' => "IPTC 045: ".$IPTC045, // IPTC_REFERENCE_SERVICE
    '2#047' => "IPTC 047: ".$IPTC047, // IPTC_REFERENCE_DATE
    '2#050' => "IPTC 050: ".$IPTC050, // IPTC_REFERENCE_NUMBER
    '2#055' => "IPTC 055: ".$IPTC055, // IPTC_CREATED_DATE
    '2#060' => "IPTC 060: ".$IPTC060, // IPTC_CREATED_TIME
    '2#065' => "IPTC 065: ".$IPTC065, // IPTC_ORIGINATING_PROGRAM
    '2#070' => "IPTC 070: ".$IPTC070, // IPTC_PROGRAM_VERSION
    '2#075' => "IPTC 075: ".$IPTC075, // IPTC_OBJECT_CYCLE
    '2#080' => "IPTC 080: ".$IPTC080, // IPTC_BYLINE
    '2#085' => "IPTC 085: ".$IPTC085, // IPTC_BYLINE_TITLE
    '2#090' => "IPTC 090: ".$IPTC090, // IPTC_CITY
    '2#092' => "IPTC 092: ".$IPTC092, // IPTC_SUBLOCATION
    '2#095' => "IPTC 095: ".$IPTC095, // IPTC_PROVINCE_STATE
    '2#100' => "IPTC 100: ".$IPTC100, // IPTC_COUNTRY_CODE
    '2#101' => "IPTC 101: ".$IPTC101, // IPTC_COUNTRY
    '2#103' => "IPTC 103: ".$IPTC103, // IPTC_ORIGINAL_TRANSMISSION_REFERENCE
    '2#105' => "IPTC 105: ".$IPTC105, // IPTC_HEADLINE
    '2#110' => "IPTC 110: ".$IPTC110, // IPTC_CREDIT
    '2#115' => "IPTC 115: ".$IPTC115, // IPTC_SOURCE
    '2#116' => "IPTC 116: ".$IPTC116, // IPTC_COPYRIGHT_NOTICE
    '2#118' => "IPTC 118: ".$IPTC118, // IPTC_CONTACT
    '2#120' => "IPTC 120: ".$IPTC120, // IPTC_CAPTION
    '2#121' => "IPTC 121: ".$IPTC121, // IPTC_LOCAL_CAPTION
    '2#122' => "IPTC 122: ".$IPTC122 // IPTC_WRITER_EDITOR
);

// Convert the IPTC tags into binary code
$data = '';
foreach($iptc as $tag => $string) {
    $tag = substr($tag, 2);
    $data .= iptc_make_tag(2, $tag, $string);
}

// Embed the IPTC data
iptcembed($data, $path, 2);
?>

