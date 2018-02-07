<?php
class Downloadexcel extends Zend_Db_Table
{
    public $DB;

    public function __construct()
    {
        $this->DB = Zend_Registry::get('DB');
    }


    public function get_header_params($export_id)
    {
        $arr_export_settings=array();
        //print $export_id;

        $arr_export_settings[1]['fname'] = 'For_Assignment_TODAY';

        $arr_export_settings[1]['header']['colmn']['0'] = 'sn';
        $arr_export_settings[1]['header']['title']['0'] = '#';
        $arr_export_settings[1]['header']['Width']['0'] = '10';


        $arr_export_settings[1]['header']['colmn']['1'] = 'req_gen_id';
        $arr_export_settings[1]['header']['title']['1'] = 'ID';
        $arr_export_settings[1]['header']['Width']['1'] = '12';


        $arr_export_settings[1]['header']['colmn']['2'] = 'assigned_vehicle_name';
        $arr_export_settings[1]['header']['title']['2'] = 'Vehicle';
        $arr_export_settings[1]['header']['Width']['2'] = '22';


        $arr_export_settings[1]['header']['colmn']['3'] = 'rent_from';
        $arr_export_settings[1]['header']['title']['3'] = 'Schedule';
        $arr_export_settings[1]['header']['Width']['3'] = '15';


        $arr_export_settings[1]['header']['colmn']['4'] = 'customer_name';
        $arr_export_settings[1]['header']['title']['4'] = 'Renter';
        $arr_export_settings[1]['header']['Width']['4'] = '40';

        $arr_export_settings[1]['header']['colmn']['5'] = 'driver_name';
        $arr_export_settings[1]['header']['title']['5'] = 'Driver';
        $arr_export_settings[1]['header']['Width']['5'] = '10';


        $arr_export_settings[1]['header']['colmn']['6'] = 'estimated_price';
        $arr_export_settings[1]['header']['title']['6'] = 'Total Due';
        $arr_export_settings[1]['header']['Width']['6'] = '15';






        $arr_export_settings[2]['fname'] = 'Ongoing';

        $arr_export_settings[2]['header']['colmn']['0'] = 'sn';
        $arr_export_settings[2]['header']['title']['0'] = '#';
        $arr_export_settings[2]['header']['Width']['0'] = '10';

        $arr_export_settings[2]['header']['colmn']['1'] = 'req_gen_id';
        $arr_export_settings[2]['header']['title']['1'] = 'ID';
        $arr_export_settings[2]['header']['Width']['1'] = '12';

        $arr_export_settings[2]['header']['colmn']['2'] = 'assigned_vehicle_name';
        $arr_export_settings[2]['header']['title']['2'] = 'Vehicle';
        $arr_export_settings[2]['header']['Width']['2'] = '22';

        $arr_export_settings[2]['header']['colmn']['3'] = 'customer_name';
        $arr_export_settings[2]['header']['title']['3'] = 'Renter';
        $arr_export_settings[2]['header']['Width']['3'] = '40';

        $arr_export_settings[2]['header']['colmn']['4'] = 'driver_name';
        $arr_export_settings[2]['header']['title']['4'] = 'Driver';
        $arr_export_settings[2]['header']['Width']['4'] = '10';

        $arr_export_settings[2]['header']['colmn']['5'] = 'estimated_price';
        $arr_export_settings[2]['header']['title']['5'] = 'Amount Due';
        $arr_export_settings[2]['header']['Width']['5'] = '15';

        $arr_export_settings[2]['header']['colmn']['6'] = 'additional_charges';
        $arr_export_settings[2]['header']['title']['6'] = 'Additional Charges';
        $arr_export_settings[2]['header']['Width']['6'] = '15';

        $arr_export_settings[2]['header']['colmn']['7'] = 'expenses';
        $arr_export_settings[2]['header']['title']['7'] = 'Expenses';
        $arr_export_settings[2]['header']['Width']['7'] = '15';


        $arr_export_settings[2]['header']['colmn']['8'] = 'status_name';
        $arr_export_settings[2]['header']['title']['8'] = 'Driver Status';
        $arr_export_settings[2]['header']['Width']['8'] = '15';



        /*
         <th>#</th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Vehicle');?><?php print $this->page_sorting_images['package_name']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Details');?><?php print $this->page_sorting_images['package_name']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Renter');?><?php print $this->page_sorting_images['car_type']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Driver');?><?php print $this->page_sorting_images['driver_type']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Due');?><?php print $this->page_sorting_images['package_name']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Received By');?><?php print $this->page_sorting_images['car_type']; ?></th>
                            <th><?php print $this->ob_LoginAuth->set_excel_header('Received On');?><?php print $this->page_sorting_images['car_type']; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl = 1;
                        if(count($this->TD_remitted_rows))
                        {
                            foreach($this->TD_remitted_rows as $k=>$v)
                            {
                                $idd=$k;
                                ?>
                                <tr>
                                    <td><?php print $sl; ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['assigned_vehicle_name'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['req_gen_id'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['customer_name'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['driver_name'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['estimated_price'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['nick_name'],$idd); ?></td>
                                    <td><?php print $this->ob_LoginAuth->set_excel_values($v['received_on'],$idd); ?></td>
         * */


        $arr_export_settings[3]['fname'] = 'Remitted';

        $arr_export_settings[3]['header']['colmn']['0'] = 'sn';
        $arr_export_settings[3]['header']['title']['0'] = '#';
        $arr_export_settings[3]['header']['Width']['0'] = '10';


        $arr_export_settings[3]['header']['colmn']['1'] = 'assigned_vehicle_name';
        $arr_export_settings[3]['header']['title']['1'] = 'Vehicle';
        $arr_export_settings[3]['header']['Width']['1'] = '22';

        $arr_export_settings[3]['header']['colmn']['2'] = 'req_gen_id';
        $arr_export_settings[3]['header']['title']['2'] = 'ID';
        $arr_export_settings[3]['header']['Width']['2'] = '12';

        $arr_export_settings[3]['header']['colmn']['3'] = 'customer_name';
        $arr_export_settings[3]['header']['title']['3'] = 'Renter';
        $arr_export_settings[3]['header']['Width']['3'] = '40';

        $arr_export_settings[3]['header']['colmn']['4'] = 'driver_name';
        $arr_export_settings[3]['header']['title']['4'] = 'Driver';
        $arr_export_settings[3]['header']['Width']['4'] = '10';

        $arr_export_settings[3]['header']['colmn']['5'] = 'nick_name';
        $arr_export_settings[3]['header']['title']['5'] = 'Received By';
        $arr_export_settings[3]['header']['Width']['5'] = '15';

        $arr_export_settings[3]['header']['colmn']['6'] = 'received_on';
        $arr_export_settings[3]['header']['title']['6'] = 'Received On';
        $arr_export_settings[3]['header']['Width']['6'] = '15';

        $arr_export_settings[3]['header']['colmn']['7'] = 'estimated_price';
        $arr_export_settings[3]['header']['title']['7'] = 'Due';
        $arr_export_settings[3]['header']['Width']['7'] = '15';

        $arr_export_settings[3]['header']['colmn']['8'] = 'recieved_amount';
        $arr_export_settings[3]['header']['title']['8'] = 'Remitted Amount';
        $arr_export_settings[3]['header']['Width']['8'] = '15';

        $arr_export_settings[3]['header']['colmn']['9'] = 'additional_charges';
        $arr_export_settings[3]['header']['title']['9'] = 'Additional Charges';
        $arr_export_settings[3]['header']['Width']['9'] = '15';

        $arr_export_settings[3]['header']['colmn']['10'] = 'expenses';
        $arr_export_settings[3]['header']['title']['10'] = 'Expenses';
        $arr_export_settings[3]['header']['Width']['10'] = '15';

        $arr_export_settings[3]['header']['colmn']['11'] = 'recieved_remarks';
        $arr_export_settings[3]['header']['title']['11'] = 'Remarks';
        $arr_export_settings[3]['header']['Width']['11'] = '15';



        $arr_export_settings[4]['fname'] = 'Driver_request_logs';

        $arr_export_settings[4]['header']['colmn']['0'] = 'request_id';
        $arr_export_settings[4]['header']['title']['0'] = 'Request ID';
        $arr_export_settings[4]['header']['Width']['0'] = '10';

        $arr_export_settings[4]['header']['colmn']['1'] = 'assigned_vehicle_name';
        $arr_export_settings[4]['header']['title']['1'] = 'Vehicle';
        $arr_export_settings[4]['header']['Width']['1'] = '22';

        $arr_export_settings[4]['header']['colmn']['2'] = 'customer_name';
        $arr_export_settings[4]['header']['title']['2'] = 'Customer';
        $arr_export_settings[4]['header']['Width']['2'] = '22';

        $arr_export_settings[4]['header']['colmn']['3'] = 'user_fname';
        $arr_export_settings[4]['header']['title']['3'] = 'Driver';
        $arr_export_settings[4]['header']['Width']['3'] = '22';

        $arr_export_settings[4]['header']['colmn']['4'] = 'status_name';
        $arr_export_settings[4]['header']['title']['4'] = 'Status';
        $arr_export_settings[4]['header']['Width']['4'] = '20';

        $arr_export_settings[4]['header']['colmn']['5'] = 'date_time';
        $arr_export_settings[4]['header']['title']['5'] = 'Date';
        $arr_export_settings[4]['header']['Width']['5'] = '40';


        $arr_export_settings[5]['fname'] = 'Customer_logs';

        $arr_export_settings[5]['header']['colmn']['0'] = 'company_name';
        $arr_export_settings[5]['header']['title']['0'] = 'Company';
        $arr_export_settings[5]['header']['Width']['0'] = '20';

        $arr_export_settings[5]['header']['colmn']['1'] = 'customer_name';
        $arr_export_settings[5]['header']['title']['1'] = 'First Name';
        $arr_export_settings[5]['header']['Width']['1'] = '20';

        $arr_export_settings[5]['header']['colmn']['2'] = 'contact_number';
        $arr_export_settings[5]['header']['title']['2'] = 'Contact Number';
        $arr_export_settings[5]['header']['Width']['2'] = '20';

        $arr_export_settings[5]['header']['colmn']['3'] = 'added_by_name';
        $arr_export_settings[5]['header']['title']['3'] = 'Added By';
        $arr_export_settings[5]['header']['Width']['3'] = '20';

        $arr_export_settings[5]['header']['colmn']['4'] = 'add_date';
        $arr_export_settings[5]['header']['title']['4'] = 'Add Date';
        $arr_export_settings[5]['header']['Width']['4'] = '20';

        //print "<pre>"; print_r($arr_export_settings[$export_id]); print "</pre>";
        return $arr_export_settings[$export_id];
    }

    public function aboutQuarter($mq_id)
    {
        $select = $this->DB->select();
        $select->from(
            array('q' => 'bsc_measurement_quarter'),
            array(
                'q.year',
                'q.quarter'
            )
        );
    }
}
