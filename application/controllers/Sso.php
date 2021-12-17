<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Secure_area.php');
class Sso extends Secure_area
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/M_user', '', TRUE);
		$this->load->model('admin/M_sekolah', '', TRUE);
		$this->load->model('admin/M_menu', '', TRUE);
		$this->load->model('admin/M_role', '', TRUE);
		$this->load->model('admin/Appconfig', '', TRUE);

    }
    
    function index()
    {
        $ch = curl_init();
        $url = "sso.teratai.id/kc-admin/users?";

        $header = array(
            "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        
        if($e = curl_error($ch)){
            echo $e;
        } else {
            $a = json_decode($result, true);
            // print_r($data);

            $data['sso'] = array_column($a['data'], 'email');
            // var_dump($data);
            // die();
        }
        curl_close($ch);
        $data['title'] = 'Members';
        $data['provinsi'] = $this->M_sekolah->get_provinsi()->result();
        $this->load->view('sso/user_sso', $data);
    }

    function get_autocomplete(){
        $ch = curl_init();
        $url = "sso.teratai.id/kc-admin/users?";

        $header = array(
            "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $res = curl_exec($ch);
        
        if($e = curl_error($ch)){
            echo $e;
        } else {
            $decoded = json_decode($res, true);
            // print_r($decoded['total']);
            // die();
            $dataEmail = [];
            for($i=0;$i<$decoded['total'];$i++){
                $dataEmail[] = array(
                    'value' => $decoded['data'][$i]['email'],
                    'display' => $decoded['data'][$i]['displayname'],
                    'user' => $decoded['data'][$i]['username'],
                    'user_id' => $decoded['data'][$i]['id']
                );
            }
            // print_r($dataEmail);
            // $email = array_column($decoded['data'], 'email');
            // $d_name = array_column($decoded['data'], 'displayname');
            // $username = array_column($decoded['data'], 'username');
            // var_dump($title);
        }
        curl_close($ch);
        $keyword = $this->input->get("query");
        // $data = $this->M_sekolah->search_blog($keyword);   

        $arr = [];
        // $arr['suggestions']=[];
        $arr['query'] = $keyword;
        $arr['suggestions'] = $dataEmail;
        // minimal PHP 5.2
        echo json_encode($arr);
    }

    function insert_sso()
    {
        if($this->input->post('pilih_admin') == 2) {
            $admin = 'admin';
        } else if($this->input->post('pilih_admin') == 11) {
            $admin = 'admin-provinsi';
        } else {
            $admin = 'admin-regional';
        }
        $data = array(
            'name' => $this->input->post('d_name'),
            'username' => $this->input->post('username'),
            'password' => 'Password-'.$this->input->post('username'),
            'roleid' => $this->input->post('pilih_admin'),
            'xcreate_date' => date('Y-m-d h:i:s'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
            'id_keycloak' => 1,
            'id_usersso' => $this->input->post('id_user'),
            'id_provinsi' => $this->input->post('nama_provinsi'),
            'id_regional' => $this->input->post('nama_kota'),
            'email' => $this->input->post('user_sso'),
            'display_name' => $this->input->post('d_name'),
            'role' => $admin,
            'status' => 'Enabled',
        );

        $url = "sso.teratai.id/kc-admin/users/client-roles";
        $header = array(
            "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );
        
        $data_array = array(
            "user_id" => $this->input->post('id_user'),
            "client_id" => 'email-siswa',
            "role_name" => $admin
        );
        $dataa = http_build_query($data_array);
        $cek = $this->M_sekolah->cek_sso($data['username'])->num_rows();
            if ($cek > 0)
            {
                $result = array('success' => false, 'msg' => 'Email sudah terdaftar');

            } else {
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataa);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $resp = curl_exec($ch);
            if ($e = curl_error($ch))
            {
                echo $e;
            } else {
                $decoded = json_decode($resp, true);
                $result = $this->M_sekolah->insert_sso($data);
                $data1 = array(
                    'keterangan' => 'invite user sso',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true);
            }
            curl_close($ch);
        }

        echo json_encode($result);
    }

    function insert_newsso()
    {
        if($this->input->post('pilih_admin2') == 2) {
            $admin = 'admin';
        } else if($this->input->post('pilih_admin2') == 11) {
            $admin = 'admin-provinsi';
        } else {
            $admin = 'admin-regional';
        }
        $data = array(
            'name' => $this->input->post('dis_name'),
            'username' => $this->input->post('new_sso'),
            'password' => $this->input->post('re_password'),
            'roleid' => $this->input->post('pilih_admin2'),
            'xcreate_date' => date('Y-m-d h:i:s'),
            'xcreate_user' => $this->load->get_var("user_info")->username,
            'id_keycloak' => 1,
            'id_provinsi' => $this->input->post('nama_provinsi2'),
            'id_regional' => $this->input->post('nama_kota2'),
            'email' => $this->input->post('new_sso'),
            'display_name' => $this->input->post('dis_name'),
            'role' => $admin,
            'status' => 'Enabled',
        );

        $url = "sso.teratai.id/kc-admin/users";
        $header = array(
            "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );

        $attributes = array(
            "id_provinsi" => $this->input->post('nama_provinsi2'),
            'id_regional' => $this->input->post('nama_kota2'),
        );
        
        $client_role = array(
            "client_id" => 'email-siswa',
            "role_name" => $admin,
            "attributes" => $attributes
        );

        $data_array = array(
            "username" => $this->input->post('new_sso'),
            "email" => $this->input->post('new_sso'),
            "displayname" => $this->input->post('dis_name'),
            "password" => $this->input->post('re_password'),
            "verify_email" => false,
            "client_role" => $client_role
        );
        $dataa = http_build_query($data_array);
        $cek = $this->M_sekolah->cek_sso($data['username'])->num_rows();
            if ($cek > 0)
            {
                $result = array('success' => false, 'msg' => 'Email sudah terdaftar');

            } else {
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataa);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $resp = curl_exec($ch);
            if ($e = curl_error($ch))
            {
                echo $e;
            } else {
                $decoded = json_decode($resp, true);
                // $result = $this->M_sekolah->insert_sso($data);
                $data1 = array(
                    'keterangan' => 'create user sso',
                    'ket_waktu' => date('Y-m-d h:i:s'),
                    'userid' => $this->load->get_var('user_info')->userid
                );
                $this->M_sekolah->log_activity($data1);
                $result = array('success' => true);
            }
            curl_close($ch);
        }

        echo json_encode($result);
    }

    public function show_data_sso()
    {
        $ch = curl_init();
        $url = "sso.teratai.id/kc-admin/db-users/email-siswa";

        $header = array(
            "Authorization: eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        
        if($e = curl_error($ch)){
            echo $e;
        } else {
            $a = json_decode($result, true);
            // print_r($a);
            
            
            $dataEmail = [];
            $url = "<a href='" . site_url("sso/detail_sso") . "'>";
            $no = 1;
            for($i=0;$i<$a['total'];$i++){
                $dataEmail[] = array(
                    'no' => $no++,
                    'email' => "<a href='" . site_url("sso/detail_sso/".$a['data'][$i]['id']) . "'>" . $a['data'][$i]['email'] . "</a>",
                    'username' => $a['data'][$i]['username'],
                    'displayname' => $a['data'][$i]['displayname'],
                    'role_name' => $a['data'][$i]['role_name'],
                    'status' => $a['data'][$i]['enabled'],
                    'last_login' => date('Y-m-d H:i:s', $a['data'][$i]['lastloggedin_timestamp']/1000)
                );
            }
            echo json_encode($dataEmail);
            // $data['sso'] = array_column($a['data'], 'email');
            // var_dump($data);
            // die();
        }
        curl_close($ch);
        // $data['title'] = 'Members';
        // $data['provinsi'] = $this->M_sekolah->get_provinsi()->result();
        // $this->load->view('sso/user_sso', $data);
        // $roleid = $this->load->get_var("user_info")->roleid;
        //     $line  = array();
        //     $line2 = array();
        //     $row2  = array();
        //     $hasil = $this->M_sekolah->get_sso()->result();
        //     $i = 1;
        //     foreach ($hasil as $value) {
        //         $row2['no'] = $i++;
        //         $row2['email'] = $value->email;
        //         $row2['username'] = $value->username;
        //         $row2['display_name'] = $value->display_name;
        //         $row2['role'] = $value->role;
        //         $row2['status'] = $value->status;
        //         $row2['last_login'] = $value->last_login;

        //         $line2[] = $row2;
        //     }
        //     $line['data'] = $line2;

        //     echo json_encode($line);
    }

    public function get_data_kota()
	{
		$nama_provinsi = $this->input->post('nama_provinsi');
		$data = $this->M_sekolah->get_kota($nama_provinsi)->result();
		$kota = '';
		if (sizeof((array) $data) > 0) {
			$kota .= "<option value=''>-=Pilih Kota=-</option>";
			foreach ($data as $row) {
				$kota .= "<option value='" . $row->id_region . "'>$row->nama_region</option>";
			}
		}
		if ($kota != "") {
			echo json_encode(array('success' => true, 'data' => $kota));
		} else {
			echo json_encode(array('success' => false, 'data' => '<option value="">-=Data Kota Kosong=-</option>'));
        }
    }

    public function get_wilayah2()
    {
        $json = [];

        $this->load->database();


        if (!empty($this->input->get("q"))) {
            // $this->db->like('nama', $this->input->get("q"));
            // $query = $this->db->select('id,id_kecamatan,nama')
            // 			->limit(10)
            // 			->get("kelurahandesa");
            // $this->db->like('nama_region', $title, 'both');
            // $this->db->order_by('nama_region', 'ASC');
            // $this->db->limit(10);
            // return $this->db->get('master_region')->result();
            $query = $this->db
                ->like('nama_region', $this->input->get("q"))
                ->order_by('nama_region', 'ASC')
                ->select('*')->limit(50, 0)->get('master_region');
            $json = $query->result();
        }


        echo json_encode($json);
    }

    public function detail_sso($id){
        $ch = curl_init();
        $url = "sso.teratai.id/kc-admin/users/".$id."?client_id=email-siswa";

        $header = array(
            "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $res = curl_exec($ch);
        $decode = json_decode($res, true);
        curl_close($ch);
        $data['title'] = "Detail SSO";
        $data['get_data'] = $decode['data'];
        $data['get_role'] = $decode['data']['resource_access'][0]['roles'][0];
        $this->load->view("sso/detail_sso", $data);
    }

    public function get_log($username){
        // $ch = curl_init();
        // $url = "sso.teratai.id/kc-admin/users/".$id."?client_id=email-siswa";

        // $header = array(
        //     "Authorization:  eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJzWjF3aUx5dEd5d3FVUU1ldDJCb3EzNHUtb0Y4UENwTFQyQUJnOUI4dzlRIn0.eyJleHAiOjE2MTI4NjU5OTQsImlhdCI6MTYxMjg2NDE5NCwianRpIjoiNmNiMDVhZDUtYTUyMC00ZjVhLWE5ODAtNWYxYjU3ZDA0M2QxIiwiaXNzIjoiaHR0cDovL3Nzby50ZXJhdGFpLmlkL2F1dGgvcmVhbG1zL2tvbWluZm8iLCJzdWIiOiI5NzE2NjkyYS05YjA3LTRmMWItOWUxZC1hODg3Yjk2YjE5MDUiLCJ0eXAiOiJCZWFyZXIiLCJhenAiOiJlbWFpbC1zaXN3YSIsInNlc3Npb25fc3RhdGUiOiJmMmIzMDVjYy0zZGIxLTRiOWMtODE2Zi1hNzczODQ0ZDdhMjAiLCJhY3IiOiIxIiwiYWxsb3dlZC1vcmlnaW5zIjpbIioiXSwicmVzb3VyY2VfYWNjZXNzIjp7ImFjY291bnQiOnsicm9sZXMiOlsibWFuYWdlLWFjY291bnQiLCJ2aWV3LXByb2ZpbGUiXX19LCJzY29wZSI6ImVtYWlsIGN1c3RvbS1hdHRyaWJ1dGVzIHBob25lIHByb2ZpbGUiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsIm5hbWUiOiJFbWFpbCBTaXN3YSIsInByZWZlcnJlZF91c2VybmFtZSI6ImVtYWlsLnNpc3dhIiwiZ2l2ZW5fbmFtZSI6IkVtYWlsIiwiZmFtaWx5X25hbWUiOiJTaXN3YSIsImVtYWlsIjoibW9oYW1tYWQubmFmaXNwdXRyYWxAZ21haWwuY29tIn0.g1TqDelQnbhWyewoGPyu0NuPIoMUz1aHGFHM3iPHjrCnZD_djF3gvrRyNTBN32vSOxKKg83FwImUG3sguHFVuPSAqraf_JGRXrTsYTIYpCHb4yGzsrK6B1FO_HxNvOYMZr_F-Z7YxKNzkTVnDWvEch0qy9pz3CjhMjYfq4-2PjBKe0GP1c0hvM-2quMdCzyyVDEZVBoZfNmbkae2_xGbhg6VazSLGJS8GqfFlE7liv_9uuLlB4BMA4KmrIZGsZKmdzPLdf1izC5lX1QeHZTCdnqjrF6PgBRpljYWKbgpbJ09awHOnJHTDsYpocxc24vNiQA2vTb7yJqq867fwISbvA"
        // );

        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // $res = curl_exec($ch);
        // $decode = json_decode($res, true);
        // curl_close($ch);

        // $dataa = $decode['data']['username'];
            $line  = array();
            $line2 = array();
            $row2  = array();
            $cek = $this->M_sekolah->activity_sso($username)->result();
            foreach ($cek as $row)
            {
                $row2['time'] = $row->ket_waktu;
                $row2['event'] = $row->keterangan;
                $row2['client_id'] = 'email-siswa';

                $line2[] = $row2;

            }
            $line['data'] = $line2;

            echo json_encode($line);
    }

}
