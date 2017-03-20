<?php

class ModelTrackApi extends Model
{
    function saveAccess($code)
    {
        try {
            $this->db->query("UPDATE oc_track_access SET count = (count + 1) WHERE code = '$code'");
        } catch (Exception $e) {
            trace(__FILE__ . '(' . __LINE__ . ') ' . $e->getMessage());
        }
    }

    function saveRegister($code, $customerId)
    {
        try {
            $this->db->query("INSERT INTO oc_track_register (code, customer_id) VALUES ('$code', '$customerId')");
        } catch (Exception $e) {
            trace(__FILE__ . '(' . __LINE__ . ') ' . $e->getMessage());
        }
    }

    function savePayment($code, $orderId)
    {
        try {
            $this->db->query("INSERT INTO oc_track_payment (code, order_id) VALUES ('$code', '$orderId')");
        } catch (Exception $e) {
            trace(__FILE__ . '(' . __LINE__ . ') ' . $e->getMessage());
        }
    }
}