<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminMapelModel extends CI_Model
{
    public function get_all_mapel()
    {
        $this->db->order_by('nama_mapel', 'ASC');
        return $this->db->get('mapel')->result_array();
    }

    public function get_mapel_by_id($mapel_id)
    {
        $this->db->where('id', $mapel_id);
        return $this->db->get('mapel')->row_array();
    }

    public function insert_mapel($data)
    {
        return $this->db->insert('mapel', $data);
    }

    public function update_mapel($mapel_id, $data)
    {
        $this->db->where('id', $mapel_id);
        return $this->db->update('mapel', $data);
    }

    public function delete_mapel($mapel_id)
    {
        $this->db->where('id', $mapel_id);
        return $this->db->delete('mapel');
    }
}
