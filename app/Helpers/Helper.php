<?php
use Carbon\Carbon;
//use App\TB_DataBroker\data_Broker;
use app\Models\TB_DataCus\Data_Customers;

/**
 * Converts a text string to an ID Card number format text.
 *
 * @return string()
 */
if (!function_exists('calculateAge')) {
  function calculateAge($bithdayDate)
  {
    $date = new DateTime($bithdayDate);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
  }
}

if (!function_exists('formatDateShort')) {
  function formatDateShort($strDate)
  {
    return date("d/m/Y", strtotime($strDate));
  }
}

if (!function_exists('formatDateThai')) {
  function formatDateThai($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    // $strHour= date("H",strtotime($strDate));
    // $strMinute= date("i",strtotime($strDate));
    // $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
    $strMonthThai = $strMonthCut[$strMonth];

    return $strDay . " " . $strMonthThai . " " . $strYear;
  }
}

if (!function_exists('formatDateThaiMY')) {
  function formatDateThaiMY($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    // $strHour= date("H",strtotime($strDate));
    // $strMinute= date("i",strtotime($strDate));
    // $strSeconds= date("s",strtotime($strDate));
    // $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
    $strMonthThai = $strMonthCut[$strMonth];

    return $strMonthThai . " " . $strYear;
  }
}

if (!function_exists('formatDateThaiShort')) {
  function formatDateThaiShort($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    // $strHour= date("H",strtotime($strDate));
    // $strMinute= date("i",strtotime($strDate));
    // $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    // $strMonthCut = Array("","01","02","03","04","05","06","07","08","09","10","11","12");
    $strMonthThai = $strMonthCut[$strMonth];

    return $strDay . " " . $strMonthThai . " " . $strYear;
  }
}


