<?php
require_once '../../includes/database_conn.php';

$request = $_REQUEST;
$col = array(
    0   =>  'day_id',
    1   =>  'day',
    2   =>  'open_hour',
    3   =>  'close_hour',
);
//create column like table in database

$sql = "SELECT * FROM `open_hours`";
$query = mysqli_query($conn, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT * FROM `open_hours` WHERE 1=1";
if (!empty($request['search']['value'])) {
    $sql .= " AND (day_id Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR day Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR open_hour Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR close_hour Like '" . $request['search']['value'] . "%' )";
}

$query = mysqli_query($conn, $sql);
$totalData = mysqli_num_rows($query);

//Order
// $sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " .
//     $request['start'] . "  ," . $request['length'] . "  ";

// $query = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($query)) {
    $subdata = array();
    $subdata[] = $row[1];
    if($row[2] == null) { 
        $subdata[] = 'CLOSED'; 
    } else { 
        $subdata[] = $row[2] . ' - ' . $row[3];
    }
    $subdata[] = '
    <button type="button" id="getEdit" data-id="' . $row[0] . '"><i class="fa-solid fa-pen"></i><span>Edit</span></button>
    <button type="button" id="getDelete" data-id="' . $row[0] . '"><i class="fa-solid fa-trash-can"></i><span>Remove Time</span></button>
    ';
    $data[] = $subdata;
}

$json_data = array(
    // "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);
