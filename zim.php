<?php

function to_object($array) {
  return json_decode(json_encode($array));
}

class ZimAccounting {

  function __construct($url) {
    $this->url = $url;
  }

  function login($username, $password) {
    $data = array('username' => $username, 'password' => $password);
    return $this->post($this->url . '/api/login', $data);
  }

  function get_companies($token) {
    $data = array('token' => $token);
    return $this->get($this->url . '/api/get_companies', $data);
  }

  function select_company($token, $company_id) {
    $data = array('token' => $token, 'company_id' => $company_id);
    return $this->post($this->url . '/api/select_company', $data);
  }

  function get_categories($token) {
    $data = array('token' => $token);
    return $this->get($this->url . '/api/get_categories', $data);
  }

  function get_users($token) {
    $data = array('token' => $token);
    return $this->get($this->url . '/api/get_users', $data);
  }

  function get_items($token) {
    $data = array('token' => $token);
    return $this->get($this->url . '/api/get_items', $data);
  }

  function save_item($token, $item) {
    $item['token'] = $token;
    return $this->post($this->url . '/api/save_item', $item);
  }

  function save_category($token, $category) {
    $category['token'] = $token;
    return $this->post($this->url . '/api/save_category', $category);
  }

  private function get($url, $data) {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url . '?' . http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);

    $output = curl_exec($curl);

    curl_close($curl);
    return $output;
  }

  private function post($url, $data, $username = '', $password = '') {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($username && $password) {
      curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    }

    $output = curl_exec($ch);

    curl_close($ch);
    return $output;
  }
}