if (!function_exists('formatDateThaiShort_monthNum')) {
  function formatDateThaiShort_monthNum($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("m", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    return $strDay . "/" . $strMonth . "/" . $strYear;
  }
}

if (!function_exists('formatDateThaiLong')) {
  function formatDateThaiLong($strDate)
  {
    $strYear = date("Y", strtotime($strDate));
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("d", strtotime($strDate));
    // $strHour= date("H",strtotime($strDate));
    // $strMinute= date("i",strtotime($strDate));
    // $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];

    return $strDay . " " . $strMonthThai . " " . $strYear;
  }
}

if (!function_exists('formatDateThaiLongPS')) {
  function formatDateThaiLongPS($strDate)
  {
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    // $strHour= date("H",strtotime($strDate));
    // $strMinute= date("i",strtotime($strDate));
    // $strSeconds= date("s",strtotime($strDate));
    $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    $strMonthThai = $strMonthCut[$strMonth];

    return  $strDay . " " . $strMonthThai . " " . $strYear;
  }
}

if (!function_exists('displayTime')) {
  function displayTime($strDateTime)
  {
    $strHour = date("H", strtotime($strDateTime));
    $strMinute = date("i", strtotime($strDateTime));
    $strSeconds = date("s", strtotime($strDateTime));
    return $strHour . ":" . $strMinute . ":" . $strSeconds;
  }
}

/**
 * เช็ควันหมดอายุบัตร
 * @return string()
 */
if (!function_exists('isCardExpired')) {
  function isCardExpired($expiryDate, $daysAhead = 30)
  {
    $expiryTimestamp = strtotime($expiryDate);

    if ($expiryTimestamp === false) {
      return false;
    }

    $currentTimestamp = strtotime(date('Y-m-d'));
    $difference = $expiryTimestamp - $currentTimestamp;

    return $difference <= ($daysAhead * 24 * 60 * 60);
  }
}
/*

/**
 * แสดงชื่อลูกค้า
 *
 * @return string()
 */
if (!function_exists('getFullName')) {
  function getFullName($Firstname_Cus, $Surname_Cus, $Prefix, $PrefixOther)
  {
    $prefix = "";
    if ($Prefix != null && $Prefix == 'อื่น ๆ') {
      $prefix = $PrefixOther;
    } else {
      $prefix = $Prefix;
    }
    return $prefix . $Firstname_Cus . "  " . $Surname_Cus;
  }
}

if (!function_exists('textFormat')) {
  function textFormat($text = '', $pattern = '', $ex = '')
  { //เลบบัตรประชาชน
    $cid = ($text == '') ? '0000000000000' : $text;
    $pattern = ($pattern == '') ? '_-____-_____-__-_' : $pattern;
    $p = explode('-', $pattern);
    $ex = ($ex == '') ? '-' : $ex;
    $first = 0;
    $last = 0;
    for ($i = 0; $i <= count($p) - 1; $i++) {
      $first = $first + $last;
      $last = strlen($p[$i]);
      $returnText[$i] = substr($cid, $first, $last);
    }

    return implode($ex, $returnText);
  }
}
// งวด , จำนวนผ่อน(เงิน/ติดลบ) , ยอดจัด
if (!function_exists('uft_Calculate_IRR')) {
  function uft_Calculate_IRR($nper, $pmt, $pv)
  {
    $fv = 0;
    $type = 0;
    $guess = 0.1;

    $rate = 0;
    $FINANCIAL_MAX_ITERATIONS = 128;
    $FINANCIAL_PRECISION = 0.0000001;

    $y = 0;
    $y0 = 0;
    $y1 = 0;
    $f = 0;
    $i = 0;
    $x0 = 0;
    $x1 = 0;

    $rate = $guess;

    if (abs($rate) < $FINANCIAL_PRECISION) {
      $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
    } else {
      $f = exp($nper * log(1 + $rate));
      $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
    }

    $y0 = $pv + $pmt * $nper + $fv;
    $y1 = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;

    $i = $x0;
    $x1 = $rate;

    while ((abs($y0 - $y1) > $FINANCIAL_PRECISION) && ($i < $FINANCIAL_MAX_ITERATIONS)) {
      $rate = ($y1 * $x0 - $y0 * $x1) / ($y1 - $y0);
      $x0 = $x1;
      $x1 = $rate;

      if (abs($rate) < $FINANCIAL_PRECISION) {
        $y = $pv * (1 + $nper * $rate) + $pmt * (1 + $rate * $type) * $nper + $fv;
      } else {
        $f = exp($nper * log(1 + $rate));
        $y = $pv * $f + $pmt * (1 / $rate + $type) * ($f - 1) + $fv;
      }

      $y0 = $y1;
      $y1 = $y;
      $i = $i + 1;
    }
    return $rate * 100;
  }
}

if (!function_exists('uft_Payment')) {
  function uft_Payment($Rate, $Periods, $Present, $Future, $Type)
  {
    $Type = 0;
    $Future = 0;
    $Result = 0;
    $Term = 0;

    if ($Rate == 0) {
      $Result = ($Present + $Future) / $Periods;
    } else {
      $term = pow(1 + $Rate, $Periods);

      if ($Type == 1) {
        $Result = ($Future * $Rate / ($term - 1) + $Present * $Rate / (1 - 1 / $term)) / (1 + $Rate);
      } else {
        $Result = $Future * $Rate / ($term - 1) + $Present * $Rate / (1 - 1 / $term);
      }
    }

    return -$Result;
  }
}

if (!function_exists('GetAssetDetailsValueName')) {
  function GetAssetDetailsValueName($data_form, $assetDetails_what, $value)
  {
    // Validate input values
    $valid = array_column($data_form['AssetDetails'][$assetDetails_what], 0);
    if (!is_string($value) || !in_array($value, $valid)) {
      return "- ไม่พบข้อมูล -";
    }
    // Create lookup arrays
    $details_lookup = array_column($data_form['AssetDetails'][$assetDetails_what], 1, 0);
    // Look up the values of $insurance_state and $insurance_class
    $details_value_name = $details_lookup[$value] ?? '';
    // Return an array of the insurance state and class names
    return $details_value_name;
  }
}

if (!function_exists('Paydue_LDATE')) {
  function Paydue_LDATE($fdate, $Timelack)
  {
    $srtDay = substr($fdate, 8, 2);
    $month = date('Y-m', strtotime('+ ' . $Timelack - 1 . ' month', strtotime($fdate) ));


    $date = $srtDay;
                
        // $currentDay = intval($srtDay);
        // switch (true) {
        //     case ($currentDay > 15):
        //          $date = '01';
        //         break;
        //     case ($currentDay > 10):
        //          $date = '15';
        //         break;
        //     case ($currentDay > 5):
        //          $date = '10';
        //         break;
        //     default:
        //          $date = '05';
        //         break;
        // }
    // if ($srtDay <= 10) {
    //   $date = 10;
    // } elseif ($srtDay > 10 and $srtDay <= 20) {
    //   $date = 20;
    // } else {
    //   if (substr($month, 5, 2) == '02') {
    //     $date = 28;
    //   } else {
    //     $date = 30;
    //   }
    // }

    $ldate = $month . '-' . $date;
    return $ldate;
  }
}

if (!function_exists('cardIDFrom')) {
  function cardIDFrom($tax_id)
  {
    // $tax_id = "086994445524";
    $textBox = "";
    $pattern = '_-____-_____-__-_';
    $p = explode('-', $pattern);
    $first = 0;
    $last = 0;
    $text = array();
    for ($pt = 0; $pt < count($p); $pt++) {
      $first = $first + $last;
      $last = strlen($p[$pt]);
      $str = substr($tax_id, $first, $last);
      $textIn = "";
      for ($i = 0; $i < strlen($str); $i++) {
        $textIn .= '<div class="border_black">' . $str[$i] . '</div>';
      }
      $text[$pt] = $textIn;
    }
    return $text[0] . '-' . $text[1] . '-' . $text[2] . '-' . $text[3] . '-' . $text[4];
  }
}

if (!function_exists('formatPhone')) {
  function formatPhone($input)
  {
    $output = substr($input, -11, -8) . "-" . substr($input, -8, -4) . "-" . substr($input, -4);
    return $output;
  }
}

function checkURL($url)
{
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

  /* Get the HTML or whatever is linked in $url. */
  $response = curl_exec($handle);

  /* Check for 404 (file not found). */
  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

  return $httpCode;
  curl_close($handle);
}
const BAHT_TEXT_NUMBERS = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
const BAHT_TEXT_UNITS = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
const BAHT_TEXT_ONE_IN_TENTH = 'เอ็ด';
const BAHT_TEXT_TWENTY = 'ยี่';
const BAHT_TEXT_INTEGER = 'ถ้วน';
const BAHT_TEXT_BAHT = 'บาท';
const BAHT_TEXT_SATANG = 'สตางค์';
const BAHT_TEXT_POINT = 'จุด';

function IntconvertThai($number, $include_unit = true, $display_zero = true)
{
  if (!is_numeric($number)) {
    return null;
  }

  $log = floor(log($number, 10));
  if ($log > 5) {
    $millions = floor($log / 6);
    $million_value = pow(1000000, $millions);
    $normalised_million = floor($number / $million_value);
    $rest = $number - ($normalised_million * $million_value);
    $millions_text = '';
    for ($i = 0; $i < $millions; $i++) {
      $millions_text .= BAHT_TEXT_UNITS[6];
    }
    return IntconvertThai($normalised_million, false) . $millions_text . IntconvertThai($rest, true, false);
  }

  $number_str = (string) floor($number);
  $text = '';
  $unit = 0;

  if ($display_zero && $number_str == '0') {
    $text = BAHT_TEXT_NUMBERS[0];
  } else
    for ($i = strlen($number_str) - 1; $i > -1; $i--) {
      $current_number = (int) $number_str[$i];

      $unit_text = '';
      if ($unit == 0 && $i > 0) {
        $previous_number = isset($number_str[$i - 1]) ? (int) $number_str[$i - 1] : 0;
        if ($current_number == 1 && $previous_number > 0) {
          $unit_text .= BAHT_TEXT_ONE_IN_TENTH;
        } else if ($current_number > 0) {
          $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
        }
      } else if ($unit == 1 && $current_number == 2) {
        $unit_text .= BAHT_TEXT_TWENTY;
      } else if ($current_number > 0 && ($unit != 1 || $current_number != 1)) {
        $unit_text .= BAHT_TEXT_NUMBERS[$current_number];
      }

      if ($current_number > 0) {
        $unit_text .= BAHT_TEXT_UNITS[$unit];
      }

      $text = $unit_text . $text;
      $unit++;
    }

  if ($include_unit) {
    $text .= BAHT_TEXT_BAHT;

    $satang = explode('.', number_format($number, 2, '.', ''))[1];
    $text .= $satang == 0
      ? BAHT_TEXT_INTEGER
      : IntconvertThai($satang, false) . BAHT_TEXT_SATANG;
  } else {
    $exploded = explode('.', $number);
    if (isset($exploded[1])) {
      $text .= BAHT_TEXT_POINT;
      $decimal = (string) $exploded[1];
      for ($i = 0; $i < strlen($decimal); $i++) {
        $text .= BAHT_TEXT_NUMBERS[$decimal[$i]];
      }
    }
  }

  return $text;
}

// ฟังก์ชันแปลงวันที่ จาก Human
if (!function_exists('convertDateHumanToPHP')) {
  function convertDateHumanToPHP($date)
  {
    // Convert the input dates to DateTime objects
    $dateObj = DateTime::createFromFormat('d/m/Y', $date);
    // Check if the dates are valid
    if (!$dateObj) {
      return throw new \Exception("รูปแบบวันที่ไม่ถูกต้อง กรุณาใช้รูปแบบ 'DD/MM/YYYY'");
    }
    // Format the dates as 'DD-MM-YYYY'
    $dateFormatted = $dateObj->format('Y-m-d');
    return $dateFormatted;
  }
}

if (!function_exists('convertDatePHPToHuman')) {
  function convertDatePHPToHuman($date)
  {
    // Convert the input dates to DateTime objects
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    // Check if the dates are valid
    if (!$dateObj) {
      //return throw new \Exception("รูปแบบวันที่ไม่ถูกต้อง กรุณาใช้รูปแบบ 'DD/MM/YYYY'");
      return "- ไม่สามารถแสดงวันที่ได้ -";
    }
    // Format the dates as 'DD-MM-YYYY'
    $dateFormatted = $dateObj->format('d/m/Y');
    return $dateFormatted;
  }
}

if (!function_exists('convertDateRangeHumanToPHP')) {
  function convertDateRangeHumanToPHP($startDate, $endDate)
  {
    // Convert the input dates to DateTime objects
    $startDateObj = DateTime::createFromFormat('d/m/Y', $startDate);
    $endDateObj = DateTime::createFromFormat('d/m/Y', $endDate);

    // Check if the dates are valid
    if (!$startDateObj || !$endDateObj) {
      return throw new \Exception("รูปแบบวันที่ไม่ถูกต้อง กรุณาใช้รูปแบบ 'DD/MM/YYYY'");
    }

    // Format the dates as 'DD-MM-YYYY'
    $startDateFormatted = $startDateObj->format('d-m-Y');
    $endDateFormatted = $endDateObj->format('d-m-Y');

    // Create the date range string
    $dateRange = $startDateFormatted . ' - ' . $endDateFormatted;

    return $dateRange;
  }
}

if (!function_exists('convertDateRangePHPToHuman')) {
  function convertDateRangePHPToHuman($dateRangeString)
  {
    // Split the date range string into start date and end date
    list($startDateStr, $endDateStr) = explode(' - ', $dateRangeString);

    // Create DateTime objects using the 'd-m-Y' format
    $startDate = DateTime::createFromFormat('d-m-Y', $startDateStr);
    $endDate = DateTime::createFromFormat('d-m-Y', $endDateStr);

    // Format the DateTime objects into 'Y-m-d' format
    $formattedStartDate = $startDate->format('d/m/Y');
    $formattedEndDate = $endDate->format('d/m/Y');

    // Return the formatted start and end dates as an array
    return array($formattedStartDate, $formattedEndDate);
  }
}
if (!function_exists('convertDateRangePHPToPHPOne')) {
  function convertDateRangePHPToPHPOne($dateRangeString)
  {
    // Split the date range string into start date and end date
    list($startDateStr, $endDateStr) = explode(' - ', $dateRangeString);

    // Create DateTime objects using the 'd-m-Y' format
    $startDate = DateTime::createFromFormat('d-m-Y', $startDateStr);
    $endDate = DateTime::createFromFormat('d-m-Y', $endDateStr);

    // Format the DateTime objects into 'Y-m-d' format
    $formattedStartDate = $startDate->format('Y-m-d');
    $formattedEndDate = $endDate->format('Y-m-d');

    // Return the formatted start and end dates as an array
    return array($formattedStartDate, $formattedEndDate);
  }
}

if (!function_exists('getFirstPhone')) {
  // ฟังก์ชันในการสร้างคำสั่ง SQL สำหรับดึงเบอร์โทรแรกที่ถูกคั่นด้วยเครื่องหมายจุลภาค
  function getFirstPhone($column)
  {
    return "LEFT($column, CHARINDEX(',', $column + ',') - 1)";
  }
}

if (!function_exists('getSecondPhone')) {
  // ฟังก์ชันในการสร้างคำสั่ง SQL สำหรับดึงเบอร์โทรแรกที่ถูกคั่นด้วยเครื่องหมายจุลภาค
  function getSecondPhone($column)
  {
    return "SUBSTRING($column, CHARINDEX(',', $column) + 1, CHARINDEX(',', $column + ',', CHARINDEX(',', $column) + 1) - CHARINDEX(',', $column) - 1)";
  }
}

if (!function_exists('replacePhone')) {
  // ฟังก์ชันในการสร้างคำสั่ง REPLACE หลายๆ ครั้ง
  function replacePhone($column)
  {
    return "REPLACE(REPLACE(REPLACE($column, '-', ''), '_', ''), ',', '')";
  }
}

if (!function_exists('getFirstPhone_php')) {
  // ฟังก์ชันในการสร้างคำสั่ง SQL สำหรับดึงเบอร์โทรแรกที่ถูกคั่นด้วยเครื่องหมายจุลภาค
  function getFirstPhone_php($string)
  {
    // ค้นหา index ของเครื่องหมายจุลภาคแรก
    $commaIndex = strpos($string, ',');

    // ถ้าเจอเครื่องหมายจุลภาค ให้ตัดเอาตัวอักษรก่อนหน้ามันมา
    if ($commaIndex !== false) {
        return substr($string, 0, $commaIndex);
    }

    // ถ้าไม่เจอเครื่องหมายจุลภาค ให้คืนค่าสตริงทั้งหมด
    return $string;
  }
}

if (!function_exists('getSecondPhone_php')) {
  // ฟังก์ชันในการดึงเบอร์โทรลำดับที่สองที่ถูกคั่นด้วยเครื่องหมายจุลภาค
  function getSecondPhone_php($column) {
      // ค้นหา index ของเครื่องหมายจุลภาคแรก
      $firstCommaIndex = strpos($column, ',');
      
      // ถ้าเจอเครื่องหมายจุลภาคแรก
      if ($firstCommaIndex !== false) {
          // ค้นหา index ของเครื่องหมายจุลภาคถัดไป
          $secondCommaIndex = strpos($column, ',', $firstCommaIndex + 1);
          
          // ถ้าเจอเครื่องหมายจุลภาคที่สอง
          if ($secondCommaIndex !== false) {
              return substr($column, $firstCommaIndex + 1, $secondCommaIndex - $firstCommaIndex - 1);
          } else {
              // ถ้าไม่เจอเครื่องหมายจุลภาคที่สอง ให้ตัดเอาส่วนที่เหลือจากเครื่องหมายจุลภาคแรก
              return substr($column, $firstCommaIndex + 1);
          }
      }
      
      // ถ้าไม่เจอเครื่องหมายจุลภาคแรก ให้คืนค่าเป็นค่าว่าง
      return '';
  }
}

if (!function_exists('formatPhoneNumber')) {
  // ฟังก์ชันในการดึงเบอร์โทรลำดับที่สองที่ถูกคั่นด้วยเครื่องหมายจุลภาค
  function formatPhoneNumber($phoneNumber, $format = '999-9999999') {
    // ตรวจสอบว่าเบอร์โทรศัพท์มีความยาวเท่ากับ 10 ตัวหรือไม่
    if (strlen($phoneNumber) != 10) {
        return $phoneNumber;
    }

    switch ($format) {
        case '99 9999 9999':
            $part1 = substr($phoneNumber, 0, 2);
            $part2 = substr($phoneNumber, 2, 4);
            $part3 = substr($phoneNumber, 6, 4);
            return $part1 . ' ' . $part2 . ' ' . $part3;

        case '999-9999999':
            $part1 = substr($phoneNumber, 0, 3);
            $part2 = substr($phoneNumber, 3, 7);
            return $part1 . '-' . $part2;

        default:
            return $phoneNumber;
    }
  }
}

if (!function_exists('getFirstName')) {
  function getFirstName($fullName) {
    // ใช้ฟังก์ชัน strpos เพื่อตรวจสอบตำแหน่งของเว้นวรรคตัวแรก
    $spacePosition = strpos($fullName, ' ');
  
    // ตรวจสอบว่ามีเว้นวรรคหรือไม่
    if ($spacePosition !== false) {
        // ตัดข้อความออกก่อนเว้นวรรคตัวแรก
        return substr($fullName, 0, $spacePosition);
    }
  
    // คืนค่าชื่อเต็มหากไม่มีเว้นวรรค
    return $fullName;
  }  
}



  function convertUTF8($text)
  {
    $len = strlen(trim($text));
    $utf = mb_convert_encoding($len, 'Windows-1252', 'UTF-8');

    $utf8 = iconv('CP1252', 'UTF-8//IGNORE', $utf);
    $len_utf8 = strlen(trim($utf8));

    if (trim($utf8) != '' && trim($utf8) != '..' && $len_utf8 > ($len / 2)) {

      $text = $utf8;

    }

    return $text;
  }

function ParsetoDate($Date_con){
  $data = null;
if($Date_con != null){
  $data =  \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($Date_con);
}
   return $data;
 
}

// ฟังก์ชันตรวจสอบเลขบัตรประชาชน
function checkID($id) {
  if (substr($id, 0, 1) == '0') {
    return false;
  }
  if (strlen($id) != 13) {
    return false;
  }
  for ($i = 0, $sum = 0; $i < 12; $i++) {
    $sum += (floatval(substr($id, $i, 1)) * (13 - $i));
  }
  if ((11 - $sum % 11) % 10 != floatval(substr($id, 12, 1))) {
    return false;
  } else {
    return true;
  }
}