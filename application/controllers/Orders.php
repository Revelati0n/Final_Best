<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Orders extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
  	public function index()
	{
		echo json_encode(array('ResponseCode' => 0, 'ResponseData' => $this->db->limit(5)->get('orders')->result_array()));
	}
    public function getOrderByID($ID = null)
    {
        if($ID != null){
            $Data = $this->db->where('OrderID', $ID)->get('orders')->result();
            if(count($Data) == 0){
                echo json_encode(array('ResponseCode' => 2, 'ResponseMsg' => 'data not found'));
            }else{
                echo json_encode(array('ResponseCode' => 0, 'ResponseData' => $Data));
            }
        }else{
            echo json_encode(array('ResponseCode' => 1, 'ResponseMsg' => 'error ID null'));
        }
    }
    public function getOrder($index = null, $item = null)
    {
        if(($index == null) or ($item == null)){
            echo json_encode(array('ResponseCode' => 1, 'ResponseMsg' => 'error index or item null'));
        }else{
            echo json_encode(array('ResponseCode' => 0, 'ResponseData' => $this->db->limit($item, $index)->get('orders')->result()));
        }
    }
    public function postOrder()
    {
        $Data = json_decode(file_get_contents('php://input'));
        if(count($Data) >= 1){
            if(count($this->db->where('OrderName', $Data->OrderName)->get('orders')->result()) == 0){
                // do save
            }else{
                echo json_encode(array('ResponseCode' => 2, 'ResponseMsg' => 'name already exists'));
            }
        }else{
            echo json_encode(array('ResponseCode' => 1, 'ResponseMsg' => 'error post null'));
        }
    }
    public function updateOrder()
    {
        $Data = json_decode(file_get_contents('php://input'));
        if(count($Data) >= 1){
            if(count($this->db->where('OrderID', $Data->OrderID)->get('orders')->result()) != 1){
                // do update
            }else{
                echo json_encode(array('ResponseCode' => 2, 'ResponseMsg' => 'ID not found'));
            }
        }else{
            echo json_encode(array('ResponseCode' => 1, 'ResponseMsg' => 'error update null'));
        }
    }
}
