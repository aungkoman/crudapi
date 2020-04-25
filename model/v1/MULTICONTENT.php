<?php
class MULTICONTENT{
        public $multicontent;
        public function __construct(){
                $this->multicontent = R::dispense('multicontent');
        }
        public function insert($data){
                // 1. title
                $this->multicontent->content_title = (string) isset($data['title']) ? sanitize_str($data['title'],"multicontent->insert : title") :  return_fail('multicontent->insert : title is not defined in requested data');

                // 2. content_text
                $this->multicontent->content_text = (string) isset($data['content_text']) ? sanitize_str($data['content_text'],"multicontent->insert : content_text") :  return_fail('multicontent->insert : content_text is not defined in requested data');

                // 4. created_date
                $this->multicontent->created_date = date("Y-m-d h:m:s");

                // 5. modified_date
                $this->multicontent->modified_date = date("Y-m-d h:m:s");
                try{
                        $id = R::store($this->multicontent);
                        return_success("multicontent->insert",$this->multicontent);
                }
                catch(Exception $exp){
                        return_fail('multicontent->insert : Exception : ',$exp->getMessage());
                }



                // // 3 content_image
                // // loop through images
                // $images = isset($data['images']) ? $data['images'] : array();
                // if(isarray($images) && count($images) > 0 ){
                //         for($i = 0; $i < count($images); $i++){
                //                 $photo = R::dispense('content_image');
                //                 $photo->url = $images[$i];
                //                 try{
                //                         $photo_id = R::store($photo);
                //                         $this->multicontent->content_images[] = $photo;
                //                 }
                //                 catch(Exception $exp){
                //                         return_fail('multicontent->insert : content_image insert fail : ',$exp->getMessage());
                //                 }
                                
                //         }
                // }
                // // 3. content_video
                // $this->multicontent->content_video = (string) isset($data['content_video']) ? sanitize_str($data['content_video'],"multicontent->insert : content_video") :  return_fail('multicontent->insert : content_video is not defined in requested data');



                // // 1. title
                // $this->multicontent->title = (string) isset($data['title']) ? sanitize_str($data['title'],"multicontent->insert : title") :  return_fail('multicontent->insert : title is not defined in requested data');

                // // 2. currency
                // $currency = (int) isset($data['currency']) ? sanitize_int($data['currency'],"multicontent->insert : currency") :  return_fail('multicontent->insert : currency is not defined in requested data');
                // $currency = R::load('currency',$currency);
                // if($currency->id == 0 ) return_fail('multicontent->insert : currency can not find ');
                // $this->multicontent->currency = $currency;

                // // 3. bank
                // $bank = (int) isset($data['bank']) ? sanitize_int($data['bank'],"multicontent->insert : bank") :  return_fail('multicontent->insert : bank is not defined in requested data');
                // $bank = R::load('bank',$bank);
                // if($bank->id == 0 ) return_fail('multicontent->insert : bank can not find ');
                // $this->multicontent->bank = $bank;

        }
        public function select($data){
                $limit = (int) isset($data['limit']) ? sanitize_int($data['limit']) : 0;
                $last_id = (int) isset($data['last_id']) ? sanitize_int($data['last_id']) : 0;
                if($limit == 0 ) $multicontents = R::find('multicontent',' id > ? ', [ $last_id ]);
                else $multicontents = R::find('multicontent', ' id > ? LIMIT ?', [ $last_id, $limit ] );
                $return_data = array();
                $test;
                foreach($multicontents AS $index=>$multicontent){
                        //$test = $multicontent->bank; // to get related foreign data
                        //$test = $multicontent->currency; // to get relate data
                        $return_data[] = $multicontent;
                }
                return_success("multicontent->select ".count($return_data),$return_data);
        }
        public function update($data){
                // 1. id
                $id = (int) isset($data['id']) ? sanitize_int($data['id']) :  return_fail('multicontent->update : id is not defined in requested data');
                $multicontent = R::load( 'multicontent', $id );
                if($multicontent->id == 0 ) return_fail("multicontent->update : no data for requested id");

                // 2. content_title
                $multicontent->content_title = (string) isset($data['content_title']) ? sanitize_str($data['content_title'],"multicontent->update : content_title") :  $multicontent->content_title;

                // 3. content_text
                $multicontent->content_text = (string) isset($data['content_text']) ? sanitize_str($data['content_text'],"multicontent->update : content_text") :  $multicontent->content_text;

                $multicontent->modified_date = date("Y-m-d h:m:s");

                try{
                        R::store($multicontent);
                        return_success("multicontent->update",$multicontent);
                }catch(Exception $exp){
                        return_fail("multicontent->update : exception",$exp->getMessage());
                }

                // // 3. currency
                // $currency_id = (int) isset($data['currency']) ? sanitize_int($data['currency'],"multicontent->update : currency") :  $multicontent->currency_id;
                // $currency = R::load('currency',$currency_id);
                // if($currency->id == 0 ) return_fail('multicontent->update : currency can not find '. $currency_id);
                // $multicontent->currency = $currency;

                // //$multicontent->currency_id = (int) isset($data['currency']) ? sanitize_int($data['currency'],"multicontent->update : currency") :  $multicontent->currency_id;

                // // 4. bank
                // $bank_id = (int) isset($data['bank']) ? sanitize_int($data['bank'],"multicontent->update : bank") :  $multicontent->bank_id;
                // $bank = R::load('bank',$bank_id);
                // if($bank->id == 0 ) return_fail('multicontent->update : bank can not find ' . $bank_id);
                // $multicontent->bank = $bank;
                // //$multicontent->bank_id = (int) isset($data['bank']) ? sanitize_int($data['bank'],"multicontent->update : bank") :  $multicontent->bank_id;

                // // 5. modified_date
                // $multicontent->modified_date = date("Y-m-d h:m:s");

                // // 6. opening_date
                // $multicontent->opening_date = (string) isset($data['opening_date']) ? sanitize_str($data['opening_date'],"multicontent->update : opening_date") :  $multicontent->opening_date;
                // $opening_date = strtotime($multicontent->opening_date); // time to unix
                // $multicontent->opening_date = date("Y-m-d",$opening_date); // well formated time

                // // 7. balance
                // $multicontent->balance = (int) isset($data['balance']) ? sanitize_int($data['balance'],"multicontent->update : balance") :  $multicontent->balance;

                // // 8. we just omit created_date :D

                
        }
        public function delete($data){
                $id = (int) isset($data['id']) ? sanitize_int($data['id']) :  return_fail('multicontent->delete : id is not defined in requested data');
                $multicontent = R::load( 'multicontent', $id );
                if($multicontent->id == 0 ) return_fail("multicontent->delete : no data for requested id");
                try{
                        R::trash($multicontent);
                        return_success("multicontent->delete",$multicontent);
                }catch(Exception $exp){
                        return_fail("multicontent->delete : exception",$exp->getMessage());
                }
        }
}// end for class
?>