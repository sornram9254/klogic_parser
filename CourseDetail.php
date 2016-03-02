<form method="GET" action="CourseDetail.php">
   <!-- SEARCH -------->
   <div class="form-group input-group" style="width:300px">
       <input type="text" name="courseID" placeholder="กรุณากรอกข้อมูล">
       <input type="submit">
   </div>
   <!-- SEARCH -------->
</form>
<?php
    isset($_REQUEST['courseID']) ? $courseID = $_REQUEST['courseID'] : $courseID = '?';
    // init
    error_reporting(E_ERROR | E_PARSE);
    header('Content-Type: text/html; charset=utf-8');
    //$curr_code = $_GET['curr_code'];
    $curr_code = $courseID;
    $xml_string = "http://klogic.kmutnb.ac.th:8080/kris/curri/showXML.jsp?currCode=" . $curr_code;
    $xmldata = @file_get_contents($xml_string);
    $xml = simplexml_load_string($xmldata); //or die("กรุณากรอกหมายเลขหลักสูตร");
    $result = 'curr_code: ' . $curr_code;
    if(!$xml){
        echo "กรุณากรอกหมายเลขหลักสูตร";
        $result = 'No post data yet.';
    }
///////////////////////////////////////////////////////////////////////////////////////
    $courseArr = @array();
    $courseCount = $xml->Courses->Course;
    for($k=0;$k<count($courseCount);$k++){
        $courseNumber = $xml->Courses->Course[$k]->attributes();
        $courseNameEng = $xml->Courses->Course[$k]->NameEng;
        $courseArr[trim($courseNumber)]  = $courseNameEng ;
    }
///////////////////////////////////////////////////////////////////////////////////////
    $termCount = $xml->Plans->Plan->YearSem;
    for($i=0;$i<count($termCount);$i++){
        //===================================================
        $attr = $xml->Plans->Plan->YearSem[$i]->attributes();
        echo "<b style='color:blue;font-size:20px'>ปีที่  " . $attr['year'];
        echo " ภาคเรียนที่ " . $attr['sem'] . "</b>";
        //===================================================
        $courseCount = $xml->Plans->Plan->YearSem[$i]->Course->count();
        echo "<table class=\"table table-striped table-bordered table-hover\">";
        echo "     <thead>";
        echo "         <tr>";
        echo "             <th width=10%>ลำดับ</th>";
        echo "             <th width=20%>รหัสวิชา</th>";
        echo "             <th width=55%>ชื่อวิชา</th>";
        echo "             <th width=15%>หน่วยกิต</th>";
        echo "         </tr>";
        echo "     </thead>";
        for($j=0;$j<$courseCount;$j++){
            $courseID = $xml->Plans->Plan->YearSem[$i]->Course[$j]->Display;
            if (strpos($courseID, 'X') !== false) { // ถ้าเจอ string แสดงว่าเป็นวิชาเลือกภาษา/เลือกเสรี
                $courseID = "<font color=red>วิชาเลือกเสรี</font>";
            }
            echo "<tr>";
            echo "    <td>XXX</td>";
            echo "    <td>" . $courseID . "</td>";
            echo "    <td>" . $courseArr[trim($courseID)] . "</td>";
            echo "    <td>" . $xml->Plans->Plan->YearSem[$i]->Course[$j]->Crd;
            echo              "(" . $xml->Plans->Plan->YearSem[$i]->Course[$j]->No_Hlec . "-";
            echo              $xml->Plans->Plan->YearSem[$i]->Course[$j]->No_Hlab . ")</td>";
            echo "</tr>";
        }
            echo "</table>";
    }
?>