<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->userdata = $this->session->userdata('logged_in');
    }

    public function index() {
        $data = array();
        $data['login_user'] = $this->session->userdata('logged_in');
        $userdata = $this->userdata;

        if ($userdata) {
            redirect("Salary/index", "refresh");
        } else {
            //        redirect("Authentication/index");
        }

        //login conroller
        if (isset($_POST['signIn'])) {
            $username = $this->input->post('email');
            $password = $this->input->post('password');
            $this->db->select('id,first_name,last_name,email,password,user_type, image');
            $this->db->from('admin_users');
            $this->db->where('email', $username);
            $this->db->where('password', md5($password));
            $this->db->limit(1);
            $query = $this->db->get();
            $checkuser = $query->row();

            if ($checkuser) {
                $usr = $checkuser->email;
                $pwd = $checkuser->password;

                if ($username == $usr && md5($password) == $pwd) {
                    $this->db->where('user_id', $checkuser->id);
                    $query = $this->db->get("salary_employee");
                    $employeecheck = $query->row();

                    $sess_data = array(
                        'username' => $username,
                        'first_name' => $checkuser->first_name,
                        'last_name' => $checkuser->last_name,
                        'login_id' => $checkuser->id,
                        'user_type' => $checkuser->user_type,
                        'image' => $checkuser->image,
                        "employee_id" => $employeecheck ? $employeecheck->id : ""
                    );
                    $this->session->set_userdata('logged_in', $sess_data);

                    $orderlog = array(
                        'log_type' => "Login",
                        'log_datetime' => date('Y-m-d H:i:s'),
                        'user_id' => $checkuser->id,
                        'order_id' => "",
                        'log_detail' => $username . " Login Succesful",
                    );
                    $this->db->insert('system_log', $orderlog);

                    $message = array(
                        'title' => 'Login Succesful',
                        'text' => "Let's start doing...",
                        'show' => true,
                        'icon' => 'happy.png'
                    );
                    $this->session->set_flashdata("checklogin", $message);
                    redirect('Salary/index');
                }
            } else {
                $message = array(
                    'title' => 'Login Failed',
                    'text' => 'Invalid email or password.',
                    'show' => true
                );
                $this->session->set_flashdata("checklogin", $message);

                //redirect('LoginAndLogout/login_admin/');
            }
        }

        //end of login controller

        $this->load->view('authentication/login', $data);
    }

    public function profile() {
        $data = array();
        // echo password_hash('rasmuslerdorf', PASSWORD_DEFAULT)."\n";
        $userid = $this->userdata['login_id'];
        $query = $this->db->get_where("admin_users", array("id" => $userid));
        $userdata = $query->row();
        $data['userdata'] = $userdata;



        $data['country'] = array();

        $config['upload_path'] = 'assets/profile_image';
        $config['allowed_types'] = '*';
        if (isset($_POST['submit'])) {
            $picture = '';

            if (!empty($_FILES['picture']['name'])) {
                $temp1 = rand(100, 1000000);
                $config['overwrite'] = TRUE;
                $ext1 = explode('.', $_FILES['picture']['name']);
                $ext = strtolower(end($ext1));
                $file_newname = $temp1 . "$userid." . $ext;
                $picture = $file_newname;
                $config['file_name'] = $file_newname;
                //Load upload library and initialize configuration
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('picture')) {
                    $uploadData = $this->upload->data();
                    $picture = $uploadData['file_name'];
                } else {
                    $picture = '';
                }
            }
            $this->db->set('image', $picture);
            $this->db->where('id', $userid); //set column_name and value in which row need to update
            $this->db->update('admin_users');
            $this->userdata['image'] = $picture;
            $this->session->set_userdata('logged_in', $this->userdata);
            redirect("Authentication/profile");
        }

        if (isset($_POST['changePassword'])) {
            $c_password = $this->input->post('c_password');
            $n_password = $this->input->post('n_password');
            $r_password = $this->input->post('r_password');
            $dc_password = $userdata->password;
            if (md5($c_password) == $dc_password) {
                if ($r_password == $n_password) {
                    $message = array(
                        'title' => 'Password Changed.',
                        'text' => 'Your password has been changed successfully.',
                        'show' => true,
                        'icon' => 'happy.png'
                    );
                    $this->session->set_flashdata("checklogin", $message);

                    $orderlog = array(
                        'log_type' => "Password Changed",
                        'log_datetime' => date('Y-m-d H:i:s'),
                        'user_id' => $userid,
                        'order_id' => "",
                        'log_detail' => $userdata->username . ' has changed password successfully.',
                    );
                    $this->db->insert('system_log', $orderlog);


                    $passowrd = array("password" => md5($n_password), "password2" => $n_password);
                    $this->db->set($passowrd);
                    $this->db->where("id", $userid);
                    $this->db->update("admin_users");

                    redirect("profile");
                } else {
                    $message = array(
                        'title' => 'Password Error.',
                        'text' => 'Entered password does not match.',
                        'show' => true,
                        'icon' => 'warn.png'
                    );
                    $this->session->set_flashdata("checklogin", $message);
                }
            } else {
                $message = array(
                    'title' => 'Password Errors.',
                    'text' => 'Current password does not match.',
                    'show' => true,
                    'icon' => 'warn.png'
                );
                $this->session->set_flashdata("checklogin", $message);
            }
        }


        $this->load->view('authentication/profile', $data);
    }

    public function logout() {
        $userdata = array();
        $username = $this->userdata["username"];
        $this->session->unset_userdata($userdata);
        $this->session->sess_destroy();

        $orderlog = array(
            'log_type' => "Log Out",
            'log_datetime' => date('Y-m-d H:i:s'),
            'user_id' => "",
            'order_id' => "",
            'log_detail' => "$username logout from system.",
        );
        $this->db->insert('system_log', $orderlog);

        redirect('Authentication', 'refresh');
    }

    public function error_404() {
        $this->load->view('errors/404');
    }

    function registrationEmployee() {
        $data = array();
        if (isset($_POST['signIn'])) {
            $username = $this->input->post('email');
            $employee_id = $this->input->post('employee_id');
            $this->db->where('email', $username);
            $this->db->where('employee_id', $employee_id);
            $query = $this->db->get("salary_employee");
            $checkuser = $query->row();
            if ($checkuser) {
                $mail_id = $checkuser->email;
                $this->db->where('email', $username);
                $query = $this->db->get("admin_users");
                $checkuserpre = $query->row();
                $otpcheck = rand(1000000, 9999999);

                $message = array(
                    'title' => 'Check your inbox',
                    'text' => "OTP has been sent on your email",
                    'show' => true,
                    'icon' => 'happy.png'
                );
                $this->session->set_flashdata("checklogin", $message);
                if ($checkuserpre) {
                    $this->db->set(array('password' => md5($otpcheck),
                        'password2' => $otpcheck));
                    $this->db->where('id', $checkuser->user_id);
                    $this->db->update('admin_users');
                    $user_id = $checkuser->user_id;
                } else {

                    $userarray = array(
                        'first_name' => $checkuser->name,
                        'last_name' => "",
                        'email' => $mail_id,
                        'password' => md5($otpcheck),
                        'password2' => $otpcheck,
                        'profession' => "",
                        "contact_no" => "",
                        'country' => "",
                        'gender' => "",
                        'birth_date' => "",
                        'user_type' => "Employee",
                        'registration_datetime' => date("Y-m-d h:i:s A")
                    );
                    $this->db->insert('admin_users', $userarray);
                    $user_id = $this->db->insert_id();

                    $this->db->set('user_id', $user_id);
                    $this->db->where('id', $checkuser->id);
                    $this->db->update('salary_employee');
                }





                $emailmessage = "$otpcheck is your OTP to login to panel.";
                setlocale(LC_MONETARY, 'en_US');
                $emailsender = EMAIL_SENDER;
                $sendername = EMAIL_SENDER_NAME;
                $email_bcc = EMAIL_BCC;
                $this->email->from(EMAIL_BCC, $sendername);
                $this->email->to($mail_id);
                $this->email->bcc(EMAIL_BCC);
                $subject = "Login OTP for Employee Registration";
                $this->email->subject($subject);
                $checkcode = REPORT_MODE;
                $this->email->message("$emailmessage", array(), true);
                $this->email->print_debugger();
                $result = $this->email->send();
                redirect('Authentication/otpCheck/' . md5($otpcheck) . "/" . $user_id);
            } else {
                $message = array(
                    'title' => 'Employee Not Found',
                    'text' => 'Invalid Employee ID# and Email.',
                    'show' => true
                );
                $this->session->set_flashdata("checklogin", $message);
            }
        }

        $this->load->view('authentication/employeereg', $data);
    }

    function otpCheck($loginkey, $user_id) {
        $data = array();
        if (isset($_POST['signIn'])) {

            $password = $this->input->post('password');
            $this->db->select('id,first_name,last_name,email,password,user_type, image');
            $this->db->where('id', $user_id);
            $this->db->where('password', md5($password));
            $query = $this->db->get("admin_users");
            $checkuser = $query->row();
            if ($checkuser) {
                $username = $checkuser->email;
                $pwd = $checkuser->password;

                if (md5($password) == $loginkey) {
                    $this->db->where('user_id', $checkuser->id);
                    $query = $this->db->get("salary_employee");
                    $employeecheck = $query->row();
                    $sess_data = array(
                        'employee_id' => $employeecheck->id,
                        'username' => $username,
                        'first_name' => $checkuser->first_name,
                        'last_name' => $checkuser->last_name,
                        'login_id' => $checkuser->id,
                        'user_type' => $checkuser->user_type,
                        'image' => $checkuser->image,
                    );
                    $this->session->set_userdata('logged_in', $sess_data);

                    $orderlog = array(
                        'log_type' => "Login",
                        'log_datetime' => date('Y-m-d H:i:s'),
                        'user_id' => $checkuser->id,
                        'order_id' => "",
                        'log_detail' => $username . " Login Succesful",
                    );
                    $this->db->insert('system_log', $orderlog);

                    $message = array(
                        'title' => 'Login Succesful',
                        'text' => "Let's start doing...",
                        'show' => true,
                        'icon' => 'happy.png'
                    );
                    $this->session->set_flashdata("checklogin", $message);
                    redirect('Salary/index');
                }
            } else {
                $message = array(
                    'title' => 'Login Failed',
                    'text' => 'Your entered invalid OTP.',
                    'show' => true
                );
                $this->session->set_flashdata("checklogin", $message);

                //redirect('LoginAndLogout/login_admin/');
            }
        }
        $this->load->view('authentication/otpcheck', $data);
    }

}
