<?php   
  defined('BASEPATH') OR exit('No direct script access allowed');   
  class M_account extends CI_Model{   
   
   function daftar($data) {   
    $this->db->insert('users',$data);   
   }  
   
   //Start: method tambahan untuk reset code  
   public function getUserInfo($id)  
   {  
     $q = $this->db->get_where('users', array('id_user' => $id), 1);   
     if($this->db->affected_rows() > 0){  
       $row = $q->row();  
       return $row;  
     }else{  
       error_log('no user found getUserInfo('.$id.')');  
       return false;  
     }  
   }  
   
  public function getUserInfoByEmail($email){  
     $q = $this->db->get_where('siswa', array('email_alter' => $email), 1);   
     if($this->db->affected_rows() > 0){  
       $row = $q->row();  
       return $row;  
     }  
   }  
   
   public function insertToken($user_id)  
   {    
     $token = substr(sha1(rand()), 0, 30);   
     $date = date('Y-m-d');  
       
     $string = array(  
         'token'=> $token,  
         'user_id'=>$user_id,  
         'created'=>$date  
       );  
     $query = $this->db->insert_string('tokens',$string);  
     $this->db->query($query);  
     return $token . $user_id;  
       
   }  
   
   public function isTokenValid($token)  
   {  
     $tkn = substr($token,0,30);  
     $uid = substr($token,30);     
       
     $q = $this->db->get_where('tokens', array(  
       'tokens.token' => $tkn,   
       'tokens.user_id' => $uid), 1);               
           
     if($this->db->affected_rows() > 0){  
       $row = $q->row();         
         
       $created = $row->created;  
       $createdTS = strtotime($created);  
       $today = date('Y-m-d');   
       $todayTS = strtotime($today);  
         
       if($createdTS != $todayTS){  
         return false;  
       }  
         
       $user_info = $this->getUserInfo($row->user_id);  
       return $user_info;  
         
     }else{  
       return false;  
     }  
       
   }   
   
   public function updatePassword($post)  
   {    
     $this->db->where('id_user', $post['id_user']);  
     $this->db->update('users', array('password' => $post['password']));      
     return true;  
   }   
   //End: method tambahan untuk reset code  

   function cek_siswa($nisn)
	{
    $sql = "SELECT * FROM siswa WHERE nisn = ? ";
		return $this->db->query($sql, array($nisn));
    }
    
    function cek_emailal($nisn, $emailal)
	{
    $sql = "SELECT * FROM siswa WHERE nisn = ? AND email_alter = ? ";
		return $this->db->query($sql, array($nisn, $emailal));
    }
    
    function get_user($nisn)
	{
    $sql = "SELECT * from siswa where no_hp > 0 and nisn COLLATE latin1_general_cs LIKE ?";
		return $this->db->query($sql, array($nisn));
    }
    
    public function check_reset_key($reset_key)
  {
    $this->db->where('reset_password', $reset_key);
    $this->db->from('siswa');
    return $this->db->count_all_results();
  }

    public function cek_email($reset_key)
    {
      $this->db->select('*')->where('reset_password', $reset_key)->from('siswa');
      return $this->db->get();
    }

  function update_reset_key($email, $reset_key, $update){
    $this->db->where('email_alter', $email);
    $data = array('reset_password'=>$reset_key, 'xupdate_reset'=>$update);
    $this->db->update('siswa', $data);
    if($this->db->affected_rows()>0){
      return TRUE;
    }else{
      return FALSE;
    }
  }
  
  public function reset_password($reset_key, $password)
	{
		$this->db->where('reset_password', $reset_key);
		$data = array('password' => $password);
		$this->db->update('siswa', $data);
		return ($this->db->affected_rows()>0 )? TRUE:FALSE;
  }
  
  public function get_time_reset($reset_key){
    $this->db->select('xupdate_reset');
    $this->db->where('reset_password', $reset_key);
    $this->db->from('siswa');
    return $this->db->get();
  }
 }   