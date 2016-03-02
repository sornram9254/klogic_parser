<?php
    //<Plan scheme="1" round="R" option="1">
    
    // init
    error_reporting(E_ERROR | E_PARSE);
    header('Content-Type: text/html; charset=utf-8');
    //$curr_code = $_GET['curr_code'];
    $curr_code = "56060214";

    $xml_string = "http://klogic.kmutnb.ac.th:8080/kris/curri/showXML.jsp?currCode=" . $curr_code;
    $xmldata = @file_get_contents($xml_string);
    #$xml = simplexml_load_string($xmldata) or die("_test_xml.php?curr_code=เลขหลักสูตร");
    $xml = simplexml_load_string($xmldata);
///////////////////////////////////////////////////////////////////////////////////////
    /*
    $courseArr = @array();
    $courseCount = $xml->Courses->Course;
    for($k=0;$k<count($courseCount);$k++){
    
        echo $xml->Courses->Course[$k]->attributes() . " - ";
        echo $xml->Courses->Course[$k]->NameEng  . " - ";
        echo $xml->Courses->Course[$k]->NameThai . " - ";
        echo $xml->Courses->Course[$k]->ShrtName . " - ";
        echo $xml->Courses->Course[$k]->DescEng  . " - ";
        echo $xml->Courses->Course[$k]->DescThai . " - ";   
        echo $xml->Courses->Course[$k]->Flag     . " - ";
        echo $xml->Courses->Course[$k]->Type     . " - ";
        echo $xml->Courses->Course[$k]->SU       . " - ";
        echo $xml->Courses->Course[$k]->Level    . " - ";
        echo $xml->Courses->Course[$k]->Crd      . " - ";
        echo $xml->Courses->Course[$k]->Crd_Lec  . " - ";
        echo $xml->Courses->Course[$k]->Crd_Lab  . " - ";
        echo $xml->Courses->Course[$k]->No_Hlec  . " - ";
        echo $xml->Courses->Course[$k]->No_Hlab  . "<br/><br/>";

        $courseNumber = $xml->Courses->Course[$k]->attributes();
        $courseNameEng = $xml->Courses->Course[$k]->NameEng;
        $courseArr[trim($courseNumber)]  = $courseNameEng ;
    }
    */
///////////////////////////////////////////////////////////////////////////////////////
//ข้อมูลรายวิชาในเทอมนั้นๆ
///////////////////////////////////////////////////////////////////////////////////////
    $attrName = $xml->Options->Option[0]->attributes()['code'];
    $attrName = $xml->Options->Option[1]->attributes()['code'];
    $attrName = $xml->Options->Option[2]->attributes()['code'];
    $attrName = $xml->Options->Option[3]->attributes()['code'];
    $attrOption = $xml->Plans->Plan[0]->attributes()['option'];//['round']
    $attrOption = $xml->Plans->Plan[1]->attributes()['option'];
    $attrOption = $xml->Plans->Plan[2]->attributes()['option'];
    $attrOption = $xml->Plans->Plan[3]->attributes()['option'];
    //echo "จำนวณแขนง " . count($xml->Options->Option)      . "<br/>";
///////////////////////////////////////////////////////////////////////////////////////
    
    for($id=0;$id<count($xml->Options->Option);$id++){
        echo "<b style='color:red;font-size:20px'>" . $xml->Options->Option[$id]->NameThai . " (" . $xml->Options->Option[$id]->NameEng . ")</b><br/>";
        $courseArr = @array();
        $courseCount = $xml->Courses->Course;
        $termCount = $xml->Plans->Plan[$id]->YearSem;
        for($k=0;$k<count($courseCount);$k++){
            $courseNumber = $xml->Courses->Course[$k]->attributes();
            $courseNameEng = $xml->Courses->Course[$k]->NameThai;
            $courseArr[trim($courseNumber)]  = $courseNameEng ;
        }
        for($i=0;$i<count($termCount);$i++){
            $attr = $xml->Plans->Plan[$id]->YearSem[$i]->attributes();
            echo "<b style='color:blue;font-size:20px'>ปีที่  " . $attr['year'];
            echo " ภาคเรียนที่ " . $attr['sem'] . "</b>";
            $courseCount = $xml->Plans->Plan[$id]->YearSem[$i]->Course->count();
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
                $courseID = $xml->Plans->Plan[$id]->YearSem[$i]->Course[$j]->Display;
                if (strpos($courseID, 'X') !== false) { // ถ้าเจอ string แสดงว่าเป็นวิชาเลือกภาษา/เลือกเสรี
                    $courseID = "<font color=red>วิชาเลือกเสรี</font>";
                }
                echo "<tr>";
                echo "    <td>XXX</td>";
                echo "    <td>" . $courseID . "</td>";
                echo "    <td>" . $courseArr[trim($courseID)] . "</td>";
                echo "    <td>" . $xml->Plans->Plan[$id]->YearSem[$i]->Course[$j]->Crd;
                echo              "(" . $xml->Plans->Plan[$id]->YearSem[$i]->Course[$j]->No_Hlec . "-";
                echo              $xml->Plans->Plan[$id]->YearSem[$i]->Course[$j]->No_Hlab . ")</td>";
                echo "</tr>";
            }
                echo "</table>";
        }
        echo "<br/><hr/><br/>";
    }
    #print_r($courseArr);
    #print $courseArr['020413104'];

///////////////////////////////////////////////////////////////////////////////////////
    //ข้อมูลหลักสูตร
    #echo $xml->Info->NameEng . "\n";    
    #echo $xml->Info->NameThai . "\n";
    #echo $xml->Info->Level . "\n";
    #echo $xml->Info->LevelText . "\n";
    #echo $xml->Info->Degree . "\n";
    #echo $xml->Info->DegreeText . "\n";
    #echo $xml->Info->Fac . "\n";
    #echo $xml->Info->FacText . "\n";
    #echo $xml->Info->Dept . "\n";
    #echo $xml->Info->DeptText . "\n";
    #echo $xml->Info->Div . "\n";
    #echo $xml->Info->DivText . "\n";
    #echo $xml->Info->BeginYear . "\n";
    #echo $xml->Info->BeginSem . "\n";
    #echo $xml->Info->CurrType . "\n";
    #echo $xml->Info->CurrTypeText . "\n";
    #echo $xml->Info->Edition . "\n";
    #echo $xml->Info->Certify . "\n";
    #echo $xml->Info->Comment;

?>
