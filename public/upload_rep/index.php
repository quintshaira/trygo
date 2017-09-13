<?php
error_reporting(0);
include_once 'lib/connection.php';
include 'lib/PHPExcel.php';

$queryDesignation=$CONN->prepare("SELECT * FROM bsc_agent_designation");
$queryDesignation->execute();
$rowDesignation = $queryDesignation->fetchAll(PDO::FETCH_ASSOC);

//echo '<pre>'; print_r($rowDesignation); exit;

if($_POST)
{
    $target_dir = "upload/";
    //$target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
    //$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $temp = explode(".", $_FILES["upload_file"]["name"]);


    $clean_name = base64_encode($temp[0]).'_'.time().'.'.$temp[1];

    if(move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_dir.$clean_name))
    {
        $file_obj_gl = $target_dir.$clean_name;  // File to read

        try {
            $inputFileType = PHPExcel_IOFactory::identify($file_obj_gl);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file_obj_gl);
        } catch(Exception $e) {
            die('Error loading file "'.pathinfo($file_obj_gl,PATHINFO_BASENAME).'": '.$e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $update_array = array();
        $temp_arr = array();
        $fileerr = 1;

        $hrdarr = array('X1','X2','reporting_director','reporting_manager','designation', 'effective_date','agent_name' ,'X4','X5','X6','X7','X8');

        echo '<pre>';
        for($row = 1; $row <= $highestRow; $row++)
        {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

            if($fileerr && $row>1)
            {
                foreach($rowData[0] as $k => $v)
                {
                    $temp_arr[$hrdarr[$k]] = trim($v);
                    if($temp_arr[$hrdarr[5]])
                    {
                        $effective_date = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($temp_arr[$hrdarr[5]]));
                    }
                }


                $agent_name         = $temp_arr['agent_name'];
                $reporting_manager  = $temp_arr['reporting_manager'];
                $reporting_director = $temp_arr['reporting_director'];
                $designation        = $temp_arr['designation'];

                $queryAgent=$CONN->prepare("SELECT
                            a.agent_id,
                            a.preffered_name,
                            a.agent_designation_id
                            FROM bsc_agent a WHERE a.preffered_name=:preffered_name");
                $queryAgent->execute(array(":preffered_name"=>$agent_name));
                $rowAgent = $queryAgent->fetch(PDO::FETCH_ASSOC);
                //echo '<pre>'; print_r($rowAgent);

                $queryAgent1=$CONN->prepare("SELECT
                            a.agent_id,
                            a.preffered_name,
                            a.agent_designation_id
                            FROM bsc_agent a WHERE a.preffered_name=:preffered_name");
                $queryAgent1->execute(array(":preffered_name"=>$reporting_manager));
                $rowAgent1 = $queryAgent1->fetch(PDO::FETCH_ASSOC);

                $queryAgent2=$CONN->prepare("SELECT
                            a.agent_id,
                            a.preffered_name,
                            a.agent_designation_id
                            FROM bsc_agent a WHERE a.preffered_name=:preffered_name");
                $queryAgent2->execute(array(":preffered_name"=>$reporting_director));
                $rowAgent2 = $queryAgent2->fetch(PDO::FETCH_ASSOC);


                foreach($rowDesignation as $k=>$v)
                {
                    if(in_array($v['agent_designation_id'],$rowAgent))
                    {
                        if($designation==$v['agent_designation_name'])
                        {
                            //$update_array['agent_id'] =  $v['agent_designation_id'];
                            $update_array['tier']     =  $v['tier'];
                            $update_array['agent_id'] =  $rowAgent['agent_id'];
                            $update_array['effective_date'] =  $effective_date;
                            if($update_array['tier']==3 || $update_array['tier']==9)
                            {
                                $update_array['tier2_supervisor'] = $rowAgent['agent_id'];
                                $update_array['tier3_supervisor'] = $rowAgent['agent_id'];

                            }elseif($update_array['tier']==2)
                            {
                                $update_array['tier2_supervisor'] = $rowAgent['agent_id'];
                                $update_array['tier3_supervisor'] = $rowAgent2['agent_id'];

                            }else
                            {
                                $update_array['tier2_supervisor'] = $rowAgent1['agent_id'];
                                $update_array['tier3_supervisor'] = $rowAgent2['agent_id'];
                            }

                        }
                    }

                }

                $queryUpdate=$CONN->prepare("UPDATE bsc_agent
         SET tier=:tier,
         tier2_supervisor=:tier2_supervisor,
         tier3_supervisor=:tier3_supervisor,
         effective_date=:effective_date
         WHERE agent_id=:agent_id");

                $queryUpdate->execute(array(":tier"=> $update_array['tier'],
                    ":tier2_supervisor"=>$update_array['tier2_supervisor'],
                    ":tier3_supervisor"=>$update_array['tier3_supervisor'],
                    ":effective_date"=>$update_array['effective_date'],
                    ":agent_id"=>$update_array['agent_id']
                ));

               /* print "<pre>"; print_r($update_array); print "</pre>";*/

            }

        }
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
                <input type="file" name="upload_file">
            </td>
            <td>
                <input type="submit" name="upload" value="upload">
            </td>
        </tr>
    </table>
</form>
