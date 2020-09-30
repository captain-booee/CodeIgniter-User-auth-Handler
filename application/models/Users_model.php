<?php 

class Users_model extends CI_Model{
	
	function create_user($email,$password,$hash){
		$data = array(
            'email' => $email,
            'password' => sha1($password),
            'hash' => $hash
        );
    
        $this->db->insert('users', $data);
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')

    }

    function login_check_user($email,$password){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $data = $this->db->get()->result_array();
        if($data){
            if (sha1($password)==$data[0]['password'] and $data[0]['status']=='1'){
                if ($data[0]['blocked'] =='1'){
                    //or return a string to set msg later on for user
                    return FALSE;
                }
                return $data;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    function check_user_ip($id,$ip){

        $this->db->select('*');
        $this->db->from('user_ips');
        $this->db->where('user_ip', $ip);
        $data = $this->db->get()->result_array();
        if($data){
            foreach($data as $key => $value){
                if ($value['user_id']==$id){
                    continue;
                }else{
                    //where ip are the same in the user_ips table :> user_id is different
                    $data = array('blocked' => '1');
                    $this->db->where('id', $id);
                    $this->db->update('users', $data);
                    return FALSE;
                }
            }
            return TRUE;
        }else{
            //we should add a row
            $data = array(
                'user_id' => $id,
                'user_ip' => $ip
            );
            $this->db->insert('user_ips', $data);
            return TRUE;
        }
    }

    function user_status_update($email, $hash){
        $this->db->select('status');
        $this->db->from('users');
        $this->db->where('email', $email);
        $data = $this->db->get()->result_array();
            if ($data[0]['status']=='1'){
                return FALSE;
            }
            
            $data = array('status' => '1');
    
            $this->db->where('email', $email);
            $this->db->where('hash', $hash);
            $this->db->update('users', $data);
            return TRUE;
            
        // Produces:
        //
        //      UPDATE mytable
        //      SET title = '{$title}', name = '{$name}', date = '{$date}'
        //      WHERE id = $id
    }


    function update_password_randomly($email, $password){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $data = $this->db->get()->result_array();
        if($data){

            if ($data[0]['status']=='0'){
                return FALSE;
            }

            $data2 = array('password' => sha1($password));
    
            $this->db->where('email', $email);
            $this->db->update('users', $data2);
            return TRUE;
        }else{
            return FALSE;
        }
    }




    function update_hash_randomly($email, $hash){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $data = $this->db->get()->result_array();
        if($data){

            if ($data[0]['status']=='1'){
                return FALSE;
            }

            $data2 = array('hash' => $hash);
            $this->db->where('email', $email);
            $this->db->update('users', $data2);
            return TRUE;
        }else{
            return FALSE;
        }
    }


}
?>