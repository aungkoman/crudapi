<?php
class user{
        public $user;
        public function __construct(){
                $this->user = R::dispense('user');
        }
        public function insert($data){
                //  1. email 
                $this->user->email = (string) isset($data['email']) ? sanitize_str($data['email'],"user->insert : email") :  return_fail('user->insert : email is not defined in requested data');
                //  2. name 
                $this->user->username = (string) isset($data['username']) ? sanitize_str($data['username'],"user->insert : username") :  return_fail('user->insert : username is not defined in requested data');
                /*
                        $hash=password_hash("rasmuslerdorf", PASSWORD_DEFAULT);
                        if (password_verify('rasmuslerdorf', $hash)) {
                        echo 'Password is valid!';
                        } else {
                        echo 'Invalid password.';
                        }


                */
                //  3. password 
                // TDL : php password stored function
                $this->user->password = (string) isset($data['password']) ? sanitize_str($data['password'],"user->insert : password") :  return_fail('user->insert : password is not defined in requested data');
                $this->user->password = password_hash($this->user->password, PASSWORD_DEFAULT);
                //  4. role
                $this->user->role = "register";//(string) isset($data['role']) ? sanitize_str($data['role'],"user->insert : role") :  return_fail('user->insert : role is not defined in requested data');
                

                // 5. created_date
                $this->user->created_date = date("Y-m-d h:m:s");

                // 6. modified_date
                $this->user->modified_date = date("Y-m-d h:m:s");
                try{
                        $id = R::store($this->user);
                        return_success("user->insert",$this->user);
                }catch(Exception $exp){
                        return_fail("user->insert : exception ",$exp->getMessage());
                }
        }
        public function select($data){
                $limit = (int) isset($data['limit']) ? sanitize_int($data['limit']) : 0;
                $last_id = (int) isset($data['last_id']) ? sanitize_int($data['last_id']) : 0;
                if($limit == 0 ) $users = R::find('user',' id > ? ', [ $last_id ]);
                else $users = R::find('user', ' id > ? LIMIT ?', [ $last_id, $limit ] );
                $return_data = array();
                foreach($users AS $index=>$user){
                        $user->password = null;
                        $return_data[] = $user;
                }
                return_success("user->select ".count($return_data),$return_data);
        }
        public function update($data){
                //print_r($data);
                $id = (int) isset($data['id']) ? sanitize_int($data['id']) :  return_fail('user->update : id is not defined in requested data');
                $user = R::load( 'user', $id );
                if($user->id == 0 ) return_fail("user->update : no data for requested id");
                // 1.  email
                $user->email = (string) isset($data['email']) ? sanitize_str($data['email'],"user->update : email") :  $user->email;
                // 2.  username
                $user->username = (string) isset($data['username']) ? sanitize_str($data['username'],"user->update : username") :  $user->username;
                // 3.  password
                $hashPw = (string) isset($data['password']) ? sanitize_str($data['password'],"user->update : password") :  "";
                if($hashPw != "" ){
                        $user->password = password_hash($hashPw, PASSWORD_DEFAULT);
                }
                //$user->password = (string) isset($data['password']) ? sanitize_str($data['password'],"user->update : password") :  $user->password;
                // 4.  role
                // TDL : php password stored function
                $user->role = (string) isset($data['role']) ? sanitize_str($data['role'],"user->update : role") :  $user->role;

                
                // 6. modified_date
                $user->modified_date = date("Y-m-d h:m:s");
                try{
                        R::store($user);
                        $user->password = null;
                        return_success("user->update",$user);
                }catch(Exception $exp){
                        return_fail("user->update : exception",$exp->getMessage());
                }
        }
        public function delete($data){
                $id = (int) isset($data['id']) ? sanitize_int($data['id']) :  return_fail('user->delete : id is not defined in requested data');
                $user = R::load( 'user', $id );
                if($user->id == 0 ) return_fail("user->delete : no data for requested id");
                try{
                        R::trash($user);
                        $user->password = null;
                        return_success("user->delete",$user);
                }catch(Exception $exp){
                        return_fail("user->delete : exception",$exp->getMessage());
                }
        }
}// end for class
?>