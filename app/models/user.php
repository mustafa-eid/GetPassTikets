<?php

session_start();

include_once __DIR__."\..\database\config.php";
include_once __DIR__."\..\database\operations.php";


if(isset($_SESSION['user'])){
      $email = $_SESSION['user']->email;
}

      class User extends config implements operations{
      private $id;
      private $first_name;		
      private $last_name;
      private $image;
      private $status;
      private $password;
      private $email;
      private $ather_people;
      private $payment_status;
      private $phone;		
      private $qr_code;		
      private $code;
      private $email_verified_at;
      private $created_at;
      private $updated_at;


      /**
       * Get the value of id
      */ 
      public function getId()
      {
      return $this->id;
      }

      /**
       * Set the value of id
      *
      * @return  self
      */ 
      public function setId($id)
      {
      $this->id = $id;

      return $this;
      }

      /**
       * Get the value of first_name
      */ 
      public function getFirst_name()
      {
      return $this->first_name;
      }

      /**
       * Set the value of first_name
      *
      * @return  self
      */ 
      public function setFirst_name($first_name)
      {
      $this->first_name = $first_name;

      return $this;
      }

      /**
       * Get the value of last_name
      */ 
      public function getLast_name()
      {
      return $this->last_name;
      }

      /**
       * Set the value of last_name
      *
      * @return  self
      */ 
      public function setLast_name($last_name)
      {
      $this->last_name = $last_name;

      return $this;
      }

      /**
       * Get the value of image
      */ 
      public function getImage()
      {
      return $this->image;
      }

      /**
       * Set the value of image
      *
      * @return  self
      */ 
      public function setImage($image)
      {
      $this->image = $image;

      return $this;
      }

      /**
       * Get the value of email
      */ 
      public function getEmail()
      {
      return $this->email;
      }

      /**
       * Set the value of email
      *
      * @return  self
      */ 
      public function setEmail($email)
      {
      $this->email = $email;

      return $this;
      }

      /**
       * Get the value of phone
      */ 
      public function getPhone()
      {
      return $this->phone;
      }

      /**
       * Get the value of password
      */ 
      public function getPassword()
      {
      return $this->password;
      }

      /**
       * Set the value of password
      *
      * @return  self
      */ 
      public function setPassword($password)
      {
      $this->password = sha1($password);
      return $this;
      }

      /**
       * Set the value of phone
      *
      * @return  self
      */ 
      public function setPhone($phone)
      {
      $this->phone = $phone;

      return $this;
      }

      /**
       * Get the value of created_at
      */ 
      public function getCreated_at()
      {
      return $this->created_at;
      }

      /**
       * Set the value of created_at
      *
      * @return  self
      */ 
      public function setCreated_at($created_at)
      {
      $this->created_at = $created_at;

      return $this;
      }

      /**
       * Get the value of updated_at
      */ 
      public function getUpdated_at()
      {
      return $this->updated_at;
      }

      /**
       * Set the value of updated_at
      *
      * @return  self
      */ 
      public function setUpdated_at($updated_at)
      {
      $this->updated_at = $updated_at;

      return $this;
      }



      /**
       * Set the value of ather_people
       *
       * @return  self
       */ 
      public function setAther_people($ather_people)
      {
            $this->ather_people = $ather_people;
            return $this;
      }

      /**
       * Get the value of ather_people
       */ 
      public function getAther_people()
      {
            return $this->ather_people;
      }

      /**
       * Get the value of payment_status
       */ 
      public function getPayment_status()
      {
            return $this->payment_status;
      }

      /**
       * Set the value of payment_status
       *
       * @return  self
       */ 
      public function setPayment_status($payment_status)
      {
            $this->payment_status = $payment_status;

            return $this;
      }

      
      /**
       * Get the value of qr_code
       */ 
      public function getQr_code()
      {
            return $this->qr_code;
      }

      /**
       * Set the value of qr_code
       *
       * @return  self
       */ 
      public function setQr_code($qr_code)
      {
            $this->qr_code = sha1($qr_code);

            return $this;
      }

      /**
       * Get the value of code
       */ 
      public function getCode()
      {
            return $this->code;
      }

      /**
       * Set the value of code
       *
       * @return  self
       */ 
      public function setCode($code)
      {
            $this->code = $code;

            return $this;
      }

            /**
       * Get the value of status
       */ 
      public function getStatus()
      {
            return $this->status;
      }

      /**
       * Set the value of status
       *
       * @return  self
       */ 
      public function setStatus($status)
      {
            $this->status = $status;

            return $this;
      }

      
      /**
       * Get the value of email_verified_at
       */ 
      public function getEmail_verified_at()
      {
            return $this->email_verified_at;
      }

      /**
       * Set the value of email_verified_at
       *
       * @return  self
       */ 
      public function setEmail_verified_at($email_verified_at)
      {
            $this->email_verified_at = $email_verified_at;

            return $this;
      }

      public function create(){
      $query = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `updated_at`, `password`, `qr_code`, `code`)
      VALUES (NULL, '$this->first_name', '$this->last_name', '$this->email', '$this->phone', current_timestamp(), current_timestamp(), '$this->password', '$this->qr_code', $this->code)";
      return $this->runDML($query);
      }


      public function read() {
            $email = $_SESSION['user']->email;
            $query = "SELECT * FROM users WHERE email = '$email'";
            return $this->runDQL($query);
      }

      public function update(){
      $image = NULL;
      if(!empty($this->image)){
      $image = " , image = '$this->image' ";
      }
      $query = "UPDATE users SET first_name = '$this->first_name', last_name = '$this->last_name', 
      phone = '$this->phone', $image WHERE email = '$this->email'";
      return $this->runDML($query);
      }

      public function delete(){

      }

      public function unique()
      {
      $query = "SELECT * FROM `users` WHERE `email` = '$this->email'";
      $result = $this->runDQL($query);
      if($result && $result->num_rows > 0){
      return "This email is already in use.";
      } else {
      return "";
      }
      }

      public function login()
      {
      $query = "SELECT * FROM `users` WHERE email = '$this->email' AND password = '$this->password'";
      return $this->runDQL($query);
      }


      public function add_ather_people() 
      {
      $query = "UPDATE `users` SET `ather_people`='$this->ather_people' WHERE `email`='$this->email'";
      return $this->runDML($query);
      }


      public function get_user_by_email(){
            $query = "SELECT * FROM `users` WHERE email = '$this->email'";
            return $this->runDQL($query);
      }

            public function checkCode()
      {
            $query = "SELECT * FROM `users` WHERE email = '$this->email' AND code = $this->code";
            return $this->runDQL($query);
      }

      public function make_user_verified()
      {
      $query = "UPDATE `users` SET `email_verified_at` = '$this->email_verified_at', `status` = $this->status
            WHERE email = '$this->email'";
      return $this->runDML($query);
      }



      public function update_code_by_email()
      {
            $query = "UPDATE `users` SET code = $this->code WHERE email = '$this->email'";
            return $this->runDML($query);
      }

      public function update_password_by_email()
      {
            $query = "UPDATE `users` SET `password` = '$this->password' WHERE email = '$this->email'";
            return $this->runDML($query);
      }

}
?>